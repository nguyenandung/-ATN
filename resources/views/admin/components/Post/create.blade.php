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
    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row mt-3">
            <h2>Đăng bài viết mới</h2>
            <div class="col-9">
                <div class="form-group">
                    <label for="" class="form-label">
                        Tiêu đề
                    </label>
                    <input type="text" class="form-control" name="title" placeholder="Nhập tiêu đề bài viết"
                        value="{{ old('title') }}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="" class="form-label">Nội dung bài viết</label>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <textarea class="ckeditor" id="editor" name="description" rows="10">
                        {{ old('description') }}
                </textarea>
                </div>
            </div>
            <div class="col-3">
                <div style="width: 100%; height:100px;" class="bg-white ">
                    <div class="p-3">

                        <label for="" class="form-label h4 fw-bold ">Trạng thái</label>
                        <br>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <input class="my-2 me-1 " type="radio" name="status" id=""
                            value="0"><span>Ẩn</span>
                        <br>
                        <input class="me-1" type="radio" name="status" id="" value="1" checked><span>Hiện
                            thị</span>
                    </div>
                </div>
                <div class="mt-2 bg-white p-2" style="width: 100%; height: auto;">
                    <label for="" class="form-label h4 fw-bold ">Ảnh bài viết</label>
                    <div class=" d-flex justify-content-center align-items-center h-100 flex-column ">
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <label for="upload" class="btn btn-sm btn-outline-primary upload">
                            Upload
                        </label>
                        <input type="file" name="image" id="upload" class="d-none" value="{{ old('image') }}"
                            accept="image/png, image/jpeg, image/jpg">
                        <img id="previewImage" src="" alt="">
                    </div>

                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-sm btn-primary ">Lưu</button>
    </form>
@endsection
@section('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    <script>
        const fileInput = document.getElementById('upload');
        const previewImage = document.getElementById('previewImage');

        fileInput.addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImage.src = event.target.result;
                };

                reader.readAsDataURL(file);
            } else {
                previewImage.src = ''; // Clear the preview if no file is selected
            }
        });
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
    </script>
@endsection
