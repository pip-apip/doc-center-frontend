@extends('layouts.app')

@section('title', 'Project Page')

@section('content')

<style>
    /* Modern Modal Styles */
    .modern-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.3s ease-in-out;
        padding: 15px;
    }

    .modern-modal-content {
        position: relative;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 15px;
        width: 90%;
        max-width: 800px;
        max-height: 85vh;
        text-align: center;
        animation: fadeIn 0.3s ease-in-out;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        justify-content: center;
        overflow: hidden;
    }

    /* PDF Viewer */
    #pdfViewer {
        width: 100%;
        height: 75vh;
        border-radius: 8px;
    }

    /* Close Button */
    .closePDF {
        position: fixed;
        top: 20px;
        right: 20px;
        font-size: 28px;
        color: white;
        cursor: pointer;
        z-index: 10000; /* Ensure it's above all elements */
        transition: transform 0.2s;
    }

    .closePDF:hover {
        transform: scale(1.2);
    }

    /* File Upload Wrapper */
    .file-upload-wrapper {
        background-color: #f4f3f2;
        padding: 16px;
        border-radius: 12px;
        text-align: center;
        width: 100%;
        font-size: 16px;
        position: relative;
        color: #fff;
        cursor: pointer;
        border: none;
    }

    .file-upload-area {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 10px;
        background-color: #5f5b59;
        border-radius: 12px;
        position: relative;
        color: white;
        cursor: pointer;
    }

    .file-upload-wrapper input[type="file"] {
        display: none;
    }

    .upload-text {
        font-size: 14px;
        color: #fff;
    }

    .browse {
        text-decoration: underline;
        font-weight: 500;
        color: #fff;
    }

    .file-preview {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #5f5b59;
        padding: 8px 12px;
        border-radius: 10px;
        color: white;
        width: 100%;
        margin-top: 10px;
        font-size: 14px;
    }

    .file-info {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 90%;
    }

    .remove-file {
        background-color: #333;
        color: white;
        border-radius: 50%;
        padding: 2px 8px;
        margin-left: 8px;
        font-weight: bold;
        cursor: pointer;
    }

    .file-upload-area.is-invalid {
        border: 2px dashed #e74c3c;
        background-color: #7b4a4a;
        color: #ffecec;
    }

    .file-upload-area.is-invalid .upload-text,
    .file-upload-area.is-invalid .browse {
        color: #ffecec;
    }

    .file-preview.is-invalid {
        border: 2px solid #e74c3c;
        background-color: #7b4a4a;
    }


    /* 🔥 Responsive for Mobile */
    @media screen and (max-width: 768px) {
        .modern-modal-content {
            width: 95%;
            max-height: 70vh;
            padding: 10px;
        }

        #pdfViewer{
            min-height: 50vh;
        }

        .closePDF {
            font-size: 24px;
            top: 5px;
            right: 10px;
        }
    }

    /* Fade-in Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
</style>

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            {{-- <h3>Activity Detail</h3> --}}
            {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Projek</li>
                    <li class="breadcrumb-item active" aria-current="page">Dokumen</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

@php
    $project = $data['project'];
    $doc = $data['docProject'];
    $categoryDoc = $data['categoryDoc'];
@endphp

{{-- <section class="section">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-8">
                    <h1>Detail Project</h1>
                </div>
            </div>
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
                        <p class="form-control-static" id="start_project_detail">
                            {{ \Carbon\Carbon::parse($project['start_date'])->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </div>

                <div class="col-sm-4">
                    <label><b> End Project : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="end_project_detail">
                            {{ \Carbon\Carbon::parse($project['end_date'])->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section> --}}

<section class="section">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10 col-10">
                    <h1>Form Dokumen <span class="d-none d-md-inline-block">Administrasi Projek</span></h1>
                </div>
                <div class="col-sm-2 col-2 d-flex justify-content-end align-items-center">
                    <a href="{{ route('project.index') }}"><i class="fa-solid fa-angle-left"></i> <span class="d-none d-md-inline-block">Kembali</span></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('project.store.doc') }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
                @csrf
                {{-- <input type="text" style="display: none"> --}}
                <div class="modal-body">
                    <label><b> Nama Projek : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="project_name_doc">{{ $project['name'] }}</p>
                    </div>
                    <input type="text" name="project_id" id="project_id" value="{{ $project['id'] }}" style="display: none">
                    <hr>
                    <label><b> Judul Dokumen : </b></label>
                    <div class="form-group">
                        <input type="text" placeholder="Masukkan Judul Dokumen Administrasi" class="form-control @error('title') is-invalid @enderror" name="title" id="title">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><b> Kategori Dokumen : </b></label>
                            <fieldset class="form-group">
                                <select class="form-select @error('admin_doc_category_id') is-invalid @enderror" id="category_input" name="admin_doc_category_id">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categoryDoc as $cat)
                                    <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('admin_doc_category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </fieldset>
                        </div>
                        <div class="col-sm-6">
                            <div class="file-upload-wrapper" id="dropzone">
                                <label for="file-upload" class="file-upload-area @error('file') is-invalid @enderror">
                                    <div class="upload-text" id="upload-text">
                                        Drag & Drop your files or <span class="browse">Browse</span>
                                    </div>
                                    <input type="file" id="file-upload" name="file" />
                                    <div class="file-preview" id="file-preview" style="display: none;">
                                        <span class="file-info" id="file-name"></span>
                                        <span class="remove-file" id="remove-file">&times;</span>
                                    </div>
                                </label>
                            </div>

                            @error('file')
                            <small class="file-error-text" style="color: #e74c3c;" id="file-error">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>
                        <div class="col-sm-2 d-md-flex justify-content-md-center align-items-md-center mt-2 mt-md-0">
                            <button class="btn btn-success" type="submit" style="margin: 0 auto"><i class="fa-solid fa-plus"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="section">
    <div class="card">
        <div class="card-header text-right">
            <h1>Dokumen Administrasi Projek</h1>
        </div>
        <div class="card-body">
            <label><b> Kategori Dokumen : </b></label>
            <fieldset class="form-group">
                <select class="form-select" id="category_show">
                    <option value="#">Pilih Kategori Dokumen</option>
                    @foreach ($categoryDoc as $cat)
                    <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                    @endforeach
                </select>
            </fieldset>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped mb-0" id="table">
                    <thead>
                        <tr>
                            {{-- <th>No</th> --}}
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        {{-- <tr>
                            <td class="text-bold-500">Michael Right</td>
                            <td>$15/hr</td>
                            <td class="text-bold-500">UI/UX</td>
                            <td>Remote</td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
            {{-- <div class="row mb-2" id="data_doc">

            </div> --}}
        </div>
    </div>
</section>

<div id="modernPDFModal" class="modern-modal" style="display: none">
    <div class="modern-modal-content">
        <span class="closePDF" onclick="closePDFModal()">&times;</span>
        <iframe id="pdfViewer" frameborder="0"></iframe>
    </div>
</div>

<script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
<!-- filepond -->
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
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
    let data_doc = {!! json_encode($doc) !!};

    $(document).ready(function () {
        console.log(data_doc);
        showDataDoc(data_doc);
    });

    function showDataDoc(data) {
        $('#table_body').empty();
        let url = "https://bepm.hanatekindo.com";
        let rows = "";
        if (data.length == 0) {
            rows += `
                <tr>
                    <td colspan="4" class="text-center">Tidak Ada Dokumen</td>
                </tr>`;
        }else{
            $.each(data, function (index, doc) {
                let deleteUrl = `{{ route('project.destroy.doc', ':id') }}`.replace(':id', doc['id']);
                rows += `
                    <tr>`;
                        // <td>${index + 1}</td>
                    rows += `<td>${doc['title']}</td>
                        <td>${doc['admin_doc_category_name']}</td>
                        <td><a onclick="openPDFModal('${url}${ doc.file }')" style="text-decoration: none; color: grey"><i class="fa-solid fa-file-pdf"></i></a></td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-danger ml-1 btn-sm" onclick="confirmDelete('${deleteUrl}')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>`;
            });
        }
        $("#table_body").html(rows);
    }

    // $('#category_show').change(function(){
    //     console.log(data_doc);
    //     let id_category = $(this).val();
    //     let url = "https://bepm.hanatekindo.com";

    //     let filteredDoc = data_doc.filter(doc =>
    //         doc.admin_doc_category.id == id_category
    //     );
    //     console.log("Filtered Doc:", filteredDoc);
    //     $('#data_doc').empty();
    //     $('#data_doc').html(`<hr>
    //         <div class="col-sm-3"></div>
    //         <div class="col-sm-6">
    //             <table id="table_doc">
    //             </table>
    //         </div>
    //         <div class="col-sm-3"></div>
    //             `);
    //     $("#table_doc").empty();
    //     if(filteredDoc.length > 0){
    //         let rows2 = "";
    //         $.each(filteredDoc, function (index, doc) {
    //             rows2 += `
    //             <tr class="mt-2">
    //                 <td><a onclick="openPDFModal('${url}${ doc.file }')" style="text-decoration: none; color: grey"><i class="fa-solid fa-file-pdf"></i></a></td>
    //                 <td width="400px">${doc.title}</td>
    //                 <td>
    //                     <a href="/project/destroyDoc/${doc.id}" class="btn btn-danger ml-1 btn-sm" onclick="return confirmDelete(this, '{{ csrf_token() }}')">
    //                         <i class="bx bx-check d-block d-sm-none"></i>
    //                         <span class="d-none d-sm-block"><i class="fa-solid fa-trash"></i></span>
    //                     </a>
    //                 </td>
    //             </tr>`;
    //         });

    //         $("#table_doc").html(rows2);
    //     }else{
    //         let rows2 = "";
    //             rows2 += `
    //             <tr class="mt-2" style="text-align: center;">
    //                 <td style="padding: 0 auto"><b>no files have been uploaded yet</b></td>
    //             </tr>`;

    //         $("#table_doc").html(rows2);
    //     }
    // });

    $('#category_show').change(function(){
        let id_category = $(this).val();
        if (id_category == "#") {
            showDataDoc(data_doc);
            return;
        }
        let filteredDoc = data_doc.filter(doc =>
            doc.admin_doc_category_id == id_category
        );
        showDataDoc(filteredDoc);
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

{{-- Modern Modal --}}
<script>
    function openPDFModal(pdfUrl) {
        document.getElementById('pdfViewer').src = pdfUrl;
        document.getElementById('modernPDFModal').style.display = "flex";
    }

    function closePDFModal() {
        document.getElementById('modernPDFModal').style.display = "none";
        document.getElementById('pdfViewer').src = "";
    }
</script>

{{-- File Upload Script --}}
<script>
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('file-upload');
    const fileName = document.getElementById('file-name');
    const uploadText = document.getElementById('upload-text');
    const filePreview = document.getElementById('file-preview');
    const removeFileBtn = document.getElementById('remove-file');

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
        fileInput.files = files;
        handleFile(files);
    });

    fileInput.addEventListener('change', function() {
        handleFile(fileInput.files);
    });

    removeFileBtn.addEventListener('click', function () {
        fileInput.value = '';
        fileName.textContent = '';
        filePreview.style.display = 'none';
        uploadText.style.display = 'block';
    });

    function handleFile(files) {
        if (files.length > 0) {
            const file = files[0];
            const sizeMB = (file.size / (1024 * 1024)).toFixed(1);
            fileName.textContent = `${file.name} (${sizeMB} MB)`;
            filePreview.style.display = 'flex';
            uploadText.style.display = 'none';
        }
    }
</script>


</script>

@endsection
