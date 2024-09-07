<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{    
    public function AdminLogin(Request $request){
        $data = $request->all();
        // dd($data);
        if (Auth::attempt(['name'=>$data['userName'],'password'=>$data['password']])) {
            // $request->session()->regenerate();
           if(Auth::user()->role == 'admin'){
               return redirect()->route('dashboard');
           }
           else{
            toastr()->error('Bạn không có quyền');
           }
        }
        
        return back()->withErrors(['Sai'=>'Tài khoản hoặc mật khẩu không đúng']);
    }
    public function logout(){
        session()->forget('admin');
        return  redirect('login');
    }

    public function dashboard()
{
    $startDate = Carbon::now()->subDays(8);
    $endDate = Carbon::now()->subDays(1);

    // $products = Product::all();
    $category = Category::all();
    $data =[];
    foreach ($category as $key => $item) {
        if(!array_key_exists($item['name'], $data)){
            $newData =  $this->fillMissingDates($startDate,$endDate,$item['name']);
            $data[$item['name']] = $newData;
        }
    }
    $salesData = OrderDetail::join('order', 'orderdetail.order_id', '=', 'order.id')
                ->join('products', 'orderdetail.product_id', '=', 'products.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                // ->where('orderdetail.product_id', $product->id)
                ->whereBetween('order.orderDate', [$startDate, $endDate])
                ->selectRaw('categories.name as category_name,DATE(order.orderDate) as date, SUM(orderdetail.quantity) as total_quantity')
                ->groupBy('category_name')
                ->groupBy('date')
                ->get();
    foreach ($salesData as $index => $item) {
        // dd(array_key_exists($item['date'],$data[$item['category_name']]['data']));

        if(array_key_exists($item['category_name'],$data)){
            // print_r($data[$item['category_name']]['data']);
            // var_dump($item['date']);
            if(array_key_exists($item['date'],$data[$item['category_name']]['data'])){
                // var_dump($item['total_quantity']);
                $data[$item['category_name']]['data'][$item['date']] = (int) $item['total_quantity'];
            }
        }
    }
    $newOrder = Order::whereRaw('DATE(orderDate) = ?',[Carbon::now()->format('Y-m-d')])->count();
    // dd($newOrder);
    $dt = OrderDetail::join('order', 'orderdetail.order_id', '=', 'order.id')
            ->whereRaw('DATE(orderDate) = ?',[Carbon::now()->format('Y-m-d')])
            ->selectRaw('sum(orderdetail.quantity * orderdetail.price) as doanhthu')
            ->first();
    $newUser = User::whereRaw('DATE(created_at) = ?',[Carbon::now()->format('Y-m-d')])->count();
            // dd($dt->doanhthu);
    $hotProduct = OrderDetail::join('order', 'orderdetail.order_id', '=', 'order.id')
                ->join('products', 'orderdetail.product_id', '=', 'products.id')
                ->whereBetween('order.orderDate', [$startDate, $endDate])
                ->selectRaw('COUNT(orderdetail.product_id) as count, products.name,sum(orderdetail.quantity) as soluong, sum(orderdetail.quantity * orderdetail.price) as doanhthu')
                ->groupby('products.name')
                ->orderBy('count','desc')
                ->orderBy('soluong','desc')
                ->orderBy('doanhthu','desc')
                ->limit(3)
                ->get();
                // dd($hotProduct);
    return view('admin.components.home',compact('data','hotProduct','newOrder','dt','newUser'));
}

private function fillMissingDates($startDate, $endDate,$label)
{
    $dateRange = $this->getDateRange($startDate, $endDate);
    $newData =[];
    $filledData = [

    ];

    foreach ($dateRange as $date) {
        $formattedDate = $date->format('Y-m-d');
        // dd($formattedDate);
        $newData[$formattedDate]= 0;
    }
    // dd($filledData);
    $filledData = [
            'label'=>$label,
            'data'=>$newData
        
    ];
    // dd(count($filledData));

    return $filledData;
}

private function getDateRange($startDate, $endDate)
{
    $dateRange = [];
    $currentDate = $startDate->copy();

    while ($currentDate->lte($endDate)) {
        $dateRange[] = $currentDate->copy();
        $currentDate->addDay();
    }

    return $dateRange;
}
    public function thongke(Request $request){
        $date = $request->date;
        $danhmuc_id = $request->danhmuc;
        
        
        if($date == '7ngay'){
            $startDate = Carbon::now()->subDays(8);
            $endDate = Carbon::now()->subDays(1);
            

        }
        else{
            $startDate = Carbon::now()->subDays(30);
            $endDate = Carbon::now()->subDays(1);
        }
        $data =  $this->getDLTK($startDate,$endDate,$danhmuc_id);
            return response()->json(['data'=>$data]);
    }
    public function getDLTK($startDate, $endDate, $danhmuc_id){
        $data =[];
        $products = Product::where('category_id',$danhmuc_id)->get();
        foreach ($products as $key => $item) {
                if(!array_key_exists($item['name'], $data)){
                    $newData =  $this->fillMissingDates($startDate,$endDate,$item['name']);
                    $data[$item['name']] = $newData;
                }
            }
            // dd($data);
            $startDate = $startDate->format('Y-m-d');
            $endDate = $endDate->format('Y-m-d');
            
            $salesData = OrderDetail::join('order', 'orderdetail.order_id', '=', 'order.id')
                ->join('products', 'orderdetail.product_id', '=', 'products.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->whereBetween('order.orderDate', [$startDate, $endDate])
                ->where('categories.id',$danhmuc_id)
                ->selectRaw('products.name as product_name,DATE(order.orderDate) as date, sum(orderdetail.quantity * orderdetail.price) as doanhthu')
                ->groupBy('product_name')
                ->groupBy('date')
                ->get();
            foreach ($salesData as $index => $item) {
                if(array_key_exists($item['product_name'],$data)){
                    if(array_key_exists($item['date'],$data[$item['product_name']]['data'])){
                        // var_dump($item['total_quantity']);
                        $data[$item['product_name']]['data'][$item['date']] = (int) $item['doanhthu'];
                    }
                }
            }
            return $data;
    }
}
