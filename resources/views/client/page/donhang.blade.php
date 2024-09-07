@extends('client.layout')
@section('style')
    <style>
        .model .model-content {
            width: 800px;
            height: 100vh !important;
        }

        @media only screen and (min-width: 992px) and (max-width: 1199px) {
            .model .model-content {
                min-width: 100% !important;
                height: 75vh !important;
            }
        }

        @media only screen and (max-width: 992px) {
            .model .model-content {
                min-width: 100% !important;
                height: 75vh !important;
            }
        }

        input#file-upload-button {
            display: none;
        }

        .model.active {}
    </style>
@endsection
@section('content')
    <div class="register-page section-padding-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-md-4">
                    <div class="my-account-menu mt-30">
                        <ul class="nav account-menu-list flex-column">
                            <li>
                                <a href="{{route('user.profile')}}"><i class="fa fa-user"></i> Hồ Sơ</a>
                            </li>
                            
                            <li>
                                <a href="{{route('ordered')}}" class="active"><i class="fa fa-shopping-cart"></i> Đơn Đặt Hàng</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-9 col-md-8">
                    <ul class="nav nav-pills mb-3 d-flex justify-content-evenly  " id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active btn btn-primary " id="all-tab" data-bs-toggle="pill"
                                data-bs-target="#all" type="button" role="tab" aria-controls="all"
                                aria-selected="true">Tất cả</button>
                            {{-- <span class="count">{{ $totalOrders }}</span> --}}
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link btn btn-primary " id="xacnhan-tab" data-bs-toggle="pill"
                                data-bs-target="#xacnhan" type="button" role="tab" aria-controls="xacnhan"
                                aria-selected="false" onclick="fetchOrderByStatus('Chờ xác nhận')">Đang chờ
                                xác nhận</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link btn btn-primary " id="danggiao-tab" data-bs-toggle="pill"
                                data-bs-target="#danggiao" type="button" role="tab" aria-controls="danggiao"
                                aria-selected="false" onclick="fetchOrderByStatus('Đang giao hàng')">Đang
                                giao hàng</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link btn btn-primary " id="dagiao-tab" data-bs-toggle="pill"
                                data-bs-target="#dagiao" type="button" role="tab" aria-controls="dagiao"
                                aria-selected="false" onclick="fetchOrderByStatus('Đã giao hàng')">Đã
                                giao</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link btn btn-primary " id="dahuy-tab" data-bs-toggle="pill"
                                data-bs-target="#dahuy" type="button" role="tab" aria-controls="dahuy"
                                aria-selected="false" onclick="fetchOrderByStatus('Đã hủy')">Đã hủy</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example"
                                        class="table table-striped table-bordered  nowrap text-center table-responsive-sm "
                                        style="width: 100%;" aria-describedby="example_info">
                                        <thead>
                                            <tr>
                                                <th rowspan="1" colspan="1" style="width: 62.2px;">Mã ĐH
                                                </th>
                                                <th rowspan="1" colspan="1" style="width: 146.2px;">Tên người nhận
                                                </th>
                                                <th rowspan="1" colspan="1" style="width: 154.2px;">Ngày đặt</th>
                                                <th rowspan="1" colspan="1" style="width: 122.2px;">Trạng thái</th>
                                                <th rowspan="1" colspan="1" style="width: 89.2px;">Tổng tiền</th>
                                                <th rowspan="1" colspan="1" style="width: 84.2px;">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allOrders as $item)
                                                <tr>
                                                    <td>
                                                        <a title="Xem chi tiết đơn {{ $item->code }}"
                                                            href="{{ route('chitietdonhang', ['id' => $item->id]) }}">
                                                            {{ $item->code }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $item->customerName }}</td>
                                                    <td>{{ $item->orderDate }}</td>
                                                    <td>{{ $item->status }}</td>
                                                    <td>{{ number_format($item->totalMoney, 0, ',', '.') }}đ</td>
                                                    <td class="d-flex justify-content-center">
                                                        <button class="bg-transparent border-0 p-0"><a
                                                                class="view-hover h3 mr-2"
                                                                href="{{ route('chitietdonhang', ['id' => $item->id]) }}"
                                                                title="Xem chi tiết"><i
                                                                    class="fa fa-eye"></i></a></button>
                                                        @if (mb_strtoupper($item->status) == 'CHỜ XÁC NHẬN')
                                                            <button class="bg-transparent border-0 p-0">
                                                                <a class="view-hover h3 ml-2 delete-order"
                                                                    onclick="showModelDeleteOrder({{ $item->id }})"
                                                                    title="Hủy đơn hàng"><i class="fa fa-trash"></i></a>
                                                            </button>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    {{ $allOrders->links() }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        let ArrayStatus = ['Chờ xác nhận', 'Đang giao hàng', 'Đã giao hàng', 'Đã hủy'];
        // function h() {
        //     document.querySelector(".tab-content").innerHTML = ``;
        // }
        function fetchOrderByStatus(status) {
            if (ArrayStatus.includes(status) && ArrayStatus.length >= 0) {
                // console.log('oke');
                const token = document.querySelector('input[name="_token"]').value;
                // console.log(token);
                $.ajax({
                    url: '/fetchOrderByStatus',
                    type: 'post',
                    data: {
                        status: status,
                        _token: token
                    },
                    success: function(data) {
                        // console.log(data);
                        document.querySelector(".tab-content").insertAdjacentHTML('beforeend', data);
                    }

                })
                ArrayStatus = ArrayStatus.filter((item) => item != status);
                console.log(ArrayStatus);
            }
            // console.log(status);
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

        function showModelComment(id) {
            console.log(id);
            let product;
            fetch(`/comment/${id}`)
                .then((result) => result.json())
                .then((data) => {
                    let html = `<h3>Đánh giá sản phẩm</h3>
                    <form action="{{ route('comment') }}" method="POST" enctype="multipart/form-data" class="overflow-y-auto ">
                        @csrf
                        <input type="hidden" value="${data.order_id}" name="order_id">`;

                    data.data.forEach(item => {
                        html += `
                                <div class="container-fluid mt-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <img src="{{ asset('assets/uploads') }}/${item['hinhanh']}" alt="">
                                                    </div>
                                                    <div class="col-9 text-start ">
                                                        <h6>${item['name']} </h6>
                                                        <span >Phân loại hàng: ${item['loai']}</span>
                                                    </div>
                                                </div>
                                            </div>        
                                        </div>
                                        <div class="row mt-2 ">
                                            <div class="col-12">
                                                <textarea name="review[${item['id']}][comment]" placeholder="Nhập nhận xét của bạn" cols="30" rows="10"></textarea>
                                                <!-- Trường tải lên ảnh -->
                                                <div>
                                                    <label for="image" class="text-start fs-6 ">Chọn hình ảnh: <i class="fa fa-camera" aria-hidden="true"></i></label>
                                                <input id="image" class="d-none" type="file" name="review[${item['id']}][images]">
                                                </div>  
                                                <input type="number" class="form-control-sm " name="review[${item['id']}][rating]" min="1" max="5" placeholder="Đánh giá từ 1 đến 5" oninput="validity.valid||(value='5');" value="5" onchange="handelChangeRate(this)">
                                            </div>
                                        </div>
                                    </div>`;
                    });

                    html +=
                        `<button class="btn btn-sm btn-secondary mt-2 mx-2 " onclick="closeModel()">Trở lại</button><button type = "submit" class="btn btn-sm btn-primary mt-2"> Gửi đánh giá </button> </form>`;
                    // endforeach
                    document.querySelector(".model-content").innerHTML += html;
                    document.querySelector(".model").classList.add('active')
                });
            // console.log(product);


        }

        function handelChangeRate(input) {
            console.log(input.value);
            if (input.value == '') {
                input.value = 5;
            }
        }
        $('input[type="number"]').change(function() {
            console.log($(this).val());
            if ($(this).val() < 1 || $(this).val() > 5 || $(this).val() == '') {
                $this.val(5);
            }
        })

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
{{-- <div class=" "></div> --}}
