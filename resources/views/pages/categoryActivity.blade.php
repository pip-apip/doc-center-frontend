@extends('layouts.app')

@section('title', 'Project Page')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Data Category Activity</h3>
            {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Category</li>
                    <li class="breadcrumb-item active" aria-current="page">Activity</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<section class="section">
    <div class="card">
        <div class="card-header">
            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formAddModal"
                id="addButton">
                <i class="fa-solid fa-plus"></i> Add</a>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th width="100">No</th>
                        <th>Category Name</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>
                <tbody id="table-categoryAdmin">

                </tbody>

            </table>
        </div>
    </div>
</section>

<div class="modal fade text-left w-100" id="formAddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33" id="formTitle">Form Add Category</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="closeAddModal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="#" id="post-form">
                @csrf
                <div class="modal-body">

                    <label>Category Name : </label>
                    <div class="form-group">
                        <input type="text" placeholder="Enter the Category Name" class="form-control"
                            name="name">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary ml-1" type="submit">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><i class="fa-solid fa-floppy-disk"></i> Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade text-left w-100" id="formEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33" id="formTitle">Form Edit Project</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="closeEditModal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="#" id="edit-form">
                @csrf
                <div class="modal-body">

                    <label>Category Name : </label>
                    <div class="form-group">
                        <input type="text" placeholder="Enter the Category Name" class="form-control" id="name_edit"
                            name="name">
                    </div>
                    @error('name')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary ml-1" type="submit" onclick="updateCategory()">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><i class="fa-solid fa-floppy-disk"></i> Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    let id_project = 0;
    $(document).ready(function () {
        let data_category = [];
        loadCategoryAdmin();
    });

    $('#formAddModal').on('hidden.bs.modal', function () {
        document.getElementById("post-form").reset();
        $('.invalid-feedback').remove(); // Remove error messages
        $('.form-control').removeClass('is-invalid');
        id_project = 0;
    });

    function loadCategoryAdmin() {
        $("#table-categoryAdmin").empty();

        $.ajax({
            url: "http://doc-center-backend.test/api/v1/activity-doc-categories", // Replace with your API URL
            type: "GET",
            dataType: "json",
            success: function (response) {
                data_category = response.data;
                // console.log(data_projects);
                if (!response || !response.data) {
                    console.error("Invalid API response:", response);
                    return;
                }

                let rows = ""; // Variable to store generated rows

                $.each(response.data, function (index, category) {
                    rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${category.name}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#formEditModal" onclick="setId(${category.id})">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger rounded-pill" onclick="deleteCategory(${category.id})">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>`;
                });

                $("#table-categoryAdmin").html(rows);

                let table1 = document.querySelector('#table1');
                let dataTable = new simpleDatatables.DataTable(table1);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    }

    function setId(id) {
        // document.getElementById("addButton").setAttribute("onclick", "set(" + id + ")");
        id_project = id;
        console.log(id_project)
        // document.getElementById("addButton").click();

        if (id_project > 0) {
            // Load project data
            let category = data_category.find(category => category.id === id);
            console.log(category);

            $('#name_edit').val(category.name);

            $('#formTitle').text('Form Edit Project');
        } else {
            $('#formTitle').text('Form Add Project');
            clearForm();
        }
    }

    function updateCategory(){
        event.preventDefault(); // Prevent default form submission

        console.log(id_project)
        // let id_project = window.id_project; // Ensure id_project is available
        if (!id_project) {
            console.error("id_project is undefined!");
            alert("Invalid project ID.");
            return;
        }

        let form = document.getElementById("edit-form"); // Get form element
        if (!form) {
            console.error("Form #edit-form not found!");
            return;
        }

        let formData = new FormData(form); // Get form data
        let jsonData = {};

        formData.forEach((value, key) => {
            jsonData[key] = value;
        });

        let apiUrl = `http://doc-center-backend.test/api/v1/activity-doc-categories/${id_project}`;


        $.ajax({
            url: apiUrl, // Use the API URL
            type: 'PATCH',
            // headers: {
            //     'Accept': 'application/json', // Specify the response format
            //     'Authorization': 'Bearer ' + yourApiToken, // Add API token if required
            // },
            data: JSON.stringify(jsonData),
            processData: false,
            contentType: 'application/json',
            success: function (response) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Your Category has been edited",
                    showConfirmButton: false,
                    timer: 1000
                }).then(() => {
                    $('#closeEditModal').click();
                    loadCategoryAdmin();
                    // location.reload(); // Refresh after the SweetAlert
                });
            },
            error: function (xhr) {
                console.log('Error:', xhr);
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    $('.invalid-feedback').remove();
                    $('.form-control').removeClass('is-invalid');
                    $.each(errors, function (key, messages) {
                        let inputField = $(`[name="${key}"]`);
                        inputField.addClass('is-invalid');
                        inputField.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                    });
                } else if(xhr.status === 400) {  // Validation error
                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, messages) {
                        let inputField = $(`[name="${key}"]`);
                        inputField.addClass("is-invalid")
                            .after(`<div class="invalid-feedback">${messages[0]}</div>`);
                    });
                }else{
                    console.log(xhr.responseJSON.errors);
                }
            }
        });
    }

    function submitPostForm(formData) {
        console.log("id_project : " + id_project);

        let apiUrl = `http://doc-center-backend.test/api/v1/activity-doc-categories`;

        let jsonData = {};
        formData.forEach((value, key) => {
            jsonData[key] = value;
        });

        $.ajax({
            url: apiUrl, // Use the API URL
            type: 'POST',
            // headers: {
            //     'Accept': 'application/json', // Specify the response format
            //     'Authorization': 'Bearer ' + yourApiToken, // Add API token if required
            // },
            data: JSON.stringify(jsonData),
            processData: false,
            contentType: 'application/json',
            success: function (response) {
                // alert('Project saved successfully!');
                // location.reload();
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Your Category has been saved",
                    showConfirmButton: false,
                    timer: 1000
                }).then(() => {
                    $('#closeAddModal').click();
                    loadCategoryAdmin();
                    // location.reload(); // Refresh after the SweetAlert
                });
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
                } else if(xhr.status === 400) {  // Validation error
                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, messages) {
                        let inputField = $(`[name="${key}"]`);
                        inputField.addClass("is-invalid")
                            .after(`<div class="invalid-feedback">${messages[0]}</div>`);
                    });
                }else{
                    console.log(xhr.responseJSON.errors);
                }
            }
        });
    }

    $('#post-form').on('submit', function (e) {
        // console.log("submit clicked");
        e.preventDefault();

        var formData = new FormData(this); // Gunakan FormData untuk semua input (termasuk file)
        // console.log("FormData Content:");
        // for (let pair of formData.entries()) {
        //     console.log(pair[0] + ": " + pair[1]);
        // }

        // Tambahkan CSRF token jika mengakses Laravel langsung
        // formData.append('_token', '{{ csrf_token() }}');

        if(id_project > 0){
            updateCategory(formData);
        }else{
            submitPostForm(formData);
        }
    });

    function deleteCategory(id) {
        console.log("ID : "+id)
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
                    url: `http://doc-center-backend.test/api/v1/activity-doc-categories/${id}`,
                    type: 'DELETE',
                    success: function (response) {75
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Your Category has been deleted",
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                            loadCategoryAdmin();
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
@endsection
