@extends('layouts.app')

@section('title', 'Project Page')

@section('content')
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Data Project</h3>
            {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Project</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<section class="section">
    <div class="card">
        <div class="card-header">
            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formModal"
                id="addButton">
                <i class="fa-solid fa-plus"></i> Add</a>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Project Name</th>
                        <th>Company Name</th>
                        <th>Director Name</th>
                        <th>Start Project</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="table-body">

                </tbody>

            </table>
        </div>
    </div>

</section>

<div class="modal fade text-left w-100" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33" id="formTitle">Form Add Project</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="closeFormModal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="#" id="post-form">
                @csrf
                <div class="modal-body">

                    <label>Project Name : </label>
                    <div class="form-group">
                        <input type="text" placeholder="Enter the Project Name" class="form-control"
                            name="project_name">
                    </div>

                    <div class="row">

                        <div class="col-sm-6">
                            <label>Company Name: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Enter the Company Name" class="form-control"
                                    name="company_name">
                            </div>

                            <label>Company Address: </label>
                            <div class="form-group">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Enter the Company Address"
                                        id="floatingTextarea" name="company_address"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Director Name: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Enter the Director Name" class="form-control"
                                    name="director_name">
                            </div>

                            <label>Director Phone: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Enter the Director Phone" class="form-control"
                                    name="director_phone">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>Start Project: </label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="start_date">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>End Project: </label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="end_date">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary ml-1" type="submit">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><i class="fa-solid fa-floppy-disk"></i> Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade text-left w-100" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Detail Project</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div>
                <div class="modal-body">

                    <label><b> Project Name : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="project_name_detail">Alpha Build</p>
                    </div>

                    <div class="row">

                        <div class="col-sm-8">
                            <label><b> Company Name : </b></label>
                            <div class="form-group">
                                <p class="form-control-static" id="company_name_detail">Alpha Build</p>
                            </div>

                            <label><b> Company Address : </b></label>
                            <div class="form-group">
                                <div class="form-floating">
                                    <p class="form-control-static" id="company_address_detail">Lorem ipsum dolor sit amet
                                        consectetur adipisicing elit. Velit maxime aut ipsam explicabo, cum consequuntur
                                        numquam dolorem harum asperiores omnis? Repellendus quasi harum consequuntur
                                        eveniet saepe voluptates quos placeat odit.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label><b> Director Name : </b></label>
                            <div class="form-group">
                                <p class="form-control-static" id="director_name_detail">John Doe</p>
                            </div>

                            <label><b> Director Phone : </b></label>
                            <div class="form-group">
                                <p class="form-control-static" id="director_phone_detail">089213182731</p>
                            </div>
                        </div>

                        <hr>

                        <div class="col-sm-8">
                            <label><b> Start Project : </b></label>
                            <div class="form-group">
                                <p class="form-control-static" id="start_project_detail">10-01-2023</p>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label><b> End Project : </b></label>
                            <div class="form-group">
                                <p class="form-control-static" id="end_project_detail">10-05-2023</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-warning ml-1" data-bs-dismiss="modal" id="editButton">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><i class="fa-solid fa-pen"></i> Edit</span>
                    </button>
                    <button type="button" class="btn btn-danger ml-1" data-bs-dismiss="modal" onclick="deleteProject()">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><i class="fa-solid fa-trash"></i> Delete</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left w-100" id="docModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Document Administration</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="#" id="docForm">
                @csrf
                {{-- <input type="text" style="display: none"> --}}
                <div class="modal-body">
                    <label><b> Project Name : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="project_name_doc"></p>
                    </div>
                    <hr>
                    <label><b> Title : </b></label>
                    <div class="form-group">
                        <input type="text" placeholder="Enter the Title Document" class="form-control" name="title">
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label><b> Category : </b></label>
                            <fieldset class="form-group">
                                <select class="form-select" id="category_input" name="admin_doc_category_id">
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-sm-6">
                            <input type="file" class="basic-filepond" name="file" required multiple data-max-file-size="2MB">
                        </div>
                        <div class="col-sm-2">
                            <a href="#" class="btn btn-success" onclick="storeDoc()" style="margin: 0 auto">
                                <i class="fa-solid fa-plus"></i> Add
                            </a>
                        </div>
                    </div>
                    <hr>
                    <label><b> Category : </b></label>
                    <fieldset class="form-group">
                        <select class="form-select" id="category_show">
                        </select>
                    </fieldset>
                    <div class="row mb-2">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <table id="table_doc">
                                {{-- <tr>
                                    <td><a href="" style="text-decoration: none; color: grey"><i class="fa-solid fa-file-pdf"></i></a></td>
                                    <td width="400px">File.pdf</td>
                                    <td>
                                        <button type="button" class="btn btn-warning ml-1 btn-sm">
                                            <i class="bx bx-check d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block"><i class="fa-solid fa-pen"></i></span>
                                        </button>
                                        <button type="button" class="btn btn-danger ml-1 btn-sm">
                                            <i class="bx bx-check d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block"><i class="fa-solid fa-trash"></i></span>
                                        </button>
                                    </td>
                                </tr> --}}
                            </table>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>
                </div>

                {{-- <div class="modal-footer">
                <button type="button" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Accept</span>
                </button>
            </div> --}}
            </form>
        </div>
    </div>
</div>

@include('ajax.projectAjax')

@endsection
