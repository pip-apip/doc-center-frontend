@extends('layouts.app')

@section('title', 'Activity Page')

@section('content')

{{-- <div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <a href="{{ route('project.index') }}"><i class="fa-solid fa-arrow-left"></i></a>
            <h3>Activity Detail</h3>
            <p class="text-subtitle text-muted">For user to check they list</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('project.index') }}">Proyek</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Activity</li>
                </ol>
            </nav>
        </div>
    </div>
</div> --}}

<section class="section">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-8 col-10">
                    <h1>Detail Proyek</h1>
                </div>
                <div class="col-sm-4 col-4 d-flex justify-content-end align-items-center">
                    <a href="{{ route('project.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fa-solid fa-angle-left"></i> <span class="d-none d-md-inline-block">Kembali</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">


            <div class="row">

                <div class="col-sm-8">
                    <label><b> Nama Proyek : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="project_name_detail">{{ $project['name'] }}</p>
                    </div>

                    <label><b> Nama Perusahaan : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="company_name_detail">{{ $project['company_name'] }}</p>
                    </div>

                    <label><b> Alamat Perusahaan : </b></label>
                    <div class="form-group">
                        <div class="form-floating">
                            <p class="form-control-static" id="company_address_detail">{{ $project['company_address'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <label><b> Proyek Leader : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="project_leader_name_detail">{{ $project['project_leader_name'] }}</p>
                    </div>

                    <label><b> Nama Direktur : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="director_name_detail">{{ $project['company_director_name'] }}</p>
                    </div>

                    <label><b> No.Telp Direktur : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="director_phone_detail">{{ $project['company_director_phone'] }}</p>
                    </div>
                </div>

                <hr>

                <div class="col-sm-8">
                    <label><b> Tanggal Mulai : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="start_project_detail">{{ \Carbon\Carbon::parse($project['start_date'])->translatedFormat('d F Y') }}</p>
                    </div>
                </div>

                <div class="col-sm-4">
                    <label><b> Tanggal Selesai : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="end_project_detail">{{ \Carbon\Carbon::parse($project['end_date'])->translatedFormat('d F Y') }}</p>
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
                <div class="col-sm-8 col-11">
                    <h1>Aktivitas Proyek</h1>
                </div>
                <div class="col-sm-4 col-1 d-flex justify-content-end align-items-center">
                    <a href="{{ route('activity.create', ['project_id' => $project['id']]) }}" class="btn btn-success"><i class="fa-solid fa-plus"></i> <span class="d-none d-md-inline-block">Tambah</span></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            {{-- <th>No</th> --}}
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Judul Aktivitas</th>
                            <th>Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table">
                        {{-- @php
                            $no = 1;
                        @endphp --}}
                        @if($activities = [] || count($activities) == 0)
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data aktivitas</td>
                            </tr>
                        @else
                        @foreach ($activities as $act)
                        <tr>
                            {{-- <td>{{ $no++ }}</td> --}}
                            <td>{{ \Carbon\Carbon::parse($act['start_date'])->translatedFormat('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($act['end_date'])->translatedFormat('d F Y') }}</td>
                            <td>{{ $act['title'] }}</td>
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
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

{{-- JQuery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    let projectData = {!! json_encode($project) !!}
    let activityList = {!! json_encode($activities) !!}
    let lastPage = {!! json_encode(session('lastUrl') ) !!}

</script>
@endsection