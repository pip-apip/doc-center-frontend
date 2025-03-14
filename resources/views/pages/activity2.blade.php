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
            <table class="table table-striped" id="table_activity">
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
    aria-hidden="true">
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
                        <input type="text" placeholder="Enter the Activity Title" class="form-control" name="title" id="title_doc">
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
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalScrollableTitle">Form Document Activity</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                        <div class="col-sm-6" id="section1" style="display: none">
                            <label>Title: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Enter the Title" class="form-control" name="title" id="title">
                            </div>
                        </div>
                    </div>

                    <div id="section2" style="display: none">
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
                                <div class="tag-container" id="tags">
                                    <input type="text" id="tagInput" placeholder="Ketik dan tekan spasi..." />
                                </div>
                            </div>
                        </div>
                </form>
            </div>


        </div>
        <div class="modal-footer">
            {{-- <button type="button" class="btn btn-primary ml-1" onclick="save()"> --}}
            <button type="button" class="btn btn-primary ml-1" onclick="storeDoc()">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block"><i class="fa-solid fa-floppy-disk"></i> Save</span>
            </button>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="formDocModal_Old" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalScrollableTitle">Form Document Activity</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="#">
                <div class="modal-body">

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
                        <div class="col-sm-6">
                            <label>Title: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Enter the Title" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div id="section1" style="display: none">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Description : </label>
                                <div id="editor">
                                    <p>Hello World!</p>
                                    <p>Some initial <strong>bold</strong> text</p>
                                    <p><br /></p>
                                </div>
                            </div>
                            <div class="col-sm-12" style="margin-top: 70px">
                                <label>Tags : </label>
                                <div class="tag-container" style="display: none; " id="section2">
                                    <input type="text" id="tagInput" placeholder="Ketik dan tekan spasi..." />
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary ml-1" data-bs-dismiss="modal" id="section3"
                        style="display: none">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><i class="fa-solid fa-floppy-disk"></i> Save</span>
                    </button>
                </div>
            </form>
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
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'direction': 'rtl' }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                [{ 'header': [1, 2, 3, false] }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'font': [] }],
                [{ 'align': [] }],
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

<script>
    let id_activity = 0;
    let activity_data = [];

    $(document).ready(function () {
        loadActivityData();
        getProject();
    });

    function loadActivityData(){
        $('#table_body').empty();
        $.ajax({
            url: 'http://doc-center-backend.test/api/v1/activities',
            type: 'GET',
            success: function (response) {
                activity_data = response.data;
                let rows = ""; // Variable to store generated rows

                $.each(response.data, function (index, activity) {
                    rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${activity.title}</td>
                        <td>${activity.project_id}</td>
                        <td>${activity.start_date}</td>
                        <td>${activity.end_date}</td>
                        <td>
                            <span class="badge ${activity.status === 'Active' ? 'bg-success' : 'bg-danger'}">
                                ${activity.status}
                            </span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning rounded-pill modalll" data-bs-toggle="modal"
                                data-bs-target="#formModal" onclick="fillForm(${activity.id})"><i
                                    class="fa-solid fa-pen"></i></a>
                            <a href="#" class="btn btn-sm btn-danger rounded-pill modalll" onclick="deleteActivity(${activity.id})"><i class="fa-solid fa-trash"></i></a>
                            <a href="#" class="btn btn-sm btn-info rounded-pill modalll" data-bs-toggle="modal"
                                data-bs-target="#formDocModal" onclick="showDocModal(${activity.id})"><i class="fa-solid fa-file"></i></a>
                            </a>
                        </td>
                    </tr>`;
                });

                $("#table_body").html(rows);
            },
            error: function (xhr) {
                console.log(xhr.responseJSON);
            }
        });
    }

    function getProject(){
        $.ajax({
            url: 'http://doc-center-backend.test/api/v1/projects',
            type: 'GET',
            success: function (response) {
                let project = response.data;
                console.log(project);
                let projectSelect = $('#project_id');
                projectSelect.empty();
                projectSelect.append('<option value="">Select Project Name</option>');
                $.each(project, function (index, value) {
                    projectSelect.append(`<option value="${value.id}">${value.project_name}</option>`);
                });
            },
            error: function (xhr) {
                console.log(xhr.responseJSON);
            }
        });
    }

    $('#formModal').on('hidden.bs.modal', function () {
        document.getElementById("activityForm").reset();
        $('.invalid-feedback').remove(); // Remove error messages
        $('.form-control').removeClass('is-invalid');
        $('.form-select').removeClass('is-invalid');
        id_activity = 0;
    });

    function fillForm(id) {
        let activity = activity_data.find(activity => activity.id === id);
        $('#project_id').val(activity.project_id);
        $('#title').val(activity.title);
        $('#start_date').val(activity.start_date);
        $('#end_date').val(activity.end_date);
        id_activity = id;
    }

    function submitForm(id){
        if(id_activity == 0){
            console.log('store');
            storeActivity();
        }else{
            console.log('update');
            updateActivity(id_activity);
        }
    }

    function updateActivity(id) {
        let form = document.getElementById("activityForm");
        if (!form) {
            console.error("Form #activityForm not found!");
            return;
        }

        let formData = new FormData(form);

        let jsonData = {};
        formData.forEach((value, key) => {
            jsonData[key] = value;
        });

        $.ajax({
            url: `http://doc-center-backend.test/api/v1/activities/${id}`,
            type: 'PATCH',
            data: JSON.stringify(jsonData),
            processData: false,
            contentType: 'application/json',
            success: function (response) {
                alert('Project updated successfully!');
                $('#closeFormModal').click();
                loadActivityData();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    $('.invalid-feedback').remove();
                    $('.form-control').removeClass('is-invalid')
                }
            }
        });
    }

    function storeActivity() {

        let form = document.getElementById("activityForm");
        if (!form) {
            console.error("Form #activityForm not found!");
            return;
        }

        let formData = new FormData(form);

        $.ajax({
            url: 'http://doc-center-backend.test/api/v1/activities',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                alert('Project saved successfully!');
                $('#closeFormModal').click();
                loadActivityData();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    $('.invalid-feedback').remove();
                    $('.form-control').removeClass('is-invalid');

                    $.each(errors, function (key, messages) {
                        let inputField = $(`[name="${key}"]`);
                        inputField.addClass('is-invalid');
                        inputField.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                    });
                } else if (xhr.status === 400) { // Validation error
                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, messages) {
                        let inputField = $(`[name="${key}"]`);
                        inputField.addClass("is-invalid")
                            .after(`<div class="invalid-feedback">${messages[0]}</div>`);
                    });
                } else {
                    console.log(xhr.responseJSON.errors);
                }
            }
        });
    }

    function deleteActivity(id) {
        // console.log("ID : "+id)
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Make AJAX request only after confirmation
                $.ajax({
                    url: `http://doc-center-backend.test/api/v1/activities/${id}`,
                    type: 'DELETE',
                    success: function (response) {75
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Your Activity has been deleted",
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                            loadActivityData();
                            // location.reload(); // Refresh after the SweetAlert
                        });
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr);
                        Swal.fire({
                            title: "Error!",
                            text: "Something went wrong. Please try again.",
                            icon: "error"
                        });
                    }
                });
            }
        });
    }

