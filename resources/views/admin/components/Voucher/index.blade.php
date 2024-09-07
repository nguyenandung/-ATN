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

        <a href="{{ route('voucher.create') }}" class="btn btn-sm btn-primary text-end ">Thêm khuyến mãi</a>

        @if (count($voucher))
            <button class="btn noborder dropdown-toggle text-primary action d-none " type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Chọn thao tác
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item action" href="" data-action="hide">Xóa voucher
                    </a>
                </li>

            </ul>
            <table class="table table-responsive-sm overflow-x-auto text-center ">
                <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" name="allID" id="">
                        </th>
                        <th scope="col">Mã khuyến mãi</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Ngày hết hạn</th>
                        <th scope="col">Đơn giá tối thiểu</th>
                        <th scope="col">Số lượt đã sử dụng</th>
                        <th scope="col">Số lượt sử dụng tối đa</th>
                        <th scope="col">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($voucher as $key => $item)
                        <tr>
                            <td class="" scope="row">
                                <input type="checkbox" name="id" value="{{ $item->id }}">
                            </td>
                            <td class="" scope="row">
                                {{ $item->ma }}</td>
                            <td class="" scope="row">
                                {{ date_format(date_create($item->ngaytao), 'd/m/Y H:i:s A') }}
                            </td>
                            <td class="" scope="row">
                                {{ date_format(date_create($item->ngayhethan), 'd/m/Y H:i:s A') }}
                            </td>
                            <td class="" scope="row">
                                {{ number_format($item->dongiatoithieu, 0, '.', '.') }}đ
                            </td>
                            <td class="" scope="row">{{ $item->solandadung }}</td>
                            <td class="" scope="row">{{ $item->solansudung }}</td>
                            <td class="" scope="row">
                                @if (date_create($item->ngayhethan) < Carbon\Carbon::now() || $item->solansudung <= $item->solandadung)
                                    Hết hạn sử dụng
                                @else
                                    Sử dụng
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $post->links() }} --}}
        @else
            <h3>Chưa có khuyến mãi nào</h3>
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
            swal({
                    title: 'Thông báo',
                    text: 'Bạn muốn xóa những voucher đã chọn?',
                    icon: 'warning',
                    buttons: true

                })
                .then((isConfirm) => {
                    if (isConfirm) {
                        // console.log('oke');
                        $.ajax({
                            type: "POST",
                            url: `{{ route('voucher.delete') }}`,
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
        })
    </script>
@endsection
