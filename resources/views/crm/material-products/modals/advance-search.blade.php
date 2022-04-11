<div id="advance-search-ng-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog w-100 modal-right h-100">
        <div class="modal-content h-100 rounded-0">
            <div class="modal-header bg-primary text-white border-0 rounded-0">
                <h4>Advanced Search Filter</h4>  
                <div class="ms-auto">
                    <a ng-click="view_my_saved_search()" class="btn btn-outline-light me-2 rounded-pill">My saved searches</a>
                    <button class="rounded-pill btn btn-light btn-sm shadow-sm border" data-bs-dismiss="modal" aria-hidden="true"><i class="bi bi-x"></i></button>
                </div>
            </div>
            <div class="modal-body modal-scroll">
                <div class="text-center">
                    <div class="row m-0">
                        <div class="col-6 text-start mb-2 px-1">
                            <small class="mb-1">In-house Product Logsheet ID#</small>
                            <input type="text" class="form-control" placeholder="Type here" ng-model="af_logsheet_id">
                        </div> 
                        <div class="col-6 text-start mb-2 px-1">
                            <label for="" class="form-label">EUC Material</label>
                            <select name="af_euc_material" id="" class="form-select" ng-model="af_euc_material">
                                <option value="">-- select --</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div> 
                        <div class="col-6 text-start mb-2 px-1">
                            <label for="" class="form-label">Usage Tracking</label>
                            <select  id="" class="form-select">
                                <option value="">-- select --</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div> 
                        <div class="col-6 text-start mb-2 px-1">
                            <label for="" class="form-label">Outlife Tracking</label>
                            <select  id="" class="form-select">
                                <option value="">-- select --</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div> 
                        <div class="col-6 text-start mb-2 px-1">
                            <small class="mb-1">CAS#</small>
                            <input type="text" class="form-control" placeholder="Type here" ng-model="af_cas">
                        </div>
                        <div class="col-6 text-start mb-2 px-1">
                            <small class="mb-1">Supplier</small>
                            <input type="text" class="form-control" placeholder="Type here" ng-model="af_supplier">
                        </div>
                        <div class="col-6 text-start mb-2 px-1">
                            <small class="mb-1">Batch#</small>
                            <input type="text" class="form-control" placeholder="Type here" ng-model="af_batch">
                        </div>
                        <div class="col-6 text-start mb-2 px-1">
                            <small class="mb-1">Serial#</small>
                            <input type="text" class="form-control" placeholder="Type here" ng-model="af_serial">
                        </div>
                        <div class="col-6 text-start mb-2 px-1">
                            <label for="" class="form-label">Statutory board</label>
                            <select name="af_statutory_board" id="" class="form-select" ng-model="af_statutory_board">
                                <option value="">-- select --</option>
                                @foreach ($statutory_body_db as $row)
                                    <option value="{{ $row->name }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div> 
                        <div class="col-6 text-start mb-2 px-1">
                            <label for="" class="form-label">Housing type</label>
                            <select name="af_housing_type" id="" class="form-select" ng-model="af_housing_type">
                                <option value="">-- select --</option>
                                @foreach ($house_type_db as $row)
                                    <option value="{{ $row->name }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div> 
                         <div class="col-6 text-start mb-2 px-1">
                            <label for="" class="form-label">Housing No</label>
                            <select name="af_housing_number" id="" class="form-select form-select-sm" ng-model="af_housing_number">
                                <option value=""> -</option>
                                @for ($key=0;$key<20;$key++)
                                    <option value="{{ $key+1 }}">{{ $key+1 }}</option>
                                @endfor
                            </select>
                        </div> 
                        <div class="col-6 text-start mb-2 px-1">
                            <label for="" class="form-label">Unit Packing size</label>
                            <select name="af_unit_pkt_size" id="" class="form-select" ng-model="af_unit_pkt_size">
                                <option value="">-- select --</option>
                                @foreach ($unit_packing_size_db as $row)
                                    <option value="{{ $row->name }}">{{ $row->name }}</option>
                                @endforeach	 
                            </select>
                        </div> 
                        <div class="col-6 text-start mb-2 px-1">
                            <small class="mb-1">Date of expiry</small>
                            <input type="date" class="form-control" placeholder="Type here" ng-model="af_date_of_expiry">
                        </div>
                        <div class="col-6 text-start mb-2 px-1">
                            <label for="" class="form-label">IQC status </label>
                            <select name="af_iqc_status" id="" class="form-select" ng-model="af_iqc_status">
                                <option value="">-- select --</option>
                                <option value="1">Pass</option>
                                <option value="2">Fail</option> 
                            </select>
                        </div>
                        <div class="col-6 text-start mb-2 px-1">
                            <small class="mb-1">PO Number</small>
                            <input type="number" class="form-control" placeholder="Type here" ng-model="af_po_number">
                        </div>
                        <div class="col-6 text-start mb-2 px-1">
                            <small class="mb-1">Extended expiry</small>
                            <input type="date" class="form-control" placeholder="Type here" ng-model="af_extended_expiry">
                        </div>
                        <div class="col-6 text-start mb-2 px-1">
                            <label for="" class="form-label">Extended QC status</label>
                            <select name="af_extended_qc_status" id="" class="form-select" ng-model="af_extended_qc_status">
                                <option value="">-- select --</option>
                                <option value="1">Pass</option>
                                <option value="2">Fail</option> 
                            </select>
                        </div>
                        <div class="col-6 text-start mb-2 px-1">
                            <label for="" class="form-label">Disposed</label>
                            <select name="af_disposed" id="" class="form-select" ng-model="af_disposed">
                                <option value="">-- select --</option>
                                <option value="1">Yes</option>
                                <option value="2">No but use for TD & EXPT</option> 
                            </select>
                        </div>
                        <div class="col-6 text-start mb-2 px-1">
                            <small class="mb-1">Project name </small>
                            <input type="text" class="form-control" placeholder="Type here" ng-model="af_project_name">
                        </div>
                        <div class="col-6 text-start mb-2 px-1">
                            <small class="mb-1">Material/In-house Product type</small>
                            <input type="text" class="form-control" placeholder="Type here" ng-model="af_product_type">
                        </div>
                        <div class="col-6 text-start mb-2 px-1">
                            <small class="mb-1">Date of shipment</small>
                            <input type="date" class="form-control" placeholder="Type here" ng-model="af_date_of_shipment">
                        </div>
                        <div class="col-6 text-start mb-2 px-1">
                            <small class="mb-1">Date of manufacture</small>
                            <input type="date" class="form-control" placeholder="Type here" ng-model="af_date_of_manufacture">
                        </div>
                        <div class="col-6 text-start mb-2 px-1">
                            <label for="" class="form-label">Extended QC status</label>
                            <select name="af_extended_qc_status" id="" class="form-select" ng-model="af_extended_qc_status">
                                <option value="">-- select --</option>
                                <option value="1">Pass</option>
                                <option value="2">Fail</option> 
                            </select>
                        </div>
                        <div class="col-6 text-start mb-2 px-1">
                            <label for="" class="form-label">Required Usage Tracking</label>
                            <select name="af_usage_tracking" id="" class="form-select" ng-model="af_usage_tracking">
                                <option value="">-- select --</option>
                                <option value="0">No</option>
                                <option value="1">Yes</option> 
                            </select>
                        </div>
                        <div class="col-6 text-start mb-2 px-1">
                            <label for="" class="form-label">Required Outlife Tracking</label>
                            <select name="af_outlife_tracking" id="" class="form-select" ng-model="af_outlife_tracking">
                                <option value="">-- select --</option>
                                <option value="0">No</option>
                                <option value="1">Yes</option> 
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top text-center">
                <label for="xxxx" data-bs-toggle="modal" data-bs-target="#save-search-name"><input type="checkbox" name="" class="form-check-input" id="xxxx"> Save this search</label>
                <button ng-click="search_advanced_mode()" class="btn btn-primary mx-auto col-3 rounded-pill"><i class="bi bi-search me-1"></i> Search</button>
            </div>
        </div> 
    </div>
</div>
 
<div class="modal fade" id="save-search-name" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white border-0 rounded-0">
                <h4>Search Title</h4>  
                <div class="ms-auto">
                    <button class="rounded-pill btn btn-light btn-sm shadow-sm border" data-bs-dismiss="modal" aria-hidden="true"><i class="bi bi-x"></i></button>
                </div>
            </div>
            <div class="modal-body">
                <input type="text" ng-model="search_title" class="form-control mb-3" placeholder="Type here..">
                <input type="submit" ng-click="save_search_title()" class="form-control btn-primary btn" value="Save">
            </div>
        </div>
    </div>
</div>