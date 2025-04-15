@extends('layouts.app')

@section('title', 'Activity Page')

@section('content')

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Data Activity</h3>
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
            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formModal"><i
                    class="fa-solid fa-plus"></i> Add</a>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Activity Title</th>
                        <th>Project</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Alpha Build</td>
                        <td>alpha@construction.com</td>
                        <td>John Doe</td>
                        <td>10-01-2023</td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>
                            <div class="btn-group mb-1">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        :
                                    </button>
                                    <div class="dropdown-menu" style="margin: 0px;">
                                        <a class="dropdown-item" href="#">Edit</a>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-info rounded-pill modalll" data-bs-toggle="modal"
                            data-bs-target="#formDocModal"><i class="fa-solid fa-file"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Skyline Towers</td>
                        <td>skyline@realty.com</td>
                        <td>Jane Smith</td>
                        <td>15-02-2023</td>
                        <td><span class="badge bg-danger">Inactive</span></td>
                        <td>
                            <div class="btn-group mb-1">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        :
                                    </button>
                                    <div class="dropdown-menu" style="margin: 0px;">
                                        <a class="dropdown-item" href="#">Edit</a>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-info rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#docModal"><i class="fa-solid fa-file"></i></a>
                        </td>
                    </tr>
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
                <h4 class="modal-title" id="myModalLabel33">Form Add Activity</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="#">
                <div class="modal-body">

                    <label>Project Name : </label>
                    <fieldset class="form-group">
                        <select class="form-select" id="basicSelect">
                            <option value="">Select Project Name</option>
                        </select>
                    </fieldset>

                    <label>Activity Title: </label>
                    <div class="form-group">
                        <input type="text" placeholder="Enter the Company Name" class="form-control">
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label>Start Project: </label>
                            <div class="form-group">
                                <input type="date" class="form-control">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label>End Project: </label>
                            <div class="form-group">
                                <input type="date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="tag-container">
                        <input type="text" id="tagInput" placeholder="Ketik dan tekan spasi..." />
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary ml-1" data-bs-dismiss="modal" onclick="save()">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><i class="fa-solid fa-floppy-disk"></i> Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade text-left w-100" id="formDocModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Form Document Activity</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="#">
                <div class="modal-body">

                    <label><b> Activity Name : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="activity_name">Alpha Build</p>
                    </div>
                    <hr>
                    <label>Title: </label>
                    <div class="form-group">
                        <input type="text" placeholder="Enter the Title" class="form-control">
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label>Document Category: </label>
                            <fieldset class="form-group">
                                <select class="form-select" id="documentCat">
                                    <option>Select Category</option>
                                    <option value="MOM">MOM</option>
                                    <option value="Picture">Foto</option>
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-sm-6" id="typeMOM" style="display: none">
                            <label>Type : </label>
                            <fieldset class="form-group">
                                <select class="form-select" id="typeMOM_input">
                                    <option>Select Type</option>
                                    <option value="Text">Text</option>
                                    <option value="File">File</option>
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-sm-6" id="uploadPict" style="display: none">
                            <input type="file" class="basic-filepond-activity1">
                        </div>

                        <div class="col-sm-12" id="textMOM" style="display: none">
                            <label>Text MOM: </label>
                            <div class="form-group">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Enter the Company Address"
                                        id="floatingTextarea"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12" id="fileMOM" style="display: none">
                            <label>File Upload : </label>
                            <input type="file" class="basic-filepond-activity2">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><i class="fa-solid fa-floppy-disk"></i> Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade text-left w-100" id="docModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Document Activity</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="#">
                <div class="modal-body">

                    <label><b> Activity Name : </b></label>
                    <div class="form-group">
                        <p class="form-control-static" id="activity_name">Alpha Build</p>
                    </div>
                    <hr>
                    <label>Title: </label>
                    <div class="form-group">
                        <input type="text" placeholder="Enter the Title" class="form-control">
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label>Document Category: </label>
                            <fieldset class="form-group">
                                <select class="form-select" id="documentCat">
                                    <option>Select Category</option>
                                    <option value="MOM">MOM</option>
                                    <option value="Picture">Foto</option>
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-sm-6" id="typeMOM" style="display: none">
                            <label>Type : </label>
                            <fieldset class="form-group">
                                <select class="form-select" id="typeMOM_input">
                                    <option>Select Type</option>
                                    <option value="Text">Text</option>
                                    <option value="File">File</option>
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-sm-6" id="uploadPict" style="display: none">
                            <input type="file" class="basic-filepond-activity1">
                        </div>

                        <div class="col-sm-12" id="textMOM" style="display: none">
                            <label>Text MOM: </label>
                            <div class="form-group">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Enter the Company Address"
                                        id="floatingTextarea"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12" id="fileMOM" style="display: none">
                            <label>File Upload : </label>
                            <input type="file" class="basic-filepond-activity2">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-warning ml-1" data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><i class="fa-solid fa-pen"></i> Edit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>

<script>
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
    $('.modalll').click(function(){
        $("#typeMOM, #uploadPict, #textMOM, #fileMOM, #taskDiv").hide();

        $("#typeMOM_input, #documentCat").selectedValue(0);
    })

    $("#documentCat").change(function(){
        var selectedValue = $(this).val();

        if(selectedValue === "MOM"){
            $("#typeMOM").show();
            $("#uploadPict").hide();
        } else if(selectedValue === "Picture"){
            $("#uploadPict").show();
            $("#typeMOM").hide();
        }
    });

    $("#typeMOM_input").change(function(){
        var selectedValue = $(this).val();

        if(selectedValue === "Text"){
            $("#textMOM").show();
            $("#fileMOM").hide();
        } else if(selectedValue === "File"){
            $("#fileMOM").show();
            $("#textMOM").hide();
        }
    });
});

let tags = [];
$(document).ready(function() {

    $("#tagInput").on("keyup", function(event) {
        if (event.key === " " && this.value.trim() !== "") {
            let tagText = this.value.trim();

            if (!tags.includes(tagText)) {
                tags.push(tagText);
                $(".tag-container").append(`
                    <span class="tag">${tagText} <span class="remove">&times;</span></span>
                `);
            }

            this.value = "";
        }
    });

    $(document).on("click", ".remove", function() {
        let tagText = $(this).parent().text().trim();
        tags = tags.filter(tag => tag !== tagText.replace("×", "").trim());
        $(this).parent().remove();
    });
});

function save() {
    console.log(tags);
}

</script>
@endsection
