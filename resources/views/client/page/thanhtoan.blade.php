@extends('client.layout')
@section('content')
    <div class="cart-page section-padding-5">
        <form action="{{ route('checkout') }}" method="post">
            <div class="container ">
                <div class="container__address">
                    <div class="container__address-css"></div>
                    <div class="container__address-content">
                        <div class="container__address-content-hd justify-content-between">
                            <div><i class="container__address-content-hd-icon fa fa-map-marker"></i>Địa Chỉ Nhận Hàng</div>
                            <button type="button" class="btn btn-primary show-add-address">+
                                Thêm
                                Địa Chỉ</button>
                        </div>
                        <ul class="shipping-list list-address"></ul>
                    </div>
                </div>
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
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($cart as $item)
                                @php
                                    $total += $item->quantity * $item->product->price;
                                @endphp
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
                                        <span class="text-primary">Còn Lại: {{ $item->stock }}</span>
                                        {{-- <input type="hidden" class="Quantity" id="Quantity-56-Size8-9Y" value="42"> --}}
                                    </td>
                                    <td class="price">
                                        <span class="amount">{{ number_format($item->product->price, 0, '.', ',') }}</span>
                                    </td>
                                    <td class="quantity">
                                        <div class="quantity d-inline-flex align-items-center border-0 ">
                                            {{-- <i class="fa fa-minus-square"></i> --}}
                                            <span>{{ $item->quantity }}</span>
                                            {{-- <input type="hidden" class="QuantityBuy" id="QuantityBuy-56"
                                                value="{{ $item->quantity }}"> --}}
                                            {{-- <i class="fa fa-plus-square"></i> --}}
                                            {{-- <div class="alert-qty-input"><span class="message-qty-input">Mua tối đa
                                                    {{ $item->stock }} sản
                                                    phẩm!</span></div> --}}
                                            {{-- <input type="hidden" value="35">
                                    <input type="hidden" value="175000">
                                    <input type="hidden" value="42"> --}}
                                        </div>
                                    </td>
                                    <td class="total">
                                        <span
                                            class="total-amount">{{ number_format($item->product->price * $item->quantity, 0, '.', ',') }}</span>
                                    </td>
                                     <!-- <td class="remove">
                                        <button class="view-hover delete-pd-cart bg-transparent border-0 "
                                            data-id="{{ $item->id }}"><i class="fa fa-trash"></i></button>
                                    </td>  -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="row">
                    <div class="col-lg-6">
                        <div class="cart-coupon">
                            <div class="cart-title">
                                <h4 class="title">Mã giảm giá</h4>
                                <p>Nhập mã giảm giá của bạn nếu có.</p>
                            </div>
                            <div class="cart-form mt-25 d-flex">
                                <div class="single-form flex-fill mr-30">
                                    <input type="text" id="VoucherCode"
                                        placeholder="Nhập mã giảm giá (chỉ áp dụng 1 lần)">
                                    <small color="red" class="voucherMessage text-primary alert-voucher"></small>
                                </div>
                                <div class="cart-form-btn d-flex">
                                    <button type="button" style="width:97px;"
                                        class="btn btn-primary pl-2 pr-2 check-voucher">Áp dụng</button>
                                </div>
                            </div>
                            {{-- <div class="text-primary alert-voucher"></div> --}}
                        </div>
                    </div>
                    <div class="col-lg-6 container__address-content">
                        <div class="container__address-content-hd">
                            <i class="container__address-content-hd-icon fa fa-money"></i>
                            <div>Phương thức thanh toán</div>
                        </div>
                        <ul class="shipping-list checkout-payment">
                            <li class="cus-radio">
                                <input type="radio" name="checkout" value="cash" id="cash" checked="">
                                <label for="cash">
                                    <span>Thanh toán khi nhận hàng</span>
                                </label>
                            </li>
                            <li class="cus-radio payment-radio">
                                <input type="radio" name="checkout" value="vnpay" id="vnpay">
                                <label for="vnpay">
                                    <span>VNPay</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-12">
                        <div class="cart-totals shop-single-content">
                            <div class="cart-title">
                                <h4 class="title">Tổng giỏ hàng</h4>
                            </div>
                            <div class="cart-total-table mt-25">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Tổng tiền hàng</td>
                                            <td class="text-right">{{ number_format($total, 0, ',', '.') }}đ</td>
                                        </tr>
                                        <tr class="shipping">
                                            <td>Giảm giá</td>
                                            <td class="text-right voucherDiscount">
                                                0đ </td>
                                        </tr>

                                        <tr>
                                            <td width="70%">Thành tiền</td>
                                            <input type="hidden" name="totalmoney" value="{{ $total }}">
                                            <td class="text-right totalBill">{{ number_format($total, 0, ',', '.') }}đ</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="dynamic-checkout-button  ">

                                <div class="cart-total-btn checkout-btn">
                                    <button type="submit" name="redirect" class="btn btn-primary btn-block btnorder"
                                        style="max-width:100%;">Đặt hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <input type="hidden" name="totalAjax" value="{{ $total }}">
    </div>
