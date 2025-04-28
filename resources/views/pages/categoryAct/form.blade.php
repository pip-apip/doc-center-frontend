@extends('layouts.app')

@section('title', 'Project Page')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            {{-- <h3>Data Category</h3> --}}
            {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Kategori</li>
                    <li class="breadcrumb-item" aria-current="page">Aktifitas</li>
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
                <div class="col-sm-8 col-8">
                    <h1>Form {{ $status === 'create' ? 'Tambah' : 'Edit' }} <span class="d-none d-md-inline-block"> Categori Aktivitas</span></h1>
                </div>
                <div class="col-sm-4 col-4 d-flex justify-content-end align-items-center">
                    <a href="{{ route('categoryAct.index') }}"><i class="fa-solid fa-angle-left"></i> <span class="d-none d-md-inline-block">Kembali</span></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($status === 'create')
                <form action="{{ route('categoryAct.store') }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
            @elseif ($status === 'edit')
                <form action="{{ route('categoryAct.update', $category['id']) }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
            @endif
            @csrf
                {{-- {{ dd($category); }} --}}
                <div class="row">
                    <div class="col-md-2">
                        <label>Nama Kategori : </label>
                    </div>
                    <div class="form-group col-md-10">
                        <input type="text" placeholder="Masukkan Nama Kategori" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $category ? $category['name'] : '') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary ml-1" type="submit">
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
    $(document).ready(function() {
        $('form').on('submit', function() {
            // $('#fullPageLoader').show();
        });
    });
</script>



@endsection