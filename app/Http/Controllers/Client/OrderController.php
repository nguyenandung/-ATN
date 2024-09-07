<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\productDetail;
use App\Models\Product;
use App\Models\Address;
use App\Models\Voucher;
use App\Models\Comment;
use DB;
use Carbon\Carbon;
// use Mail;
use App\Events\SendMail;
use Log;
use Session;


class OrderController extends Controller
{
    public function index(){
        // dd(Auth::user()->id);
        $cart = Cart::with(['product'=>function($query){
            $query->with('images')->select('id', 'name', 'price', 'slug');
        }])->where('user_id',Auth::id())->get();
        foreach ($cart as $key=>$item) {
            $quantity  = $item->product->productDetail->where('size',$item->size)->where('color',$item->color)->select('quantity')->first();
            $item['stock']=$quantity['quantity'];
        }
        return view('client.page.thanhtoan',compact('cart'));
    }
    public function checkout(Request $request){
        // dd($request);
        $code = rand(0,9999) +1;
        $cart = Cart::where('user_id',Auth::id())->get();
        // $tong =0 ;
        // foreach ($cart as $item) {
        //     $tong +=$item->quantity*$item->product->price;
        // }
        $tong = $request->totalmoney;
        $address = Address::where('id',$request->address_rdo)
        ->where('user_id',Auth::id())
        ->first();
        if($request->checkout == 'cash'){
            try {
                DB::beginTransaction();
                
                $order = new Order;
                $order->code = $code;
                $order->user_id = Auth::id();
                $order->status = 'Chờ xác nhận';
                if($request->has('voucher')){
                    $voucher = Voucher::find($request->voucher);
                    // dd($voucher);
                    $voucher->solandadung +=1;
                    $voucher->save();
                }
                $order->totalMoney = $tong;
                $order->customerName= $address->name ;
                $order->phone = $address->phone ;
                $order->address = $address->address ;
                $order->paymentMethod = 'Thanh toán khi nhận hàng';
                $order->orderDate = Carbon::now();
                $order->save();
                $order_id = $order->id;
                // dd('oke');
                $hmtlCartItem = '';
                foreach ($cart as $item) {
                    // dd($cart);
                    
                    try { 
                        $od = new OrderDetail;
                        $od->product_id = $item->product_id;
                        $od->order_id = $order_id;
                        $od->size = $item->size;
                        $od->color = $item->color;
                        $od->quantity = $item->quantity;
                        // $od->save();
                        // dd($od);
                        
                        // lấy ra thông tin của sản phẩm có size và màu đàng mua để cập nhật số lượng 
                        $prode = productDetail::where('product_id',$item->product_id)->where('size',$item->size)
                                        ->where('color',$item->color)->first();
                        if($prode->quantity - $item->quantity <0){
                            // dd('oke');
                            // toastr()->error('Bạn không có quyền');
                            toastr()->error('Sản phẩm trong kho ít hơn sản phẩm trong giỏ hàng');
                            DB::rollback(); 
                            return redirect()->back();
                        }
                        $prode->quantity -= $item->quantity;
                        $prode->save();
                        $product = Product::find($item->product_id);
                        $product->stock -= $item->quantity;
                        $product->save();
                        $od->price = $product->price;
                        $od->save();
                        $hmtlCartItem.="<tr>
                                        <td>".$product->name."
                                        <td>".$item['size']."-".$item['color']."</td>
                                        <td>".$item['quantity']."</td>
                                        <td>".number_format($product->price, 0, ',', '.') ."đ</td>
                                    </tr>";
                    } catch (\Throwable $th) {
                        Log::error($th);
                        DB::rollback(); 
                    }
                }
                DB::commit();
                // event(new SendMail($email, $order, $carts));
                // Mail::to(Auth::user()->email)->send(new OrderConfirm($order,$cart));
                Cart::where('user_id', Auth::id())->delete();
                // $cart->delete();
                toastr()->success('Đặt hàng thành công');
                // event(new SendMail(Auth::user()->email, $order,$hmtlCartItem));
                return redirect()->route('ordered');
            } catch (Throwable  $e) {
                var_dump($e);
                DB::rollback();
            }   
        }
        else{
            if (session()->has('address_id')) {
                session()->forget('address_id');
            }
            if ($request->has('voucher')) {
                // Lấy ID của voucher từ request
                $voucherId = $request->input('voucher');

                // Ghi đè ID của voucher vào session
                Session::put('voucher_id', $voucherId);

                // Tăng số lần đã dùng của voucher
                
            }
            session()->put('address_id',$request->address_rdo);
            return $this->Create_VNPay_payment($request->address_rdo,$code,$tong);
        }
    }

