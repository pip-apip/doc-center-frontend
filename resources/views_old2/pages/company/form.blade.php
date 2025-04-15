@extends('layouts.app')

@section('title', 'Company Page')

@section('content')

<style>
    /* File Upload Wrapper */
    .file-upload-wrapper {
        background-color: #f4f3f2;
        padding: 20px;
        border-radius: 8px;
        border: none;
        text-align: center;
        width: 100%;
        color: #555;
        font-size: 16px;
        position: relative;
        cursor: pointer;
    }

    .file-upload-wrapper input[type="file"] {
        display: none;
    }

    .file-upload-wrapper .file-name {
        font-size: 14px;
        color: #555;
    }

    .file-upload-wrapper .browse {
        text-decoration: underline;
        font-weight: 500;
        color: #444;
    }

    .file-upload-wrapper.is-invalid {
    border: 2px solid red;
    background-color: #fff0f0;
}
</style>

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <a href="{{ route('company.index') }}"><i class="fa-solid fa-arrow-left"></i></a>
            {{-- <h3>Data Company</h3> --}}
            {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Company</li>
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
                    <h1>Company {{ $status === 'create' ? 'Add' : 'Edit' }} Form</h1>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($status === 'create')
                <form id="companyForm" action="{{ route('company.store') }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
            @elseif ($status === 'edit')
                <form id="companyForm" action="{{ route('company.update', $company['id']) }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
            @endif
            @csrf
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label>Company Name: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Enter the Company Name" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $company ? $company['name'] : '') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <label>Company Address: </label>
                        <div class="form-group">
                            <textarea class="form-control @error('address') is-invalid @enderror" placeholder="Enter the Company Address" id="address" name="address">{{ old('address', $company ? $company['address'] : '') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label>Director Name: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Enter the Director Name" class="form-control is-invalid" name="director_name" id="director_name" value="{{ old('director_name', $company ? $company['director_name'] : '') }}">
                            {{-- @error('director_name') --}}
                                <div class="invalid-feedback">Error</div>
                            {{-- @enderror --}}
                        </div>

                        <label>Director Phone: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Enter the Director Phone" class="form-control @error('director_phone') is-invalid @enderror" name="director_phone" id="director_phone" value="{{ old('director_phone', $company ? $company['director_phone'] : '') }}">
                            @error('director_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label>Director Signature</label>
                        {{-- <div class="form-group">
                            <input type="file" class="file_ttd" name="file" data-max-file-size="2MB">
                        </div> --}}
                        <div class="file-upload-wrapper" id="dropzone">
                            <label for="file-upload" class="file-upload-wrapper {{ $errors->has('director_signature') ? 'is-invalid' : '' }}">
                                Drag & Drop your files or <span class="browse">Browse</span>
                                <input type="file" id="file-upload" name="director_signature" />
                                <div class="file-name" id="file-name"></div>
                            </label>
                        </div>
                        @error('director_signature')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary ml-1" id="submitBtn">
                    <i class="fa-solid fa-floppy-disk"></i> Save
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

<script>
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
</script>

{{-- File Upload Script --}}
<script>
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('file-upload');
    const fileName = document.getElementById('file-name');

    // Handle file drag events
    dropzone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropzone.classList.add('dragover');
    });

    dropzone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropzone.classList.remove('dragover');
    });

    dropzone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropzone.classList.remove('dragover');
        const files = e.dataTransfer.files;
        fileInput.files = files; // simulate file selection
        displayFileName(files);
    });

    // Handle file selection from the input
    fileInput.addEventListener('change', function(e) {
        displayFileName(fileInput.files);
    });

    // Function to display file name
    function displayFileName(files) {
        if (files.length > 0) {
            fileName.textContent = `Selected file: ${files[0].name}`;
        } else {
            fileName.textContent = '';
        }
    }
</script>

@endsection