@extends('admin.components.dashboard')
@section('style')
    <style>
        .ck.ck-reset.ck-editor.ck-rounded-corners {
            width: 100%;
            height: auto;
            /* min-height: 500px; */
        }

        .ck.ck-content {
            min-height: 200px;
        }

        .page-body-wrapper {
            /* margin: 0 !important; */
            background-color: #f4f6f8;
        }

        #previewImage {
            /* min-height: 200px; */
            height: auto;
            max-height: 400px;
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <form action="{{ route('voucher.store') }}" method="post">
        @csrf
        <div class="row mt-3 d-flex  flex-column ">
            <h2>Thêm khuyến mãi</h2>
            <div class="col-6">
                <div class="form-group">
                    <label for="" class="form-label">
                        Mã khuyến mãi
                    </label>
                    <input type="text" class="form-control" name="ma" placeholder="Nhập mã khuyến mãi"
                        value="{{ old('ma') }}">
                    @error('ma')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Đơn giá tối thiểu</label>
                    <input type="number" class="form-control " name="dongiatoithieu" oninput="validity.valid||(value='0');"
                        placeholder="Nhập đơn giá tối thiểu để sử dụng voucher">
                    @error('dongiatoithieu')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Số tiền giảm</label>
                    <input type="number" class="form-control " name="sotiengiam" oninput="validity.valid||(value='0');"
                        placeholder ="Nhập số tiền giảm tối đa của voucher">
                    @error('sotiengiam')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="" class="form-label">
                        Số lần sử dụng tối đa
                    </label>
                    <input type="number" class="form-control " name="solansudung" oninput="validity.valid||(value='0');">
                    @error('solansudung')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Ngày hết hạn</label>
                    {{-- {!! Form::datetime('a', $value, [$options]) !!} --}}
                    <input type="datetime-local" class="form-control " name="ngayhethan">
                    @error('ngayhethan')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

            </div>
        </div>
        <button type="submit" class="btn btn-sm btn-primary ">Lưu</button>
    </form>
@endsection
@section('script')
    <script>
        // let minDate = new Date();
        // console.log(minDate.('YYYY-MM-DDTHH:mm'));
    </script>
@endsection
