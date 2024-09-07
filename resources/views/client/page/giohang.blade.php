@extends('client.layout')
@section('content')
    <div class="cart-page section-padding-5">
        @if (count($cart) > 0)
            <div class="container ">
                <div class="cart-table table-responsive ">
                    @csrf
                    <table class="table ">
                        <thead>
                            <tr>
                                <th class="image">Hình Ảnh</th>
                                <th class="product">Sản Phẩm</th>
                                <th class="price">Giá</th>
                                <th class="quantity">Số Lượng</th>
                                <th class="total">Tổng</th>
                                <th class="remove">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @php
                            $total = 0;
                        @endphp --}}
                            @foreach ($cart as $item)
                                {{-- @php
                                $total += $item->quantity * $item->product->price;
                            @endphp --}}
                                <tr class="product-item id-{{ $item->id }}">
                                    <td class="image">
                                        <a href="{{ route('chitietsanpham', ['name' => $item->product->slug]) }}">
                                            <img src="{{ asset('assets/uploads/' . $item->product->images[0]->url) }}"
                                                alt=""></a>
                                    </td>
                                    <td class="product">
                                        <a href="{{ route('chitietsanpham', ['name' => $item->product->slug]) }}">
                                            {{ $item->product->name }}
                                        </a>
                                        <span>Mã sản phẩm: {{ $item->product->id }}</span>
                                        <span>Loại: {{ $item->color }}-{{ $item->size }}</span>
                                        <span class="text-primary stock-{{ $item->id }}">Còn Lại:
                                            <span>{{ $item->stock }}</span></span>
                                        {{-- <input type="hidden" class="Quantity" id="Quantity-56-Size8-9Y" value="42"> --}}
                                    </td>
                                    <td class="price">
                                        <span
                                            class="amount">{{ number_format($item->product->price, 0, '.', '.') }}đ</span>
                                    </td>
                                    <td class="quantity">
                                        <div class="quantity d-inline-flex align-items-center ">
                                            <i class="fa fa-minus-square action" data-action="tru"
                                                data-id="{{ $item->id }}"></i>
                                            <input type="number" class="QuantityBuy change"
                                                id="QuantityBuy-{{ $item->id }}" value="{{ $item->quantity }}"
                                                min="1" oninput="validity.valid||(value='1');" data-action="change"
                                                data-id="{{ $item->id }}">
                                            <i class="fa fa-plus-square action" data-action="cong"
                                                data-id="{{ $item->id }}"></i>
                                            <div class="alert-qty-input"><span class="message-qty-input">Mua tối đa
                                                    {{ $item->stock }} sản
                                                    phẩm!</span></div>
                                            {{-- <input type="hidden" value="35">
                                    <input type="hidden" value="175000">
                                    <input type="hidden" value="42"> --}}
                                        </div>
                                    </td>
                                    <td class="total">
                                        <span
                                            class="total-amount">{{ number_format($item->product->price * $item->quantity, 0, '.', '.') }}</span>
                                    </td>
                                    <td class="remove">
                                        <button class="view-hover delete-item-cart delete-pd-cart bg-transparent border-0 "
                                            data-id="{{ $item->id }}"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="cart-btn">
                    <div class="cart-btn-left">
                        <a href="{{ url('/cuahang') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
                    </div>
                    <div class="cart-btn-right">
                        <a href="{{ route('emptyCart') }}" class="btn">Xóa giỏ hàng</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="cart-totals">
                            <div class="cart-title">
                                <h4 class="title">Tổng giỏ hàng</h4>
                            </div>
                            <div class="cart-total-table mt-25">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p class="value">Thành Tiền</p>
                                            </td>
                                            <td>
                                                <p class="price"></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart-total-btn">
                                <a href="{{ route('thanhtoan') }}" class="btn btn-primary btn-block btn-payment">Thanh
                                    toán</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div>
                <h3 class="w-100 d-flex  justify-content-center ">Giỏ hàng trống</h3>
                <div class="d-flex  justify-content-center ">
                    <a href="{{ url('/cuahang') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            function getTotal() {
                let totalAmount = document.querySelectorAll(".total-amount");
                // console.log(Array.from(totalAmount));
                let total = 0;
                Array.from(totalAmount).forEach(function(item) {
                    // console.log(item);
                    total += Number(item.textContent.replace(/\./g, '').replace('đ', ''));
                })
                let price = document.querySelector('p.price');
                price.textContent = total.toLocaleString('vi-VN') + 'đ';
                console.log(price);
            }
            getTotal();

            function updatequantity(newQuantity, id) {
                // let newQuantity = quantity.val();
                let token = $('input[name="_token"]').val();
                // console.log('oke');
                $.ajax({
                    type: 'post',
                    url: "{{ route('updatequantity') }}",
                    data: {
                        _token: token,
                        newQuantity: newQuantity,
                        id: id
                    },
                    success: function(data) {
                        if (data.data == 200) {
                            let amount = document.querySelector(`tr.id-${id}`).querySelector(
                                "span.amount");

                            console.log(amount);
                            let newTotalAmount = Number(newQuantity) * Number(amount.textContent
                                .replace(/\./g, '')
                                .replace('đ', ''))
                            // console.log();
                            document.querySelector(`tr.id-${id}`).querySelector(
                                    "span.total-amount").textContent =
                                newTotalAmount.toLocaleString('vi-VN')
                            // console.log(amount);

                            getTotal();
                        }
                    }

                })
            }

            function deleteTr(idCart) {
                $.ajax({
                    url: '/deleteCartItem',
                    type: 'POST',
                    data: {
                        _token: token,
                        id: idCart
                    },
                    success: function(data) {
                        // console.log(data);
                        if (data.status == true) {
                            // console.log(data.status);
                            $(`.id-${idCart}`).remove();
                            getTotal();
                        } else {
                            // console.log(data.message);
                        }
                    }
                })
            }
            $('.delete-pd-cart').click(function() {
            const idCart = $(this).data('id');
            // console.log(token);
            deleteTr(idCart);
        })
            $(".action").click(function() {
                handelChangeQuantity($(this).data('action'), $(this).data('id'))
            })
            $(".change").change(function() {
                handelChangeQuantity($(this).data('action'), $(this).data('id'))

            })

            function handelChangeQuantity(action, id) {
                // console.log('oke');

                let quantity = $('#QuantityBuy-' + id);
                let currentquantity = quantity.val()
                let stock = $('span.stock-' + id + '>span').html();
                // console.log(stock);
                // console.log(quantity);
                if (action == 'tru') {
                    if (currentquantity > 1) {
                        quantity.val(parseInt(currentquantity) - 1);

                    } else {
                        deleteTr(id)
                        getTotal();
                        return;
                    }
                } else if (action == 'cong') {
                    if (currentquantity < parseInt(stock)) {
                        // console.log('oke');
                        quantity.val(parseInt(currentquantity) + 1);
                    } else {
                        swal(`Bạn chỉ có thể mua tối đa ${stock} sản phẩm`);
                    }
                } else {
                    if (currentquantity >= parseInt(stock)) {
                        swal(`Bạn chỉ có thể mua tối đa ${stock} sản phẩm`);
                        quantity.val(parseInt(stock));
                    }
                }
                updatequantity(quantity.val(), id) // console.log(quantity.val());
            }
        })
        let token = $('input[name="_token"]').val();
        
    </script>
@endsection
