@extends('layouts.app')

@section('title', 'Project Page')

@section('content')
<style>
    /* Universal Modal Styling */
    .modern-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.3s ease-in-out;
        padding: 15px;
    }

    /* Modal Content - Desktop */
    .modern-modal-content {
        position: relative;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 15px;
        width: 90%;
        max-width: 800px;
        max-height: 85vh;
        text-align: center;
        animation: fadeIn 0.3s ease-in-out;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        justify-content: center;
        overflow: hidden;
    }

    #imageViewer {
        max-width: 100%;
        max-height: 75vh;
        border-radius: 8px;
        object-fit: contain;
    }

    /* Close Button */
    .closeImage {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 28px;
        color: white;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .closeImage:hover {
        transform: scale(1.2);
    }

    /* 🔥 Responsive for Mobile */
    @media screen and (max-width: 768px) {
        .modern-modal-content {
            width: 95%;
            max-height: 70vh;
            padding: 10px;
        }

        #imageViewer {
            min-height: 50vh;
        }

        .closeImage {
            font-size: 24px;
            top: 5px;
            right: 10px;
        }
    }

    /* Fade-in Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
</style>

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Data Company</h3>
            {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Company</li>
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
                        <th>Company Name</th>
                        <th>Company Address</th>
                        <th>Director Name</th>
                        <th>Director Phone</th>
                        <th>Director Signature</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>
                <tbody id="table-body">

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
                <h4 class="modal-title" id="formTitle">Form Add Project</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="closeFormModal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form id="companyForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Company Name: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Enter the Company Name" class="form-control" id="name" name="name">
                            </div>

                            <label>Company Address: </label>
                            <div class="form-group">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Enter the Company Address" id="address" name="address"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Director Name: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Enter the Director Name" class="form-control" name="director_name" id="director_name">
                            </div>

                            <label>Director Phone: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Enter the Director Phone" class="form-control" name="director_phone" id="director_phone">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <label>Director Signature</label>
                            <div class="form-group">
                                <input type="file" class="file_ttd" name="file" data-max-file-size="2MB">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary ml-1" onclick="store(event)">
                        <i class="fa-solid fa-floppy-disk"></i> Save
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
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary ml-1" type="submit" onclick="updateProject()">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><i class="fa-solid fa-floppy-disk"></i> Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modernImageModal" class="modern-modal" style="display: none" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modern-modal-content">
        <span class="closeImage" onclick="closeModernModal()">&times;</span>
        <img id="modernImagePreview" alt="Preview">
    </div>
</div>

<div id="fullPageLoader" class="full-page-loader">
    <div class="spinner-border text-light" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>


<script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- filepond -->
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>

<script>
    FilePond.create( document.querySelector('.file_ttd'), {
        allowImagePreview: false,
        allowMultiple: true,
        allowFileEncode: false,
        required: false,
        acceptedFileTypes: ['png', 'jpg', 'jpeg'],
        fileValidateTypeDetectType: (source, type) => new Promise((resolve, reject) => {
            // Do custom type detection here and return with promise
            resolve(type);
        })
    });
</script>

<script>
    let id_company = 0;
    let backendUrl = 'http://doc-center-backend.test/';
    let access_token = @json(session('user.access_token'));
    $(document).ready(function () {
        let data_company = [];
        loadProjects();
    });

    $('#formAddModal').on('hidden.bs.modal', function () {
        document.getElementById("companyForm").reset();
        $('.invalid-feedback').remove(); // Remove error messages
        $('.form-control').removeClass('is-invalid');
        id_company = 0;
    });

    function loadProjects() {
        $('#fullPageLoader').show();
        $("#table-body").empty();

        $.ajax({
            url: backendUrl + "api/v1/companies",
            type: "GET",
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + access_token,
            },
            dataType: "json",
            success: function (response) {
                if(response.status === 200){
                    data_company = response.data;
                    console.log(response);
                    if (!response || !response.data) {
                        console.error("Invalid API response:", response);
                        return;
                    }

                    let rows = ""; // Variable to store generated rows

                    $.each(response.data, function (index, company) {
                        rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${company.name ? company.name : "-"}</td>
                            <td>${company.address ? company.address : "-"}</td>
                            <td>${company.director_name ? company.director_name : "-"}</td>
                            <td>${company.director_phone}</td>
                            <td>
                                ${company.director_signature ?
                                `<button class="btn btn-sm btn-info" onclick="openModernModal('${backendUrl + company.director_signature}')"><i class="fa-solid fa-eye"></i> Preview Signature</button>` : `"Don't have Signature Director"`}
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning rounded-pill" data-bs-toggle="modal"
                                    data-bs-target="#formAddModal" onclick="setId(${company.id})">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-danger rounded-pill" data-bs-toggle="modal" onclick="deleteCompany(${company.id})">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>`;
                    });

                    $("#table-body").html(rows);

                    let table1 = document.querySelector('#table1');
                    let dataTable = new simpleDatatables.DataTable(table1);
                }else{
                    console.log(response);
                }
                $('#fullPageLoader').hide();
            },
            error: function (xhr, status, error) {
                if (xhr.status === 401) {
                    console.log("Token expired. Refreshing token...");
                    refreshToken();
                } else {
                    console.log(xhr);
                }
            }
        });
    }

    function setId(id) {
        let company = data_company.find(company => company.id === id);
        $('#name').val(company.name);
        $('#address').val(company.address);
        $('#director_name').val(company.director_name);
        $('#director_phone').val(company.director_phone);
        id_company = id;
    }

    function updateProject(){
        $('#fullPageLoader').show();
        event.preventDefault(); // Prevent default form submission

        console.log(id_company)
        // let id_company = window.id_company;
        if (!id_company) {
            console.error("id_company is undefined!");
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

        let apiUrl = `https://bepm.hanatekindo.com/api/v1/admin-doc-categories/${id_company}`;


        $.ajax({
            url: apiUrl, // Use the API URL
            type: 'PATCH',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + access_token,
            },
            data: JSON.stringify(jsonData),
            processData: false,
            contentType: 'application/json',
            success: function (response) {
                $('#fullPageLoader').hide();
                if(response.status === 400) {  // Validation error
                    let errors = response.errors;

                    $.each(errors, function (key, messages) {
                        let inputField = $(`[name="${key}"]`);
                        inputField.addClass("is-invalid")
                            .after(`<div class="invalid-feedback">${messages[0]}</div>`);
                    });
                }else if(response.status === 200){
                    $('#fullPageLoader').hide();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Company Data  has been edited",
                        showConfirmButton: false,
                        timer: 1000
                    }).then(() => {
                        $('#closeEditModal').click();
                        loadProjects();
                        // location.reload(); // Refresh after the SweetAlert
                    });
                }else{
                    console.log(response)
                }
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    console.log("Token expired. Refreshing token...");
                    refreshToken();
                } else {
                    console.log(xhr);
                }
            }
        });
    }

    function store(event) {
        $('#fullPageLoader').show();
        event.preventDefault();

        console.log('Storing company details...');

        let formData = new FormData();
        formData.append("name", $("#name").val());
        formData.append("address", $("#address").val());
        formData.append("director_name", $("#director_name").val());
        formData.append("director_phone", $("#director_phone").val());

        let filePondInstance = FilePond.find(document.querySelector('.file_ttd'));
        if (filePondInstance) {
            let files = filePondInstance.getFiles();

            if (files.length > 0) {
                formData.append("director_signature", files[0].file);
            }
        }

        let apiUrl = '';

        if(id_company === 0){
            apiUrl = backendUrl + `api/v1/companies`;
        }else{
            apiUrl = backendUrl + `api/v1/companies/` + id_company;
        }


        $.ajax({
            url: apiUrl,
            type: "POST",
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + access_token,
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#fullPageLoader').hide();
                if(response.status === 400) {
                    let errors = response.errors;

                    $.each(errors, function (key, messages) {
                        let inputField = $(`[name="${key}"]`);
                        inputField.addClass("is-invalid")
                            .after(`<div class="invalid-feedback">${messages[0]}</div>`);
                    });
                }else if(response.status === 200){
                    $('#fullPageLoader').hide();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Company Data has been edited",
                        showConfirmButton: false,
                        timer: 1000
                    }).then(() => {
                        $('#closeEditModal').click();
                        loadProjects();
                        // location.reload(); // Refresh after the SweetAlert
                    });
                }else{
                    console.log(response)
                }
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    console.log("Token expired. Refreshing token...");
                    refreshToken();
                } else {
                    console.log(xhr);
                }
            }
        });
    }

    function deleteCompany(id) {
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
                $.ajax({
                    url: backendUrl + `api/v1/companies/${id}`,
                    type: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + access_token,
                    },
                    success: function (response) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Company Data has been deleted",
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                            loadProjects();
                            // location.reload(); // Refresh after the SweetAlert
                        });
                    },
                    error: function (xhr) {
                        if (xhr.status === 401) {
                            console.log("Token expired. Refreshing token...");
                            refreshToken();
                        } else {
                            console.error('Error:', xhr);
                            Swal.fire({
                                title: "Error!",
                                text: "Something went wrong. Please try again.",
                                icon: "error"
                            });
                        }
                    }
                });
            }
        });
    }

    function openModernModal(imageSrc) {
        document.getElementById('modernImagePreview').src = imageSrc;
        document.getElementById('modernImageModal').style.display = "flex";
    }

    function closeModernModal() {
        document.getElementById('modernImageModal').style.display = "none";
    }
</script>
@endsection
