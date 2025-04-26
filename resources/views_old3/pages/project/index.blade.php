@extends('layouts.app')

@section('title', 'Project Page')

@section('content')
<style>
    .scrollable-table {
        width: 100%;
        border-collapse: collapse;
    }

    .scrollable-table thead,
    .scrollable-table tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed; /* Prevents layout issues */
    }

    .scrollable-table tbody {
        display: block;
        max-height: 200px;
        overflow-y: auto;
    }

    .scrollable-table thead th input[type="text"] {
        width: 80%;
        padding: 2px 8px;
        font-size: 0.9rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        color: rgb(97, 112, 126);
        margin-left: 4px;
    }

    .scrollable-table thead th input[type="text"]:focus {
    outline: none;
    box-shadow: none;
    border-color: #ccc; /* atau warna border default yang kamu mau */
}

    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }
</style>

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            {{-- <h3>Data Project</h3> --}}
            {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Projek</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<section class="section">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-8">
                    <h1>Projek</h1>
                </div>
                <div class="col-sm-4 d-flex justify-content-end align-items-center">
                    <a href="{{ route('project.create') }}" class="btn btn-success">
                        <i class="fa-solid fa-plus"></i> Tambah
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('project.index') }}" id="pagination-form" class="mb-4">
                <fieldset class="form-group" style="width: 70px">
                    <select class="form-select" id="entire-page" name="per_page" onchange="document.getElementById('pagination-form').submit();">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                    </select>
                </fieldset>
            </form>
            <div class="table-responsive">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Projek</th>
                            <th>Nama Perusahaan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @php
                            $no = $results->firstItem();
                        @endphp
                        @foreach ($results as $project)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $project['name'] }}</td>
                                <td>{{ $project['company_name'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($project['start_date'])->translatedFormat('d F Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($project['end_date'])->translatedFormat('d F Y') }}</td>
                                <td>
                                    {{-- <span class="badge {{ $project['status'] ? 'bg-success' : 'bg-danger'}}"> --}}
                                    <span class="badge bg-danger">
                                        {{-- {{$project['status']}} --}}
                                        Undefined
                                    </span>
                                </td>
                                <td>
                                    {{-- <a href="{{ route('project.edit', $project['id']) }}" class="btn btn-sm btn-warning rounded-pill" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a> --}}
                                    <a onclick="showDetail({{ json_encode($project) }})" class="btn btn-sm btn-warning rounded-pill" data-bs-toggle="modal" data-bs-target="#detailModal">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </a>
                                    <a href="{{ route('project.doc', $project['id']) }}" class="btn btn-sm btn-info rounded-pill">
                                        <i class="fa-solid fa-file"></i>
                                    </a>
                                    <a href="{{ route('activity.project', $project['id']) }}" class="btn btn-sm btn-secondary rounded-pill">
                                        <i class="fa-solid fa-chart-line"></i>
                                    </a>
                                    <a href="{{ route('activity.project', $project['id']) }}" onclick="teamModal({{ $project['id'] }}, `{{ $project['name'] }}`, ``)" class="btn btn-sm btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#teamModal">
                                        <i class="fa-solid fa-user-group"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            {{-- <td colspan="2">Total <b>{{ $results->firstItem() }}</b> Data</td> --}}
                            <td colspan="7"><span style="margin-top: 15px;">{{ $results->appends(request()->query())->links() }}</span></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade text-left w-100" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Detail Projek</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="closeDetailModal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div>
                <div class="modal-body">

                    <label><b> Nama Projek : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="project_name_detail">Alpha Build</p>
                    </div>

                    <div class="row">

                        <div class="col-sm-8">
                            <label><b> Nama Perusahaan : </b></label>
                            <div class="form-group">
                                <p class="form-control-static" id="company_name_detail">Alpha Build</p>
                            </div>

                            <label><b> Alamat Perusahaan : </b></label>
                            <div class="form-group">
                                <div class="form-floating">
                                    <p class="form-control-static" id="company_address_detail">Lorem ipsum dolor sit amet
                                        consectetur adipisicing elit. Velit maxime aut ipsam explicabo, cum consequuntur
                                        numquam dolorem harum asperiores omnis? Repellendus quasi harum consequuntur
                                        eveniet saepe voluptates quos placeat odit.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label><b> Nama Direktur : </b></label>
                            <div class="form-group">
                                <p class="form-control-static" id="director_name_detail">John Doe</p>
                            </div>

                            <label><b> No.Telp Direktur : </b></label>
                            <div class="form-group">
                                <p class="form-control-static" id="director_phone_detail">089213182731</p>
                            </div>
                        </div>

                        <hr>

                        <div class="col-sm-8">
                            <label><b> Tanggal Mulai : </b></label>
                            <div class="form-group">
                                <p class="form-control-static" id="start_project_detail">10-01-2023</p>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label><b> Tanggal Selesai : </b></label>
                            <div class="form-group">
                                <p class="form-control-static" id="end_project_detail">10-05-2023</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <a class="btn btn-warning ml-1" id="editButton">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><i class="fa-solid fa-pen"></i> Edit</span>
                    </a>
                    <button type="button" class="btn btn-danger ml-1" data-bs-dismiss="modal" onclick="deleteProject()">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><i class="fa-solid fa-trash"></i> Hapus</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left w-100" id="teamModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Tim Projek</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="closeTeamModal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div>
                <div class="modal-body">
                    <input type="text" id="project_id" hidden>
                    <label><b> Nama Projek : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="project_name_team">Alpha Build</p>
                    </div>
                    <hr>
                    <div class="row" id="teamInput" style="display: none">
                        <div class="col-sm-6">
                            <p class="text-center"><b>ALL USER</b></p>
                            <hr>
                            <table class="table table-striped mb-0 scrollable-table">
                                <thead>
                                    <tr>
                                        <th width="80%">Nama <input type="text" id="userSearch"></th>
                                        <th width="20%" style="text-align: center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table_set">
                                </tbody>
                            </table>
                        </div>

                        <div class="col-sm-6">
                            <p class="text-center"><b>FIX TEAM</b></p>
                            <hr>
                            <table class="table table-striped mb-0 scrollable-table">
                                <thead>
                                    <tr>
                                        <th width="80%">Nama</th>
                                        <th width="20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table_fix">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="teamShow" style="display: none">
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                <table class="table table-striped mb-0 scrollable-table">
                                    <thead>
                                        <tr>
                                            <th width="10%">No</th>
                                            <th width="90%">Nama</th>
                                            {{-- <th width="20%">Aksi</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody id="table_show">
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer" id="footerTeam">
                    {{-- <button type="button" class="btn btn-success ml-1" onclick="saveTeam()" id="submitButton">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Simpan
                    </button> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<div id="fullPageLoader" class="full-page-loader" style="display: none">
    <div class="spinner-border text-light" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<div id="modernImageModal" class="modern-modal" style="display: none" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modern-modal-content">
        <img id="modernImagePreview" alt="Preview">
    </div>
    <span class="closeImage" onclick="closeModernModal()">&times;</span>
</div>

<script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
    let users = {!! isset($users) ? json_encode($users) : '[]' !!};
    let teams = {!! isset($groupedTeams) ? json_encode($groupedTeams) : '[]' !!};
    let userSet = [];
    let teamFix = [];


    document.addEventListener("DOMContentLoaded", function () {
        setUser();
        console.log(JSON.stringify(@json(session('lastRoute')), null, 2));
    });

    $('#teamModal').on('hidden.bs.modal', function () {
        $('#userSearch').val('');
        $('#table_set').empty();
        $('#table_fix').empty();
        userSet = [];
        setUser();
        teamFix = [];
    });

    function teamModal(id, projectName, status){
        teams.forEach(function (team) {
            if (team.project_id == id) {
                teamFix = team.members;
            }
        });
        userSet = userSet.filter(user => !teamFix.some(team => team.id === user.id));
        renderTeam();
        renderUser();

        $('#project_id').val(id);
        $('#project_name_team').text(projectName);
        if(teamFix.length > 0 && status === ""){
            $('#footerTeam').empty();
            let html = '';
            $.each(teamFix, function (index, user) {
                html += `
                    <tr>
                        <td width="10%" class="text-bold-500">${index+1}</td>
                        <td width="90%" class="text-bold-500">${user.name}</td>
                    </tr>`;
            });
            $('#table_show').html(html);
            $('#teamShow').show();
            $('#teamInput').hide();
        }else{
            $('#teamShow').hide();
            $('#teamInput').show();
        }

        let footerHtml = '';
        if(status === "input" || teamFix.length === 0){
            footerHtml += `
                <button type="button" class="btn btn-success ml-1" onclick="saveTeam()" id="submitButton">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan
                </button>
            `;
        }else{
            footerHtml += `
                <button type="button" class="btn btn-warning ml-1" onclick="teamModal(${id}, '${projectName}', 'input')" id="submitButton">
                        <i class="fa-solid fa-pen"></i>
                        Edit
                </button>
            `;
        }
        $('#footerTeam').html(footerHtml);
        $('#userSearch').val('');
    }

    $('#userSearch').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#table_set tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    function saveTeam(){
        // console.log(teamFix);
        buttonLoadingStart('submitButton');
        $.ajax({
            url: "{{ route('project.store.team') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                team: teamFix,
                project_id: $('#project_id').val()
            },
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        buttonLoadingEnd('submitButton');
                        $('#closeTeamModal').click();
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        buttonLoadingEnd('submitButton');
                        $('#closeTeamModal').click();
                    });
                }
            }, error: function (xhr) {
                console.log(xhr.responseText);
            }
        })
    }

    function setUser(){
        $.each(users, function (index, user) {
            userSet.push({
                name: user.name,
                id: user.id
            });
        });
    }

    function renderUser(){
        let rows = "";
        // let button = "";
        $('#table_set').empty();
        if(userSet.length > 0){
            $.each(userSet, function (index, user) {
                rows += `
                    <tr>
                        <td width="80%" class="text-bold-500">${user.name}</td>
                        <td width="20%" style="text-align: center">
                            <button type="button" class="btn btn-sm btn-success rounded-pill" onclick="removeUser(${user.id}, 'user')">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </td>
                    </tr>`;
                // button = `
                //     <button type="button" class="btn btn-success ml-1" onclick="teamModal(${user.id}, '${user.name}')" id="submitButton">
                //             <i class="fa-solid fa-pen"></i>
                //             Edit
                //     </button>`;
            });
            // $('#footerTeam').html(button);
        } else {
            rows += `
                <tr>
                    <td colspan="2" class="text-center">Tidak Ada User Yang Tersisa</td>
                </tr>`;
        }
        $('#table_set').html(rows);
    }

    function renderTeam(){
        let rows = "";
        $('#table_fix').empty();
        if(teamFix.length > 0){
            $.each(teamFix, function (index, user) {
                rows += `
                    <tr>
                        <td width="80%" class="text-bold-500">${user.name}</td>
                        <td width="20%" style="text-align: center">
                            <button type="button" class="btn btn-sm btn-danger rounded-pill" onclick="removeUser(${user.id}, 'team')">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </td>
                    </tr>`;
            });
        } else {
            rows += `
                <tr>
                    <td colspan="2" class="text-center">Tidak Anggota di Projek ini</td>
                </tr>`;
        }
        $('#table_fix').html(rows);
    }

    function removeUser(id, status){
        const user = userSet.find(user => user.id === id);
        const team = teamFix.find(user => user.id === id);

        if (status === 'team' && team) {
            teamFix = teamFix.filter(user => user.id !== id);
            if (team) userSet.push(team);
        } else if (status === 'user' && user) {
            userSet = userSet.filter(user => user.id !== id);
            if (user) teamFix.push(user);
        }

        renderUser();
        renderTeam();
    }

    function confirmDelete(url) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Anda tidak dapat mengembalikan data yang dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
        }).then((result) => {
            if (result.isConfirmed) {
                $('#fullPageLoader').show();
                window.location.href = url;
            }
        });
    }

    function showDetail(data){
        console.log(data);
        $("#project_name_detail").text(data.name);
        $("#company_name_detail").text(data.company_name);
        $("#company_address_detail").text(data.company_address);
        $("#director_name_detail").text(data.company_director_name);
        $("#director_phone_detail").text(data.company_director_phone);
        $("#start_project_detail").text(dateFormat(data.start_date));
        $("#end_project_detail").text(dateFormat(data.end_date));
        $("#editButton").attr("href", "{{ route('project.edit', '') }}/"+data.id);
    }

    function dateFormat(dateString) {
        let [year, month, day] = dateString.split("-");

        let date = new Date(year, month - 1, day);

        let formattedDate = new Intl.DateTimeFormat("id-ID", {
            day: "2-digit",
            month: "long",
            year: "numeric"
        }).format(date);

        return formattedDate;
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
