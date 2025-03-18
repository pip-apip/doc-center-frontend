@extends('layouts.app')

@section('title', 'Activity Page')

@section('content')

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Data Activity</h3>
            {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Activity</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section">
    <div class="card">
        <div class="card-header text-right">
            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formModal"><i
                    class="fa-solid fa-plus"></i> Add</a>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Activity Title</th>
                        <th>Project</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody id="table_body">

                </tbody>
            </table>
        </div>
    </div>

</section>

<div class="modal fade text-left w-100" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Form Add Activity</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="closeFormModal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="#" id="activityForm">
                @csrf
                <div class="modal-body">

                    <label>Project Name : </label>
                    <fieldset class="form-group">
                        <select class="form-select" id="project_id" name="project_id">
                            <option value="">Select Project Name</option>
                        </select>
                    </fieldset>

                    <label>Activity Title: </label>
                    <div class="form-group">
                        <input type="text" placeholder="Enter the Activity Title" class="form-control" name="title"
                            id="title_activity">
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label>Start Project: </label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="start_date" id="start_date">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>End Project: </label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="end_date" id="end_date">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary ml-1" onclick="submitForm()">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><i class="fa-solid fa-floppy-disk"></i> Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="formDocModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalScrollableTitle">Form Document Activity</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="closeFormModal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="activityDocForm">
                    <label><b> Activity Name : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="activity_name_doc">Alpha Build</p>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Document Category: </label>
                            <fieldset class="form-group">
                                <select class="form-select" id="documentCat">
                                    <option value="#">Select Category</option>
                                    <option value="MOM">MOM</option>
                                    <option value="Picture">Foto</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-sm-6" id="section1Form" style="display: none">
                            <label>Title: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Enter the Title" class="form-control" name="title"
                                    id="title_activity_doc">
                            </div>
                        </div>
                        <div class="col-sm-6" id="section1Show" style="display: none">
                            <label>Title: </label>
                            <div class="form-group">
                                <p class="form-control-static" id="title_static">Test</p>
                            </div>
                        </div>
                    </div>

                    <div id="section2Form" style="display: none">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Description : </label>
                                <div id="quillEditor">
                                    {{-- <p>Hello World!</p>
                                    <p>Some initial <strong>bold</strong> text</p>
                                    <p><br /></p> --}}
                                </div>
                            </div>
                            <div class="col-sm-12" style="margin-top: 70px">
                                <label>Tags : </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="tagInput" placeholder="Ketik dan tekan spasi..." />
                                </div>
                                <div class="tag-container" id="tags">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="section2Show" style="display: none">

                    </div>
                </form>
            </div>
            <div class="modal-footer" id="saveButton">
                {{-- <button type="button" class="btn btn-primary ml-1" onclick="save()"> --}}
                {{-- <button type="button" class="btn btn-primary ml-1" onclick="storeDoc()">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><i class="fa-solid fa-floppy-disk"></i> Save</span>
                </button> --}}
            </div>
        </div>
    </div>
</div>

{{-- JQuery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
{{-- SimpleDatatables - Template --}}
<script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
{{-- Filepond - Template --}}
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
{{-- Quill.js --}}
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

{{-- Datatables Script --}}
<script>
    let table = document.querySelector('#table_activity');
    let dataTable = new simpleDatatables.DataTable(table);

</script>

{{-- FIlepond Script --}}
<script>
    FilePond.create(document.querySelector('.basic-filepond-activity1'), {
        allowImagePreview: false,
        allowMultiple: false,
        allowFileEncode: false,
        required: false
    });

    FilePond.create(document.querySelector('.basic-filepond-activity2'), {
        allowImagePreview: false,
        allowMultiple: false,
        allowFileEncode: false,
        required: false
    });

</script>

{{-- Quill.js Script --}}
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

</script>

{{-- AJAX JQuery Function --}}
{{-- <script>
    let tags = [];

    $(document).ready(function () {
        $("#documentCat").change(function () {
            var selectedValue = $(this).val();

            if (selectedValue !== "#") {
                $("#section1").show();
                $("#section2").show();
            } else {
                $("#section1").hide();
                $("#section2").hide();
            }
        });
    });

    function showFormModal() {
        console.log("test")
        tags = ["1", "2", "3"]
    }

    $(document).ready(function () {
        // $("#tagInput").on("keyup", function(event) {
        //     if (event.key === " " && this.value.trim() !== "") {
        //         let tagText = this.value.trim();

        //         if (!tags.includes(tagText)) {
        //             tags.push(tagText);
        //             $(".tag-container").append(`
        //                 <span class="tag">${tagText} <span class="remove">&times;</span></span>
        //             `);
        //         }

        //         this.value = "";
        //     }
        // });

        // $(document).on("click", ".remove", function() {
        //     let tagText = $(this).parent().text().trim();
        //     tags = tags.filter(tag => tag !== tagText.replace("×", "").trim());
        //     $(this).parent().remove();
        // });

        // --------------- edit (fill form)
        tags = ["Laravel", "PHP", "JavaScript"]; // Contoh data dari database

        function renderTags() {
            $(".tag-container").html(""); // Hapus tag lama
            $(".tag-container").append(
                `<input type="text" id="tagInput" placeholder="Ketik dan tekan spasi..." style="margin-right: 2px"/>`
                );
            tags.forEach(tag => {
                $(".tag-container").append(`
                <span class="tag">${tag} <span class="remove">&times;</span></span>
            `);
            });
        }

        renderTags(); // Tampilkan tag saat halaman dimuat

        $(document).on("keyup", "#tagInput", function (event) {
            if (event.key === " " && this.value.trim() !== "") {
                let tagText = this.value.trim();

                if (!tags.includes(tagText)) { // Cegah tag duplikat
                    tags.push(tagText);
                    renderTags();
                }

                this.value = "";
            }
        });

        $(document).on("click", ".remove", function () {
            let tagText = $(this).parent().text().trim().replace("×", "").trim();
            tags = tags.filter(tag => tag !== tagText);
            renderTags();
        });

        console.log(tags); // Data tag yang bisa dikirim ke server
    });

    function save() {
        console.log(tags);
    }

</script> --}}

@include('ajax.activityAjax')
@endsection
