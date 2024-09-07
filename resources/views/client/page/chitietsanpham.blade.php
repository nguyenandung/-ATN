@extends('client.layout')
@section('style')
    <style>
        .slide-image {
            overflow: hidden;
        }

        .list-image {
            position: relative;
            display: flex;
            flex-wrap: nowrap;
            gap: 15px;
            /* justify-content: space-between; */
        }

        .list-image .pre {
            position: absolute;
            top: 50%;
            left: 0rem;
            transform: translate(0, -50%);
            font-size: 20px;

            background-color: #cccccc;
            color: white
                /* animation: opac 0.5s ease-in-out;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            animation-iteration-count: infinite; */
        }

        .list-image .next {
            position: absolute;
            top: 50%;
            right: 0rem;
            font-size: 20px;
            transform: translate(0, -50%);
            /* background-color: transparent; */
            background-color: #cccccc;
            color: white
        }

        .image-item {
            display: none;
            transition: all 0.5s;
        }

        .image-item.active {
            border: 1px solid red;
        }

        .image-item.show {
            flex: 0 0 33.33%;
            max-width: calc(33.333% - 10px);
            border: 1px solid grey;
            display: block;
            transition: 0.2s ease-in-out;
            /* animation: fadeleft 0.5s ease-in-out; */
            opacity: 1;
            /* transform: translateX(-100%) */
        }

        @keyframes faderight {
            from {
                opacity: 0.4;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeleft {
            from {
                opacity: 0.4;
                transform: translateX(-100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .box-size,
        .box-color {
            display: flex;
            min-width: 60px;
            max-height: 40px;
            max-width: 120px;
            margin: 10px;
        }

        .box-color input[type=radio],
        .box-size input[type=radio] {
            display: none
        }

        .box-color label,
        .box-size label {
            height: 40px;
            text-align: center;
            width: 100%;
            padding: 10px;
            background-color: grey;
            color: black;
            cursor: pointer;
            background-color: #f7f8fa;
        }


        .box-color input[type=radio]:checked+label,
        .box-size input[type=radio]:checked+label {
            background-color: var(--primary-color);
            color: white;
        }


        .quantity-item.active {
            display: block;
        }

        .quantity-item {
            display: none;
        }

        .quantity-buy input[type=number] {
            height: 40px;
            text-align: center;
            max-width: 100px !important;
            border: none !important;
            outline: none;
            font-size: 16px;
        }

        .btn-addCart {
            border-radius: 10px;
            padding: 0 35px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="product-image">
                    <div class="preview-image">
                        <img src="{{ asset('assets/uploads/' . $product->images[0]->url) }}" alt="">
                    </div>
                    <div class="slide-image">
                        <div class="list-image mt-2">
                            @if (count($product->images) > 3)
                                <button class="next" onclick="ImageSlide('next')"><i class="fa fa-chevron-right"
                                        aria-hidden="true"> </i></button>
                                <button class="pre" onclick="ImageSlide('prev')">
                                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                </button>
                            @endif
                            @foreach ($product->images as $key => $item)
                                @if ($key == 0)
                                    <div class="image-item active show">
                                        <img onclick="previewImg('{{ $item->url }}')"
                                            src="{{ asset('assets/uploads/' . $item->url) }}" alt="">
                                    </div>
                                @elseif($key == 1 || $key == 2)
                                    <div class="image-item show">
                                        <img onclick="previewImg('{{ $item->url }}')"
                                            src="{{ asset('assets/uploads/' . $item->url) }}" alt="">
                                    </div>
                                @else
                                    <div class="image-item ">
                                        <img onclick="previewImg('{{ $item->url }}')"
                                            src="{{ asset('assets/uploads/' . $item->url) }}" alt="">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h3>{{ $product->name }}</h3>
                <h5>Mã sản phẩm: {{ $product->id }}</h5>
                <div class="product-info">
                    <div>
                        Còn lại: {{ $product->stock }} sản phẩm
                    </div>
                    <div class="fw-bold ">
                        {{ number_format($product->price, 0, ',', '.') }}
                        đ
                    </div>
                </div>
                <div class="product-color d-flex ">
                    @php
                        $arrayColor = [];
                    @endphp
                    @foreach ($product->productDetail as $key => $item)
                        @if (!in_array($item->color, $arrayColor))
                            @php
                                $arrayColor[] = $item->color;
                            @endphp
                            @if ($key == 0)
                                <div class="box-color">
                                    <input type="radio" name="color" id="{{ $item->color }}"
                                        onclick="toggleSizeAndColor()" checked data-color="{{ $item->color }}">
                                    <label for="{{ $item->color }}" class="color-item">
                                        {{ $item->color }}
                                    </label>
                                </div>
                            @else
                                <div class="box-color">
                                    <input type="radio" name="color" id="{{ $item->color }}"
                                        onclick="toggleSizeAndColor()" data-color="{{ $item->color }}">
                                    <label for="{{ $item->color }}" class="color-item">
                                        {{ $item->color }}
                                    </label>
                                </div>
                            @endif
                        @endif
                    @endforeach

                </div>
                <div class="product-size d-flex">
                    @php
                        $arraysize = [];
                    @endphp
                    @foreach ($product->productDetail as $key => $item)
                        @if (!in_array($item->size, $arraysize))
                            @php
                                $arraysize[] = $item->size;
                            @endphp
                            @if ($key == 0)
                                <div class="box-size">
                                    <input type="radio" name="size" id="{{ $item->size }}"
                                        onclick="toggleSizeAndColor()" checked data-size="{{ $item->size }}">
                                    <label for="{{ $item->size }}" class="size-item">
                                        {{ $item->size }}
                                    </label>
                                </div>
                            @else
                                <div class="box-size">
                                    <input type="radio" name="size" id="{{ $item->size }}"
                                        onclick="toggleSizeAndColor()" data-size="{{ $item->size }}">
                                    <label for="{{ $item->size }}" class="size-item">
                                        {{ $item->size }}
                                    </label>
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
                <div class="quantityInStock">
                    @php
                        $arrayQuantity = [];
                    @endphp
                    @foreach ($product->productDetail as $key => $item)
                        {{-- @php
                            dd($item->id);
                        @endphp --}}
                        @if ($key == 0)
                            <div class="quantity-item active" data-sizecolor="{{ $item->size }}{{ $item->color }}">
                                Còn lại: <span>{{ $item->quantity }}</span>
                            </div>
                        @else
                            <div class="quantity-item " data-sizecolor="{{ $item->size }}{{ $item->color }}">
                                Còn lại: <span>{{ $item->quantity }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="quantity-buy">
                    <span>Số lượng: </span>
                    <i onclick="updateQuantityModal('giam')" class="fa fa-minus-square" aria-hidden="true"></i>
                    <input type="number" step="1" min="1" value="1" class='quantity'
                        oninput="validity.valid||(value='1');">
                    <i onclick="updateQuantityModal('tang')" class="fa fa-plus-square" aria-hidden="true"></i>
                </div>
                <div>
                    <button class="btn btn-primary mt-3 btn-addCart" onclick="btnAddToCart({{ $product->id }})">
                        Thêm vào giỏ hàng
                    </button>
                </div>
                {{-- <div>
                    <button class="btn btn-primary mt-3">
                        Mua ngay
                    </button>
                </div> --}}

            </div>
        </div>
        <div class="row mt-4">
            <div>
                <ul class="nav nav-pills mb-3 d-flex justify-content-center " id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="chitiet-tab" data-bs-toggle="pill" data-bs-target="#chitiet"
                            type="button" role="tab" aria-controls="chitiet" aria-selected="true">Chi tiết sản
                            phẩm</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="danhgia-tab" data-bs-toggle="pill" data-bs-target="#danhgia"
                            type="button" role="tab" aria-controls="danhgia" aria-selected="false">Đánh
                            giá</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="chitiet" role="tabpanel" aria-labelledby="chitiet-tab">
                        <div class="product-description">
                            <h4 class="title">
                                Mô tả sản phẩm
                            </h4>
                            <div class="body">
                                {!! $product->description !!}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="danhgia" role="tabpanel" aria-labelledby="danhgia-tab">
                        <div class="reviews">
                            @if (count($comment) > 0)
                                <h3 class="review-title">Khách hàng đánh giá</h3>
                                <ul class="reviews-items">
                                    @foreach ($comment as $item)
                                        <li>
                                            <div class="single-review">
                                                <h6 class="name">{{ $item->user->name }}</h6>
                                                <div class="rating-date">
                                                    <ul class="rating">
                                                        @for ($i = 0; $i < $item->point; $i++)
                                                            <li class="rating-on"><i class="fa fa-star"></i></li>
                                                        @endfor
                                                    </ul>
                                                    <span class="date">{{ $item->created_at }}</span>
                                                </div>
                                                @if ($item->body != null)
                                                    <p>{{ $item->body }}</p>
                                                @endif
                                                @if ($item->images != null)
                                                    <div style="max-width: 150px; max-height: 150px;">
                                                        <img class="w-100 object-fit-cover "
                                                            src="{{ asset('assets/uploads/' . $item->images) }}"
                                                            alt="">
                                                    </div>
                                                @endif

                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <h3 class="review-title">Sản phẩm chưa có đánh giá nào</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function ImageSlide(action) {
            let ImageSlide = document.querySelectorAll('.image-item');
            const ListImageSho = document.querySelectorAll('.image-item.show');
            const lastIndex = Array.from(ImageSlide).lastIndexOf(ListImageSho[ListImageSho.length - 1]);
            // const lastIndex = Array.from(ImageSlide).lastIndexOf(document.querySelector('.image-item.show'));
            const firstIndex = Array.from(ImageSlide).indexOf(ListImageSho[0]);
            console.log(lastIndex);
            // console.log(firstIndex);
            if (action == 'prev') {
                if (firstIndex != 0) {
                    ImageSlide[lastIndex].classList.remove('show');
                    ImageSlide[firstIndex - 1].classList.add('show');
                    ImageSlide[lastIndex - 1].style.animation = '';
                    ImageSlide[firstIndex].style.animation = '';
                    ImageSlide[firstIndex - 1].style.animation = '';

                    setTimeout(() => {
                        ImageSlide[lastIndex - 1].style.animation = 'fadeleft 0.5s ease-in-out';
                        ImageSlide[firstIndex].style.animation = 'fadeleft 0.5s ease-in-out';
                        ImageSlide[firstIndex - 1].style.animation = 'fadeleft 0.5s ease-in-out';
                        ImageSlide[lastIndex].style.animation = '';
                    }, 15);
                }

            } else {
                if (lastIndex < ImageSlide.length - 1) {
                    ImageSlide[firstIndex].classList.remove('show');
                    ImageSlide[lastIndex + 1].classList.add('show');
                    ImageSlide[lastIndex + 1].style.animation = '';
                    ImageSlide[lastIndex].style.animation = '';
                    ImageSlide[firstIndex + 1].style.animation = '';

                    setTimeout(() => {
                        ImageSlide[lastIndex + 1].style.animation = 'faderight 0.5s ease-in-out';
                        ImageSlide[lastIndex].style.animation = 'faderight 0.5s ease-in-out';
                        ImageSlide[firstIndex + 1].style.animation = 'faderight 0.5s ease-in-out';
                        ImageSlide[firstIndex].style.animation = '';
                    }, 15);
                }
            }
        }

        function previewImg(url) {
            console.log(url);
            const preViewImg = document.querySelector('.preview-image>img');
            preViewImg.src = `{!! asset('assets/uploads/') !!}/${url}`;
        }
    </script>
@endsection
