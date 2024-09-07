@extends('client.layout')
@section('banner')
    <div class="banner-main">
        <div class="slider-area position-relative ">
            <div class="swiper-container slider-active">
                <div class="swiper-wrapper">
                    <!--Single Slider Start-->
                    <div class="single-slider swiper-slide animation-style-01"
                        style="background-image: url('{{ asset('assets/imgs/KIDOLBanner.png') }}');">
                        <div class="container">
                            <div class="slider-content">
                                <h5 class="sub-title">Nhập: <span class="text-primary">SALE100K</span> <br> Giảm
                                    100K
                                    cho mọi đơn hàng</h5>
                                <h2 class="main-title">Ngày đặc biệt!</h2>
                                <p>Nhập: <span class="text-primary">SALE10</span> để được giảm 10%, số lượng có
                                    hạn!
                                </p>

                                <ul class="slider-btn">
                                    <li><a href="{{route('locsanpham')}}" class="btn btn-round btn-primary">Bắt
                                            đầu mua sắm</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--Single Slider End-->

                    <!--Single Slider Start-->
                    <div class="single-slider swiper-slide animation-style-01"
                        style="background-image: url('{{ asset('assets/imgs/KIDOLBanner2.png') }}');">
                        <div class="container" style="text-align:right;">
                            <div class="slider-content">
                                <h5 class="sub-title sub-title-right">Nhập: <span class="text-info">SALE100K</span>
                                    <br> Giảm 100K cho mọi đơn hàng
                                </h5>
                                <h2 class="main-title">Ngày đặc biệt!</h2>
                                <p>Nhập: <span class="text-info">SALE10</span> để được giảm 10%, số lượng có hạn!
                                </p>

                                <ul class="slider-btn">
                                    <li><a href="" class="btn btn-round btn-primary">Bắt
                                            đầu mua sắm</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" swiper-next"><i class="fa fa-angle-right"></i></div>
                <div class=" swiper-prev"><i class="fa fa-angle-left"></i></div>

                <div class="swiper-pagination"></div>

            </div>
        </div>
    </div>
