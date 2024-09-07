@extends('admin.components.dashboard')
@section('style')
    <style>
        .order-item .nosuccess {
            background-color: #FF9900;
            padding: 5px;
            border-radius: 5px;
            font-weight: 700;
        }

        .order-item .success {
            background-color: rgb(15, 215, 12);
            padding: 5px;
            border-radius: 5px;
            font-weight: 700;
        }

        .order-item .cash {
            background-color: rgb(15, 215, 12);
            padding: 5px;
            border-radius: 5px;
            font-weight: 700;
        }

        .order-item .vnpay {
            background-color: rgb(15, 215, 12);
            padding: 5px;
            border-radius: 5px;
            font-weight: 700;
        }
    </style>
@endsection
@section('content')
    <div class="row mt-4">
        <div class="fs-5">
            <div class="code">Đơn hàng: {{ $order->code }}</div>
            <div class="information">
                <div class="customer_name">
                    Tên người nhận: {{ $order->customerName }}
                </div>
                <div class="phone">
                    Số điện thoại: {{ $order->phone }}
                </div>
                <div class="address">
                    Địa chỉ nhận hàng: {{ $order->address }}
                </div>
            </div>
            <div class="status">
                <div>Trạng thái giao hàng: {{ $order->status }}</div>
                <div>
                    Trạng thái thanh toán: {{ $order->paymentMethod }}
                </div>
                {{-- </div> --}}
            </div>
        </div>
        <div class="product-list mt-4">
            <h5 class="fw-bold ">Danh sách sản phẩm đơn hàng</h3>
                <table class="table  text-center ">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Hình ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetail as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="w-25 ">
                                    <img class="w-100 h-75 "
                                        src="{{ asset('assets/uploads/' . $item->product->images[0]->url) }}"
                                        alt="">
                                </td>
                                <td>
                                    <div>
                                        Mã sản phẩm: {{ $item->product->id }}
                                    </div>
                                    <div class="my-2">Loại:{{ $item->color }} - {{ $item->size }}</div>
                                </td>
                                <td>{{ number_format($item->product->price, 0, ',', '.') }}đ</td>
                                <td>{{ $item->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

        </div>

    </div>
@endsection
