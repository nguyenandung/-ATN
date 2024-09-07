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
    <div class="row">
        <div class="fs-3 ">
            <div class="code">Đơn hàng: {{ $order->code }}</div>
            <div class="information_customer">
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
        </div>
        <div class="status mt-3 ">
            <div class="col-6 p-0 ">
                <span class="fs-5 ">Trạng thái giao hàng</span>
                <select name="" id="" class="form-select ">
                    <option value="Chờ xác nhận" {{ mb_strtoupper($order->status) == 'CHỜ XÁC NHẬN' ? 'selected' : '' }}>Chờ
                        xác
                        nhận
                    </option>
                    <option value="Đang giao hàng"
                        {{ mb_strtoupper($order->status) == 'ĐANG GIAO HÀNG' ? 'selected' : '' }}>
                        Đang giao hàng
                    </option>
                    <option value="Đã nhận được hàng"
                        {{ mb_strtoupper($order->status) == 'ĐÃ NHẬN ĐƯỢC HÀNG' ? 'selected' : '' }}>
                        Đã nhận được hàng
                    </option>
                    <option value="Đã hủy" {{ mb_strtoupper($order->status) == 'ĐÃ HỦY' ? 'selected' : '' }}>
                        Đã hủy
                    </option>
                </select>
            </div>
            <div class="col-6 ">

            </div>
        </div>
        {{-- <div class="product-list">
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
                                    src="{{ asset('assets/uploads/' . $item->product->images[0]->url) }}" alt="">
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
        </div> --}}
    </div>
@endsection
