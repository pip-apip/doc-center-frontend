@extends('layouts.app')

@section('title', 'Project Page')

@section('content')

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Project</li>
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
                    <h1>Form {{ $status === 'create' ? 'Tambah' : 'Edit' }} Projek</h1>
                </div>
                <div class="col-sm-4 d-flex justify-content-end align-items-center">
                    <a href="{{ route('project.index') }}"><i class="fa-solid fa-angle-left"></i> Kembali</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($status === 'create')
                <form action="{{ route('project.store') }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
            @elseif ($status === 'edit')
                <form action="{{ route('project.update', $project['id']) }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
            @endif
            @csrf
            <label>Nama Projek : </label>
            <div class="form-group">
                <input type="text" placeholder="Masukkan Nama Projek" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $project ? $project['name'] : '') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-12">
                <label>Nama Perusahaan: </label>
                <fieldset class="form-group">
                    <select class="form-select @error('company_id') is-invalid @enderror" id="company_id" name="company_id">
                        <option value="">Pilih Perusahaan</option>
                        @foreach ($companies as $comp)
                        <option value="{{ $comp['id'] }}" {{ old('company_id', $project ? $project['company_id'] : '') == $comp['id'] ? 'selected' : '' }}>
                            {{ $comp['name'] }}
                        </option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </fieldset>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <label>Tanggal Mulai: </label>
                    <div class="form-group">
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', $project ? $project['start_date'] : '') }}">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-6">
                    <label>Tanggal Selesai: </label>
                    <div class="form-group">
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date', $project ? $project['end_date'] : '') }}">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

                <button type="submit" class="btn btn-primary ml-1">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan
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

<div id="modernImageModal" class="modern-modal" style="display: none" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modern-modal-content">
        <img id="modernImagePreview" alt="Preview">
    </div>
    <span class="closeImage" onclick="closeModernModal()">&times;</span>
</div>

<script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log(JSON.stringify(@json(session('lastRoute')), null, 2));
    });
</script>

@endsection