    public function responseVNPAY(Request $request){
        // dd($request);
        $vnp_SecureHash = $request->vnp_SecureHash;
        $vnp_HashSecret = 'NAVBRQKIYHLUQBUWRGJFKDZKOVFNGYOO';
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        if ($secureHash == $vnp_SecureHash) {
            // dd($request->vnp_ResponseCode);
            if ($request->vnp_ResponseCode == '00') {
                // dd('oke');
                $cart = Cart::where('user_id',Auth::id())->get();
                $tong = $request->vnp_Amount / 100;
                // dd(session()->get('address_id'));
                $address = Address::where('id',session()->get('address_id'))
                                    ->where('user_id',Auth::id())
                                    ->first();
                try {
                    $voucherId = session()->get('voucher_id','');
                    
                DB::beginTransaction();

                $order = new Order;
                $order->code = $request->vnp_TxnRef;
                $order->user_id = Auth::id();
                if($voucherId != ''){
                    $voucher = Voucher::find($voucherId);
                    if ($voucher) {
                        // dd($voucher);
                        $voucher->solandadung += 1;
                        $voucher->save();
                    }
                    $order->voucher_id = $voucherId;
                }
                $order->status = 'Chờ xác nhận';
                $order->totalMoney = $tong;
                $order->customerName= $address->name ;
                $order->phone = $address->phone ;
                $order->address = $address->address ;
                $order->paymentMethod = 'Thanh toán qua VNPAY';
                $order->orderDate = Carbon::now();
                $order->save();
                $order_id = $order->id;
                foreach ($cart as $item) {
                    try { 
                        $od = new OrderDetail;
                        $od->product_id = $item->product_id;
                        $od->order_id = $order_id;
                        $od->size = $item->size;
                        $od->color = $item->color;
                        $od->quantity = $item->quantity;
                        if($prod->quantity - $item->quantity <0){
                            // dd('oke');
                            // toastr()->error('Bạn không có quyền');
                            toastr()->error('Sản phẩm trong kho ít hơn sản phẩm trong giỏ hàng');
                            DB::rollback(); 
                            return redirect()->back();
                        }
                        $prode->quantity -= $item->quantity;
                        $prode->save();
                        $product = Product::find($item->product_id);
                        $product->stock -= $item->quantity;
                        $product->save();
                        $od->price = $product->price;
                        $od->save();
                        
                    } catch (\Throwable $th) {
                        //throw $th;
                        DB::rollback(); 
                    }
                }
                DB::commit();
                session()->forget('address_id');
                // Mail::to(Auth::user()->email)->send(new OrderConfirm($order,$cart));
                toastr()->success('Đặt hàng thành công');
                Cart::where('user_id', Auth::id())->delete();

                return redirect()->route('ordered');
                } catch (Throwable  $e) {
                    var_dump($e);
                    DB::rollback();
                }   
            }
            else{
                return redirect()->route('giohang');
            }
        }
    }
    public function Create_VNPay_payment($address_rdo,$code,$tong){
        // dd('oke');
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:8000/responseVNPAY";
        $vnp_TmnCode = "3XZ62T96";//Mã website tại VNPAY 
        $vnp_HashSecret = "NAVBRQKIYHLUQBUWRGJFKDZKOVFNGYOO"; //Chuỗi bí mật
        $order_id = $code;
        $vnp_TxnRef = $order_id;
        $vnp_OrderInfo = 'Thanh toán đơn hàng';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $tong * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'ncb';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            // "vnp_Bill_Address"=>$vnp_Bill_Address,
            // "vnp_Bill_City"=>$vnp_Bill_City,
            // "vnp_Bill_Country"=>$vnp_Bill_Country,
            // "vnp_Inv_Phone"=>$vnp_Inv_Phone,
            // "vnp_Inv_Email"=>$vnp_Inv_Email,
            // "vnp_Inv_Customer"=>$vnp_Inv_Customer,
            "vnp_Inv_Address"=>'Nghệ An',
        );
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return Redirect($vnp_Url);   
    }

    public function ordered(){
        $allOrders = Order::where('user_id',Auth::id())->orderBy('cancelReson')->orderBy('orderDate','desc')->paginate(10);
        return view('client.page.donhang',compact('allOrders'));
    }
    public function detailOrder($id){
        if($id !=''){
            $order = Order::with('orderDetail')
            ->where('id',$id)->first();
            // dd($cart->orderDetail[0]->product->images[0]);
            return view('client.page.chitietdonhang',compact('order'));
        }
    }
    public function deleteOrder(Request $request){
        $id =  $request->id;
        $cancelReson =$request->cancelReson;
        // dd($cancelReson);
        try {
            $order =  Order::find($id);
            $orderDetail = OrderDetail::where('order_id',$id)->get();
            foreach($orderDetail as $item){
                $productDetail = ProductDetail::where('color',$item->color)->where('size',$item->size)->where('product_id',$item->product_id)->first();
                // dd($productDetail);
                $productDetail->quantity +=$item->quantity;
                $productDetail->save();
                $product = Product::find($item->product_id);
                $product->stock += $item->quantity;
                $product->save();
            }
            $order->cancelReson = $cancelReson;
            // dd($order->cancelReson);
            $order->status = 'Đã hủy';
            $order->isCancel = 1;
            $order->save();
            return response()->json(['code'=>200]);
        } catch (\Throwable $th) {
            return response()->json(['code'=>500]);
            // throw $th;
        }
    }
    public function fetchOrderByStatus(Request $request){
        try {
            $status = $request->status;
        if($status == 'Đã giao hàng'){
            $orderByStatus = Order::where('status',$status)->orWhere('status','Đã nhận hàng')->where('user_id',Auth::id())->get();
        }
        else{
            $orderByStatus = Order::where('status',$status)->where('user_id',Auth::id())->get();
        }
        // dd($request);
        
        // dd(count($orderByStatus));
        if(count($orderByStatus) == 0){
            if($status == 'Chờ xác nhận'){
                $data = '<div class="tab-pane fade show active" id="xacnhan" role="tabpanel" aria-labelledby="xacnhan-tab">';
            }
            else if($status== 'Đang giao hàng'){
                // dd('oke');
                $data = ' <div class="tab-pane fade show active" id="danggiao" role="tabpanel" aria-labelledby="danggiao-tab">';
            }
            else if($status == 'Đã giao hàng'){
                $data ='<div class="tab-pane fade show active" id="dagiao" role="tabpanel" aria-labelledby="dagiao-tab">';
            }
            else {
                $data = '<div class="tab-pane fade show active" id="dahuy" role="tabpanel" aria-labelledby="dahuy-tab">';
            }
            $data .= '
            <div class="row">
            <div class="col-sm-12">
            <table id="example" class="table table-striped table-bordered  nowrap text-cen"
            style="width: 100%;" aria-describedby="example_info">
            <thead>
            <tr>
            <th rowspan="1" colspan="1" style="width: 62.2px;">Mã ĐH
            </th>
            <th rowspan="1" colspan="1" style="width: 146.2px;">Tên người nhận
            </th>
            <th rowspan="1" colspan="1" style="width: 154.2px;">Ngày đặt</th>
            <th rowspan="1" colspan="1" style="width: 122.2px;">Trạng thái</th>
            <th rowspan="1" colspan="1" style="width: 89.2px;">Tổng tiền</th>
            <th rowspan="1" colspan="1" style="width: 84.2px;">Thao tác</th>
            </tr>
            </thead>
            <tbody>
            <tr class="odd"><td valign="top" colspan="6" class="text-center">No data available in table</td></tr>
            </tbody>
            </table>
            </div>
            </div></div>';
            return response()->json($data);
        }   
        if($status == 'Chờ xác nhận'){
            // dd('oke');
            $data = '<div class="tab-pane fade show active" id="xacnhan" role="tabpanel" aria-labelledby="xacnhan-tab">
            <div class="row">
            <div class="col-sm-12">
            <table id="example" class="table table-striped table-bordered  nowrap table-responsive-sm text-center "
            style="width: 100%;" aria-describedby="example_info">
            <thead>
            <tr>
            <th rowspan="1" colspan="1" style="width: 62.2px;">Mã ĐH
            </th>
            <th rowspan="1" colspan="1" style="width: 146.2px;">Tên người nhận
            </th>
            <th rowspan="1" colspan="1" style="width: 154.2px;">Ngày đặt</th>
            <th rowspan="1" colspan="1" style="width: 122.2px;">Trạng thái</th>
            <th rowspan="1" colspan="1" style="width: 89.2px;">Tổng tiền</th>
            <th rowspan="1" colspan="1" style="width: 84.2px;">Thao tác</th>
            </tr>
            </thead>
            <tbody>';
            foreach ($orderByStatus as $key => $item) {
                $data.='<tr>
                <td>'.$item->code.'</td>
                <td>'.$item->customerName.'</td>
                <td>'. $item->orderDate.'</td>
                <td>'.$item->status .'</td>
                <td>'.$item->totalMoney.'</td>
                <td class="d-flex justify-content-center">
                <button class="bg-transparent border-0 p-0"><a
                class="view-hover h3 mr-2" href="'.
                route('chitietdonhang',['id'=>$item->id])
                .'"
                data-toggle="tooltip" data-placement="top"
                title="Xem chi tiết" data-original-title="Xem chi tiết"><i
                class="fa fa-eye"></i></a></button>
                <button class="bg-transparent border-0 p-0" disabled>
                <a class="view-hover h3 ml-2 delete-order" onclick="showModelDeleteOrder('.$item->id.')"><i class="fa fa-trash"></i></a>
                </button>
                </td>
                </tr>';
            }
            
            $data.='</tbody>
            </table>
            </div>
            </div></div>';
            
            return response()->json($data);
        }
        else if($status== 'Đang giao hàng'){
            $data = '<div class="tab-pane fade show active" id="danggiao" role="tabpanel" aria-labelledby="danggiao-tab">
            <div class="row">
            <div class="col-sm-12">
            <table id="example" class="table table-striped table-bordered  nowrap table-responsive-sm text-center"
            style="width: 100%;" aria-describedby="example_info">
            <thead>
            <tr>
            <th rowspan="1" colspan="1" style="width: 62.2px;">Mã ĐH
            </th>
            <th rowspan="1" colspan="1" style="width: 146.2px;">Tên người nhận
            </th>
            <th rowspan="1" colspan="1" style="width: 154.2px;">Ngày đặt</th>
            <th rowspan="1" colspan="1" style="width: 122.2px;">Trạng thái</th>
            <th rowspan="1" colspan="1" style="width: 89.2px;">Tổng tiền</th>
            <th rowspan="1" colspan="1" style="width: 84.2px;">Thao tác</th>
            </tr>
            </thead>
            <tbody>';
            foreach ($orderByStatus as $key => $item) {
                $data.='<tr>
                <td>'.$item->code.'</td>
                <td>'.$item->customerName.'</td>
                <td>'. $item->orderDate.'</td>
                <td>'.$item->status .'</td>
                <td>'.$item->totalMoney.'</td>
                <td class="d-flex justify-content-center">
                <button class="bg-transparent border-0 p-0"><a
                class="view-hover h3 mr-2" href="'.
                route('chitietdonhang',['id'=>$item->id])
                .'"
                data-toggle="tooltip" data-placement="top"
                title="Xem chi tiết" data-original-title="Xem chi tiết"><i
                class="fa fa-eye"></i></a></button>
                </td>
                </tr>';
            }
            
            $data.='</tbody>
            </table>
            </div>
            </div></div>';
            
            return response()->json($data);
        }
        else if($status == 'Đã giao hàng'){
            $data = '<div class="tab-pane fade show active" id="dagiao" role="tabpanel" aria-labelledby="dagiao-tab">
            <div class="row">
            <div class="col-sm-12">
            <table id="example" class="table table-striped table-bordered  nowrap table-responsive-sm text-center"
            style="width: 100%;" aria-describedby="example_info">
            <thead>
            <tr>
            <th rowspan="1" colspan="1" style="width: 62.2px;">Mã ĐH
            </th>
            <th rowspan="1" colspan="1" style="width: 146.2px;">Tên người nhận
            </th>
            <th rowspan="1" colspan="1" style="width: 154.2px;">Ngày đặt</th>
            <th rowspan="1" colspan="1" style="width: 122.2px;">Trạng thái</th>
            <th rowspan="1" colspan="1" style="width: 89.2px;">Tổng tiền</th>
            <th rowspan="1" colspan="1" style="width: 84.2px;">Thao tác</th>
            </tr>
            </thead>
            <tbody>';
            foreach ($orderByStatus as $key => $item) {
                $data.='<tr>
                <td>'.$item->code.'</td>
                <td>'.$item->customerName.'</td>
                <td>'. $item->orderDate.'</td>
                <td>'.$item->status .'</td>
                <td>'.$item->totalMoney.'</td>
                <td class="d-flex justify-content-center">
                <button class="bg-transparent border-0 p-0"><a
                class="view-hover h3 mr-2" href="'.
                route('chitietdonhang',['id'=>$item->id])
                .'"
                data-toggle="tooltip" data-placement="top"
                title="Xem chi tiết" data-original-title="Xem chi tiết"><i
                class="fa fa-eye"></i></a></button>';
                
                if($item->status == 'Đã giao hàng'){
                    $data.='<button class="bg-transparent border-0 p-0"><a
                class="view-hover h3 mr-2" href="'.
                route('danhanhang',['id'=>$item->id])
                .'"
                data-toggle="tooltip" data-placement="top"
                title="Đã nhận hàng"><i class="fa fa-check" aria-hidden="true"></i></a></button>';
                }
                if( $item->status == 'Đã nhận hàng' && $item->isComment == 0){
                    $data.='<button class="bg-transparent border-0 p-1 " onclick="showModelComment('.$item->id.')" title="Đánh giá" data-id="'.$item->id.'"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
                }

                $data.='</td>
                </tr>';
            }
            
            $data.='</tbody>
            </table>
            </div>
            </div></div>';
            
            return response()->json($data);
        }
        else{
            $data = '<div class="tab-pane fade show active" id="dahuy" role="tabpanel" aria-labelledby="dahuy-tab">
            <div class="row">
            <div class="col-sm-12">
            <table id="example" class="table table-striped table-bordered  nowrap table-responsive-sm text-center"
            style="width: 100%;" aria-describedby="example_info">
            <thead>
            <tr>
            <th rowspan="1" colspan="1" style="width: 62.2px;">Mã ĐH
            </th>
            <th rowspan="1" colspan="1" style="width: 146.2px;">Tên người nhận
            </th>
            <th rowspan="1" colspan="1" style="width: 154.2px;">Ngày đặt</th>
            <th rowspan="1" colspan="1" style="width: 122.2px;">Trạng thái</th>
            <th rowspan="1" colspan="1" style="width: 89.2px;">Tổng tiền</th>
            <th rowspan="1" colspan="1" style="width: 84.2px;">Thao tác</th>
            </tr>
            </thead>
            <tbody>';
            foreach ($orderByStatus as $key => $item) {
                $data.='<tr>
                <td>'.$item->code.'</td>
                <td>'.$item->customerName.'</td>
                <td>'. $item->orderDate.'</td>
                <td>'.$item->status .'</td>
                <td>'.$item->totalMoney.'</td>
                <td class="d-flex justify-content-center">
                <button class="bg-transparent border-0 p-0"><a
                class="view-hover h3 mr-2" href="'.
                route('chitietdonhang',['id'=>$item->id])
                .'"
                data-toggle="tooltip" data-placement="top"
                title="Xem chi tiết" data-original-title="Xem chi tiết"><i
                class="fa fa-eye"></i></a></button>
                </td>
                </tr>';
            }
            
            $data.='</tbody>
            </table>
            </div>
            </div></div>';
            
            return response()->json($data);
        }
        } catch (\Throwable $th) {
            //throw $th;
        }
                        
    }
    public function danhanhang($id){
        $order = Order::find($id);
        $order->status = 'Đã nhận hàng';
        $order->save();
        return redirect()->back();
    }
    public function comment(Request $request){
        $order_id = $request->id;
        $product = [];
        $order = Order::where('id',$order_id)->where('user_id',Auth::id())->first();
        $arrayKey =[];
        foreach ($order->orderDetail as $key => $item) {
            // dd($item->product);
            if(!in_array($item->product->id,$arrayKey)){
                $arrayKey[] = $item->product->id;
                $product[] = [
                'id'=>$item->product->id,
                'name'=>$item->product->name,
                'loai'=>$item->color.'-'.$item->size,
                'hinhanh'=>$item->product->images[0]->url,
            ];
            }
            
        }
        return response()->json(['data'=>$product,'order_id'=>$order_id]);
    }
    public function postcomment(Request $request){
        $data = $request->all();
        // dd($data);
        foreach ($data['review'] as $key => $item) {
           $comment = new Comment;
            // dd($key);
            $comment->product_id = $key;
            // dd($item['image'])
            $comment->user_id = Auth::id();
           if($item['comment'] != null){
                $comment->body = $item['comment'];
           }
           if(array_key_exists('images', $item)){
                // dd('oke');
                
                $extenstion = $item['images']->getClientOriginalExtension();
                $filename = time().'.'.$extenstion;
                $item['images']->move(public_path('/assets/uploads/'), $filename);
                    // $item['images']->move('/assets/uploads/', $filename);
                $comment->images = $filename;
           }
           $comment->point =  $item['rating'];
           $comment->created_at = Carbon::now();
           $comment->save();
        // dd();
        }
        $order = Order::find($data['order_id']);
        $order->isComment = true;
        $order->save();
        toastr()->success('Cảm ơn bạn đã đánh giá sản phẩm');
        return redirect()->back();

    }
    public function checkvoucher(Request $request){
        $vouchercode = $request->voucher;
        $voucher= Voucher::where('ma',$vouchercode)->first();
        // dd($voucher<=$request->total);
        
        if(!$voucher){
            return response()->json(['code'=>201,'message'=>'Voucher không đúng']);
        }
        if($voucher->dongiatoithieu >= $request->total){
            return response()->json(['code'=>201,'message'=>"Đơn hàng tối thiểu $voucher->dongiatoithieu"."đ mới được sử dụng"]);
        }
        if($voucher->ngayhethan <Carbon::now()){
            // dd(Carbon::now());
            return response()->json(['code'=>201,'message'=>'Voucher đã hết hạn']);
        }
        if($voucher->solandasudung >= $voucher->solansudung){
            return response()->json(['code'=>201,'message'=>'Voucher đã hết lượt sử dụng']);
        }
        
        $data = [
            'id'=>$voucher->id,
            'giamgia'=>$voucher->sotiengiam
        ];
        return response()->json(['code'=>200,'message'=>'Áp dụng voucher thành công','data'=>$data]);
    }
}
