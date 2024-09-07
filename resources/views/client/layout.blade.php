<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>An Dung Shop</title>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
    <link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @yield('style')
    <style>
        .header-logo img {
            border-radius: 50%;
        }
    </style>
</head>

<body>
    @csrf
    <div class="main-wrapper">
        <div class="header-mobile d-lg-none sticky">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="header-logo d-none  ">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('assets/imgs/andung.png') }}" class="img-fluid w-25 h-25" alt=""></a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="header-meta-info">
                            <div class="header-account">

                                {{-- <div class="header-account-list dropdown top-link"> --}}

                                @if (!Auth::check() || Auth::user()->role != 'khachhang')
                                    <button class="btn  noborder dropdown-toggle text-primary" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/register') }}">Đăng ký</a></li>
                                        <li><a href="{{ url('/login') }}">Đăng nhập</a></li>
                                    </ul>
                                @else
                                    <div class="dropdown">
                                        <button class="btn  noborder dropdown-toggle text-primary" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="">Hồ
                                                    sơ của tôi
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('ordered') }}">Đơn
                                                    mua
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('logout') }}">Đăng
                                                    xuất
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="cart-block">
                                        <a href="{{ route('giohang') }}">
                                            <i class="fa-solid fa-cart-shopping w-100 fs-4"></i>
                                        </a>
                                    </div>
                                @endif
                                {{-- @endif --}}

                                {{-- </div> --}}

                                <div class="header-account-list mobile-menu-trigger ms-2 ">
                                    <button id="menu-trigger">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-mobile-menu d-lg-none">

            <a href="javascript:void(0)" class="mobile-menu-close">
                <span></span>
                <span></span>
            </a>

            <div class="header-meta-info">
                <div class="header-search">
                    <form action="{{ route('locsanpham') }}" method="get">
                        <input type="text" name="keyword" placeholder="Tìm kiếm sản phẩm " autocomplete="off"
                            class="" style="border:none;background: transparent">
                        <button class="bg-transparent " style="border:none">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                    {{-- <form type="GET" action="{{ route('locsanpham') }}">
                        <input type="text" name="keyword" id="search-input"  placeholder="Tìm kiếm sản phẩm  "
                            autocomplete="off">
                        <button class="search-btn"><i class="icon-search"></i></button>
                    </form> --}}
                </div>
            </div>

            <div class="site-main-nav">
                <nav class="site-nav">
                    <ul class="navbar-mobile-wrapper">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="/cuahang">Cửa hàng</a></li>
                        <li><a href="">Tin tức</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="header-section d-lg-block p-0 d-none ">
            <div class="main-header">
                <div class="container position-relative ">
                    <div class="row align-items-center ">
                        <div class="col-lg-2 ">
                            <div class="header-logo h-100 ">
                                <a href="{{ url('/') }}">
                                    <img src="{{ asset('assets/imgs/andung.png') }}" alt="" style="height: 100%">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-7 position-static d-flex justify-content-around">
                            <div class="site-main-nav d-flex justify-content-around w-100 ">
                                <div class="site-nav d-flex justify-content-around w-100">
                                    <ul class="nav d-flex justify-content-around w-100 ">
                                        <li class="nav-item mx-2">
                                            <a href="{{ url('/') }}">
                                                Trang chủ
                                            </a>
                                        </li>
                                        <li class="nav-item mx-2 " class="menu-item-has-children position-static ">
                                            <a href="{{ url('/cuahang') }}">
                                                Cửa hàng
                                            </a>
                                        </li>
                                        <li class="nav-item mx-2 ">
                                            <a href="{{ url('tin-tuc') }}">Tin tức</a>
                                        </li>
                                        <!-- <li class="nav-item mx-2 ">
                                            <a href="{{ url('lienhe') }}">Liên hệ</a>
                                        </li> -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="header-meta-info d-lg-flex  position-relative ">
                                <div class="header-search">
                                    <form action="{{ route('locsanpham') }}" method="get">
                                        <input type="text" name="keyword" placeholder="Tìm kiếm " class="w-4"
                                            autocomplete="off" class=""
                                            style="border:none;background: transparent">
                                        <button class="bg-transparent " style="border:none">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </form>
                                </div>
                                <ul class="search-product">

                                </ul>
                                <div class="header-account d-flex ">
                                   
                                        @if (!Auth::check() || Auth::user()->role != 'khachhang')
                                        <div class="header-user">
                                            <div class="d-flex ">
                                                <a href="{{ route('login') }}"
                                                    class="link-underline link-underline-opacity-0 col-6">Đăng
                                                    nhập
                                                </a>
                                                <span>/</span>
                                                <a href="{{ route('register') }}"
                                                    class="link-underline link-underline-opacity-0 col-6">Đăng
                                                    ký
                                                </a>
                                            </div>
                                        </div>
                                        @else
                                        <div class="header-user">

                                            <div class="dropdown">
                                                <button class="btn  noborder dropdown-toggle text-black"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{route('user.profile')}}">Hồ
                                                            sơ của tôi
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('ordered') }}">Đơn
                                                            mua
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('logout') }}">Đăng
                                                            xuất
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                    </div>
                                    <div class="cart-block">
                                        <a href="{{ route('giohang') }}">
                                            <i class="fa-solid fa-cart-shopping w-100 fs-4"></i>
                                        </a>
                                    </div>     
                                        @endif
                                    

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @yield('banner')
        @yield('content')
    </div>
    <div class="model  ">
        <div class="model-content">
        </div>

    </div>