@endsection
@section('script')
    <script>
        getAddress();

        function getAddress() {
            fetch('http://localhost:8000/getaddress')
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    document.querySelector(".list-address").innerHTML = data;
                })
        }
        $('.show-add-address').click(function() {
            let html = `    <h5>Thêm địa chỉ</h5>
                            <div class="form-group">
                                <label for="">Tên người nhận</label>
                                <input type="text" class="form-control" name="nguoinhan">
                            </div>
                            <div class="form-group">
                                <label for="">Số điện thoại</label>
                                <input type="text" class="form-control" name="sodienthoai">
                            </div>
                            <div class="form-group">
                                <label for="">Địa chỉ</label>
                                <input type="text" class="form-control" name="diachi">
                            </div>
                            <div>
                                <button type="button" class="btn btn-secondary" onclick="closeModel()">Hủy</button>
                                <button type="button" class="btn btn-primary add-address" onclick="addAddress()">Lưu</button>
                                </div>
                        `;
            document.querySelector(".model-content").innerHTML += html;
            document.querySelector(".model").classList.add('active')
        })

        function addAddress() {
            const customerName = $('input[name="nguoinhan"]').val();
            const phone = $('input[name="sodienthoai"]').val();
            const address = $('input[name="diachi"]').val();
            const token = $('input[name="_token"]').val();
            $.ajax({
                type: 'post',
                url: '/add-address',
                data: {
                    name: customerName,
                    phone: phone,
                    address: address,
                    _token: token
                },
                success: function(data) {
                    closeModel();
                    getAddress();
                }
            })
        }

        function editAddress() {
            const customerName = $('input[name="nguoinhan"]').val();
            const phone = $('input[name="sodienthoai"]').val();
            const address = $('input[name="diachi"]').val();
            const token = $('input[name="_token"]').val();
            const id = $('input[name="id"]').val();
            $.ajax({
                type: 'post',
                url: '/edit-address',
                data: {
                    id: id,
                    name: customerName,
                    phone: phone,
                    address: address,
                    _token: token
                },
                success: function(data) {
                    closeModel();
                    getAddress();
                }
            })
        }

        function showEditAddress(data) {
            let html = `    <h5>Thêm địa chỉ</h5>
                            <input type="hidden" name="id" value="${data.dataset.id}"/>
                            <div class="form-group">
                                <label for="">Tên người nhận</label>
                                <input type="text" class="form-control" name="nguoinhan" value="${data.dataset.name}">
                            </div>
                            <div class="form-group">
                                <label for="">Số điện thoại</label>
                                <input type="text" class="form-control" name="sodienthoai" value="${data.dataset.phone}">
                            </div>
                            <div class="form-group">
                                <label for="">Địa chỉ</label>
                                <input type="text" class="form-control" name="diachi" value="${data.dataset.address}">
                            </div>
                            <div>
                                <button type="button" class="btn btn-secondary" onclick="closeModel()">Hủy</button>
                                <button type="button" class="btn btn-primary add-address" onclick="editAddress()">Lưu</button>
                                </div>
                        `;
            document.querySelector(".model-content").innerHTML += html;
            document.querySelector(".model").classList.add('active')
        }

        function RemoveAddress(id) {
            swal({
                    title: 'Thông báo',
                    text: 'Bạn có muốn xóa địa chỉ này',
                    type: "error"
                })
                .then(
                    (isConfirm) => {
                        // console.log(isConfirm);
                        if (isConfirm) {
                            const token = $('input[name="_token"]').val();
                            $.ajax({
                                type: 'post',
                                url: '/remove-address',
                                data: {
                                    id: id,
                                    _token: token
                                },
                                success: function(data) {
                                    // closeModel();
                                    getAddress();
                                }
                            })
                        }
                    }
                )

        }
        $('.btnorder').click(CheckAddress);

        function CheckAddress(event) {
            // kiem tra xem nguoi dung da có dia chi giao hang chua
            let address = document.querySelectorAll('input[name="address_rdo"]').length;
            if (address <= 0) {
                swal('Thông báo', 'Bạn chưa có địa chỉ giao hàng hãy nhập địa chỉ giao hàng', 'info');
                event.preventDefault();
            }
        }
        $('.check-voucher').click(function() {
            const token = $('input[name="_token"]').val();
            $voucherCode = $("#VoucherCode").val();
            let currentTotal = $('input[name="totalAjax"]').val();
            if ($voucherCode != '') {
                $.ajax({
                    type: 'post',
                    url: "{{ route('checkvoucher') }}",
                    data: {
                        _token: token,
                        voucher: $voucherCode,
                        total: currentTotal
                    },
                    success: function(data) {
                        // console.log(data);
                        if (data.code == 200) {
                            $(".voucherMessage").html(data.message);

                            // console.log(parseFloat(currentTotal));
                            let total = parseFloat(currentTotal) - parseFloat(data.data.giamgia);
                            if (total > 0) {
                                $('.totalBill').html(total.toLocaleString('vi-VN') + 'đ');
                                $('input[name="totalmoney"]').val(total);
                                $('.voucherDiscount').html(data.data.giamgia + 'đ')
                            } else {
                                $('.totalBill').html(0 + 'đ');
                                $('input[name="totalmoney"]').val(0);
                                $('.voucherDiscount').html(currentTotal + 'đ')
                            }
                            $('.cart-coupon').append(
                                `<input type="hidden" value="${data.data.id}" name="voucher">`)

                        } else {
                            $(".voucherMessage").html(data.message);
                        }
                    }
                })
            }
        })
    </script>
@endsection
