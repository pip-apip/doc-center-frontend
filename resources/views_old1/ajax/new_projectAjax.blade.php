<script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- filepond -->
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

<script>
    FilePond.create(document.querySelector('.basic-filepond-activity1'), {
        allowImagePreview: false,
        allowMultiple: false,
        allowFileEncode: false,
        required: false
    });
    FilePond.create( document.querySelector('.filepond-project'), {
        // allowImagePreview: false,
        // allowMultiple: true,
        // allowFileEncode: false,
        // required: true,
        // acceptedFileTypes: ['pdf'],
        // fileValidateTypeDetectType: (source, type) => new Promise((resolve, reject) => {
        //     // Do custom type detection here and return with promise
        //     resolve(type);
        // })
        allowImagePreview: false,
        allowMultiple: false,
        allowFileEncode: false,
        required: false
    });
</script>

<script>
    let id_project = 0;
    let backendUrl = 'http://doc-center-backend.test/api/v1/';
    let access_token = @json(session('user.access_token'));
    $(document).ready(function () {
        let data_projects = [];
        loadProjects();
    });

    $('#formModal, #detailModal, #docModal').on('hidden.bs.modal', function () {
        document.getElementById("post-form").reset();
        $('.invalid-feedback').remove();
        $('.form-control').removeClass('is-invalid');
        $('.form-group').removeClass('is-invalid');
        id_project = 0;
    });

    function loadProjects() {
        $('#fullPageLoader').show();
        $("#table-body").empty();

        $.ajax({
            url: backendUrl + "projects",
            type: "GET",
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + access_token,
            },
            dataType: "json",
            success: function (response) {
                if(response.status === 200){
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
                            <td>${project.name}</td>
                            <td>${project.company.name}</td>
                            <td>` + dateFormat(project.start_date) + `</td>
                            <td>` + dateFormat(project.end_date) + `</td>
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
                                <button class="btn btn-sm btn-danger rounded-pill" onclick="activityPage(${project.id})">
                                    <i class="fa-solid fa-chart-line"></i>
                                </button>
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
                // console.log(@json(session('user.access_token')));
                if (xhr.status === 401) {
                    console.log("Token expired. Refreshing token...");
                    refreshToken();
                } else {
                    console.log(xhr);
                }
            }
        });
    }

    function getCompany(){
        $.ajax({
            url: backendUrl + "companies",
            type: "GET",
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + access_token,
            },
            dataType: "json",
            success: function (response) {
                data_company = response.data;
                let rows = `<option value="#">Select Company</option>`;
                $.each(response.data, function (index, company) {
                    rows += `<option value="${company.id}">${company.name}</option>`;
                });

                $("#company_id").html(rows);
            },
            error: function (xhr, status, error) {
                if (xhr.status === 401) {
                    console.log("Token expired. Refreshing token...");
                    // refreshToken();
                } else {
                    console.log(xhr);
                }
            }
        });
    }

    function detailModal(id) {
        let project = data_projects.find(project => project.id === id);
        id_project = project.id;
        // console.log(project);
        $("#project_name_detail").text(project.name);
        $("#company_name_detail").text(project.company.name);
        $("#company_address_detail").text(project.company.address);
        $("#director_name_detail").text(project.company.director_name);
        $("#director_phone_detail").text(project.company.director_phone);
        $("#start_project_detail").text(dateFormat(project.start_date));
        $("#end_project_detail").text(dateFormat(project.end_date));
        $('#editButton').attr("onclick", "setId(" + project.id + ")")
        // document.getElementById("editButton").setAttribute("onclick", "setId(" + project.id + ")");
    }

    function dateFormat(dateString) {
        let [year, month, day] = dateString.split("-"); // Split by "-"

        // Convert to a valid Date object
        let date = new Date(year, month - 1, day); // Month is zero-based in JS

        // Format using Indonesian locale
        let formattedDate = new Intl.DateTimeFormat("id-ID", {
            day: "2-digit",
            month: "long",
            year: "numeric"
        }).format(date);

        return formattedDate;
    }

    function openPDFModal(pdfUrl) {
        document.getElementById('pdfViewer').src = pdfUrl;
        document.getElementById('modernPDFModal').style.display = "flex";
    }

    function closePDFModal() {
        document.getElementById('modernPDFModal').style.display = "none";
        document.getElementById('pdfViewer').src = ""; // Clear src to stop loading
    }
</script>