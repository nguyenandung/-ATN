@extends('client.layout')
@section('style')
    <style>
        .page-item {
            /* background-color: #f379a7; */
            margin: 3px;
        }
    </style>
@endsection
@section('content')
    <div class="container mt-md-5  pt-md-2  ">
        <div class="row">
            <div class="col-lg-3">
                <h3 class="text-uppercase ">bộ lọc tìm kiếm</h3>
                <div class="sidebar-category mt-2 ">
                    <h4>Theo danh mục</h4>
                    <ul class="categories-list">
                        @foreach ($category as $item)
                            {{-- @php
                                dd($category);
                            @endphp --}}
                            <li class="d-flex align-items-center mt-2">
                                <input class="filter-product" type="checkbox" value="{{ $item->id }}"
                                    id="{{ $item->id }}" style="width:15px;height:15px;" onclick="filterCategory()">
                                <label class="mb-0 ms-2" for="{{ $item->id }}">
                                    <span class="fw-bold fs-6 ">
                                        {{ $item->name }}
                                    </span>
                                </label>
                                <span class="ms-auto fw-bold ">
                                    ({{ $item->product->count() }})
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="sidebar-price mt-2">
                    <h5>Theo giá</h5>
                    <div class="d-flex justify-content-between ">
                        <input type="text" class="px-3 " placeholder="đ Từ" id="priceTo">
                        <span class="d-flex flex-column justify-content-center ">&nbsp;&nbsp;-&nbsp;&nbsp;</span>
                        <input type="text" class="px-3" placeholder="đ Đến" id="priceFrom">
                    </div>
                    <div class=" mt-2">
                        <button type="button" class="btn btn-primary w-100 applyPrice">Áp dụng</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="container-fluid mt-2">
                    <div class="row">
                        @foreach ($product as $item)
                            <div class="col-sm-4 ">
                                <div class="single-product" style="">
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
                                                    <a class="add-to-cart" href=""
                                                        onclick="addToCart({{ $item->id }},event)"><i
                                                            class="fa fa-cart-plus" aria-hidden="true"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h4 class="product-name">
                                            <a
                                                href="{{ route('chitietsanpham', ['name' => \Illuminate\Support\Str::slug($item->name, '-')]) }}">
                                                {{ $item->name }}
                                            </a>
                                        </h4>
                                        <div class="price-box text-center ">

                                            <span class="current-price">{{ number_format($item->price, 0, ',', '.') }}
                                                đ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="page-pagination">
                        <nav>
                            <ul class="pagination justify-content-center">
                                {{ $product->links() }}
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function setInputState() {
            let urlParams = new URLSearchParams(window.location.search);
            let danhMucValues = urlParams.get('danhmuc');
            let priceTo = urlParams.get('min');
            let priceFrom = urlParams.get('max');
            if (danhMucValues) {
                let danhMucArray = danhMucValues.split(',');
                $(".filter-product").each((index, item) => {
                    if (danhMucArray.includes(item.id)) {
                        item.checked = true;
                    }
                });
            }
            document.getElementById("priceTo").value = priceTo;
            document.getElementById("priceFrom").value = priceFrom;
        }

        // Gọi hàm setCheckboxState() khi trang được tải lại
        setInputState();
        let url = window.location.href;
        url = url.indexOf('?keyword=') != -1 ? url : `${window.location.origin}/cuahang?store=all`;
        let priceTo = document.getElementById('priceTo').value;
        let priceFrom = $('#priceFrom').val();
        console.log(priceTo);

        function filterCategory() {
            let currentHref = window.location.href;
            if (currentHref.indexOf('?store=all') != -1) {
                url = currentHref;
            }
            console.log(url);
            let arrayCategory = [];
            let CategoryList = $(".filter-product");
            CategoryList.each((index, item) => {
                if (item.checked) {
                    // console.log(item.id);
                    arrayCategory.push(item.id)
                }
            });
            let index = 0;
            if (arrayCategory.length > 0) {
                const indexDM = url.indexOf('&danhmuc=');
                if (indexDM != -1) {
                    index = indexDM + '&danhmuc='.length;
                    url = url.slice(0, index) + arrayCategory.toString();
                } else {
                    url = url + '&danhmuc=' + arrayCategory.toString();
                }
                if (priceTo != '') {
                    url = url + '&min=' + priceTo;
                }
                if (priceFrom != '') {
                    url += '&max=' + priceFrom;
                }
                window.location.href = url;
            }
        }

        $(".applyPrice").click(function() {
            let currentHref = window.location.href;
            if (currentHref.indexOf('?store=all') != -1) {
                url = currentHref;
            }
            let urlParams = new URLSearchParams(window.location.search);
            let currentPriceTo = urlParams.get('min');
            let currentPriceFrom = urlParams.get('max');

            // console.log(priceTo);
            let priceTo = $('#priceTo').val();
            let priceFrom = $('#priceFrom').val();

            // let index = 0;
            const indexPriceMin = url.indexOf('&min=');
            const indexPriceMax = url.indexOf('&max=');

            if (indexPriceMin != -1) {
                if (currentPriceTo == null) {
                    url = url.replace('&min=', `&min=${priceTo}`);
                } else {
                    url = url.replace(`&min=${currentPriceTo}`, `&min=${priceTo}`);
                }
            } else {
                if (priceTo != '') {
                    url = url + `&min=${priceTo}`;
                }
            }

            if (indexPriceMax != -1) {
                if (currentPriceTo == null) {
                    url = url.replace('&max=', `&max=${priceFrom}`);
                } else {
                    url = url.replace(`&max=${currentPriceFrom}`, `&max=${priceFrom}`);

                }
            } else {
                if (priceFrom != '') {
                    url = url + `&max=${priceFrom}`;
                }
            }
            window.location.href = url;
        })
    </script>
@endsection
