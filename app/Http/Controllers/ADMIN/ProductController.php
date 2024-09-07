<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\productDetail;
use App\Models\Images;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

// use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::with('category')->paginate(30);
        // dd($product);
        return view('admin.components.Product.index',compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::all();
        
        return view('admin.components.Product.create',compact('category'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $data =  $request->all();
        $data = $request->validate([
            'name'=>'required',
            'category'=>'required',
            'price'=>'required',
            'size'=>'required',
            'color'=>'required',
            'description'=>'required',
            'image'=>'required'
            
        ],[
            'name.required'=>'Tên sản phẩm không được để trống',
            'price.required'=>'Giá sản phẩm không được để trống',
            'size.required'=>'Phải chọn ít nhất 1 size',
            'color.required'=>'Phải có ít nhất 1 màu',
            'image.required'=>'Phải có ít nhất 1 ảnh',
            'description.required'=>'Mô tả sản phẩm không được để trống',
        ]);
        // dd($data['image']);
        // dd($data);
        $data['S'] = $request->S;
        $data['M'] = $request->M;
        $data['L'] = $request->L;
        $data['XL'] = $request->XL;
        $data['XXL'] = $request->XXL;
        
        try {
            $product = new Product;
            $product->name = $data['name'];
            $product->slug = Str::slug($data['name']);
            $product->description = $data['description'];
            $product->price = $data['price'];
            $stock = 0;
            foreach ($data['size'] as $key1=>$size) {
                $stock +=  $data[$size] * count($data['color']);
            }
            $product->stock = $stock;
            $product->create_at = Carbon::now();
            $product->create_by = 'admin';
            $product->category_id = $data['category'];
            $product->save();
            $productID = $product->id;
        // dd($productID);
        
        // dd($productID);

        foreach($data['size'] as $key1=>$size){
            foreach ($data['color'] as $key2 => $color) {
                $product_detail = new productDetail;
                // dd($data[$size]);
                $product_detail->product_id = $productID;
                $product_detail->color = $color;
                $product_detail->size = $size;
                $product_detail->quantity = $data[$size];
                $product_detail->created_at = Carbon::now();
                $product_detail->save();
            }
        }
        foreach ($data['image'] as $key => $item) {
            // dd($item);
            $image = new Images;
            $extenstion = $item->getClientOriginalExtension();
            $filename = time().'_'.uniqid().'.'.$extenstion;
            $item->move(public_path('/assets/uploads/'), $filename);
            $image->product_id  = $productID;
            $image->url = $filename;
            $image->save();

        }
        toastr()->success('Thêm sản phẩm thành công');
        return redirect()->route('product.index');
        } catch (\Throwable $th) {
            toastr()->error('Có lỗi khi thêm vui lòng thử lại');
            // toastr()->error('Có lỗi khi thêm sản phẩm vui lòng thử lại');
            return  redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $product = Product::find($id);
        $product = Product::with('productDetail')->with('images')->find($id);
        $category = Category::all();
        // $productDetail = productDetail::where('product_id',$product->id)->get();
        // in_array('small', array_values($product_detail['size'));
        // dd($product->productDetail);
        return view('admin.components.Product.edit',compact('product','category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        // dd($data);
        
        $product = Product::find($id);
        $product->category_id = $data['category'];
        $product->stock = $data['quantity'];
        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->description = $data['description'];
        $product->save();
        if(array_key_exists('image', $data)){
            
            foreach ($data['image'] as $key => $item) {
                $image = new Images;
                $extenstion = $item->getClientOriginalExtension();
                $filename = time().'_'.uniqid().'.'.$extenstion;
                $item->move(public_path('/assets/uploads/'), $filename);
                $image->product_id  = $id;
                $image->url = $filename;
                // var_dump($filename);
                $image->save();
            }
            // dd('oke');

        }
         return redirect()->route('product.index');

    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        // dd('oke');
        try {
            $product = Product::find($id);
        // dd($product);
        $product->delete();
        toastr()->success('Xóa sản phẩm thành công');
        return redirect()->route('product.index');
        } catch (\Throwable $th) {
            toastr()->error('Bạn chỉ có thể ẩn sản phẩm này');
            return redirect()->route('product.index');
        }
    }
    public function deleteProduct(Request $request){
        try {
            $product = Product::whereIn('id',$request->id)->delete();
            // dd('oke');
            toastr()->success('Xóa sản phẩm thành công');
            return response()->json(['code' => 200, 'message' => 'Xóa sản phẩm thành công']);
        } catch (\Throwable $th) {
            // throw $th;
            // dd('oke');
            return response()->json(['code' => 500, 'message' => 'Bạn không thể xóa tất cả sản phẩm đã chọn! Vui lòng xóa từng sản phẩm']);
        }
    }
    public function changeStatus(Request $request){
        // dd($request->id);
        DB::beginTransaction();
        try {
            $product = Product::whereIn('id',$request->id)
            ->update(['status' => $request->status == 'true' ? 1:0]);
                DB::commit();
                toastr()->success('Thay đổi trạng thái sản phẩm thành công');
                return response()->json(['code' => 200, 'message' => 'Thay đổi trạng thái thành công']);

        } catch (Throwable $th) {
            //throw $th;
            DB::rollback();
            toastr()->error('Có lỗi khi thay đổi trạng thái');
            return response()->json(['code' => 500, 'message' => 'Có lỗi khi thay đổi trạng thái']);
        }
    }
    public function updateProductDetail(Request $request){
        $data = $request->data;
        $productDetail = productDetail::find($data['id']);

        // cap nhat lai so luong trong kho ở product
        $product = Product::find($productDetail->product_id);
        $product->stock = ((int)$product->stock - (int)$productDetail->quantity + (int)$data['quantity']);
        $product->save();

        //cap nhat bang productDetail
        $productDetail->size = $data['size'];
        $productDetail->color = $data['color'];
        $productDetail->quantity = $data['quantity'];
        $productDetail->updated_at = Carbon::now();
        $productDetail->save();
        return response()->json(['code' => 200, 'mes' => $product->stock]);
    }
    public function deleteItemProductDetail(Request $request){
        $id = $request->id;
        $productDetail = productDetail::find($id);
        $productDetail->delete();
        return response()->json(['code' => 200, 'mes' => 'oke']);
    }
    public function deleteImageByPro(Request $request){
        $id = $request->id;
        $proId = $request->product_id;
        Images::where('id',$id)->where('product_id',$proId)->delete();
        return response()->json(['code'=>200]);
    }
}
