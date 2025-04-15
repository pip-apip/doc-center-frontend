@extends('layouts.app')

@section('title', 'Project Page')

@section('content')

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            {{-- <h3>Data Activity</h3> --}}
            {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Activity</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section">
    <div class="card">
        <div class="card-header text-right">
            <div class="row">
                <div class="col-sm-8">
                    <h1>Activity</h1>
                </div>
                <div class="col-sm-4 d-flex justify-content-end align-items-center">
                    <a href="{{ route('activity.create') }}" class="btn btn-success">
                        <i class="fa-solid fa-plus"></i> Add
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Activity Title</th>
                        <th>Project</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                @php
                    $no = 1;
                @endphp
                <tbody id="table_body">
                    @foreach ($activities['data'] as $act)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $act['title'] }}</td>
                        <td>{{ $act['project']['name'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($act['start_date'])->translatedFormat('d F Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($act['end_date'])->translatedFormat('d F Y') }}</td>
                        <td>
                            {{-- <span class="badge {{ $project['status'] ? 'bg-success' : 'bg-danger'}}"> --}}
                            <span class="badge bg-danger">
                                {{-- {{$project['status']}} --}}
                                Undefined
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('activity.edit', $act['id']) }}" class="btn btn-sm btn-warning rounded-pill">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger rounded-pill" onclick="confirmDelete('{{ route('activity.destroy', $act['id']) }}')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <a href="{{ route('activity.doc', $act['id']) }}" class="btn btn-sm btn-info rounded-pill">
                                <i class="fa-solid fa-file"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

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
    let data = {!! json_encode($activities) !!}
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

@endsection