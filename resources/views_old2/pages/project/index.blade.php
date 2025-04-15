@extends('layouts.app')

@section('title', 'Project Page')

@section('content')

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
                    <li class="breadcrumb-item active" aria-current="page">Project</li>
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
                    <h1>Project</h1>
                </div>
                <div class="col-sm-4 d-flex justify-content-end align-items-center">
                    <a href="{{ route('project.create') }}" class="btn btn-success">
                        <i class="fa-solid fa-plus"></i> Add
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Project Name</th>
                        <th>Company Name</th>
                        <th>Start Project</th>
                        <th>End Project</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($projects as $project)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $project['name'] }}</td>
                            <td>{{ $project['company']['name'] }}</td>
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</section>

<div class="modal fade text-left w-100" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Detail Project</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="closeDetailModal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div>
                <div class="modal-body">

                    <label><b> Project Name : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="project_name_detail">Alpha Build</p>
                    </div>

                    <div class="row">

                        <div class="col-sm-8">
                            <label><b> Company Name : </b></label>
                            <div class="form-group">
                                <p class="form-control-static" id="company_name_detail">Alpha Build</p>
                            </div>

                            <label><b> Company Address : </b></label>
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
                            <label><b> Director Name : </b></label>
                            <div class="form-group">
                                <p class="form-control-static" id="director_name_detail">John Doe</p>
                            </div>

                            <label><b> Director Phone : </b></label>
                            <div class="form-group">
                                <p class="form-control-static" id="director_phone_detail">089213182731</p>
                            </div>
                        </div>

                        <hr>

                        <div class="col-sm-8">
                            <label><b> Start Project : </b></label>
                            <div class="form-group">
                                <p class="form-control-static" id="start_project_detail">10-01-2023</p>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label><b> End Project : </b></label>
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
                        <span class="d-none d-sm-block"><i class="fa-solid fa-trash"></i> Delete</span>
                    </button>
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
    let data = {!! json_encode($projects) !!}
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.querySelector('#table');
        new simpleDatatables.DataTable(table);
    });

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

    function showDetail(data){
        console.log(data);
        $("#project_name_detail").text(data.name);
        $("#company_name_detail").text(data.company.name);
        $("#company_address_detail").text(data.company.address);
        $("#director_name_detail").text(data.company.director_name);
        $("#director_phone_detail").text(data.company.director_phone);
        $("#start_project_detail").text(dateFormat(data.start_date));
        $("#end_project_detail").text(dateFormat(data.end_date));
        $("#editButton").attr("href", "{{ route('project.edit', '') }}/"+data.id);
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