</script>

<script>
    let tags = [];
    $(document).ready(function () {
        renderTags();
    });

    $("#documentCat").change(function () {
        let selectedValue = $(this).val();
        if (selectedValue === "MOM") {
            $("#section1").show();
            $("#section2").show();
            // $("#section3").show();
        } else {
            $("#section1").hide();
            $("#section2").hide();
            // $("#section3").hide();
        }
    });

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

    $(document).on("keyup", "#tagInput", function (event) {
        if (event.key === " " && this.value.trim() !== "") {
            let tagText = this.value.trim();
            if (!tags.includes(tagText)) {
                tags.push(tagText);
                renderTags();
            }
            this.value = "";
        }
    });

    // Remove tag on click
    $(document).on("click", ".remove", function () {
        let tagText = $(this).parent().text().trim().replace("×", "").trim();
        tags = tags.filter(tag => tag !== tagText);
        renderTags();
    });

    function showDocModal(id){
        id_activity = id;
        let activity = activity_data.find(activity => activity.id === id_activity);
        $('#activity_name_doc').text(activity.title);

        // let activityDoc = getActivityDoc(id);
        // console.log(activityDoc);

    }

    function getActivityDoc(id){
        $.ajax({
            url: `http://doc-center-backend.test/api/v1/activity-docs/${id}`,
            type: 'GET',
            success: function (response) {
                return response.data;
            },
            error: function (xhr) {
                console.log(xhr.responseJSON);
            }
        });
    }

    function storeDoc() {
        console.log(id_activity);
        // let form = document.getElementById("activityDocForm");
        // if (!form) {
        //     console.error("Form #activityDocForm not found!");
        //     return;
        // }

        let formData = new FormData();

        formData.append("title", $("#title_doc").val());
        formData.append("description", quill.root.innerHTML);
        formData.append("tags", JSON.stringify(tags));
        formData.append("activity_doc_category_id", $("#documentCat").text());
        formData.append("activity_id", id_activity);

        // formData.append("document_category", $("#documentCat").val());

        // $.ajax({
        //     url: 'http://doc-center-backend.test/api/v1/activity-docs',
        //     type: 'POST',
        //     data: formData,
        //     processData: false,
        //     contentType: false,
        //     success: function (response) {
        //         alert('Document saved successfully!');
        //         $('#closeFormDocModal').click();
        //         loadActivityData();
        //     },
        //     error: function (xhr) {
        //         if (xhr.status === 422) {
        //             let errors = xhr.responseJSON.errors;

        //             $('.invalid-feedback').remove();
        //             $('.form-control').removeClass('is-invalid')
        //         }
        //     }
        // });
    }

    $('#formDocModal').on('hidden.bs.modal', function () {
        document.getElementById("activityForm").reset();
        $('.invalid-feedback').remove(); // Remove error messages
        $('.form-control').removeClass('is-invalid');
        $('.form-select').removeClass('is-invalid');
        id_activity = 0;
    });
</script>
@endsection
