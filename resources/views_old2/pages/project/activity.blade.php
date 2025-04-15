@extends('layouts.app')

@section('title', 'Activity Page')

@section('content')

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <a href="{{ route('project.index') }}"><i class="fa-solid fa-arrow-left"></i></a>
            {{-- <h3>Activity Detail</h3> --}}
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
            <h1>Detail Project</h1>
        </div>
        <div class="card-body">
            <label><b> Project Name : </b></label>
            <div class="form-group">
                <p class="form-control-static" id="project_name_detail">{{ $project['name'] }}</p>
            </div>

            <div class="row">

                <div class="col-sm-8">
                    <label><b> Company Name : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="company_name_detail">{{ $project['company']['name'] }}</p>
                    </div>

                    <label><b> Company Address : </b></label>
                    <div class="form-group">
                        <div class="form-floating">
                            <p class="form-control-static" id="company_address_detail">{{ $project['company']['address'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <label><b> Director Name : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="director_name_detail">{{ $project['company']['director_name'] }}</p>
                    </div>

                    <label><b> Director Phone : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="director_phone_detail">{{ $project['company']['director_phone'] }}</p>
                    </div>
                </div>

                <hr>

                <div class="col-sm-8">
                    <label><b> Start Project : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="start_project_detail">{{ $project['start_date'] }}</p>
                    </div>
                </div>

                <div class="col-sm-4">
                    <label><b> End Project : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="end_project_detail">{{ $project['end_date'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<section class="section">
    <div class="card">
        <div class="card-header text-right">
            <div class="row">
                <div class="col-sm-8">
                    <h1>Activity Project</h1>
                </div>
                <div class="col-sm-4 d-flex justify-content-end align-items-center">
                    <a href="{{ route('activity.create') }}" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Activity Title</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody id="table">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($activities as $act)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $act['title'] }}</td>
                        <td>{{ $act['start_date'] }}</td>
                        <td>{{ $act['end_date'] }}</td>
                        <td>
                            {{-- <span class="badge {{ $project['status'] ? 'bg-success' : 'bg-danger'}}"> --}}
                            <span class="badge bg-danger">
                                {{-- {{$project['status']}} --}}
                                Undefined
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('activity.edit', $act['id']) }}" class="btn btn-sm btn-warning rounded-pill">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger rounded-pill" onclick="confirmDelete('{{ route('activity.destroy', $act['id']) }}')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <a href="{{ route('activity.doc', $act['id']) }}" class="btn btn-sm btn-info rounded-pill">
                                <i class="fa-solid fa-file"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</section>

{{-- JQuery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
{{-- SimpleDatatables - Template --}}
<script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>

<script>
    let projectData = {!! json_encode($project) !!}
    let activityList = {!! json_encode($activities) !!}
    let lastPage = {!! json_encode(session('lastUrl') ) !!}

    document.addEventListener("DOMContentLoaded", function () {
        const table = document.querySelector('#table');
        new simpleDatatables.DataTable(table);
    });

</script>
@endsection