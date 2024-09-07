@extends('admin.components.dashboard')
@section('style')
    <style>
        .table td img {
            border-radius: 0;
            width: 100px;
            height: auto;
            object-fit: cover;
        }
    </style>
@endsection
@section('content')
    <div class="card-body container ">

        <a href="{{ route('post.create') }}" class="btn btn-sm btn-primary text-end ">Thêm bài viết</a>

        @if (count($post))
            <button class="btn noborder dropdown-toggle text-primary action d-none " type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Chọn thao tác
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item action" href="" data-action="hide">Xuất bản
                    </a>
                </li>
                <li>
                    <a class="dropdown-item action" href="" data-action="show">Ngừng xuất bản
                    </a>
                </li>
                <li>
                    <a class="dropdown-item action" href="" data-action="delete">Xóa bài viết
                    </a>
                </li>
            </ul>
            <table class="table table-responsive-sm overflow-x-auto text-center ">
                <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" name="allID" id="">
                        </th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Ngày đăng</th>
                        <th scope="col">Ngày cập nhật</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($post as $key => $item)
                        <tr>
                            <td class="" scope="row">
                                <input type="checkbox" name="id" value="{{ $item->id }}">
                            </td>
                            <td class="" scope="row"><a href="{{ route('post.edit', ['post' => $item->id]) }}">
                                    {{ $item->title }}</a></td>
                            <td class="" scope="row">
                                <a href="{{ route('post.edit', ['post' => $item->id]) }}">
                                    <img src="{{ asset('assets/uploads/' . $item->image) }}" alt="">
                                </a>
                            </td>
                            <td class="" scope="row">{{ $item->status == 1 ? 'Xuất bản' : 'Không xuất bản' }}</td>
                            <td class="" scope="row">{{ $item->created_at }}</td>
                            <td class="" scope="row">
                                {{ $item->updated_at == null ? $item->created_at : $item->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $post->links() }}
        @else
            <h3>Chưa có bài viết nào</h3>
        @endif
    </div>
@endsection
@section('script')
    <script>
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
                        url: `/admin/post/changeStatus`,
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
                            text: 'Bạn muốn xóa những bài viết đã chọn?',
                            icon: 'warning',
                            buttons: true

                        })
                        .then((isConfirm) => {
                            if (isConfirm) {
                                console.log('oke');
                                $.ajax({
                                    type: "POST",
                                    url: `{{ route('post.delete') }}`,
                                    data: {
                                        // status: true,
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

                            }
                        })
                    break;
                default:
                    break;
            }
        })
    </script>
@endsection
