<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::paginate(10);
        return view('admin.components.Post.index',compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.components.Post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'=>'required|unique:post',
            'description'=>'required',
            'image'=>'required',
            'status'=>'required'
        ],[
            'title.required'=>'Tiêu đề bài viết không được để trống',
            'title.unique'=>'Đã có bài viết có tiêu đề này',
           'description.required' =>'Nội dung bài viết không được để trống',
           'image.required' =>'Ảnh bài viết không được để trống',
           'status.required' =>'Trạng thái bài viết phải chọn ẩn hoặc hiện'
        ]);
        try {
            DB::beginTransaction();
            $post = new Post;
            $extenstion = $data['image']->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $data['image']->move(public_path('/assets/uploads/'), $filename);
            $post->image  = $filename;
            $post->title = $data['title'];
            $post->description = $data['description'];
            $post->status= $data['status'];
            $post->slug = Str::slug($data['title']);
            $post->created_at = Carbon::now();
            $post->save();
            DB::commit();
            toastr()->success('Thêm mới bài viết thành công');
            return $this->index();
        } catch (Throwable $th) {
            toastr()->error('Thêm sản phẩm thất bại');
            DB::rollback();
            return  redirect()->back();
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        return view('admin.components.Post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title'=>'required',
            'description'=>'required',
            'status'=>'required'
        ],[
            'title.required'=>'Tiêu đề bài viết không được để trống',
            // 'title.unique'=>'Đã có bài viết có tiêu đề này',
           'description.required' =>'Nội dung bài viết không được để trống',
           'status.required' =>'Trạng thái bài viết phải chọn ẩn hoặc hiện'
        ]);
        // dd($data);
        try {
            DB::beginTransaction();
            $post = Post::find($id);

            if($request->hasFile('image')){
                $extenstion = $request->image->getClientOriginalExtension();
                $filename = time().'.'.$extenstion;
                $request->image->move(public_path('/assets/uploads/'), $filename);
                $post->image  = $filename;
                if (File::exists($post->image)) {
                    File::delete($post->image);
                }
            }
            $post->title = $data['title'];
            $post->description = $data['description'];
            $post->status= $data['status'];
            $post->slug = Str::slug($data['title']);
            $post->updated_at = Carbon::now();
            $post->save();
            DB::commit();
            toastr()->success('Cập nhật bài viết thành công');
            return $this->index();
        } catch (Throwable $th) {
            toastr()->error('Có lỗi khi cập nhật bài viết');
            DB::rollback();
            return  redirect()->back();
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
    public function xoa(Request $request){
        $post = Post::whereIn('id',$request->id)->get();
        foreach ($post as $key => $item) {
            if (File::exists($item->image)) {
                    File::delete($item->image);
                }
        }
        Post::whereIn('id',$request->id)->delete();
        toastr()->success('Xóa sản phẩm thành công');
        return response()->json(['code' => 200, 'message' => 'Xóa sản phẩm thành công']);
    }
}
