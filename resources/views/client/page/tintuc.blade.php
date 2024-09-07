@extends('client.layout')
@section('content')
    <div class="container">
        <div class="row">
            @foreach ($post as $item)
                <div class="col-4">
                    <div class="single-blog">
                        <div class="blog-image">
                            <a href="#">
                                <img style="max-width: 100% !important;" src="{{ asset('assets/uploads/' . $item->image) }}" alt=""></a>
                        </div>
                        <div class="blog-content">
                            <h4 class="title"><a
                                    href="#">{{ $item->title }}</a>
                            </h4>
                            <div class="articles-date">
                                <p><span>{{ $item->created_at }}</span></p>
                            </div>
                            <div class="four-line mb-4">
                                {!! $item->description !!}
                            </div> 

                            <div class="blog-footer">
                                <a class="more"
                                    href="#"
                                    >Tìm
                                    hiểu thêm</a>
                                <!-- <p class="comment-count"><i class="icon-message-circle"></i> 0</p> -->
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection