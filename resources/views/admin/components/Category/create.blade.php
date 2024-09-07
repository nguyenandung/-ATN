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
    <form class="mt-3" action="{{ route('category.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="form-group">
                <label for="name">Tên danh mục</label>
                <input class="form-control" id="name" type="text" name="name">
            </div>
        </div>
        <div class="row">
            <label for="">Mô tả danh mục</label>
            <textarea class="ckeditor" id="editor" name="description" rows="10" cols="50">
        </textarea>
        </div>
        <button type="submit" class="btn btn-sm btn-primary mt-3">Thêm</button>
    </form>
@endsection
@section('script')
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script> --}}

    <script>
        const a = document.querySelector('#editor');

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
