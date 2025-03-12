<script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- filepond -->
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>

<script>
    FilePond.create( document.querySelector('.basic-filepond'), {
        allowImagePreview: false,
        allowMultiple: true,
        allowFileEncode: false,
        required: true,
        acceptedFileTypes: ['pdf'],
        fileValidateTypeDetectType: (source, type) => new Promise((resolve, reject) => {
            // Do custom type detection here and return with promise
            resolve(type);
        })
    });
</script>

<script>
    let id_project = 0;
    $(document).ready(function () {
        let data_projects = [];
        loadProjects();
        getCategory();
        getDoc();
    });

    $('#formModal').on('hidden.bs.modal', function () {
        document.getElementById("post-form").reset();
        $('.invalid-feedback').remove(); // Remove error messages
        $('.form-control').removeClass('is-invalid');
        id_project = 0;
    });

    function loadProjects() {
        $("#table-body").empty();

        $.ajax({
            url: "http://doc-center-backend.test/api/v1/projects", // Replace with your API URL
            type: "GET",
            dataType: "json",
            success: function (response) {
                data_projects = response.data;
                // console.log(data_projects);
                if (!response || !response.data) {
                    console.error("Invalid API response:", response);
                    return;
                }

                let rows = ""; // Variable to store generated rows

                $.each(response.data, function (index, project) {
                    rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${project.project_name}</td>
                        <td>${project.company_name}</td>
                        <td>${project.director_name}</td>
                        <td>${project.start_date}</td>
                        <td>
                            <span class="badge ${project.status === 'Active' ? 'bg-success' : 'bg-danger'}">
                                ${project.status}
                            </span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#detailModal" onclick="detailModal(${project.id})">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-info rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#docModal" onclick="showDoc(${project.id})">
                                <i class="fa-solid fa-file"></i>
                            </a>
                        </td>
                    </tr>`;
                });

                $("#table-body").html(rows);

                let table1 = document.querySelector('#table1');
                let dataTable = new simpleDatatables.DataTable(table1);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    }

    function detailModal(id) {
        let project = data_projects.find(project => project.id === id);
        id_project = project.id;
        // console.log(project);

        $("#project_name_detail").text(project.project_name);
        $("#company_name_detail").text(project.company_name);
        $("#company_address_detail").text(project.company_address);
        $("#director_name_detail").text(project.director_name);
        $("#director_phone_detail").text(project.director_phone);
        $("#start_project_detail").text(project.start_date);
        $("#end_project_detail").text(project.end_date);
        document.getElementById("editButton").setAttribute("onclick", "setId(" + project.id + ")");
    }

    function setId(id) {
        // document.getElementById("addButton").setAttribute("onclick", "set(" + id + ")");
        id_project = id;
        console.log(id_project+" in setId()")
        $('#formTitle').empty();

        if (id_project > 0) {
            // Load project data
            let project = data_projects.find(project => project.id === id);
            // console.log(project);

            document.querySelector('input[name="project_name"]').value = project.project_name;
            document.querySelector('input[name="company_name"]').value = project.company_name;
            document.querySelector('textarea[name="company_address"]').value = project.company_address;
            document.querySelector('input[name="director_name"]').value = project.director_name;
            document.querySelector('input[name="director_phone"]').value = project.director_phone;
            document.querySelector('input[name="start_date"]').value = project.start_date;
            document.querySelector('input[name="end_date"]').value = project.end_date;

            $('#formTitle').text('Form Edit Project');
            console.log(" in setId() if")
            document.getElementById("addButton").click();
        } else {
            console.log(" in setId() else")
            $('#formTitle').text('Form Add Project');
        }

        // document.getElementById("addButton").setAttribute("onclick", "set(0)");
    }

    function updateProject(formData){
        let apiUrl = `http://doc-center-backend.test/api/v1/projects/${id_project}`;

        let jsonData = {};
        formData.forEach((value, key) => {
            jsonData[key] = value;
        });

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
                console.log('Response:', response);
                alert('Project updated successfully!');
                location.reload();
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

        $.ajax({
            url: '{{ route('project.store') }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                alert('Project saved successfully!');
                location.reload();
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
            updateProject(formData);
        }else{
            submitPostForm(formData);
        }
    });

    function deleteProject() {
        console.log(id_project);
        $.ajax({
            url: `http://doc-center-backend.test/api/v1/projects/${id_project}`,
            type: 'DELETE',
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     // 'Authorization': 'Bearer ' + yourApiToken
            // },
            success: function (response) {
                alert('Project deleted successfully!');
                location.reload();
            },
            error: function (xhr) {
                console.error('Error:', xhr);
                alert('Something went wrong. Please try again.');
            }
        });
    }

    // ================== Document Modal ==================

    $('#docModal').on('hidden.bs.modal', function () {
        document.getElementById("post-form").reset();
        $('.invalid-feedback').remove(); // Remove error messages
        $('.form-control').removeClass('is-invalid');
        $('.form-select').removeClass('is-invalid');
        id_project = 0;
    });

    function getCategory(){
        $("#category_input").empty();
        $("#category_show").empty();

        $.ajax({
            url: "http://doc-center-backend.test/api/v1/admin-doc-categories", // Replace with your API URL
            type: "GET",
            dataType: "json",
            success: function (response) {
                // console.log(response);

                if (!response || !response.data) {
                    console.error("Invalid API response:", response);
                    return;
                }

                let rows = ""; // Variable to store generated rows
                rows += `<option value="#">Select Category</option>`;

                $.each(response.data, function (index, category) {
                    rows += `
                    <option value="${ category.id }">${ category.name }</option>`;
                });

                $("#category_input").html(rows);
                $("#category_show").html(rows);
            }
        });
    }

    function showDoc(id) {
        let project = data_projects.find(project => project.id === id);
        id_project = project.id;
        // console.log(project);

        $("#project_name_doc").text(project.project_name);
    }

    function storeDoc(){
        event.preventDefault();

        let form = document.getElementById("docForm");
        if (!form) {
            console.error("Form #docForm not found!");
            return;
        }

        let formData = new FormData(form);

        if (typeof id_project !== 'undefined' && id_project !== null) {
            formData.append("project_id", id_project);
        } else {
            console.error("Error: id_project is undefined or null!");
            alert("Invalid project ID.");
            return;
        }

        let filePondInstance = FilePond.find(document.querySelector('.basic-filepond'));
        if (filePondInstance) {
            let files = filePondInstance.getFiles();

            if (files.length > 0) {
                formData.append("file", files[0].file);
            } else {
                console.warn("No file selected!");
                alert("Please select a file.");
                return;
            }
        } else {
            console.error("FilePond instance not found!");
            alert("File input not found.");
            return;
        }

        let apiUrl = `http://doc-center-backend.test/api/v1/admin-docs`;

        $.ajax({
            url: apiUrl,
            type: 'POST',
            data: formData,
            // headers: {
            //     'Accept': 'application/json', // Specify the response format
            //     'Authorization': 'Bearer ' + yourApiToken, // Add API token if required
            // },
            // data: JSON.stringify(jsonData),
            processData: false,
            contentType: false,
            success: function (response) {
                console.log('Response:', response);
                alert('Document saved successfully!');
                location.reload();
            },
            error: function (xhr) {
                console.log('Error:', xhr);
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    $('.invalid-feedback').remove();
                    $('.form-control').removeClass('is-invalid');
                }else if(xhr.status === 400) {
                    let errors = xhr.responseJSON.errors;
                    console.log(errors);

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

    function getDoc(){
        // $('#category_show').onchange(function(){
        //     let id_category = $(this).val();
        //     console.log(id_category);
        // });
        // let category = data_category.find(category => category.id === id);
        // let file = category.find()

        // $("#doc_table").empty();

        $.ajax({
            url: `http://doc-center-backend.test/api/v1/admin-docs`, // Replace with your API URL
            type: "GET",
            dataType: "json",
            success: function (response) {
                console.log(response.data);

                let id_category = 2;
                let id_project = 3;

                let filteredData = response.data.filter(doc =>
                    doc.admin_doc_category_id === id_category && doc.project_id === id_project
                );

                console.log("Filtered Data:", filteredData);

                // if (!response || !response.data) {
                //     console.error("Invalid API response:", response);
                //     return;
                // }

                // let rows = "";

                // $.each(response.data, function (index, doc) {
                //     rows += `
                //     <tr>
                //         <td>${index + 1}</td>
                //         <td>${doc.category_name}</td>
                //         <td>${doc.file_name}</td>
                //         <td>${doc.created_at}</td>
                //         <td>
                //             <a href="#" class="btn btn-sm btn-warning rounded-pill" data-bs-toggle="modal"
                //                 data-bs-target="#detailModal" onclick="detailModal(${doc.id})">
                //                 <i class="fa-solid fa-ellipsis-vertical"></i>
                //             </a>
                //         </td>
                //     </tr>`;
                // });

                // $("#doc_table").html(rows);
            }
        });
    }
</script>

