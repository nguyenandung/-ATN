<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\productDetail;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Images;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class Homecontroller extends Controller
{
    public function index(){
        // dd(Auth::user());
        
        
        $product = Product::with('images')->where('status',1)->get();
        // $product2 = Product::join('orderdetail', 'orderdetail.product_id', '=', 'products.id')
        //             ->selectRaw('COUNT(orderdetail.product_id) as count,products.*')
        //             ->groupBy('products.id')
        //             ->groupBy('products.category_id')
        //             ->orderBy('count','desc')->get();
        //             dd($product2);
                    // ->having('count');
        $product3 = Product::with('images')->where('status',1)->get();
        $post = Post::where('status',1)->get();
        // dd($product[0]->images);
        return view('client.page.index',compact('product','post'));
    }
    public function cuahang(){
        
        $product = Product::where('status',1)->paginate(9);
        // dd($product);
        return view('client.page.store',compact('product'));
    }
    public function chitietsanpham($name=""){
        if($name!=""){
            // $name = Str::replace('-',' ',$name);
            // dd($name);
            $product = Product::where('slug',$name)->with('images')->with('productDetail')->first();
            $comment = Comment::where('product_id',$product->id)->orderBy('created_at','desc')->get();
            return view('client.page.chitietsanpham',compact('product','comment'));
        }
        return redirect()->back();
    }
    public function locsanpham(Request $request){
        if(!isset($request->danhmuc) && !isset($request->min) && !isset($request->max) && !isset($request->keyword)){
            return $this->cuahang();
        }  
        $danhmuc = $request->danhmuc;
        $min = $request->min;
        $max = $request->max;
        $keyword = $request->keyword;
        $category = Category::all();
        $query = Product::query();
        
        // dd('oke');
        if($danhmuc=='' && $min=='' && $max =='' && $keyword ==''){
            // dd('1');
            return $this->cuahang();
        }
        
        else{
            if($keyword != ''){
                $query->where('name','like','%'.$keyword.'%');
            }
            if($danhmuc != ''){
                // dd($danhmuc);
                $danhmuc = explode(',', $danhmuc);
                $query->whereIn('category_id',$danhmuc);
            }
            if($min != ''){
                $query->where('price','>=',$min);
            }
            if($max != ''){
                $query->where('price','<=',$max);
            }
            // dd($query->tosql());
            $product = $query->where('status',1)->paginate(9);
            // dd($product);
            return view('client.page.store',compact('category','product'));
        }
    }
    public function getSizeAndColor($id){
        try {
            $productDetail = ProductDetail::where('product_id',$id)->get();
            // dd($productDetail);
            return  response()->json([
                "status"=>200,
                'data'=>$productDetail
            ]);
        } catch (\Throwable $th) {
            return  response()->json([
                "status"=>500,
                'message'=>'Có lỗi'
            ]);
        }
    }
    public function goiysearch(Request $request){
        $product = Product::where('name','like',$request->value.'%')->limit(5)->get();
        $data= '';
        foreach ($product as $key => $value) {
            $data .= '<li class="search-product-item d-flex align-items-center">
                            <a class="search-product-text"
                                href="'. route('chitietsanpham', ['name' => $value->slug]) .'">
                                <div class="d-flex align-items-center">
                                    <img width="50" height="50"
                                        src="'. asset('assets/uploads/'.$value->images[0]->url).'"
                                        alt="">
                                    <span class="two-line ml-2">'.$value->name.'</span>
                                </div>
                            </a>
                        </li>';
        }
         
        return response()->json($data);
    }
    public function tintuc(){
        $post = Post::where('status',1)->get();
        return view('client.page.tintuc',compact('post'));
    }
}
