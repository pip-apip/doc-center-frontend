@extends('layouts.app')

@section('title', 'Project Page')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            {{-- <pre>{{ json_encode(session('lastRoute'), JSON_PRETTY_PRINT) }}</pre> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard </a></li>
                    <li class="breadcrumb-item" aria-current="page">Aktivitas</li>
                    <li class="breadcrumb-item active" aria-current="page">Form</li>
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
                    <h1>Form {{ $status === 'create' ? 'Tambah' : 'Edit' }} Aktivitas</h1>
                </div>
                @php
                    $lastRoute = session('lastRoute');
                    $routeParts = explode(', ', $lastRoute); // pisahkan nama route dan parameter
                    $routeName = $routeParts[0];
                    $routeParam = $routeParts[1] ?? null;
                @endphp


                <div class="col-sm-4 d-flex justify-content-end align-items-center">
                    <a href="{{ $routeParam ? route($routeName, $routeParam) : route($routeName) }}">
                        <i class="fa-solid fa-angle-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($status === 'create')
                <form action="{{ route('activity.store') }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
            @elseif ($status === 'edit')
                <form action="{{ route('activity.update', $activity['id']) }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
            @endif
                @csrf
                <label>Nama Projek : </label>
                <fieldset class="form-group">
                    {!! $countDocAct > 0 ? '<input type="text" name="project_id" id="project_id" value="' . $activity['project_id'] . '" hidden>' : '' !!}
                    <select class="form-select @error('project_id') is-invalid @enderror" id="project_id" name="project_id" {{ $countDocAct > 0 ? 'disabled' : '' }}>
                        <option value="">Pilih Projek</option>
                        @foreach ($projects as $project)
                        <option value="{{ $project['id'] }}" {{ old('project_id', $activity ? $activity['project_id'] : '') == $project['id'] ? 'selected' : '' }}>
                            {{ $project['name'] }}
                        </option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </fieldset>
                {{-- @if ($countDocAct > 0)
                    <input type="text" name="project_id" id="project_id" value="{{ $activity['project']['id'] }}" hidden>
                @endif --}}

                <label>Judul Aktivitas : </label>
                <div class="form-group">
                    <input type="text" placeholder="Masukkan Judul Aktivitas" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title', $activity ? $activity['title'] : '') }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <label>Tanggal Mulai: </label>
                        <div class="form-group">
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="start_date" value="{{ old('start_date', $activity ? $activity['start_date'] : '') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label>Tanggal Selesai: </label>
                        <div class="form-group">
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" id="end_date" value="{{ old('end_date', $activity ? $activity['end_date'] : '') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary ml-1" type="submit">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><i class="fa-solid fa-floppy-disk"></i> Simpan</span>
                </button>
            </form>
        </div>
    </div>
</section>

<div id="fullPageLoader" class="full-page-loader" style="display: none">
    <div class="spinner-border text-light" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@if(session()->has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session()->get('success') }}',
        });
    </script>
@endif

@if(session()->has('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session()->get('error') }}',
        });
    </script>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log(JSON.stringify(@json(session('lastRoute')), null, 2));
    });
</script>



@endsection