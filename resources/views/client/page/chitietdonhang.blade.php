@extends('client.layout')
@section('content')
    <div class="cart-page section-padding-5">
        <div class="container">

            <div class="container__address">
                <div class="container__address-css"></div>
                <div class="container__address-content">
                    <div class="container__address-content-hd justify-content-between">
                        <div><i class="container__address-content-hd-icon fa fa-map-marker"></i>Địa Chỉ Nhận Hàng</div>
                    </div>
                    <div style="font-size:20px;">
                        <div>Tên người nhận: {{ $order->customerName }}</div>
                        <div>Số điện thoại: {{ $order->phone }}</div>
                        <div>Địa chỉ: {{ $order->address }}</div>
                    </div>
                </div>
            </div>

            <div class="cart-table table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th class="image">Hình Ảnh</th>
                            <th class="product">Sản Phẩm</th>
                            <th class="price">Giá</th>
                            <th class="quantity">Số Lượng</th>
                            <th class="total">Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetail as $item)
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
                                </td>
                                <td class="price">
                                    <span class="amount">{{ number_format($item->product->price, 0, '.', ',') }}</span>
                                </td>
                                <td class="quantity">
                                    <div class="quantity d-inline-flex align-items-center border-0 ">
                                        <span>{{ $item->quantity }}</span>
                                    </div>
                                </td>
                                <td class="total">
                                    <span
                                        class="total-amount">{{ number_format($item->product->price * $item->quantity, 0, '.', ',') }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($order->isCancel == 1)
                <h3 style="color: red;">Đã hủy đơn hàng</h3>
                <p class="fs-5 ">Lý do: {{ $order->cancelReson }}</p>
            @else
                <div class="row">
                    <div>
                        Lưu ý: <span class="fw-bold ">Vui lòng kiểm tra hàng trước khi nhận hàng. Chúng tôi sẽ không chịu
                            trách
                            nhiệm sau khi bạn đã
                            nhận hàng </span>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-totals shop-single-content">
                        <div class="cart-title">
                            <h4 class="title">Tổng giỏ hàng</h4>
                        </div>
                        <div class="cart-total-table mt-25" style="position:relative;">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Tổng tiền hàng</td>
                                        <td class="text-right">{{ $order->totalMoney }}</td>
                                    </tr>
                                    <tr>
                                        <td width="70%">Thành tiền</td>
                                        <td class="text-right totalBill">{{ $order->totalMoney }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if (mb_strtoupper($order->status) == 'CHỜ XÁC NHẬN')
                <div class="row">
                    <button class="btn btn-primary " onclick="showModelDeleteOrder({{ $order->id }})">Hủy đơn
                        hàng</button>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script>
        function showModelDeleteOrder(id) {
            let html = `<span class="exit" onclick="closeModel()">
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                        </span>
                        <div>
                            <div class="form-group">
                                <label for="" class="form-label ">Lý do hủy đơn hàng</label>
                                <input type="text" name="lydo" class="form-control " placeholder="Lý do hủy ">
                            </div>
                            <div>
                                <button class="btn-sm btn-primary border-2 " onclick="deleteOrder(${id})">Xác nhận hủy</button>
                            </div>
                        </div>

                        `;
            document.querySelector(".model-content").innerHTML += html;
            document.querySelector(".model").classList.add('active')

        }

        function deleteOrder(id) {
            let token = $('input[name="_token"]').val();
            let cancelReson = $('input[name="lydo"]').val();
            // console.log(cancelReson);
            if (cancelReson != '') {
                $.ajax({
                    type: 'POST',
                    url: '/deleteOrder',
                    data: {
                        _token: token,
                        id: id,
                        cancelReson: cancelReson
                    },
                    success: function(data) {
                        if (data.code == 200) {
                            // swal('Có lỗi khi hủy đơn hàng');
                            swal('Hủy đơn hàng thành công');
                            // setTimeout(() => {
                                const href = "{{ route('ordered') }}";
                                window.location.href = href;
                            // }, 500);
                        } else {
                            swal('Có lỗi khi hủy đơn hàng');
                        }
                    }
                })
            } else {
                $('input[name="lydo"]').focus();
            }
        }
    </script>
@endsection
