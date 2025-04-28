@extends('layouts.app')

@section('title', 'Company Page')

@section('content')

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            {{-- <h3>Data Company</h3> --}}
            {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">User</li>
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
                    <h1>Form {{ $status === 'create' ? 'Tambah' : 'Edit' }} User</h1>
                </div>
                <div class="col-sm-4 d-flex justify-content-end align-items-center">
                    <a href="{{ route('user.index') }}"><i class="fa-solid fa-arrow-left"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($status === 'create')
                <form action="{{ route('user.store') }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
            @elseif ($status === 'edit')
                <form action="{{ route('user.update', $user['id']) }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
            @endif
            @csrf
                <div class="row">
                    <div class="col-md-2">
                        <label>Username: </label>
                    </div>
                    <div class="form-group col-md-10">
                        <input type="text" placeholder="Masukkan Username" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user ? $user['username'] : '') }}">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label>Name: </label>
                    </div>
                    <div class="form-group col-md-10">
                        <input type="text" placeholder="Masukkan Nama" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user ? $user['name'] : '') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label>Password: </label>
                    </div>
                    <div class="form-group col-md-10">
                        <input type="password" placeholder="Masukkan Password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label>Role User</label>
                    </div>
                    <fieldset class="form-group col-md-10">
                        <select class="form-select" name="role" id="role">
                            <option value="USER" {{ old('role', $user ? $user['role'] : '') == 'USER' ? 'selected' : '' }}>User</option>
                            <option value="ADMIN" {{ old('role', $user ? $user['role'] : '') == 'ADMIN' ? 'selected' : '' }}>Admin</option>
                            <option value="SUPERADMIN" {{ old('role', $user ? $user['role'] : '') == 'SUPERADMIN' ? 'selected' : '' }}>Super Admin</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </fieldset>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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

@endsection