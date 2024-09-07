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
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <div class="card-header">
                <h4>Thêm mới sản phẩm
                    <a href="{{ route('product.index') }}" class="btn btn-primary btn-sm float-right">Quay lại</a>
                </h4>
            </div>
            <div class="card-body container ">
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md mb-3">
                            <label>Tên sản phẩm
                            </label>
                            <input type="text" name="name" class="form-control" />
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md mb-3">
                            <label for="category">Danh mục sản phẩm</label>
                            <select class="form-select " id="category" name="category">
                                <option class="" value="">Chọn danh mục</option>
                                @foreach ($category as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            {{-- @if ($errors->has('category'))
                                <x-validation-errors>
                                    {{ $errors->first('category') }}
                                </x-validation-errors>
                            @endif --}}

                        </div>
                    </div>

                    <div class="row">
                        {{-- <div class="row"> --}}
                        <div class="col-md-6 mb-3">
                            <label>Hình ảnh</label>
                            <input type="file" name="image[]" multiple class="form-control" />
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        {{-- </div> --}}
                        <div class="col-6">
                            <label>Giá tiền
                            </label>
                            <input type="number" name="price" class="form-control" />
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="container ">
                            <div class="row">
                                <div class="container-fluid col-6">
                                    <label>Kích thước: </label>
                                    <div class="row mt-2 enableInput" style="max-width: 350px;">
                                        @error('size')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        <div class="col-sm">
                                            <label>Small :</label>
                                            <input type="checkbox" name="size[]" value="S" id="enableInput"
                                                onchange="toggleInputFields('enableInput','small')" />
                                        </div>
                                        <div class="col-sm  d-flex justify-content-between ">
                                            <label for="small">Small:</label>
                                            <input type="number" name="S" id="small" class="form-control"
                                                style="width: 100px;" oninput="validateTotal()" min="1"
                                                step="1" readonly />
                                        </div>

                                    </div>

                                    <div class="row mt-2 enablemedium" style="max-width: 350px;">
                                        <div class="col-sm ">
                                            <label>Medium :</label>
                                            <input type="checkbox" name="size[]" value="M" id="enablemedium"
                                                onchange="toggleInputFields('enablemedium','medium')" />
                                        </div>
                                        <div class="col-6 d-flex justify-content-between ">
                                            <label for="medium">Medium:</label>
                                            <input type="number" name="M" id="medium" class="form-control"
                                                style="width: 100px;" oninput="validateTotal()" min="1"
                                                step="1" readonly />
                                        </div>
                                    </div>

                                    <div class="row mt-2 enablelarge" style="max-width: 350px;">
                                        <div class="col-sm ">
                                            <label>Large :</label>
                                            <input type="checkbox" name="size[]" value="L" id="enablelarge"
                                                onchange="toggleInputFields('enablelarge','large')" />
                                        </div>
                                        <div class="col-6 d-flex justify-content-between ">
                                            <label for="large">Large:</label>
                                            <input type="number" name="L" id="large" class="form-control"
                                                style="width: 100px;" oninput="validateTotal()" min="1"
                                                step="1" readonly />
                                        </div>
                                    </div>

                                    <div class="row mt-2 enableXL" style="max-width: 350px;">
                                        <div class="col-sm ">
                                            <label>XL :</label>
                                            <input type="checkbox" name="size[]" value="XL" id="enableXL"
                                                onchange="toggleInputFields('enableXL','xl')" />
                                        </div>
                                        <div class="col-6 d-flex justify-content-between ">
                                            <label for="xl">XL:</label>
                                            <input type="number" name="XL" id="xl" class="form-control"
                                                style="width: 100px;"oninput="validateTotal()" min="1"
                                                step="1" readonly />
                                        </div>
                                    </div>

                                    <div class="row mt-2 enableXXL" style="max-width: 350px;">
                                        <div class="col-sm ">
                                            <label>XXL :</label>
                                            <input type="checkbox" name="size[]" value="XXL" id="enableXXL"
                                                onchange="toggleInputFields('enableXXL','xxl')" />
                                        </div>
                                        <div class="col-6 d-flex justify-content-between ">
                                            <label for="xxl">XXL:</label>
                                            <input type="number" name="XXL" id="xxl" class="form-control"
                                                style="width: 100px;" oninput="validateTotal()" min="1"
                                                step="1" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid col-6 color">
                                    <div class="row">
                                        <label>Màu sắc
                                        </label>
                                        <input type="text" id="inputColor" name="inputColor" class="form-control" />
                                        @error('color')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        <button class="btn btn-primary mt-2" type="button" onclick="addcolor();">Thêm
                                            màu</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md mb-3">
                            <label>Mô tả sản phẩm
                            </label>
                            <textarea id="editor" style="height:90px; width:543px" name="description" class="form-control ckeditor"></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary text-white float-end">Tạo mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script> --}}
@endsection
@section('script')
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: "{{ route('upload', ['_token' => csrf_token()]) }}",
                },
                language: 'en',
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells',
                        'tableCellProperties',
                        'tableProperties'
                    ]
                },

                // Thiết lập kích thước
                width: '100%',
                height: 'auto'
            })
            .catch(error => {
                console.error(error);
            });

        function toggleInputFields(idSize, InputSize) {
            let enableInputCheckbox = document.getElementById(idSize)
            let inputFields = document.querySelectorAll("#" + InputSize);
            let rowSize = document.querySelectorAll("." + idSize)[0];
            console.log(rowSize);

            for (var i = 0; i < inputFields.length; i++) {
                inputFields[i].readOnly = !enableInputCheckbox.checked;
                // if not checked  clear fields
                if (!enableInputCheckbox.checked) {
                    inputFields[i].value = '';
                    console.log('oke');
                }
                //  
            }
        }

        function validateTotal() {
            const input1 = parseInt(document.getElementById("small").value) || 0;
            const input2 = parseInt(document.getElementById("medium").value) || 0;
            const input3 = parseInt(document.getElementById("large").value) || 0;
            const input4 = parseInt(document.getElementById("xl").value) || 0;
            const input5 = parseInt(document.getElementById("xxl").value) || 0;
            const total = parseInt(document.getElementById("quantity").value) || 0;

            if (input1 + input2 + input3 + input4 + input5 !== total) {
                document.getElementById("error-message").textContent = "Error: Please verify the quantity!";
            } else {
                document.getElementById("error-message").textContent = "";
            }
        }

        function validateTotal() {
            // Get values from the "Small," "Medium," "Large," "XL," and "XXL" input fields
            var smallValue = parseInt(document.getElementById("small").value) || 0;
            var mediumValue = parseInt(document.getElementById("medium").value) || 0;
            var largeValue = parseInt(document.getElementById("large").value) || 0;
            var xlValue = parseInt(document.getElementById("xl").value) || 0;
            var xxlValue = parseInt(document.getElementById("xxl").value) || 0;

            // Calculate the total
            var total = smallValue + mediumValue + largeValue + xlValue + xxlValue;

            // Update the "quantity" input field with the total value
            document.getElementById("quantity").value = total;
        }

        function addcolor() {
            let rowColor = document.querySelectorAll(".color")[0];
            let Inputcolor = document.getElementById('inputColor');

            let newDiv = document.createElement('div');
            newDiv.className = "row";
            newDiv.innerHTML = `<input type="text" class="form-control" name="color[]" value="${Inputcolor.value}">`;
            rowColor.prepend(newDiv);
            Inputcolor.value = "";
            Inputcolor.focus();
        }
    </script>
@endsection
