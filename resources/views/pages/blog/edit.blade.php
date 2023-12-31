@extends('layouts.master')
@section('content')
    <div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-12">
                        <label for="category_title" class="form-label">name</label>
                        <input type="text" class="form-control" name="category_title" id="category_title">
                    </div>
                    <div class="mb-12">
                        <label for="category_title" class="form-label">parent</label>
                        <select class="form-control" name="categories" id="ParentCategories">
                            <option value="0">Without Parent</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="AddCategory(this);" class="btn btn-primary">Create Category</button>
                </div>
            </div>
        </div>
    </div>
    <form class="col-md-12 content" action="{{ route('admin.blogs.update', $blog) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">

            <div class="form-group col-md-6">
                <label for="title">title</label>
                <input type="text" class="form-control" name="title" value="{{$blog->title}}" id="title">
            </div>

            <div class="row col-md-6">
                <label for="title">category</label>
                <div class="form-group col-md-8">
                    <select class="form-control selectpicker" name="category[]" id="category1" multiple
                        data-live-search="true">
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}" {{ in_array($item->id, $BlogCategories) ? 'selected' : '' }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Add Category
                    </button>
                </div>
            </div>

        </div>

        <div class="mb-3">
            <label for="formFile" class="form-label">pick primary Image</label>
            <input class="form-control" type="file" name="file" id="formFile">
        </div>
        <div class="container form-group">
            <label for="myeditorinstance">Blog content</label>
            <textarea class="form-control" id="myeditorinstance" name="text" rows="200">{!! $blog->text !!}</textarea>
        </div>
        <div class="container form-group">
            <button class="btn btn-success col-md-12">Save</button>
        </div>
    </form>
@endsection

@section('js')
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: " importcss advlist anchor autolink autoresize autosave charmap code codesample directionality emoticons fullscreen help image importcss insertdatetime link lists media nonbreaking pagebreak preview quickbars searchreplace table template visualblocks visualchars wordcount",
            toolbar1: "aligncenter alignjustify alignleft alignnone alignright| anchor | blockquote blocks | backcolor | bold | copy | cut | fontfamily fontsize forecolor h1 h2 h3 h4 h5 h6 hr indent | italic | language | lineheight | newdocument | outdent",
            toolbar2: " paste pastetext | print | redo | remove removeformat | selectall | strikethrough | styles | subscript superscript underline | undo | visualaid | a11ycheck advtablerownumbering typopgraphy anchor restoredraft charmap code codesample addcomment showcomments ltr rtl fliph flipv imageoptions rotateleft rotateright emoticons export fullscreen help image insertdatetime link openlink unlink bullist numlist media mergetags mergetags_list nonbreaking pagebreak preview quickimage quicklink quicktable cancel save searchreplace spellcheckdialog spellchecker | table tablecellprops tablecopyrow tablecutrow tabledelete tabledeletecol tabledeleterow tableinsertdialog tableinsertcolafter tableinsertcolbefore tableinsertrowafter tableinsertrowbefore tablemergecells tablepasterowafter tablepasterowbefore tableprops tablerowprops tablesplitcells tableclass tablecellclass tablecellvalign tablecellborderwidth tablecellborderstyle tablecaption tablecellbackgroundcolor tablecellbordercolor tablerowheader tablecolheader | template | insertfile | visualblocks visualchars | wordcount",
            directionality: "ltr rtl",
            height: "1000",
            image_title: true,
            font_family_formats: "B-nazanin=b-nazanin; B-titr=b-titr; Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
            content_css: "{{ asset('css/tiny.css') }}",
            convert_urls: false,
            automatic_uploads: true,
            images_upload_url: '/uploadImage',
            file_picker_types: 'image',
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function() {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function() {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), {
                            title: file.name
                        });
                    };
                };
                input.click();
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            new MultipleSelect('#category1', {
                placeholder: 'Select Category'
            })
        });

        function AddCategory(target) {
            var name = document.getElementById("category_title").value
            var parent = document.getElementById("ParentCategories").value

            $(document).ready(function() {
                console.log("jquery detected");
                $.post("{{ route('admin.categoryCreate') }}", {
                    '_token': "{{ csrf_token() }}",
                    'name': name,
                    'parent': parent
                }, function(response, status) {
                    if (response.status == false) {
                        alert('name is required!');
                    } else {
                        $("#category1").append(
                            `<option value="${response.category.id}">${response.category.name}</option>`
                        );
                        $("#ParentCategories").append(
                            `<option value="${response.category.id}">${response.category.name}</option>`
                        );
                        $('#exampleModal').delay(200).fadeOut(450);
                        $(".modal-backdrop").delay(200).fadeOut(450);
                        $("#multiple-select-container-1").remove();
                        $(document).ready(function() {
                            new MultipleSelect('#category1', {
                                placeholder: 'Select Category'
                            })
                        });
                    }
                }).fail(function(response) {
                    console.log(response);
                });
            });
        }
    </script>
@endsection
