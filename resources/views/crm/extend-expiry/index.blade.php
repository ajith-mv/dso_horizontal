@extends('layouts.app')
@section('content')
        
    <div class="d-flex align-items-center mb-3">
        <div class="col-5 p-1 border rounded-pill shadow-sm bg-white">
            <div class="input-group align-items-center" title="Scan Barcode">
                <i class="bi bi-upc-scan font-20 mx-2"></i>
                <input type="text" class="form-control form-control-lg border-0 bg-light ms-1 rounded-pill" placeholder="Click here to scan">
            </div> 
        </div>
    </div>
   
    <div class="table-fillters row m-0 p-2">
        <div class="col-12 mb-2 text-end">
            <button  data-bs-toggle="modal" data-bs-target="#advance-search-modal"  class="rounded-pill btn btn-sm btn-light shadow-sm border"><i class="bi bi-funnel-fill me-1"></i></i> Advanced filter</button>
        </div>
        <div class="col">
            <label for="" class="form-label">Material/Product description</label>
            <input type="text" class="form-control custom" placeholder="Type here...">
        </div> 
        <div class="col">
            <label for="" class="form-label">Brand</label>
            <input type="text" class="form-control custom" placeholder="Type here...">
        </div> 
        <div class="col">
            <label for="" class="form-label">Owner 1/2</label>
            <select name="" id="" class="form-select custom">
                <option value="">-- select --</option>
                <option value="1">Vetri maran</option>
                <option value="2">Alan walker</option>
                <option value="3">Alex</option>
                <option value="4">Hema</option>
            </select>
        </div> 
        <div class="col">
            <label for="" class="form-label">Dept</label>
            <select name="" id="" class="form-select custom">
                <option value="">-- select --</option>
                <option value="1">EGP1</option>
                <option value="2">EGP4</option>
                <option value="3">EGP7</option>
                <option value="4">FSML</option>
                <option value="4">STML</option>
            </select>
        </div> 
        <div class="col">
            <label for="" class="form-label">Storage area</label>
            <select name="" id="" class="form-select custom">
                <option value="">-- select --</option>
                <option value="1">AR</option>
                <option value="2">CW</option>
                <option value="3">MA</option>
                <option value="4">SP</option>
                <option value="4">MR</option>
                <option value="4">Polymer</option>
                <option value="4">ChemShed1</option>
                <option value="4">ChemShed2</option>
            </select>
        </div> 
        <div class="col">
            <label for="" class="form-label">Housing type</label>
            <input type="text" class="form-control custom" placeholder="Type here...">
        </div>
        <div class="col d-flex align-items-center justify-content-center">
            <div class="btn-group">
                <button class="btn btn-sm btn-primary rounded w-100 h-100 me-2"><i class="bi bi-search"></i></i> </button>
                <button class="btn btn-sm btn-light w-100 h-100 rounded"><i class="bi bi-arrow-counterclockwise"></i></button>
            </div>
        </div> 
    </div>
    <div class="table-responsive">
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th class="table-th child-td-lg">Mat/Pdt decription</th>
                    <th class="table-th child-td">Brand</th>
                    <th class="table-th child-td">Batch/Serial#</th>
                    <th class="table-th child-td">Pkt size (L)</th>
                    <th class="table-th child-td">Qty</th>
                    <th class="table-th child-td-lg">Owner1/2</th>
                    <th class="table-th child-td">Storage rm</th>
                    <th class="table-th child-td">Housing type</th>
                    <th class="table-th child-td">DOE</th>
                    <th class="table-th child-td">QC status</th>
                    <th class="table-th child-td">Used for TD/Expt</th>
                    <th class="table-th child-td">Actions</th>
                </tr> 
            </thead>
            @for ($key=0; $key<10; $key++)
            <tr class="table-tr">
                <td colspan="12" class="p-0 border-bottom">
                    <table class="table m-0">
                        <tr>
                            <td class="child-td-lg"><i class="bi bi-caret-right-fill collapsed table-toggle-icon" data-bs-toggle="collapse" href="#row_{{ $key+1 }}" role="button" aria-expanded="false" aria-controls="row_{{ $key+1 }}"></i> Acetone IND</td>
                            <td class="child-td">XOX</td>
                            <td class="child-td"></td>
                            <td class="child-td">1</td>
                            <td class="child-td">20 <i class="text-success dot-sm bi bi-circle-fill"></i></td>
                            <td class="child-td-lg"></td>
                            <td class="child-td"></td>
                            <td class="child-td"></td>
                            <td class="child-td"></td>
                            <td class="child-td"></td>
                            <td class="child-td"></td>
                            <td class="child-td">
                                <div class="dropdown">
                                    <a class="ropdown-toggle text-secondary" href="#" id="topnav-dashboards" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </a> 
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#Extensionmodal"><i class="bi bi-arrow-up-right-square me-1"></i>Extension</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="collapse" id="row_{{ $key+1 }}">
                            <td colspan="12" class="p-0">
                                <table class="table bg-white m-0">
                                    @for ($key2=0; $key2<4; $key2++)
                                        <tr>
                                            <td class="child-td-lg"></td>
                                            <td class="child-td"></td>
                                            <td class="child-td">Batch1/-</td>
                                            <td class="child-td"></td>
                                            <td class="child-td">10</td>
                                            <td class="child-td-lg">Keith/HuiBeng</td>
                                            <td class="child-td">CW</td>
                                            <td class="child-td">FC1</td>
                                            <td class="child-td">
                                                @if ($key2 == 0)
                                                    <small class="d-flex">31/10/2021  <i class="ms-1 text-danger dot-sm bi bi-circle-fill"></i></small>
                                                @endif
                                                @if ($key2 == 1)
                                                    <small class="d-flex">31/10/2021  <i class="ms-1 text-success dot-sm bi bi-circle-fill"></i></small>
                                                @endif 
                                                @if ($key2 == 2)
                                                    <small class="d-flex">31/10/2021  <i class="ms-1 text-danger dot-sm bi bi-circle-fill"></i></small>
                                                @endif
                                                @if ($key2 == 3)
                                                    <small class="d-flex">31/10/2021  <i class="ms-1 text-success dot-sm bi bi-circle-fill"></i></small>
                                                @endif
                                            </td>
                                            <td class="child-td">
                                                @if ($key2 == 0)
                                                    <small class="badge badge-success-lighten rounded-pill">PASS</small>
                                                @endif
                                                @if ($key2 == 1)
                                                    <small class="badge badge-danger-lighten rounded-pill">FALL</small>
                                                @endif 
                                                @if ($key2 == 2)
                                                    <small class="badge badge-success-lighten rounded-pill">PASS</small>
                                                @endif
                                                @if ($key2 == 3)
                                                    <small class="badge badge-danger-lighten rounded-pill">FALL</small>
                                                @endif 
                                            </td>
                                            <td class="child-td">-</td>
                                            <td class="child-td">
                                                <div class="dropdown">
                                                    <a class="ropdown-toggle text-secondary" href="#" id="topnav-dashboards" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </a> 
                                                    <div class="dropdown-menu"> 
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#Extensionmodal" href="#" data-target="#ViewMP"><i class="bi bi-arrow-up-right-square me-1"></i>Extension</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr> 
                                    @endfor
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            @endfor
        </table> 
    </div> 
    <div id="Extensionmodal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog custom-modal-dialog modal-top">
            <div class="modal-content rounded-0 border-bottom shadow">
                <div class="card-header text-center rounded-0 bg-primary text-white">
                    <div>
                        <h4 class="modal-title mb-1" id="topModalLabel">Repack/Outlife batch</h4>
                        <p class="m-0">Please fill in the information below. The field labels marked with * are required input fields.</p>
                    </div>
                    <button type="button" class="btn-close top-0 right-0 m-2 position-absolute" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body ">
                    <div class="row container py-3 col-lg-9 mx-auto">
                        <div class="col-sm-3 mb-2 mb-sm-0 border-end  py-3">
                            <h1 class="h5">Extended QC Results Status :</h1>
                            <div class="nav flex-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <label for="Pass_label" class="nav-link active show form-radio-success" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-pass" role="tab" aria-controls="v-pills-pass" aria-selected="true">
                                    <input type="radio" name="group" class="form-check-input border-success" checked id="Pass_label"> <span class="text-success"> Pass</span>
                                </label>
                                <label for="Fail_label" class="nav-link form-radio-danger " id="v-pills-fail-tab" data-bs-toggle="pill" href="#v-pills-fail" role="tab" aria-controls="v-pills-fail" aria-selected="false">
                                    <input type="radio" name="group"  class="form-check-input border-danger" id="Fail_label"> <span class="text-danger">Fail</span>
                                </label> 
                            </div>
                        </div>                    
                        <div class="col-sm-9">
                            <div class="tab-content  p-3" id="v-pills-tabContent">
                                <div class="tab-pane fade active show" id="v-pills-pass" role="tabpanel" aria-labelledby="v-pills-pass-tab">
                                    <p class="text-muted">
                                        Please fill in the information below for <b class="text-dark">expiry extension</b>. The field labels marked with * are required input fields.
                                    </p>
                                    <div class="row m-0">
                                        <div class="col-12 text-start mb-2 px-1">
                                            <small class="mb-1">Extended QC Documents*</small>
                                            <input type="file" class="form-control" placeholder="Type here">
                                        </div>
                                        <div class="col-12 text-start mb-2 px-1">
                                            <small class="mb-1">Extended Expiry Date *</small>
                                            <input type="date" class="form-control" placeholder="Type here">
                                        </div>
                                        <div class="col-12 text-start mb-2 px-1">
                                            <small class="mb-1">Remark</small>
                                            <input type="text" class="form-control" placeholder="Type here">
                                        </div>
                                        <div class="col-12 text-center mb-2 px-1">
                                            <button class="btn btn-success rounded-pill">Submit & Save disabled</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-fail" role="tabpanel" aria-labelledby="v-pills-fail-tab">
                                    <p class="text-muted">
                                        Please fill in the information below for <b class="text-dark">expiry extension</b>. The field labels marked with * are required input fields.
                                    </p>
                                    <div class="row m-0">
                                        <div class="col-12 text-start mb-2 px-1">
                                            <small class="mb-1">Extended QC Documents*</small>
                                            <input type="file" disabled class="form-control" placeholder="Type here">
                                        </div>
                                        <div class="col-12 text-start mb-2 px-1">
                                            <small class="mb-1">Extended Expiry Date *</small>
                                            <input type="date" disabled class="form-control" placeholder="Type here">
                                        </div>
                                        <div class="col-12 text-start mb-2 px-1">
                                            <small class="mb-1">Remark</small>
                                            <input type="text" disabled class="form-control" placeholder="Type here">
                                        </div>
                                        <div class="col-12 text-center mb-2 px-1">
                                            <button class="btn btn-outline-danger rounded-pill">Please proceed for disposal</button>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div> 
@endsection