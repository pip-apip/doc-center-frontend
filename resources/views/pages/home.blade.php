@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
<style>
    .suggestions {
        list-style: none;
        padding: 0;
        margin: 0;
        position: absolute;
        background: white;
        border: 1px solid #ccc;
        width: 85%;
        max-height: 150px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }

    .suggestions li {
        padding: 8px;
        cursor: pointer;
    }

    .suggestions li:hover,
    .suggestions li.selected {
        background: #980003;
        color: white;
    }

    #tagSearch{
        position: sticky;
        overflow-y: auto;
        top: 50px;
        height: auto;
    }

    @media (max-width: 768px) {
        .row {
            display: flex;
            flex-direction: column-reverse;
        }

        #tagSearch {
            position: relative;
        }
    }
</style>


<div class="page-title mb-2">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Dashboard</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="#">Dashboard</a></li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="row">
    <div class="col-12 col-lg-9">
        <div class="row">
            <div class="col-6 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon purple">
                                    <i class="fa fa-user-shield"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Total Aktivitas</h6>
                                <h6 class="font-extrabold mb-0">112.000</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon blue">
                                    <i class="fa fa-user-clock"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Aktivitas Perbulan</h6>
                                <h6 class="font-extrabold mb-0">183.000</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon green">
                                    <i class="fa fa-user-check"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Sedang Bertugas</h6>
                                <h6 class="font-extrabold mb-0">80.000</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon red">
                                    <i class="fa fa-user-times"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Menunggu Tugas</h6>
                                <h6 class="font-extrabold mb-0">112</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Grafik Aktivitas Bulan Ini</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-profile-visit"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-3">
        <div class="card">
            <div class="card-body py-4 px-3">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-lg">
                        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="PM - HMA" />
                    </div>
                    <div class="ms-3 name">
                        <h5 class="font-bold">{{ session('user.username') }}</h5>
                        <h6 class="text-muted mb-0">{{ session('user.name') }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4>Aktivitas Terkini</h4>
            </div>
            <div class="card-content pb-4">
                <div class="recent-message d-flex px-0 py-1">
                    <div class="name ms-4">
                        <h5 class="mb-1">Hank Schrader</h5>
                        <p class="text-muted mb-0">Lorem Ipsum is not simply random text</p>
                    </div>
                </div>
                <div class="recent-message d-flex px-0 py-2">
                    <div class="name ms-4">
                        <h5 class="mb-1">Dean Winchester</h5>
                        <p class="text-muted mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                    </div>
                </div>
                <div class="recent-message d-flex px-1 py-2">
                    <div class="name ms-4">
                        <h5 class="mb-1">Morbi Leo</h5>
                        <p class="text-muted mb-0">It is a long established fact that a reader will be distracted by the </p>
                    </div>
                </div>
                <div class="px-4">
                    <button class='btn btn-block btn-xl btn-light-primary font-bold mt-3'>
                        Selengkapnya
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade text-left w-100" id="readModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33" id="modalTitle"></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6">
                    <label><b> Nama Aktivitas : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="activity_name"></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <label><b> Judul Dokumen : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="doc_title"></p>
                    </div>
                </div>
                <div class="col-md-12">
                    <label><b>Deskripsi : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="description"></p>
                    </div>
                </div>
                <div class="col-md-8">
                    <label><b> Tag : </b></label>
                    <div class="form-group" id="tags">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="fullPageLoader" class="full-page-loader" style="display: none">
    <div class="spinner-border text-light" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="{{ asset('assets/vendors/apexcharts/apexcharts.js') }}"></script>
<script>
    var optionsProfileVisit = {
        annotations: {
            position: 'back'
        },
        dataLabels: {
            enabled:false
        },
        chart: {
            type: 'bar',
            height: 400
        },
        fill: {
            opacity:1
        },
        plotOptions: {
        },
        series: [{
            name: 'total',
            data: [
                9,20,30,20,10,20,30,20,10,20,
                19,210,130,120,140,210,130,210,110,120,
                99,10,30,100,40,80,30,50,110,220,120,
            ]
        }],
        colors: '#435ebe',
        xaxis: {
            categories: [
                "01","02","03","04","05","06","07","08","09","10",
                "11","12","13","14","15","16","17","18","19","20",
                "21","22","23","24","25","26","27","28","29","30","31",
            ]
        },
    }

    var chartProfileVisit = new ApexCharts(document.querySelector("#chart-profile-visit"), optionsProfileVisit);
    chartProfileVisit.render();
</script>
@endsection
