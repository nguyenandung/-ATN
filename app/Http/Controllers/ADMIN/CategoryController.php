<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::paginate(10);
        return view('admin.components.Category.index',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.components.Category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $category = new Category;
            $category->name = $request->name;
            $category->description = $request->description;
            $category->status = '1';
            $category->created_at  = Carbon::now();
            $category->save();
            DB::commit();
            toastr()->success('Thêm danh mục thành công');
            return redirect("/admin/category");
        } catch (Throwable $th) {
            DB::rollBack();
            // dd("lỗi");?
            toastr()->error('Có lỗi khi thêm danh mục');
            throw $th;
        }
        return redirect()->back()->withInput();
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
        $category = Category::find($id);
        return view('admin.components.Category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($id);
        try {
            DB::beginTransaction();
            $category = Category::find($id);
            $category->name = $request->name;
            $category->description = $request->description;
            $category->updated_at  = Carbon::now();
            $category->save();

            // dd($category);

            DB::commit();
            toastr()->success('Sửa danh mục thành công');
            return redirect("/admin/category");
        } catch (Throwable $th) {
            DB::rollback();
            toastr()->erorr('Sửa danh mục thất bại');
            return redirect()->back()->withInput();
            throw $th;

        }
    }
    public function destroy(string $id)
    {
        try {
            $category = Category::find($id);
            $category->delete();
            toastr()->success('Xóa danh mục thành công');
            return redirect("/admin/category");
        } catch (\Throwable $th) {
            //throw $th;
            toastr()->warning('Bạn chỉ được phép ẩn danh mục này!');
            return redirect('/admin/category');
        }

    }
    public function changeStatus(Request $request){
        // dd($request->id);
        DB::beginTransaction();
        try {
            $category = Category::whereIn('id',$request->id)
            ->update(['status' => $request->status == 'true' ? 1:0]);
            $product = Product::whereIn('category_id',$request->id)
            ->update(['status' => $request->status == 'true' ? 1:0]);
            DB::commit();
            toastr()->success('Thay đổi trạng thái danh mục thành công');
            return response()->json(['code' => 200, 'message' => 'Thay đổi trạng thái thành công']);

        } catch (Throwable $th) {
            //throw $th;
            DB::rollback();
            toastr()->error('Có lỗi khi thay đổi trạng thái');
            return response()->json(['code' => 500, 'message' => 'Có lỗi khi thay đổi trạng thái']);
        }
    }
}
