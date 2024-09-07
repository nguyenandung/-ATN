@extends('admin.components.dashboard')
@section('style')
    <style>
        .status {
            position: absolute;
            top: 50%;
            right: 50%;
            transform: translate(-100%, -50%);
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row d-flex mt-4 justify-content-end ">
            <div class="col-md-12 ">
                <div class="card-header d-flex justify-content-between ">
                    <h4>
                        Danh sách danh mục sản phẩm

                    </h4>
                    <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm ">
                        Thêm danh mục
                    </a>

                </div>
            </div>
        </div>
        <div class="row my-3 ">
            <div class="col-9 d-flex ">
                <input type="text" class="form-control rounded-2 bg-transparent border-0 " placeholder="Tìm kiếm danh mục">
                <button class="bg-transparent " style="border:none">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </div>
        <button class="btn noborder dropdown-toggle text-primary action d-none " type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            Chọn thao tác
        </button>
        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item action" href="" data-action="hide">Ẩn danh mục
                </a>
            </li>
            <li>
                <a class="dropdown-item action" href="" data-action="show">Hiện danh mục
                </a>
            </li>
        </ul>
        <table class=" container  table table-responsive-lg  ">
            <thead>
                <tr>
                    <th scope="col">
                        <input type="checkbox" name="allID" id="">
                    </th>
                    <th scope="col">Tên danh mục</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($category as $key => $item)
                    <tr>
                        <td><input type="checkbox" name="id" value="{{ $item->id }}"></td>
                        <td scope="row">{{ $item->name }}</td>
                        <td scope="row">{!! $item->description !!}</td>
                        <td scope="row">
                            <div class="form-check form-switch d-flex justify-content-center align-items-center">
                                <input class="form-check-input status" type="checkbox" name="status"
                                    {{ $item->status == 1 ? 'checked' : '' }} data-id="{{ $item->id }}">
                            </div>
                        </td>
                        <td scope="row">
                            <div class="d-flex">
                                <a href="{{ route('category.edit', ['category' => $item]) }}">
                                    <button class="btn btn-secondary ">Edit</button>
                                </a>
                                <form action="{{ route('category.destroy', ['category' => $item]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('category.destroy', ['category' => $item]) }}"
                                        onclick="return confirm('Bạn muốn xóa danh mục này?')">
                                        <button class="btn btn-primary mx-2">Delete</button>
                                    </a>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $category->links() }}
    </div>
@endsection
@section('script')
    <script>
        $('input[name="status"]').change(function() {
            const id = $(this).data('id');
            const status = $(this).is(':checked') ? true : false;
            const token = $('input[name="_token"]').val();
            if (status == false) {
                swal({
                    title: 'Thông báo',
                    text: 'Thao tác này sẽ ẩn toàn bộ sản phẩm thuộc danh mục này. Bạn có muốn thực hiện không?',
                    icon: 'warning',
                    buttons: true

                }).then((isConfirm) => {
                    if (isConfirm) {
                        $.ajax({
                            type: "POST",
                            url: `/admin/category/changeStatus`,
                            data: {
                                status: status,
                                id: [id],
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
                    } else {
                        $(this).prop('checked', !status);
                    }
                })
            } else {
                $.ajax({
                    type: "POST",
                    url: `/admin/category/changeStatus`,
                    data: {
                        status: status,
                        id: [id],
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
            }

        })
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
                    swal({
                        title: 'Thông báo',
                        text: 'Thao tác này sẽ ẩn toàn bộ sản phẩm thuộc danh mục này. Bạn có muốn thực hiện không?',
                        icon: 'warning',
                        buttons: true

                    }).then((isConfirm) => {
                        if (isConfirm) {
                            $.ajax({
                                type: "POST",
                                url: `/admin/category/changeStatus`,
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
                        }
                    })

                    break;
                case 'show':
                    $.ajax({
                        type: "POST",
                        url: `/admin/category/changeStatus`,
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
                                    url: `/admin/category/deleteProduct`,
                                    data: {
                                        status: true,
                                        id: arrayID,
                                        _token: token
                                    },
                                    success: function(data) {
                                        if (data.code == 200) {
                                            // window.location.reload();
                                            // alert('Oke');
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
