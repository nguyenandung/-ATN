@extends('admin.components.dashboard')
@section('content')
<div class="row fw-bold fs-5 text-center ">
    <div class="col-5">Hình ảnh</div>
    <div class="col-2">Tiêu đề chính</div>
    <div class="col-2">Tiêu đề phụ</div>
    <div class="col-1">Trạng thái</div>
    <div class="col-1">Vị trí tiêu đề</div>
    <div class="col-1">Thao tác</div>
</div>
    @foreach ($slide as $item)
        <div class="row text-center align-items-center mt-2">
            <div class="col-5">
                <img class="w-100" src="{{asset('assets/uploads/'.$item->url)}}" alt="">
            </div>
            <div class="col-2">
                <p>{{$item->main_title}}</p>
            </div>
            <div class="col-2">
                <p>{{$item->sub_title}}</p>
            </div>
            <div class="col-1">
                @if ($item->status == 0)
                    Ẩn
                    @else
                    Hiện thị
                @endif
            </div>
            <div class="col-1">
                {{$item->position == 'T'? 'Trái': 'Phải'}}
            </div>
            <div class="col-1">
                <a href="{{route('admin.setting.slide',['id'=>$item->id])}}" class="btn btn-primary ">Sửa</a>
            </div>
        </div>
    @endforeach
@endsection