@extends('admin.components.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <div class="card-header d-flex justify-content-between mt-3 ">
                <h4> Danh sách sản phẩm
                </h4>
                <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm float-right">Thêm sản phẩm</a>
            </div>
            <style>
                th,
                td {
                    text-align: center;
                }

                .status {
                    margin: 0;
                }

                .description {
                    overflow: hidden;
                    /* border: none; */
                    /* min-height: calc(1.5rem *4); */
                    height: 100%;
                    display: -webkit-box;
                    -webkit-box-orient: vertical;
                    -webkit-line-clamp: 4;
                }
            </style>
            <div class="row my-3 ">
                <div class="col-9 d-flex ">
                    <input type="text" class="form-control rounded-2 bg-transparent border-0 "
                        placeholder="Tìm kiếm sản phẩm ">
                    <button class="bg-transparent " style="border:none">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>
            <div class="card-body container ">
                <button class="btn noborder dropdown-toggle text-primary action d-none " type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Chọn thao tác
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item action" href="" data-action="hide">Ẩn sản phẩm
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item action" href="" data-action="show">Hiện sản phẩm
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item action" href="" data-action="delete">Xóa sản phẩm
                        </a>
                    </li>
                </ul>
                <table class="table table-responsive ">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input type="checkbox" name="allID" id="">
                            </th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Tồn kho</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $key => $item)
                            <tr>
                                <td class="" scope="row">
                                    <input type="checkbox" name="id" value="{{ $item->id }}">
                                </td>
                                <td class="" scope="row">{{ $item->name }}</td>
                                <td class="" scope="row">{{ $item->category->name }}</td>
                                <td class="description" scope="row">{!! $item->description !!}</td>
                                <td class="" scope="row">{{ $item->price }}</td>
                                <td class="" scope="row">{{ $item->stock }}</td>
                                <td class="" scope="row">
                                    <div
                                        class="d-block  form-check form-switch d-flex justify-content-center align-items-center">
                                        <input class="form-check-input status" type="checkbox" name="status"
                                            {{ $item->status == 1 ? 'checked' : '' }} data-id="{{ $item->id }}">
                                    </div>
                                </td>
                                <td class="" scope="row">
                                    <div class="d-flex ">
                                        <a class="btn btn-sm btn-secondary "
                                            href="{{ route('product.edit', ['product' => $item]) }}">
                                            Sửa
                                        </a>
                                        <form class="d-inline mx-1" onsubmit="confirmDelete(this,event)"
                                            action="{{ route('product.destroy', ['product' => $item]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-primary" >Xóa</button>
                                            {{-- <a class="btn btn-sm btn-primary"
                                                href="{{ route('product.destroy', ['product' => $item->id]) }}"
                                                >Xóa
                                            </a> --}}
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $product->links() }}
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script>
        $(".status").click(function() {
            // Lấy 'id' và 'status' từ phần tử đang được click
            const id = $(this).data('id');
            const status = $(this).is(":checked");
            const token = $('input[name="_token"]').val();
            // console.log("ID:", id, "Status:", status);
            $.ajax({
                type: "POST",
                url: `/admin/product/changeStatus`,
                data: {
                    status: status,
                    id: [id],
                    _token: token
                },
                success: function(data) {
                    if (data.code == 200) {
                        console.log('oke');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log lỗi nếu có
                }
            })
        });
        function  confirmDelete(form,event){
            swal({
                title: 'Thông báo',
                text: 'Bạn muốn xóa sản phẩm này?',
                icon: 'warning',
                buttons: true
                
            })
            .then((isConfirm) => {
                if (!isConfirm) {
                    console.log(event);
                    event.preventDefault();
                }
                else{

                    form.submit();
                }
            })
            event.preventDefault();
        }
        $(".action.dropdown-item").click(function(event) {
            event.preventDefault();
            const action = $(this).data('action');
            const token = $('input[name="_token"]').val();
            let arrayID = [];
            $('input[name="id"]').each(function() {
                if ($(this).is(":checked")) {
                    arrayID.push($(this).val())
                }
            });

            switch (action) {
                case 'hide':
                    // console.log("ID:", id, "Status:", status);
                    $.ajax({
                        type: "POST",
                        url: `/admin/product/changeStatus`,
                        data: {
                            status: false,
                            id: arrayID,
                            _token: token
                        },
                        success: function(data) {
                            if (data.code == 200) {
                                window.location.reload();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log lỗi nếu có
                        }
                    })
                    break;
                case 'show':
                    $.ajax({
                        type: "POST",
                        url: `/admin/product/changeStatus`,
                        data: {
                            status: true,
                            id: arrayID,
                            _token: token
                        },
                        success: function(data) {
                            if (data.code == 200) {
                                window.location.reload();
                                // alert('Oke');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log lỗi nếu có
                        }
                    })
                    break;
                case 'delete':
                    swal({
                            title: 'Thông báo',
                            text: 'Bạn muốn xóa những sản phẩm đã chọn?',
                            icon: 'warning',
                            buttons: true

                        })
                        .then((isConfirm) => {
                            if (isConfirm) {
                                $.ajax({
                                    type: "POST",
                                    url: `/admin/product/deleteProduct`,
                                    data: {
                                        status: true,
                                        id: arrayID,
                                        _token: token
                                    },
                                    success: function(data) {
                                        if (data.code == 200) {
                                            window.location.reload();
                                            // alert('Oke');
                                        }
                                        else{
                                            swal('Thông báo',data.message,'warning');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(xhr
                                            .responseText); // Log lỗi nếu có
                                    }
                                })

                            }
                        })
                    break;
                default:
                    break;
            }
        })
    </script>
@endsection
