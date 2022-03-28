@extends('layouts.app')
@section('content') 
    <div ng-app="SearchAddApp" ng-controller="SearchAddController">
        
        <div class="d-flex align-items-center mb-3">
            <div class="col-5 p-1 border rounded-pill shadow-sm bg-white">
                <div class="input-group align-items-center" title="Scan Barcode">
                    <i class="bi bi-upc-scan font-20 mx-2"></i>
                    <input type="number" ng-model="barcode_number" ng-keyup="search_barcode_number()" class="form-control form-control-lg border-0 bg-light ms-1 rounded-pill" placeholder="Click here to scan">
                </div>
            </div>
            <div class="col-6 d-flex justify-content-end ms-auto text-end">
                <button data-bs-toggle="modal" data-bs-target="#ImportFromExcel" class="btn btn-success rounded-pill mx-1"><i class="bi bi-file-earmark-spreadsheet me-1"></i> Import from Excel</button>
                <a href="{{ route('mandatory-form-one') }}" class="btn btn-primary rounded-pill mx-1"><i class="fa fa-plus me-1"></i> Add</a>
            </div>
        </div>
 
        <div class="table-fillters row m-0 p-2">
            <div class="col-12 mb-2 text-end d-flex justify-content-end">
                    <div class="dropdown">
                        <button class="btn btn-light mx-1 border rounded-pill dropdown-toggle arrow-none"   id="topnav-ecommerce" role="button"     data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-caret-down-square-fill"></i>  
                        </button>
                        <div class="dropdown-menu" aria-labelledby="topnav-ecommerce" >
                            <label class="dropdown-item"><input type="checkbox" ng-model="on_item_description" class="form-check-input me-1">Item Description</label> 
                            <label class="dropdown-item"><input type="checkbox" ng-model="on_brand" class="form-check-input me-1">Brand</label> 
                            <label class="dropdown-item"><input type="checkbox" ng-model="on_batch" class="form-check-input me-1">Batch/Serial#</label> 
                            <label class="dropdown-item"><input type="checkbox" ng-model="on_" class="form-check-input me-1">Pkt size </label> 
                            <label class="dropdown-item"><input type="checkbox" ng-model="on_" class="form-check-input me-1">Qty</label> 
                            <label class="dropdown-item"><input type="checkbox" ng-model="on_" class="form-check-input me-1">Owner1/2 </label> 
                            <label class="dropdown-item"><input type="checkbox" ng-model="on_" class="form-check-input me-1">Storage Room </label> 
                            <label class="dropdown-item"><input type="checkbox" ng-model="on_" class="form-check-input me-1">Housing type  </label> 
                            <label class="dropdown-item"><input type="checkbox" ng-model="on_" class="form-check-input me-1">DOE </label> 
                            <label class="dropdown-item"><input type="checkbox" ng-model="on_" class="form-check-input me-1">QC status  </label> 
                            <label class="dropdown-item"><input type="checkbox" ng-model="on_" class="form-check-input me-1">Used for TD/Expt </label> 
                        </div>
                    </div> 
                <button  data-bs-toggle="modal" data-bs-target="#advance-search-modal"  class="rounded-pill btn btn-sm btn-light shadow-sm border"><i class="bi bi-funnel-fill me-1"></i></i> Advanced filter</button>
            </div>
            <div class="col">
                <label for="" class="form-label">Item description</label>
                <input type="text" ng-model="item_description" name="item_description" class="form-control custom" placeholder="Type here...">
            </div> 
            <div class="col">
                <label for="" class="form-label">Brand</label>
                <input type="text" ng-model="brand" name="brand" class="form-control custom" placeholder="Type here...">
            </div> 
            <div class="col">
                <label for=""  class="form-label">Owner 1/2</label>
                <select name="owner" ng-model="owner" class="form-select custom">
                    <option value="">-- select --</option>
                    <option value="1">Vetri maran</option>
                    <option value="2">Alan walker</option>
                    <option value="3">Alex</option>
                    <option value="4">Hema</option>
                </select>
            </div> 
            <div class="col">
                <label for="" class="form-label">Dept</label>
                <select name="dept" ng-model="dept" id="" class="form-select custom">
                    <option value="">-- select --</option>
                    @foreach ($departments_db as $item)
                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                    @endforeach 
                </select>
            </div> 
            <div class="col">
                <label for="" class="form-label">Storage area</label>
                <select name="storage_area" ng-model="storage_area" class="form-select custom">
                    <option value="">-- select --</option>
                    @foreach ($storage_room_db as $row)
                        <option value="{{ $row->name }}">{{ $row->name }}</option>
                    @endforeach 
                </select>
            </div> 
            <div class="col">
            
                <label for="" class="form-label">Date in</label>
                <input type="date" ng-model="date_in" name="date_in" class="form-control custom" placeholder="Type here...">
            </div>
            <div class="col d-flex align-items-center justify-content-center">
                <div class="btn-group">
                    <button ng-click="bulk_search()" class="btn btn-sm btn-primary rounded w-100 h-100 me-2"><i class="bi bi-search"></i></i> </button>
                    <button ng-click="reset_bulk_search()" class="btn btn-sm btn-light w-100 h-100 rounded"><i class="bi bi-arrow-counterclockwise"></i></button>
                </div>
            </div> 
        </div>
        
        <div>
            <table class="table table-centered table-bordered table-hover bg-white">
                <thead>
                    <tr>
                        <th ng-show="on_item_description" class="position-relative table-th child-td-lg">Item Description 
                            <i ng-click="sort_by('id', 'asc')" class="bi bi-arrow-up  position-absolute top-0 right-0 cur_ponit"></i>
                            <i ng-click="sort_by('id', 'desc')" class="bi bi-arrow-down  position-absolute bottom-0 right-0 cur_ponit"></i>
                        </th>
                        <th ng-show="on_brand" class="position-relative table-th child-td">Brand 
                            <i ng-click="sort_by('brand', 'asc')" class="bi bi-arrow-up  position-absolute top-0 right-0 cur_ponit"></i>
                            <i ng-click="sort_by('brand', 'desc')" class="bi bi-arrow-down  position-absolute bottom-0 right-0 cur_ponit"></i>
                        </th>
                        <th ng-show="on_batch" class="position-relative table-th child-td">Batch/Serial# 
                            <i ng-click="sort_by('batch', 'asc')" class="bi bi-arrow-up  position-absolute top-0 right-0 cur_ponit"></i>
                            <i ng-click="sort_by('batch', 'desc')" class="bi bi-arrow-down  position-absolute bottom-0 right-0 cur_ponit"></i>
                        </th>
                        <th class="position-relative table-th child-td">Pkt size 
                            <i ng-click="sort_by('unit_packing_size', 'asc')" class="bi bi-arrow-up  position-absolute top-0 right-0 cur_ponit"></i>
                            <i ng-click="sort_by('unit_packing_size', 'desc')" class="bi bi-arrow-down  position-absolute bottom-0 right-0 cur_ponit"></i>
                        </th>
                        <th class="position-relative table-th child-td">Qty 
                            <i ng-click="sort_by('quantity', 'asc')" class="bi bi-arrow-up  position-absolute top-0 right-0 cur_ponit"></i>
                            <i ng-click="sort_by('quantity', 'desc')" class="bi bi-arrow-down  position-absolute bottom-0 right-0 cur_ponit"></i>
                        </th>
                        <th class="position-relative table-th child-td-lg">Owner1/2 
                            <i ng-click="sort_by('owner_one', 'asc')" class="bi bi-arrow-up  position-absolute top-0 right-0 cur_ponit"></i>
                            <i ng-click="sort_by('owner_one', 'desc')" class="bi bi-arrow-down  position-absolute bottom-0 right-0 cur_ponit"></i>
                        </th>
                        <th class="position-relative table-th child-td">Storage Room 
                            <i ng-click="sort_by('storage_room', 'asc')" class="bi bi-arrow-up  position-absolute top-0 right-0 cur_ponit"></i>
                            <i ng-click="sort_by('storage_room', 'desc')" class="bi bi-arrow-down  position-absolute bottom-0 right-0 cur_ponit"></i>
                        </th>
                        <th class="position-relative table-th child-td">Housing type 
                            <i ng-click="sort_by('house_type', 'asc')" class="bi bi-arrow-up  position-absolute top-0 right-0 cur_ponit"></i>
                            <i ng-click="sort_by('house_type', 'desc')" class="bi bi-arrow-down  position-absolute bottom-0 right-0 cur_ponit"></i>
                        </th>
                        <th class="position-relative table-th child-td">DOE 
                            <i ng-click="sort_by('date_of_expiry', 'asc')" class="bi bi-arrow-up  position-absolute top-0 right-0 cur_ponit"></i>
                            <i ng-click="sort_by('date_of_expiry', 'desc')" class="bi bi-arrow-down  position-absolute bottom-0 right-0 cur_ponit"></i>
                        </th>
                        <th class="position-relative table-th child-td">QC status 
                            <i ng-click="sort_by('iqc_status', 'asc')" class="bi bi-arrow-up  position-absolute top-0 right-0 cur_ponit"></i>
                            <i ng-click="sort_by('iqc_status', 'desc')" class="bi bi-arrow-down  position-absolute bottom-0 right-0 cur_ponit"></i>
                        </th>
                        <th class="position-relative table-th child-td">Used for TD/Expt 
                            <i ng-click="sort_by('item_description', 'asc')" class="bi bi-arrow-up  position-absolute top-0 right-0 cur_ponit"></i>
                            <i ng-click="sort_by('item_description', 'desc')" class="bi bi-arrow-down  position-absolute bottom-0 right-0 cur_ponit"></i>
                        </th>
                        <th class="table-th child-td">Actions </th>
                    </tr> 
                </thead> 
                <tr>
                    <td colspan="12" class="text-center" ng-show="material_products.data.length == 0">
                        No data found
                    </td>
                </tr>
                <tr class="table-tr" ng-show="material_products.length != 0" ng-repeat="(index,row) in material_products.data track by row.id">
                    <td colspan="12" class="p-0 border-bottom">
                        <table class="table table-centered m-0">
                            <tr>
                                <td class="child-td-lg" ng-show="on_item_description">
                                    <i class="bi bi-caret-right-fill float-start table-toggle-icon collapsed" data-bs-toggle="collapse" href="#row_@{{ index+1 }}" role="button" aria-expanded="false" aria-controls="row_@{{ index+1 }}"></i> 
                                    @{{ row.item_description }} |   @{{ row.id }} 
                                </td>
                                <td class="child-td" ng-show="on_brand">@{{ row.brand }}</td>
                                <td class="child-td" ng-show="on_batch"></td>
                                <td class="child-td">@{{ row.unit_packing_size }}L</td>
                                <td class="child-td">@{{ row.quantity }} <i class="text-success dot-sm bi bi-circle-fill"></i></td>
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
                                        <div class="dropdown-menu" >
                                            <a ng-click="view_material_product(row)" class="dropdown-item"><i class="bi bi-eye-fill me-1"></i>View </a>
                                            <a ng-click="edit_material_product(row.id)" class="dropdown-item"><i class="bi bi-pencil-square me-1"></i> Edit </a>
                                            <a ng-click="delete_material_product(row.id)"  class="dropdown-item text-danger" href="#"><i class="bi bi-trash3-fill me-1"></i> Delete</a> 
                                        </div>
                                    </div>
                                </td> 
                            </tr>
                            <tr class="collapse" id="row_@{{ index+1 }}">
                                <td colspan="12" class="p-0">
                                    <table class="table table-centered bg-white m-0">
                                        @for ($key2=0; $key2<4; $key2++)
                                            <tr>
                                                <td class="child-td-lg" ng-show="on_item_description"></td>
                                                <td class="child-td" ng-show="on_brand"></td>   
                                                @if ($key2 == 0)
                                                <td class="child-td" ng-show="on_batch">Batch/1</td>
                                                @endif
                                                @if ($key2 == 1)
                                                <td class="child-td" ng-show="on_batch">Batch/2</td>
                                                @endif 
                                                @if ($key2 == 2)
                                                <td class="child-td" ng-show="on_batch">Batch/3</td>
                                                @endif
                                                @if ($key2 == 3)
                                                <td class="child-td" ng-show="on_batch">Batch/4</td>
                                                @endif  
                                                @if ($key2 == 0)
                                                <td class="child-td">1L</td>
                                                @endif
                                                @if ($key2 == 1)
                                                <td class="child-td">1L</td>
                                                @endif 
                                                @if ($key2 == 2)
                                                <td class="child-td">0.5L</td>
                                                @endif
                                                @if ($key2 == 3)
                                                <td class="child-td">5L</td>
                                                @endif  
                                                <td class="child-td">
                                                    @if ($key2 == 0)
                                                    30
                                                    @endif
                                                    @if ($key2 == 1)
                                                    9
                                                    @endif 
                                                    @if ($key2 == 2)
                                                    2
                                                    @endif
                                                    @if ($key2 == 3)
                                                    10
                                                    @endif  
                                                </td>
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
                                                            <a class="dropdown-item text-secondary" href="#" data-bs-toggle="modal" data-bs-target="#View_Batch_Material_Product_details"><i class="bi bi-eye"></i> View batch details</a>
                                                            <a class="dropdown-item text-secondary" href="#"><i class="bi bi-back me-1"></i>Duplicate batch</a>
                                                            <a class="dropdown-item text-secondary" href="#"><i class="bi bi-pencil-square me-1"></i>Edit batch</a>
                                                            <a class="dropdown-item text-secondary" href="#" data-bs-toggle="modal" data-bs-target="#Transfers"><i class="bi bi-arrows-move me-1"></i>Transfer</a>
                                                            <a class="dropdown-item text-secondary" href="#" data-bs-toggle="modal" data-bs-target="#RepackTransfers"><i class="bi bi-box-seam me-1"></i>Repack/Transfer </a>
                                                            <a class="dropdown-item text-secondary" href="#" data-bs-toggle="modal" data-bs-target="#RepackOutlife"><i class="bi bi-box2-fill me-1"></i>Repack/outlife</a>
                                                            <a class="dropdown-item text-secondary" onclick="printModal()" href="#"><i class="bi bi-upc-scan me-1"></i>Print Barcode/Label</a>
                                                            <a class="dropdown-item text-danger" onclick="deleteModal()" href="#"><i class="bi bi-trash3-fill me-1"></i> Delete batch</a> 
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
            </table>
 
            
            <div class="pb-3">
                <page-pagination></page-pagination>
            </div>
            

            <div id="View_Material_Product_Details" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog w-100 modal-right h-100">
                    <div class="modal-content h-100 rounded-0">
                        <div class="modal-header bg-primary text-white border-0 rounded-0">
                            <h4>View Material / Product details</h4>
                            <button class="rounded-pill btn btn-light btn-sm ms-auto shadow-sm border" data-bs-dismiss="modal" aria-hidden="true"><i class="bi bi-x"></i></button>
                        </div>
                        <div class="modal-body modal-scroll-2 p-0"> 
                            <ol class="list-group list-group-numbered">
                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-start" ng-repeat="(index, row) in view_material_product_data">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">@{{ row.name }}</div>
                                        @{{ row.item }}
                                    </div>
                                </li>
                            </ol> 
                        </div> 
                    </div> 
                </div>
            </div>
        </div> 
        <div id="Transfers" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog custom-modal-dialog modal-top">
                <div class="modal-content rounded-0 border-bottom shadow">
                    <div class="modal-header rounded-0 bg-primary text-white  ">
                        <h4 class="modal-title" id="topModalLabel">Transfer batch</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body  ">
                        <table class="table table-centered bg-white table-bordered table-hover custom-center m-0">
                            <thead class="bg-light text-primary-2 table-bordered table-hover"> 
                                <tr>
                                    <th width="200px">Transfer Qty</th>
                                    {{-- <th>Storage room (able to add in new rooms in the future)</th>
                                    <th>Housing type (able to add in new housing type in the future)</th> --}}
                                    <th>Storage room </th>
                                    <th>Housing type </th>
                                    <th>Housing No.</th>
                                    <th>Owner 1</th>
                                    <th>Owner 2</th>
                                    <th> <i class="text-danger bi bi-trash3-fill"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="200px" class="text-center"><input type="number" name="" id="" value="5" class="text-center form-control form-control-sm"></td>
                                    <td>
                                        <select name="" id="" class="form-select form-select-sm">
                                            <option value="">AR</option> 
                                            <option value="">CW</option> 
                                            <option value="">MA</option> 
                                            <option value="">SP</option> 
                                            <option value="">MR</option> 
                                            <option value="">Polymer</option> 
                                            <option value="">ChemShed1</option> 
                                            <option value="">ChemShed2</option> 
                                        </select>
                                    </td>
                                    <td>
                                        <select name="" id="" class="form-select form-select-sm">
                                            <option value=""> Flammable Cabinet</option>
                                            <option value=""> Acid Cabinet</option>
                                            <option value=""> Base Cabinet</option>
                                            <option value=""> Metal Cabinet</option>
                                            <option value=""> Racks</option>
                                            <option value=""> Dry Cabinet</option>
                                            <option value=""> Pallet </option>
                                            <option value=""> Freezer</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="" id="" class="form-select form-select-sm">
                                            <option value=""> -</option>
                                            @for ($key=0;$key<20;$key++)
                                                <option value="">@{{ index+1 }}</option>
                                            @endfor
                                        </select>
                                    </td>
                                    <td>
                                        <select name="" id="" class="form-select form-select-sm">
                                            <option value="">Beng HJibn</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="" id="" class="form-select form-select-sm">
                                            <option value="">HuiBeng</option>
                                        </select>
                                    </td>
                                    <td>
                                        <i class="btn btn-sm border shadow btn-light rounded-pill bi bi-x"></i>
                                    </td>
                                </tr> 
                            </tbody>
                        </table>
                    </div> 
                    <div class="modal-footer text-end  border-top">
                        <button class="btn btn-primary rounded-pill">Click to confirm transfer</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div> 
        <div id="RepackTransfers" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog custom-modal-dialog modal-top">
                <div class="modal-content rounded-0 border-bottom shadow">
                    <div class="modal-header rounded-0 bg-primary text-white  ">
                        <h4 class="modal-title" id="topModalLabel">Repack/Transfer Material/Product batch</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row m-0">
                            <div class="col-lg-12">
                                <h5 class="h5 text-primary text-center"> Bulk vol tracking logsheet (Drum)</h5>
                                <table class="table table-centered bg-white table-bordered table-hover custom-center mb-3">
                                    <thead class="bg-light text-primary-2 table-bordered table-hover"> 
                                        <tr>
                                   
                                            <th>Time stamp</th>
                                            <th>Current accessed</th>
                                            <th>Input Used amt (L)</th>
                                            <th>Remain Amt (L)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 0">10/09/2021 at 08:00</td>
                                            <td style="padding: 0">Ziv</td>
                                            <td style="padding: 0"><input type="number" name="" id="" value="10" class="text-center form-control form-control-sm"></td>
                                            <td style="padding: 0">15</td>
                                        </tr> 
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-12">
                                <h5 class="h5 text-primary text-center">Repacked mat/product tracking logsheet (Repack)</h5>
                                <table class="table table-centered bg-white table-bordered table-hover custom-center m-0">
                                    <thead class="bg-light text-primary-2 table-bordered table-hover"> 
                                        <tr>
                                            <th width="200px">Repack Size(L)</th>
                                             <th>Qty</th>
                                            <th>Storage Room</th>
                                            <th>Housing type</th>
                                             <th>Housing No</th>
                                            <th>Owner 1</th>
                                            <th>Owner 2</th>
                                            <th>Generate Unique Barcode</th>
                                            <th> <i class="text-danger bi bi-trash3-fill"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 0" width="200px" class="text-center"><input type="number" name="" id="" value="5" class="text-center form-control form-control-sm"></td>
                                            <td style="padding: 0">
                                                <select name="" id="" class="form-select form-select-sm">
                                                    <option value="">CW</option>
                                                </select>
                                            </td>
                                              <td style="padding: 0">15</td>
                                            <td style="padding: 0">
                                                <select name="" id="" class="form-select form-select-sm">
                                                    <option value="">FC1</option>
                                                </select></td>
                                           <td>
                                        <select name="" id="" class="form-select form-select-sm">
                                            <option value=""> -</option>
                                            @for ($key=0;$key<20;$key++)
                                                <option value="">@{{ index+1 }}</option>
                                            @endfor
                                        </select>
                                    </td>
                                            <td style="padding: 0">
                                                <select name="" id="" class="form-select form-select-sm">
                                                    <option value="">Keith</option>
                                                </select>
                                            </td>
                                            <td style="padding: 0">
                                                <select name="" id="" class="form-select form-select-sm">
                                                    <option value="">HuiBeng</option>
                                                </select>
                                            </td>
                                              <td style="padding: 0">Batch2/1</td>
                                            <td style="padding: 0">
                                                <i class="btn btn-sm border shadow btn-light rounded-pill bi bi-x"></i>
                                            </td>
                                        </tr> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> 
                    <div class="modal-footer text-end  border-top">
                        <button class="btn btn-primary rounded-pill">Click to confirm and proceed to print label page</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div> 
        <div id="RepackOutlife" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog custom-modal-dialog modal-top">
                <div class="modal-content rounded-0 border-bottom shadow">
                    <div class="modal-header rounded-0 bg-primary text-white  ">
                        <h4 class="modal-title" id="topModalLabel">Repack/Outlife Material/Product batch</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>				  
                    <div class="modal-body  ">
                     <h5 class="h5 text-primary text-center">Mat/Pdt outlife logsheet</h5>
                        <table class="table table-centered  bg-white table-bordered table-hover custom-center m-0">
                            <thead class="bg-light text-primary-2 table-bordered table-hover"> 
                                <tr>
                                    <th width="200px">(Mother)Material/Product Draw status</th>
                                    <th>Date/time stamp</th>
                                    <th>Last accessed</th>
                                    <th>Auto-generate unique barcode label</th>
                                    <th>Qty cut (kitted prepreg)</th>
                                    <th>
                                        Remaining outlife (prepreg roll)
                                        Intital count: 
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <input type="number" name="" id="" style="width: 45px" value="30" class="me-1 p-0 text-center form-control form-control-sm"> days
                                        </div>
                                    </th>
                                    <th> <i class="text-danger bi bi-trash3-fill"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="300px" colspan="3">
                                        <div class="row mb-2">
                                            <div class="col p-0">
                                                <button class="btn btn-success">Draw Out</button>
                                            </div>
                                            <div class="col p-0">11/09/2021 08:00</div>
                                            <div class="col p-0">HuiBeng</div>
                                        </div>
                                        <div class="row ">
                                            <div class="col p-0">
                                                <button class="btn btn-secondary">Draw in</button>
                                            </div>
                                            <div class="col p-0">11/09/2021 08:00</div>
                                            <div class="col p-0">HuiBeng</div>
                                        </div>
                                    </td>
                                    <td>
                                        Roll2/1 
                                    </td>
                                    <td class="text-center"><input type="number" name="" id="" value="10" class="text-center form-control form-control-sm"></td>
                                    <td>29 days 17hrs</td>
                                    <td>
                                        <i class="btn btn-sm border shadow btn-light rounded-pill bi bi-x"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> 
                    <div class="card-footer ">
                        <div class="row align-items-center">
                            <div class="shadow-sm border col-4">
                                <label for="end_of_material_products" class="p-2"><input type="checkbox" class="form-check-input me-2" name="" id="end_of_material_products"> End of batch</label>
                            </div>
                            <div class="col-6 ms-auto text-end">
                                <button class="btn btn-primary rounded-pill h-100">Save and Submit</button>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <div id="ImportFromExcel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog modal-sm">
                <form action="{{ route('import_data') }}" method="POST" enctype="multipart/form-data" class="modal-content rounded-0 border-bottom shadow">
                    @csrf
                    <div class="modal-header rounded-0 bg-primary text-white ">
                        <h4 class="modal-title" id="topModalLabel">Import Data From Excel</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="select_file" class="form-control"> 
                    </div>
                    <div class="modal-footer border-top">
                        <button type="submit" class="btn btn-primary rounded-pill w-100"><i class="bi bi-box-arrow-in-down-left me-1"></i>Import</button>
                    </div>
                </form><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div> 
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>

    <script>

        var app = angular.module('SearchAddApp', []); 
     

        app.controller('SearchAddController', function($scope, $http) {


            $scope.on_item_description = true;
            $scope.on_brand = true;
            $scope.on_batch = true;
 
            $scope.getPage = function (link) { 
                if($scope.material_products.current_page == link.label) {
                    return false
                }
               
                $http({
                    method: 'get', 
                    url: link.url,  
                }).then(function(response) {
                    $scope.material_products = response.data.data; 
                    $scope.material_products.links.shift();
                    $scope.material_products.links.pop();
                }, function(response) {
                    Message('danger', response.data.message);
                });  
            } 
            $scope.next_Prev_page = function (params) {
                $http({
                    method: 'get', 
                    url: params,  
                }).then(function(response) {
                    $scope.material_products = response.data.data; 
                    $scope.material_products.links.shift();
                    $scope.material_products.links.pop();
                }, function(response) {
                    Message('danger', response.data.message);
                });  
            } 
            $scope.get_material_products =  function () {
                $http({
                    method: 'get', 
                    url: "{{ route('get-material-products') }}",  
                }).then(function(response) {
                    $scope.material_products = response.data.data;
                    $scope.material_products.links.shift();
                    $scope.material_products.links.pop();
                }, function(response) {
                    Message('danger', response.data.message);
                });
            }
            $scope.get_material_products();


            $scope.sort_by = function (name, type) {
              
                $http({
                    method: 'post', 
                    url: "{{ route('get-material-products') }}",
                    data : {
                        sort_by: {
                            col_name :  name ,
                            order_type :  type ,
                        }
                    }
                }).then(function(response) {
                    $scope.material_products = response.data.data;
                    $scope.material_products.links.shift();
                    $scope.material_products.links.pop();
                }, function(response) {
                    Message('danger', response.data.message);
                });
            }
 
            $scope.search_barcode_number = function () {
                $http({
                    method: 'post', 
                    url: "{{ route('get-material-products') }}",
                    data : {
                        filters: $scope.barcode_number
                    }
                }).then(function(response) {
                    $scope.material_products = response.data.data;
                    $scope.material_products.links.shift();
                    $scope.material_products.links.pop();
                }, function(response) {
                    Message('danger', response.data.message);
                });
            } 
            $scope.bulk_search = function () {
                if($scope.item_description == undefined && $scope.brand == undefined && $scope.owner == undefined && $scope.dept == undefined && $scope.storage_area == undefined && $scope.date_in == undefined) {
                    return false
                }
               let date_in = moment($scope.date_in).format('YYYY-MM-DD');
                
                $http({
                    method: 'post', 
                    url: "{{ route('get-material-products') }}",
                    data : {
                        bulk_search: {
                            item_description : $scope.item_description == undefined ? '' : $scope.item_description,
                            brand : $scope.brand == undefined ? '' : $scope.brand,
                            owner : $scope.owner == undefined ? '' : $scope.owner,
                            dept : $scope.dept == undefined ? '' : $scope.dept,
                            storage_area : $scope.storage_area == undefined ? '' : $scope.storage_area,
                            date_in : $scope.date_in == undefined ? '' : date_in,
                        }
                    }
                }).then(function(response) {
                    $scope.material_products = response.data.data;
                    $scope.material_products.links.shift();
                    $scope.material_products.links.pop();
                }, function(response) {
                    Message('danger', response.data.message);
                });
            } 
            $scope.reset_bulk_search = function () {
                $scope.get_material_products();
                $scope.item_description = ''
                $scope.brand = ''
                $scope.owner = ''
                $scope.dept = ''
                $scope.storage_area = ''
                $scope.date_in = ''
            } 
            $scope.view_material_product = function (row) {
                $('#View_Material_Product_Details').modal('show'); 
                $scope.view_material_product_data  = [
                    {name: "Category Selection", item:row.category_selection == 'in_house' ? 'In-house Product' : 'Material'},
                    {name: 'Item description' , item : row.item_description},
                    {name: 'In-house Product Logsheet ID#' , item : row.in_house_product_logsheet_id},
                    {name: 'EUC material' , item : row.euc_material},
                    {name: 'Brand' , item : row.brand},
                    {name: 'Supplier' , item : row.supplier},
                    {name: 'Unit Packing size' , item : row.unit_packing_size},
                    {name: 'Statutory body' , item : row.statutory_body},
                    {name: 'Owner 1' , item : row.owner_one},
                    {name: 'Owner 2 (SE/PL/FM)' , item : row.owner_two},
                    {name: 'Remarks' , item : row.remarks},
                    {name: 'Alert Threshold Qty for new material/product description' , item : row.alert_threshold_qty_for_new},
                    {name: 'Alert before expiry (in terms of weeks) for new material/product description' , item : row.alert_before_expiry},
                    {name: 'Access' , item : row.access},
                ]
            }
            $scope.edit_material_product = function (id) {
                var route =  "{{ route('material-product.edit-form-one') }}"+'/'+ id
                window.location.replace(route);
            }
            $scope.delete_material_product = function (id) {
               var route = "{{ route('delete-material-products') }}"+"/"+id
                swal({
                    text: "Are you sure want to Delete?",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Cancel",
                            value: null,
                            visible: true,
                            className: "btn-light rounded-pill btn",
                            closeModal: true,
                        },
                        confirm: {
                            text: "Yes! Delete",
                            value: true,
                            visible: true,
                            className: "btn btn-danger rounded-pill",
                            closeModal: true
                        }
                    }, 
                }).then((isConfirm) => {
                    if(isConfirm) {
                        $http({
                            method: 'POST', 
                            url: route, 
                        }).then(function(response) {
                            $scope.data = response.data; 
                            $scope.get_material_products();
                            Message('success', response.data.message); 
                        }, function(response) {
                            $scope.data = response.data || 'Request failed';
                        });
                    } 
                });
            }
        });

        app.directive('pagePagination', function(){  
            return{
                restrict: 'E',
                template: `
                <ul class="pagination btn-group pagination-rounded" ng-show="material_products.data != ''"> 
                    <li class="page-item" ng-show="material_products.prev_page_url != null">
                        <a class="page-link"  href="javascript: void(0);" ng-click="next_Prev_page(material_products.prev_page_url)" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item" ng-class="{active : link.active == true}" ng-repeat="(index, link) in material_products.links">
                        <a class="page-link" href="javascript: void(0);" ng-click="getPage(link)" > @{{ link.label}}  </a>
                    </li>  
                    <li class="page-item" ng-show="material_products.next_page_url != null">
                        <a class="page-link" href="javascript: void(0);" ng-click="next_Prev_page(material_products.next_page_url)"  aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
                `
            };
        });
    </script> 
@endsection