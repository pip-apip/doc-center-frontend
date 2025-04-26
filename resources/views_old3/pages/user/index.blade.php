@extends('layouts.app')

@section('title', 'User Page')

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
                    <li class="breadcrumb-item active" aria-current="page">User</li>
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
                    <h1>User</h1>
                </div>
                <div class="col-sm-4 d-flex justify-content-end align-items-center">
                    <a href="{{ route('user.create') }}" class="btn btn-success">
                        <i class="fa-solid fa-plus"></i> Tambah
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('user.index') }}" id="pagination-form" class="mb-4">
                <fieldset class="form-group" style="width: 70px">
                    <select class="form-select" id="entire-page" name="per_page" onchange="document.getElementById('pagination-form').submit();">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                    </select>
                </fieldset>
            </form>
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th width="100">No</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                @php
                    $no = is_object($results) && method_exists($results, 'firstItem') ? $results->firstItem() : 0;
                @endphp
            <tbody id="table_body">
            @if(is_object($results) && method_exists($results, 'firstItem'))
                @foreach ($results as $user)
                    @php
                        $status = '<span class="badge ' . (isset($user['token']) && $user['token'] ? 'bg-success' : 'bg-danger') . '">'
                                . (isset($user['token']) && $user['token'] ? 'Online' : 'Offline') . '</span>';
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['role'] }}</td>
                        <td>{!! $status !!}</td>

                        <td>
                            <a href="{{ route('user.edit', $user['id']) }}" class="btn btn-sm btn-warning rounded-pill">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger rounded-pill" onclick="confirmDelete('{{ route('user.destroy', $user['id']) }}')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                @else
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            @if (is_object($results) && method_exists($results, 'onEachSide'))
                                <td colspan="7"><span style="margin-top: 15px;">{{ $results->appends(request()->query())->links() }}</span></td>
                            @endif
                        </tr>
                    </tfoot>
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

    function openModernModal(imageSrc) {
        document.getElementById('modernImagePreview').src = imageSrc;   
        document.getElementById('modernImageModal').style.display = "flex";
    }

    function closeModernModal() {
        document.getElementById('modernImageModal').style.display = "none";
    }
</script>

@endsection