@endsection
@section('content')
    {{-- shipping area --}}
    <div class="shipping-area  " style="padding: 90px;">
        <div class="container ">
            <div class="row">
                <div class="col-lg-3  col-sm-6">
                    <div class="single-shipping d-flex ">
                        <div class="shipping-icon">
                            <img src="{{ asset('assets/imgs/Free-Delivery.png') }}" alt="">
                        </div>
                        <div class="shipping-content" style="margin-left:20px;">
                            <h5 class="title">
                                Miễn phí vận chuyển
                            </h5>
                            <p>Giao hàng miễn phí cho tất cả các đơn đặt hàng trên 1.000.000đ</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3  col-sm-6">
                    <div class="single-shipping d-flex ">
                        <div class="shipping-icon">
                            <img src="{{ asset('assets/imgs/Online-Order.png') }}" alt="">
                        </div>
                        <div class="shipping-content" style="margin-left:20px;">
                            <h5 class="title">
                                Đặt hàng online
                            </h5>
                            <p>Đừng lo lắng, bạn có thể đặt hàng Trực tuyến trên Trang web của chúng tôi</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3  col-sm-6">
                    <div class="single-shipping d-flex ">
                        <div class="shipping-icon">
                            <img src="{{ asset('assets/imgs/Freshness.png') }}" alt="">
                        </div>
                        <div class="shipping-content" style="margin-left:20px;">
                            <h5 class="title">
                                Hiện đại
                            </h5>
                            <p>Cập nhật những sản phẩm mới nhất</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3  col-sm-6">
                    <div class="single-shipping d-flex ">
                        <div class="shipping-icon">
                            <img src="{{ asset('assets/imgs/Made-By-Artists.png') }}" alt="">
                        </div>
                        <div class="shipping-content" style="margin-left:20px;">
                            <h5 class="title">
                                Hỗ trợ 24\7
                            </h5>
                            <p>Đội ngũ hỗ trợ trưc tuyến chuyên nghiệp</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- product-recommend --}}
    <div class="new-product-area section-padding-2">
        <div class="container ">
            <div class="row  justify-content-center ">
                <div class="col-6 col-md-9 col-sm-11 w-100">
                    <div class="section-title text-center  ">
                        <h2 class="title">Gợi Ý Cho Bạn</h2>
                        <p>A perfect blend of creativity, energy, communication, happiness and love. Let us arrange
                            a smile for you.</p>
                    </div>
                </div>
            </div>

            {{-- san pham moi slide --}}
            <div class="swiper newProduct mt-5 ">
                <div class="swiper-wrapper">
                    @foreach ($product as $key => $item)
                        <div class="swiper-slide">
                            <div class="single-product">
                                <div class="product-image">
                                    <a href="{{ route('chitietsanpham', ['name' => $item->slug]) }}">
                                        <img src="{{ asset('assets/uploads/' . $item->images[0]->url) }}" alt="">
                                    </a>
                                    <div class="action-links">
                                        <ul>
                                            <li>
                                                <a class="product-detail"
                                                    href="{{ route('chitietsanpham', ['name' => $item->slug]) }}"><i
                                                        class="fa fa-eye" aria-hidden="true"></i></a>
                                            </li>
                                            <li>
                                                <a class="add-to-cart" href=""
                                                    onclick="addToCart({{ $item->id }},event)"><i
                                                        class="fa fa-cart-plus" aria-hidden="true"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h4 class="product-name">
                                        {{ $item->name }}
                                    </h4>
                                    <div class="price-box">
                                        <span class="current-price">{{ $item->price }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>

    {{-- San pham moi --}}
    <div class="features-product-area section-padding-5">
        <div class="container" style="padding: 90px;">
            <div class="row d-flex justify-content-center ">
                <div class="col-6 col-md-9 col-sm-11 w-100">
                    <div class="section-title text-center">
                        <h2 class="title">Sản phẩm mới</h2>
                        <p>A perfect blend of creativity, energy, communication, happiness and love. Let us arrange
                            a smile for you.</p>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="mt-4">
                <!-- List group -->
                <div class="list-group d-flex container flex-row justify-content-center" id="myList" role="tablist">
                    <a class="list-group-item title list-group-item-action active p-sm-0 " style="border:none;"
                        data-bs-toggle="list" href="#banchay" role="tab">Bán chạy</a>
                    <a class="list-group-item title list-group-item-action p-sm-0 " style="border:none;"
                        data-bs-toggle="list" href="#noibat" role="tab">Nổi bật</a>
                    <a class="list-group-item title list-group-item-action p-sm-0 " style="border:none;"
                        data-bs-toggle="list" href="#dangsale" role="tab">Đang sale</a>
                </div>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="banchay" role="tabpanel">
                        <div class="container ">

                            <div class="swiper newProduct">
                                <div class="swiper-wrapper">
                                    @foreach ($product as $key => $item)
                                        <div class="swiper-slide">
                                            <div class="single-product">
                                                <div class="product-image">
                                                    <a href="{{ route('chitietsanpham', ['name' => $item->slug]) }}">
                                                        <img src="{{ asset('assets/uploads/' . $item->images[0]->url) }}"
                                                            alt="">
                                                    </a>
                                                    <div class="action-links">
                                                        <ul>
                                                            <li>
                                                                <a class="product-detail"
                                                                    href="{{ route('chitietsanpham', ['name' => $item->slug]) }}"><i
                                                                        class="fa fa-eye" aria-hidden="true"></i></a>
                                                            </li>
                                                            <li>
                                                                <a class="add-to-cart" href=""><i
                                                                        class="fa fa-cart-plus"
                                                                        aria-hidden="true"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-content">
                                                    <h4 class="product-name">
                                                        {{ $item->name }}
                                                    </h4>
                                                    <div class="price-box">
                                                        <span
                                                            class="current-price">{{ number_format($item->price, 0, ',', '.') }}
                                                            đ</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="noibat" role="tabpanel">
                        <div class="swiper newProduct">
                            <div class="swiper-wrapper">
                                @foreach ($product as $key => $item)
                                    <div class="swiper-slide">
                                        <div class="single-product">
                                            <div class="product-image">
                                                <a href="{{ route('chitietsanpham', ['name' => $item->slug]) }}">
                                                    <img src="{{ asset('assets/uploads/' . $item->images[0]->url) }}"
                                                        alt="">
                                                </a>
                                                <div class="action-links">
                                                    <ul>
                                                        <li>
                                                            <a class="product-detail" href=""><i class="fa fa-eye"
                                                                    aria-hidden="true"></i></a>
                                                        </li>
                                                        <li>
                                                            <a class="add-to-cart" href=""><i
                                                                    class="fa fa-cart-plus" aria-hidden="true"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h4 class="product-name">
                                                    {{ $item->name }}
                                                </h4>
                                                <div class="price-box">
                                                    <span
                                                        class="current-price">{{ number_format($item->price, 0, ',', '.') }}
                                                        đ</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="dangsale" role="tabpanel">
                        <div class="swiper newProduct">
                            <div class="swiper-wrapper">
                                @foreach ($product as $key => $item)
                                    <div class="swiper-slide">
                                        <div class="single-product">
                                            <div class="product-image">
                                                <a href="{{ route('chitietsanpham', ['name' => $item->slug]) }}">
                                                    <img src="{{ asset('assets/uploads/' . $item->images[0]->url) }}"
                                                        alt="">
                                                </a>
                                                <div class="action-links">
                                                    <ul>
                                                        <li>
                                                            <a class="product-detail"
                                                                href="{{ route('chitietsanpham', ['name' => $item->slug]) }}"><i
                                                                    class="fa fa-eye" aria-hidden="true"></i></a>
                                                        </li>
                                                        <li>
                                                            <a class="add-to-cart" href=""><i
                                                                    class="fa fa-cart-plus" aria-hidden="true"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h4 class="product-name">
                                                    {{ $item->name }}
                                                </h4>
                                                <div class="price-box">
                                                    <span
                                                        class="current-price">{{ number_format($item->price, 0, ',', '.') }}
                                                        đ</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- baiviet --}}
    <div class="blog-area blog-bg section-padding-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-9 col-sm-11 w-100">
                    <div class="section-title text-center">
                        <h2 class="title">Bài Viết Của Chúng Tôi</h2>
                        <p>A perfect blend of creativity, energy, communication, happiness and love. Let us arrange a
                            smile for you.</p>
                    </div>
                </div>
            </div>
            <div class="blog-wrapper mt-30">
                <div class="swiper-container blog-active swiper-container-initialized swiper-container-horizontal">
                    <div class="swiper-wrapper" aria-live="polite">
                        @foreach ($post as $item)
                            <div class="swiper-slide">

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
                                                href="#">Tìm
                                                hiểu thêm</a>
                                            <!-- <p class="comment-count"><i class="icon-message-circle"></i> 0</p> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Add Arrows -->
                        @if (count($post) > 3)
                            <div class="swiper-next" tabindex="0" role="button" aria-label="Next slide"
                                aria-controls="swiper-wrapper-5eab3a3b40429f0d"><i class="fa fa-angle-right"></i></div>
                            <div class="swiper-prev" tabindex="0" role="button" aria-label="Previous slide"
                                aria-controls="swiper-wrapper-5eab3a3b40429f0d"><i class="fa fa-angle-left"></i></div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
