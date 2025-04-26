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
        border: 1px solid #dc3545;
        background-color: #f8d7da;
        color: #721c24;
    }

    .file-upload-wrapper .file-upload{
        cursor: pointer;
    }

    .file-preview {
        margin-top: 10px;
        text-align: center;
    }

    .file-preview img {
        max-width: 200px;
        max-height: 150px;
        display: block;
        margin: 10px auto;
        border-radius: 6px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .remove-btn {
        background: none;
        border: none;
        color: #c00;
        cursor: pointer;
        text-decoration: underline;
        font-size: 14px;
        margin-top: 5px;
    }
</style>

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
                    <li class="breadcrumb-item" aria-current="page">Perusahaan</li>
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
                    <h1>Form {{ $status === 'create' ? 'Tambah' : 'Edit' }} Perusahaan</h1>
                </div>
                <div class="col-sm-4 d-flex justify-content-end align-items-center">
                    <a href="{{ route('company.index') }}"><i class="fa-solid fa-angle-left"></i> Kembali</a>
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
                        <label>Nama Perusahaan: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Masukkan Nama Perusahaan" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $company ? $company['name'] : '') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <label>Alamat Perusahaan: </label>
                        <div class="form-group">
                            <textarea class="form-control @error('address') is-invalid @enderror" placeholder="Masukkan Alamat Perusahaan" id="address" name="address">{{ old('address', $company ? $company['address'] : '') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label>Nama Direktur: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Masukkan Nama Direktur" class="form-control @error('director_name') is-invalid @enderror" name="director_name" id="director_name" value="{{ old('director_name', $company ? $company['director_name'] : '') }}">
                            @error('director_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <label>No.Telp Direktur: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Masukkan No.Telp Direktur" class="form-control @error('director_phone') is-invalid @enderror" name="director_phone" id="director_phone" value="{{ old('director_phone', $company ? $company['director_phone'] : '') }}">
                            @error('director_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <label>Tanda Tangan Direktur</label>
                        <div class="file-upload-wrapper {{ $errors->has('director_signature') ? 'is-invalid' : '' }}" id="dropzone">
                            <label for="file-upload" class="file-upload">
                                <div class="text" id="text"> Drag & Drop your files or <span class="browse">Browse</span></div>
                                <input type="file" id="file-upload" name="director_signature" accept="image/*" />
                                <div class="file-name" id="file-name"></div>
                            </label>
                            <div class="file-preview" id="file-preview">
                                @if (!empty($company['director_signature']))
                                    <img src="{{ $API_url . $company['director_signature'] }}" id="preview-img">
                                    <button type="button" class="remove-btn" onclick="removeFile()"><i class="fa-solid fa-xmark"></i></button>
                                    <input type="hidden" name="existing_signature" value="{{ $company['director_signature'] }}">
                                @endif
                            </div>
                        </div>
                        @error('director_signature')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary ml-1" id="submitBtn">
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
        $('.text').hide();
    }

    const previewContainer = document.getElementById('file-preview');

    function displayPreviewImage(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewContainer.innerHTML = `
                <img src="${e.target.result}" id="preview-img">
                <button type="button" class="remove-btn" onclick="removeFile()"><i class="fa-solid fa-xmark"></i></button>
            `;
        };
        reader.readAsDataURL(file);
    }

    function removeFile() {
        fileInput.value = ''; // Clear the file input
        fileName.textContent = '';
        previewContainer.innerHTML = '';
        $('.text').show();
    }

    // Hook into file change to show preview
    fileInput.addEventListener('change', function(e) {
        if (fileInput.files && fileInput.files[0]) {
            displayFileName(fileInput.files);
            displayPreviewImage(fileInput.files[0]);
        }
    });

    // Also handle file drop
    dropzone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropzone.classList.remove('dragover');
        const files = e.dataTransfer.files;
        fileInput.files = files;
        if (files.length > 0) {
            displayFileName(files);
            displayPreviewImage(files[0]);
        }
    });
</script>

@endsection