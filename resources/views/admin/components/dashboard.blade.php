<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>An Dung Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('head')
    @yield('style')
    <style>
        body {
            height: 100vh;
        }
    </style>
</head>

<body class="">
    @csrf
    <div class="container-fluid" style="padding: 0 !important;">
        <div class="header-account-list mobile-menu-trigger ms-2 d-sm-block d-lg-none">
            <button id="menu-trigger">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>
        </div>
        <div class="header-mobile-menu d-lg-none d-sm-none ">

            <a href="javascript:void(0)" class="mobile-menu-close">
                <span></span>
                <span></span>
            </a>
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
        <div class="container-fluid page-body-wrapper p-0">
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <div class="user-profile">
                    <div class="user-image">
                        <img src="{{ asset('assets/imgs/andung.png') }}">
                    </div>
                    <div class="user-name">
                        ADMIN
                    </div>
                    <div class="user-designation">
                        {{-- ADMIN --}}
                    </div>
                </div>
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fa fa-home me-3 " aria-hidden="true"></i>
                            <span class="menu-title">Trang chủ</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="{{ route('category.index') }}"
                            aria-expanded="false" aria-controls="ui-basic">
                            <i class="icon-disc menu-icon"></i>
                            <span class="menu-title">Danh mục sản phẩm</span>
                        </a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('product.index') }}">
                            <i class="icon-file menu-icon"></i>
                            <span class="menu-title">Sản phẩm</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('order.index') }}">
                            <i class="icon-pie-graph menu-icon"></i>
                            <span class="menu-title">Đơn hàng</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('post.index') }}">
                            <i class="icon-pie-graph menu-icon"></i>
                            <span class="menu-title">Bài viết</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('voucher.index') }}">
                            <i class="icon-pie-graph menu-icon"></i>
                            <span class="menu-title">Khuyến mãi</span>
                        </a>
                    </li>
                
                    <li class="nav-item">
                        <a href="{{ route('admin.logout') }}" class="nav-link">
                            {{-- <i class="icon-inbox"></i> --}}
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            <span class="menu-title">Logout</span>
                        </a>
                    </li>

                </ul>
            </nav>
            <main class="container overflow-y-auto ">
                @yield('content')
            </main>
        </div>
    </div>
    <div class="model  ">
        <div class="model-content">
        </div>
    </div>
</body>

</html>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/template.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script> --}}
@include('sweetalert::alert')
<script src="{{ asset('assets/js/ckeditor.js') }}"></script>
<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script>
    $(document).ready(function() {
        $('input[name="allID"]').change(function() {
            // console.log('oke');
            if ($(this).is(':checked')) {
                $('input[name="id"]').prop('checked', true);
            } else {
                $('input[name="id"]').prop('checked', false);
            }
            showOption();
        })

        let checkBox = false;
        // let checkBoxes = 
        function showOption() {
            let allChecked = $('input[name="id"]:checked').length === $('input[name="id"]').length
            if (allChecked) {
                $('input[name="allID"]').prop('checked', true);
            } else {
                $('input[name="allID"]').prop('checked', false);
            }
            checkBox = $('input[name="id"]').is(':checked');
            if (checkBox) {

                $(".action").removeClass('d-none');
            } else {
                // console.log(checkBox);
                $(".action").addClass('d-none');
            }
        }
        $('input[name="id"]').on('change', showOption)
    });

    function closeModel() {
        document.querySelector(".model").classList.remove('active')
        document.querySelector(".model-content").innerHTML = '';
    }
</script>
@yield('script')
