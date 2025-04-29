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

<div class="page-heading">
    <!-- <div class="page-title">
        <div class="row">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
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
                    </div>
                </div>

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
                    <div class="card-body py-4 px-5">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg">
                                <img src="{{ asset('assets/images/logo/logo.png') }}" alt="PM - HMA" />
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold">9 Paket</h5>
                            </div>
                        </div>
                    </div>
                </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


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
