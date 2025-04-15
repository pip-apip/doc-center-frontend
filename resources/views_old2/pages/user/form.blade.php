@extends('layouts.app')

@section('title', 'Company Page')

@section('content')

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
                <div class="row">
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
                            <div class="form-floating">
                                <textarea class="form-control @error('address') is-invalid @enderror" placeholder="Enter the Company Address" id="address" name="address">{{ old('address', $company ? $company['address'] : '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label>Director Name: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Enter the Director Name" class="form-control @error('director_name') is-invalid @enderror" name="director_name" id="director_name" value="{{ old('director_name', $company ? $company['director_name'] : '') }}">
                            @error('director_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                        <div class="form-group">
                            <input type="file" class="file_ttd" name="file" data-max-file-size="2MB">
                        </div>
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

<!-- filepond -->
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>

<script>
    FilePond.create(document.querySelector('.file_ttd'), {
        allowImagePreview: false,  // Disable image preview (optional, based on your use case)
        allowMultiple: false,      // Allow only one file to be uploaded (set to true if multiple files are allowed)
        allowFileEncode: true,     // Enable base64 encoding of the file (optional)
        required: false,           // Make the file input not required (set to true if required)
        acceptedFileTypes: ['image/png', 'image/jpeg'], // Allowed file types (can be adjusted based on your needs)
        maxFileSize: '2MB',        // Max file size limit
    });

    // FilePond.registerPlugin();

    // const inputElement = document.querySelector("#director_signature");
    // const pond = FilePond.create(inputElement, {
    //     server: {
    //         process: "{{ $status === 'create' ? route('company.store') : route('company.update', $company['id']) }}", // Using the same endpoint
    //         headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    //     }
    // });
</script>

<script>
    $(document).ready(function() {
        let csrfToken = $("meta[name='csrf-token']").attr("content");

        $('#submitBtn').on('click', function(e) {
            e.preventDefault();

            let formData = new FormData();
            formData.append("name", $("#name").val());
            formData.append("address", $("#address").val());
            formData.append("director_name", $("#director_name").val());
            formData.append("director_phone", $("#director_phone").val());

            let filePondInstance = FilePond.find(document.querySelector('.file_ttd'));
            if (filePondInstance) {
                let files = filePondInstance.getFiles();
                if (files.length > 0) {
                    formData.append("director_signature", files[0].file);
                }
            }

            let actionUrl = $("#companyForm").attr("action");
            let method = $("#companyForm").attr("method").toUpperCase();

            $.ajax({
                url: actionUrl,
                type: method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response)
                    if(response.status === 'success') {
                        // Display success message (using a custom alert or modal)
                        alert(response.message);
                    } else {
                        // Display error message
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error (e.g., show an error message)
                    console.log("An error occurred: " + xhr.responseText);
                }
            });
        });
    });
</script>

@endsection