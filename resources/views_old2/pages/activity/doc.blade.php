@extends('layouts.app')

@section('title', 'Activity Page')

@section('content')

<style>
    .tags-form{
        margin-top: 80px;
    }

    @media screen and (max-width: 768px) {
        .tags-form{
            margin-top: 130px;
        }
    }
</style>

@php
    $activity = $data['activity'];
    $doc = $data['docActivity'];
    $categoryDoc = $data['categoryDoc'];
@endphp

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <a href="{{ route('activity.index') }}"><i class="fa-solid fa-arrow-left"></i></a>
            {{-- <h3>Activity Detail</h3> --}}
            {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Activity</li>
                    <li class="breadcrumb-item active" aria-current="page">Document</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section">
    <div class="card">
        <div class="card-header text-right">
            <h1>Document Activity</h1>
        </div>
        <div class="card-body">
            <label><b> Activity Name : </b></label>
            <div class="form-group">
                <p class="form-control-static" id="project_name_detail">{{ $activity['title'] }}</p>
            </div>
            <label><b> Category : </b></label>
            <fieldset class="form-group">
                <select class="form-select" id="documentCat">
                    <option value="#">Select Category</option>
                    @foreach ($categoryDoc as $cat)
                    <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                    @endforeach
                </select>
            </fieldset>
        </div>
    </div>
</section>

<section class="section" id="form_MOM" style="display: none">
    <div class="card">
        {{-- <div class="card-header text-right">
            <h1>Document Activity</h1>
        </div> --}}
        <div class="card-body">
            <form action="" id="form">
                @csrf
                <input type="text" name="activity_id" id="activity_id" hidden>
                <input type="text" name="category_id" id="category_id" hidden>
                <input type="text" name="doc_id" id="doc_id" hidden>
                <label>Title Doc :</label>
                <div class="form-group">
                    <input type="text" placeholder="Enter the Title" class="form-control" name="title" id="title_activity_doc">
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label>Description : </label>
                        <div id="quillEditor">
                            {{-- <p>Hello World!</p>
                            <p>Some initial <strong>bold</strong> text</p>
                            <p><br /></p> --}}
                        </div>
                    </div>
                    <div class="col-sm-12 tags-form">
                        <label>Tags : </label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="tagInput" placeholder="Ketik dan tekan enter..." name="tags"/>
                        </div>
                        <div class="tag-container" id="tags">
                        </div>
                    </div>
                </div>
                <hr>
                <button class="btn btn-primary ml-1" type="button" onclick="storeDoc()">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><i class="fa-solid fa-floppy-disk"></i> Save</span>
                </button>
            </form>
        </div>
    </div>
</section>

<section class="section" id="show_MOM" style="display: none">
    <div class="card">
        {{-- <div class="card-header text-right">
            <h1>Document Activity</h1>
        </div> --}}
        <div class="card-body">
            <label><b>Title Doc :</b></label>
            <div class="form-group">
                <p class="form-control-static" id="title_show"></p>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label><b>Description : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="desc_show"></p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <label><b>Tags : </b></label>
                    <div class="tag-container" id="tags_show">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="button" class="btn btn-danger" id="btnDelete">
                <i class="fa-solid fa-trash"></i> Delete
            </button>
        </div>
    </div>
</section>

{{-- JQuery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
{{-- SimpleDatatables - Template --}}
<script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
{{-- Filepond - Template --}}
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
{{-- Quill.js --}}
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

@if(session()->has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session()->get('success') }}',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            $('#fullPageLoader').hide();
        });
    </script>
@endif

@if(session()->has('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session()->get('error') }}',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            $('#fullPageLoader').hide();
        });
    </script>
@endif

<script>
    const quill = new Quill('#quillEditor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'script': 'sub'
                }, {
                    'script': 'super'
                }],
                [{
                    'indent': '-1'
                }, {
                    'indent': '+1'
                }],
                [{
                    'direction': 'rtl'
                }],
                [{
                    'size': ['small', false, 'large', 'huge']
                }],
                [{
                    'header': [1, 2, 3, false]
                }],
                [{
                    'color': []
                }, {
                    'background': []
                }],
                [{
                    'font': []
                }],
                [{
                    'align': []
                }],
                ['clean']
            ]
        }
    });

    let tags = [];

    function renderTags() {
        let tagContainer = $("#tags");
        tagContainer.find(".tag").remove();

        if (tags.length === 0) return;

        tags.forEach((tag, index) => {
            let tagElement = $(`
                <div class="tag">
                    ${tag}
                    <span class="remove" data-index="${index}">&times;</span>
                </div>
            `);
            tagContainer.append(tagElement);
        });
    }

    $(document).on("keydown", "#tagInput", function (event) {
        if (event.key === "Enter" && this.value.trim() !== "") {
            event.preventDefault();

            let tagText = this.value.trim().toLowerCase();

            if (!tags.includes(tagText)) {
                tags.push(tagText);
                renderTags();
            }

            this.value = "";
        }
    });

    $(document).on("click", ".remove", function () {
        let index = $(this).data("index");
        tags.splice(index, 1);
        renderTags();
    });
</script>

<script>
    let doc = {!! json_encode($data['docActivity']) !!}

    $("#documentCat").change(async function () {
        $("#form")[0].reset();
        $('#form_MOM').hide();
        $('#show_MOM').hide();

        let selectedValue = $(this).val();
        if(selectedValue !== "#"){
            let filteredDocs = doc.filter(item => item.activity_doc_category.id == selectedValue);
            if(filteredDocs.length !== 0){
                // console.log("Filtered Documents:", filteredDocs);
                showDoc(filteredDocs);
            }else{
                // console.log("not document exist")
                $('#form_MOM').show();
                $('#activity_id').val("{{ $activity['id'] }}");
                $('#category_id').val(selectedValue);
            }
        }

    });

    function showDoc(data) {
        let title = data[0]['title']
        let description = data[0]['description']
        let tags = data[0]['tags'];
        let id = data[0]['id'];

        $('#title_show').text(title);
        $('#desc_show').text(description);

        let tagContainer = $("#tags_show");
        tagContainer.find(".tag").remove();

        tags.forEach((tag) => {
            let tagElement = $(`
                <div class="tag">
                    ${tag}
                </div>
            `);
            tagContainer.append(tagElement);
        });
        $('#show_MOM').show();
        $('#btnDelete').attr('onclick', `confirmDelete('${"{{ route('activity.doc.delete', ':id') }}".replace(':id', id)}')`);
    }

    function storeDoc() {
        let formData = new FormData(document.getElementById("form"));
        formData.append('description', quill.root.innerHTML);
        formData.append('tags', JSON.stringify(tags));
        $.ajax({
            url: "{{ route('activity.doc.store') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);
                if(response.status === 'error'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return;
                }else{
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                }
            },
            error: function (xhr) {
                console.error('Error:', xhr);
            }
        });
    }

    function confirmDelete(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#fullPageLoader').show();
                window.location.href = url;
            }
        });
    }
</script>

@endsection