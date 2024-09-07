<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\productDetail;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function index(){
        // $cart = Cart::where('user_id',Auth::id())->get();
        $cart = Cart::with(['product'=>function($query){
            $query->with('images')->select('id', 'name', 'price', 'slug');
        }])->where('user_id',Auth::id())->get();
        foreach ($cart as $key=>$item) {
            $quantity  = $item->product->productDetail->where('size',$item->size)->where('color',$item->color)->select('quantity')->first();
            $item['stock']=$quantity['quantity'];
        }
        // dd($cart[0]->product->slug);
        return view('client.page.giohang',compact('cart'));
    }
    function addToCart(Request $request){
        $data = $request->only('quantity', 'size', 'color', 'id');
        try {
            $userId = Auth::id();
            
            $cartItem = Cart::where('user_id', $userId)
                ->where('product_id', $data['id'])
                ->where('size', $data['size'])
                ->where('color', $data['color'])
                ->first();

            if ($cartItem == null) {
                $cart = Cart::create([
                    'user_id' => $userId,
                    'product_id' => $data['id'],
                    'quantity' => $data['quantity'],
                    'size' => $data['size'],
                    'color' => $data['color']
                ]);
                return response()->json(['status' => true, 'message' => 'Thêm giỏ hàng thành công']);
            } else {
               
                $stock = productDetail::where('product_id',$data['id'])
                        ->where('size',$data['size'])
                        ->where('color',$data['color'])
                        ->value('quantity');
                
                $cartItem->quantity +=$data['quantity'];
                if($cartItem->quantity >$stock){
                    return response()->json(['status' => false, 'message' => 'Số lượng vượt quá số lượng còn lại trong kho']);
                }
                else{
                    $cartItem->save();
                    return response()->json(['status' => true, 'message' => 'Thêm giỏ hàng thành công', 'data' => $stock]);
                }
            }
        } catch (Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Đã xảy ra lỗi', 'data' => $th]);
        }    
    }
    public function deleteCartItem(Request $request){
        try {
            $idCartItem = $request->id;
            $userId = Auth::id();
            $cartItem = Cart::where('id',$idCartItem)->where('user_id',$userId)->delete();
            // $cartItem->id = 1000;
            return response()->json(['status'=>true,'message'=>'oke']);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'message'=>'Có lỗi']);
        }
    }
    public function updatequantity(Request $request){
        try {
            $newQuantity = $request->newQuantity;
            $id = $request->id;
            $cartItem = Cart::find($id);
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
            return response()->json(['data'=>200]);
        } catch (\Throwable $th) {
            return response()->json(['data'=>201]);
            
        }
        // dd($newQuantity);
    }
    public function emptyCart(){
        Cart::where('user_id',Auth::id())->delete();
        return  redirect()->back();
    }
}