</body>

</html>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script> --}}
{{-- <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/main.js') }}"></script> --}}
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
{{-- <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script> --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    $('#menu-trigger').click(function() {
        $(".header-mobile-menu").addClass('open');
    })
    $(".mobile-menu-close").click(function() {
        $(".header-mobile-menu").removeClass('open');

    })
    // goi y tim kiem
    $('input[name="keyword"]').on('keyup', function() {
        // console.log('a');
        const value = $('input[name="keyword"]').val();
        const token = $('input[name="_token"]').val();
        $.ajax({
            url: '/goiytimkiem',
            type: 'POST',
            data: {
                value: value,
                _token: token
            },
            success: function(data) {
                $('.search-product').fadeIn();
                $(".search-product").html(data);
                console.log(data);
            }
        })
    })
    $('input[name="keyword"]').on('blur', function() {
        $('.search-product').fadeOut();
    });

    const blog = new Swiper(".blog-active", {
        speed: 800,
		loop: false,
		slidesPerView: 3,
		spaceBetween: 30,
		navigation: {
		  nextEl: '.swiper-next',
		  prevEl: '.swiper-prev',
		},
		breakpoints: {
			0: {
			  slidesPerView: 1,
			},
			576: {
			  slidesPerView: 1,
			},
			768: {
			  slidesPerView: 2,
			},
			992: {
			  slidesPerView: 3,
			},
		}
    });
    const swiperNewProduct = new Swiper(".newProduct", {


        watchSlidesProgress: true,
        slidesPerView: 4,
        spaceBetween: 30,
        centeredSlides: true,
        loop: true,
        speed: 800,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            576: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            992: {
                slidesPerView: 4,
            },
        }
    });
    var swiperBanner = new Swiper('.slider-active', {
        speed: 800,
        loop: true,
        slidesPerView: 1,
        // autoplay: {
        //     delay: 2500,
        //     disableOnInteraction: false,
        // },
        navigation: {
            nextEl: ".swiper-next",
            prevEl: ".swiper-prev",
        },
        // navigation: {
        //     nextEl: ".swiper-button-next",
        //     prevEl: ".swiper-button-prev",
        // },
        effect: "fade",
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

    });
    // var swiper = new Swiper(".mySwiper", {
    //     watchSlidesProgress: true,
    //     slidesPerView: 3,
    // });
    let arrayQuantity = [];

    function addToCart(id, event) {
        // console.log(event);
        event.preventDefault();
        fetch(`http://localhost:8000/api/sizeandcolor/${id}`)
            .then(response => response.json())
            .then(data => {
                arrayQuantity = [];
                let arraySize = new Set();
                let arrayColor = new Set();
                arrayQuantity = data.data;
                data.data.forEach(item => {
                    arraySize.add(item['size']);
                    arrayColor.add(item['color']);
                });
                let html = `<span class="exit" onclick="closeModel()">
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                            </span>`;

                html += `<div>Màu sắc: </div>
                        <div class="box-color">`
                Array.from(arrayColor).forEach((item, index) => {
                    if (index == 0) {
                        html += `<div class="item">
                                <input type="radio" name="color" id="${item}" data-color="${item}" onclick="toggleSizeAndColor()"checked>
                                <label for="${item}">${item}</label>
                            </div>`
                    } else {
                        html += `<div class="item">
                                <input type="radio" name="color" id="${item}" data-color="${item}" onclick="toggleSizeAndColor()">
                                <label for="${item}">${item}</label>
                            </div>`
                    }
                })
                html += `</div>
                         <div>Kích thước:</div>   
                            <div class="box-size">`
                // console.log(typeof arrayColor);
                Array.from(arraySize).forEach((item, index) => {
                    // console.log(index);
                    if (index == 0) {
                        html += `<div class="item">
                                    <input type="radio" name="size" id="${item}"  data-size="${item}" onclick="toggleSizeAndColor()" checked>
                                    <label for="${item}">${item}</label>
                                </div>`
                    } else {
                        html += `<div class="item">
                                    <input type="radio" name="size" id="${item}" data-size="${item}" onclick="toggleSizeAndColor()">
                                    <label for="${item}">${item}</label>
                                </div>`
                    }
                })
                html += `</div>
                        `;
                arrayQuantity.forEach((item, index) => {
                    // console.log(arrayQuantity);
                    if (index == 0) {
                        html += `<div class="quantity-item active" data-sizecolor="${item['size']}${item['color']}" >
                                Còn lại: <span>${item['quantity']}</span>
                                </div>`;
                    } else {
                        html += `<div class="quantity-item" data-sizecolor="${item['size']}${item['color']}">
                                Còn lại: <span>${item['quantity']}</span></div>`;
                    }
                })
                html += `
                        <div class="box-quantity">
                            <span>Số lượng: </span>
                            <i onclick="updateQuantityModal('giam')" class="fa fa-minus-square" aria-hidden="true"></i>
                            <input type="number" step="1" min="1" value="1" class='quantity' oninput="validity.valid||(value='1');" onchange="updateQuantityModal('change')">  
                            <i onclick="updateQuantityModal('tang')" class="fa fa-plus-square" aria-hidden="true"></i>  
                        </div>
                        <div><button class="btn btn-primary mt-2"  onclick="btnAddToCart(${id})">
                                Thêm giỏ hàng
                            </button>
                            </div>`;
                // console.log(html);
                document.querySelector(".model-content").innerHTML += html;
                document.querySelector(".model").classList.add('active')
            });
    }

    function closeModel() {
        document.querySelector(".model").classList.remove('active')
        document.querySelector(".model-content").innerHTML = '';
    }



    function toggleSizeAndColor() {
        let size;
        let color;
        $('input[name="size"]').each(function() {
            if ($(this).is(':checked') == true) {
                // console.log("a");
                size = $(this).data('size');

            }
        });
        $('input[name="color"]').each(function() {
            if ($(this).is(':checked') == true) {
                color = $(this).data('color');
            }
        });
        // console.log(size + color);
        $('.quantity-item').each(function() {
            console.log($(this).data('sizecolor'));
            if ($(this).data('sizecolor') == size + color) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        })
        // console.log(size + color);
        // console.log('oke');
        $('.quantity').val(1);
    }

    function btnAddToCart(id) {
        const Authlogin = {!! json_encode(Auth::check()) !!};
        if (Authlogin) {
            let quantityStock = document.querySelector(".quantity-item.active>span").textContent;
            // console.log(typeof quantityStock);
            let quantity = $(".quantity").val();
            // console.log(quantity <= parseInt(quantityStock));
            if (quantity <= parseInt(quantityStock)) {
                let size;
                let color;
                $('input[name="size"]').each(function() {
                    if ($(this).is(':checked') == true) {
                        // console.log("a");
                        size = $(this).data('size');

                    }
                });
                $('input[name="color"]').each(function() {
                    if ($(this).is(':checked') == true) {
                        color = $(this).data('color');
                    }
                });
                const token = $('input[name="_token"]').val();
                $.ajax({
                    url: '/addToCart',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data: {
                        token: token,
                        quantity: quantity,
                        size: size,
                        color: color,
                        id: id
                    },
                    success: function(data) {
                        const model = document.querySelector(".model")
                        model.classList.remove('active')
                        model.querySelector('.model-content').innerHTML = '';
                        if (data.status == true) {
                            swal('Thông báo', data.message, 'success');
                        } else {
                            swal('Thông báo', data.message, 'error');
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }

                })
            } else {
                alert('Số lượng mua lớn hơn số lượng trong kho');
            }
        } else {
            window.location.href = `http://localhost:8000/login`;
        }

        // console.log(id);
    }
    // them gio hang

    function updateQuantityModal(action) {
        // console.log(arrayQuantity);
        let quantityStock = document.querySelector(".quantity-item.active>span").textContent;
        // console.log(quantityStock);
        let inputQuantity = $('.quantity');
        let currentQuantity = parseInt(inputQuantity.val());
        if (action == 'giam') {
            if (currentQuantity > 1) {
                inputQuantity.val(currentQuantity - 1);
            } else {
                inputQuantity.val(1);
            }
        } else if (action == 'tang') {
            if (currentQuantity < parseInt(quantityStock)) {
                inputQuantity.val(currentQuantity + 1);
            } else {
                inputQuantity.val(quantityStock);
            }
        } else {
            if (currentQuantity > parseInt(quantityStock)) {
                inputQuantity.val(quantityStock);
            }
        }
    }
</script>
@yield('script')
