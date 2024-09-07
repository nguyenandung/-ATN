@extends('admin.components.dashboard')
@section('style')
    <style>
        .model {
            top: 0;
            display: none;
            z-index: 999;
            height: 100vh;
            width: 100vw;
            position: fixed;

        }

        .model.active {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .model .model-content {
            height: auto;
            width: 400px;
            text-align: center;
            background-color: white;
            border: 1px solid black;
            padding-top: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px;
            border-radius: 20px;
            position: relative;
            animation: showmodel 0.3s ease-in-out;
            /* animation-iteration-count: infinite; */
        }

        @keyframes showmodel {
            0% {
                scale: 0;

            }

            25% {
                scale: 0.25;
            }

            50% {
                scale: 0.5;
            }

            75% {
                scale: 0.75;
            }

            100% {
                scale: 1;
            }
        }


        .model .model-content .exit {
            position: absolute;
            top: 0;
            right: 10px;
            z-index: 999;
            font-size: 20px;
            cursor: pointer;
        }

        .order-item .nosuccess {
            background-color: #FF9900;
            padding: 5px;
            border-radius: 5px;
            font-weight: 700;
        }

        .order-item .xacnhan {
            background-color: #ec240a;
            padding: 5px;
            border-radius: 5px;
            font-weight: 700;
            color: white;
        }

        .order-item .success {
            background-color: rgb(15, 215, 12);
            padding: 5px;
            border-radius: 5px;
            font-weight: 700;
        }

        .order-item .cash {
            background-color: #FF9900;

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
    <div class="row my-3">
        <h3 class="header">Danh sách đơn hàng
        </h3>
        <div class="row my-3 ">
            <div class="col-9 d-flex ">
                <input type="text" class="form-control rounded-2 bg-transparent border-0 " placeholder="Tìm kiếm đơn hàng">
                <button class="bg-transparent " style="border:none">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <form action="{{ route('order.filter') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-3"><label class="form-label fs-6  " for="">Chọn trạng thái: </label></div>
                        <div class="col-4">
                            <select class="form-control-sm " name="status" id="optionstatus">
                                <option value="all">Tất cả</option>
                                <option value="choxacnhan">Chờ xác nhận</option>
                                <option value="danggiao">Đang giao</option>
                                <option value="danhanhang">Đã nhận hàng</option>
                                <option value="dahuy">Đã hủy</option>
                            </select>
                        </div>
                        <div class="col-4">

                            <select class="form-control-sm " name="Cash" id="optionCash">
                                <option value="all">Tất cả</option>
                                <option value="chuathanhtoan">Chưa thanh toán</option>
                                <option value="dathanhtoan">Đã thanh toán</option>
                            </select>
                        </div>
                        <div class="col-1">
                            <button type="submit" class="btn btn-sm btn-primary ">Lọc</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <table class="table  w-100 table-responsive text-center ">
            <thead class="">
                <tr>
                    <th>
                        Mã đơn hàng
                    </th>
                    <th>Ngày</th>
                    <th>Tình trạng đơn hàng</th>
                    <th>Tình trạng thanh toán</th>
                    <th>Khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order as $key => $item)
                    <tr class="order-item">
                        <td>
                            <a href="{{ route('order.show', ['order' => $item->id]) }}">{{ $item->code }}</a>
                        </td>
                        <td>
                            {{-- {{ }} --}}
                            {{ date_format(date_create($item->orderDate), 'd/m/Y H:i:s A') }}
                        </td>
                        <td>
                            @if (mb_strtoupper($item->status) == 'CHỜ XÁC NHẬN')
                                <span class="xacnhan">{{ $item->status }}</span>
                            @elseif (mb_strtoupper($item->status) != 'ĐÃ NHẬN HÀNG')
                                <span class="nosuccess">{{ $item->status }}</span>
                            @else
                                <span class="success">{{ $item->status }}</span>
                            @endif
                        </td>
                        <td>
                            @if (mb_strtoupper($item->paymentMethod) == 'THANH TOÁN KHI NHẬN HÀNG')
                                @if (mb_strtoupper($item->status) == 'ĐÃ NHẬN HÀNG')
                                    <span class="vnpay">Đã thanh toán</span>
                                @else
                                    <span class="cash">Chưa thanh toán</span>
                                @endif
                            @else
                                <span class="vnpay">Đã thanh toán</span>
                            @endif

                        </td>
                        <td>
                            {{ $item->user->phonenumber }}
                        </td>
                        <td>
                            {{ number_format($item->totalMoney, 0, ',', '.') }}đ
                        </td>
                        @if (mb_strtoupper($item->status) == 'CHỜ XÁC NHẬN')
                            <td class="d-flex">
                                <button class="btn btn-sm btn-primary text-white me-1"
                                    onclick="changeStatusOrder('{{ $item->id }}','{{ mb_strtoupper($item->status) }}')">
                                    Xác nhận đơn
                                </button>
                                <button class="btn btn-sm btn-primary btn-danger   text-white "
                                    onclick="showModelDeleteOrder('{{ $item->id }}')">
                                    Hủy đơn
                                </button>
                            </td>
                        @elseif (mb_strtoupper($item->status) == 'ĐANG GIAO HÀNG')
                            <td>
                                <button class="btn btn-sm btn-primary text-white"
                                    onclick="changeStatusOrder('{{ $item->id }}','{{ mb_strtoupper($item->status) }}')">
                                    Xác nhận đã giao hàng
                                </button>
                            </td>
                        @elseif (mb_strtoupper($item->status) == 'ĐÃ HỦY')
                            <td>
                                {{ $item->cancelReson }}
                            </td>
                        @else
                            <td>
                                <span class="success">{{ $item->status }}</span>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
@section('script')
    <script>
        function changeStatusOrder(id, status) {
            const token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('order.changeStatus') }}",
                type: 'post',
                data: {
                    id: id,
                    status: status,
                    _token: token
                },
                success: function(data) {
                    if (data.data == 200) {
                        window.location.reload();
                    }
                }
            })
        }

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
                            window.location.reload();
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
