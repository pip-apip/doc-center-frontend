@extends('layouts.app')

@section('title', 'Project Page')

@section('content')

@php
    $lastRoute = session()->get('lastRoute');
    $lastRoute = $lastRoute ? explode(',', $lastRoute) : [];
@endphp

<div class="page-heading">
    <div class="page-content">
        <section id="basic-horizontal-layouts">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-8 col-8">
                            <h1>{{ $status === 'create' ? 'Tambah' : 'Edit' }} <span class="d-none d-md-inline-block">Aktivitas</span></h1>
                        </div>
                        <div class="col-sm-4 col-4 d-flex justify-content-end align-items-center">
                            <a href="{{ isset($lastRoute[0], $lastRoute[1]) ? route($lastRoute[0], $lastRoute[1]) : '#' }}" class="btn btn-secondary btn-sm">
                                <i class="fa-solid fa-angle-left"></i> <span class="d-none d-md-inline-block">Kembali</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($status === 'create')
                        <form action="{{ route('activity.store') }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
                    @elseif ($status === 'edit')
                        <form action="{{ route('activity.update', $activity['id']) }}" method="POST" class="form form-vertical" enctype="multipart/form-data">
                    @endif
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <label>Nama Proyek <code>*</code></label>
                            </div>
                            <fieldset class="form-group col-md-10">
                                @if ($countDocAct > 0)
                                    <input type="text" name="project_id" id="project_id" value="{{ $activity['project_id'] }}" hidden>
                                @endif
                                <select class="form-select @error('project_id') is-invalid @enderror" id="project_id" name="project_id" {{ $countDocAct > 0 ? 'disabled' : '' }}>
                                    <option value="">Pilih Proyek</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project['id'] }}" {{ old('project_id', $projectId ?? $activity['project_id'] ?? '') == $project['id'] ? 'selected' : '' }}>
                                            {{ $project['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </fieldset>
                            {{-- @if ($countDocAct > 0)
                                <input type="text" name="project_id" id="project_id" value="{{ $activity['project']['id'] }}" hidden>
                            @endif --}}
                            <div class="col-md-2">
                                <label>Kategori Aktivitas <code>*</code></label>
                            </div>
                            <fieldset class="form-group col-md-10">
                                <select class="form-select" id="activity_category_id" name="activity_category_id">
                                    <option value="#">Pilih Kategori</option>
                                    @foreach ($categoryAct as $cat)
                                    <option value="{{ $cat['id'] }}" {{ old('activity_category_id', $activity ? $activity['activity_category_id'] : '') == $cat['id'] ? 'selected' : '' }}>
                                        {{ $cat['name'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </fieldset>
                            <div class="col-md-2">
                                <label>Catatan Aktivitas <code>*</code></label>
                            </div>
                            <div class="form-group col-md-10">
                                <input type="text" placeholder="Masukkan Catatan Aktivitas" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title', $activity ? $activity['title'] : '') }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label>Tanggal Mulai <code>*</code></label>
                            </div>
                            <div class="form-group col-md-10">
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="start_date" value="{{ old('start_date', $activity ? $activity['start_date'] : '') }}">
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label>Tanggal Selesai <code>*</code></label>
                            </div>
                            <div class="form-group col-md-10">
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" id="end_date" value="{{ old('end_date', $activity ? $activity['end_date'] : '') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-12 offset-sm-2 d-flex justify-content-start mt-3">
                                <button type="submit"
                                    class="btn btn-primary me-1 mb-1">Simpan</button>
                                <button type="reset"
                                    class="btn btn-light-secondary me-1 mb-1">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

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
    document.addEventListener("DOMContentLoaded", function () {
        console.log(JSON.stringify(@json(session('lastRoute')), null, 2));
    });
</script>



@endsection