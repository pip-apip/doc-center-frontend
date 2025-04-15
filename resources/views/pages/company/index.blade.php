@extends('layouts.app')

@section('title', 'Company Page')

@section('content')

<style>
    /* Universal Modal Styling */
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

    /* Modal Content - Desktop */
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

    /* Image */
    #imageViewer {
        max-width: 100%;
        max-height: 75vh;
        border-radius: 8px;
        object-fit: contain;
    }

    /* Close Button */
    .closeImage {
        position: fixed;
        top: 20px;
        right: 20px;
        font-size: 28px;
        color: white;
        cursor: pointer;
        z-index: 10000; /* Ensure it's above all elements */
        transition: transform 0.2s;
    }

    .closeImage:hover {
        transform: scale(1.2);
    }

    /* 🔥 Responsive for Mobile */
    @media screen and (max-width: 768px) {
        .modern-modal-content {
            width: 95%;
            max-height: 70vh;
            padding: 10px;
        }

        #imageViewer {
            min-height: 50vh;
        }

        .closeImage {
            font-size: 24px;
            top: 10px;
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
            {{-- <h3>Data Company</h3> --}}
            {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Perusahaan</li>
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
                    <h1>Perusahaan</h1>
                </div>
                <div class="col-sm-4 d-flex justify-content-end align-items-center">
                    <a href="{{ route('company.create') }}" class="btn btn-success">
                        <i class="fa-solid fa-plus"></i> Simpan
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th width="100">No</th>
                        <th>Nama Perusahaan</th>
                        <th>Alamat Perusahaan</th>
                        <th>Nama Direktur</th>
                        {{-- <th>Director Phone</th> --}}
                        {{-- <th>Director Signature</th> --}}
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($companies as $company)
                    @php
                        $director_signature = $company['director_signature'] ?
                        '<button class="btn btn-sm btn-info" onclick="openModernModal(\'' . $API_url . $company['director_signature'] . '\')"><i class="fa-solid fa-eye"></i> Preview Signature</button>' : "Don't have Signature Director";
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $company['name'] }}</td>
                        <td>{{ $company['address'] }}</td>
                        <td>{{ $company['director_name'] }}</td>
                        {{-- <td>{{ $company['director_phone'] }}</td> --}}
                        {{-- <td>{!! $director_signature !!}</td> --}}
                        <td>
                            <a href="{{ route('company.edit', $company['id']) }}" class="btn btn-sm btn-warning rounded-pill">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger rounded-pill" onclick="confirmDelete('{{ route('company.destroy', $company['id']) }}')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
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

        new simpleDatatables.DataTable(table, {
            perPage: 5, // 👈 Default entries per page
            perPageSelect: [5, 10, 25, 50] // 👈 Optional: customize dropdown options
        });
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

    function openModernModal(imageSrc) {
        document.getElementById('modernImagePreview').src = imageSrc;
        document.getElementById('modernImageModal').style.display = "flex";
    }

    function closeModernModal() {
        document.getElementById('modernImageModal').style.display = "none";
    }
</script>

@endsection
