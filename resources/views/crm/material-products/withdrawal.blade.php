@extends('layouts.app')
@section('content') 
    <div ng-app="RootApp" ng-controller="RootController">
        <div class="d-flex align-items-center mb-3 justify-content-between">
            <div class="col-5 p-1 border rounded-pill shadow-sm bg-white">
                <div class="input-group align-items-center" title="Scan Barcode">
                    <i class="bi bi-upc-scan font-20 mx-2"></i>
                    <input type="number" min="1"  onkeyup="return this.value = ''" ng-model="barcode_number" min="1" ng-change="search_barcode_number()" class="form-control form-control-lg border-0 bg-light ms-1 rounded-pill" placeholder="Click here to scan">
                    <i ng-click="resetBarCode()" class="bi bi-x-circle-fill font-20 text-danger position-absolute right-0 me-2" style="cursor: pointer;z-index:111"></i>
                </div>
            </div> 
            <div class="col-1 text-end">
                <div ng-show="withdrawalType">
                    @include('crm.partials.table-column-filter') 
                </div>
            </div>
        </div>
        <div class="card" ng-if="withdrawalType">
            <ul class="nav nav-tabs bg-light">
                <li class="nav-item">
                    <a class="nav-link" ng-class="withdrawalType == 'DIRECT_DEDUCT' ? 'active' : ''">
                        <i class="mdi mdi-home-variant d-md-none d-block"></i>
                        <span class="d-none d-md-block">Direct Deduct</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" ng-class="withdrawalType == 'DEDUCT_TRACK_USAGE' ? 'active' : ''">
                        <i class="mdi mdi-account-circle d-md-none d-block"></i>
                        <span class="d-none d-md-block">Deduct & Track Usage</span>
                    </a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" ng-class="withdrawalType == 'DEDUCT_TRACK_OUTLIFE' ? 'active' : ''">
                        <i class="mdi mdi-account-circle d-md-none d-block"></i>
                        <span class="d-none d-md-block">Deduct & Track Outlife</span>
                    </a>
                </li> 
            </ul>
            <section class="border border-top-0 card-body"> 
                <div class="mb-3">
                    @include('crm.partials.data-table')
                </div>
                <div ng-if="withdrawalType == 'DIRECT_DEDUCT'"> 
                    <form action="{{ route('withdrawal.direct-deduct') }}" method="POST">
                        @csrf
                        <table class="table bg-white table-borderless border table-centered table-hover">
                            <thead class="border-bottom">
                                <tr class="bg text-white">
                                    <th class="bg-dark text-center text-white" style="padding: 5px !important;" colspan="7">
                                        <span class="text-center">Withdrawal Cart</span>
                                    </th>
                                </tr>
                                <tr class="bg-light text-primary"> 
                                    <th class="table-th child-td">Item description</th>
                                    <th class="table-th child-td">Brand</th>
                                    <th class="table-th child-td">Batch#/ Serial#</th>
                                    <th class="table-th child-td">Unit packing value</th>
                                    <th class="table-th child-td">Withdraw Qty</th>
                                    <th class="table-th child-td">Remarks</th>
                                    <th class="table-th child-td text-center"> <i class="text-danger bi bi-trash3-fill"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="(index,row) in directDeduct">
                                    <td>
                                        <span>
                                            @{{ row.item_description }}
                                        </span>
                                        <input type="hidden" name="id[]"  value="@{{ row.id }}">
                                        <input type="hidden" name="category_selection[]"  value="@{{ row.category_selection }}">
                                    </td>
                                    <td>@{{ row.brand }}</td>
                                    <td>@{{ row.batch }} / @{{ row.serial }}</td>
                                    <td>@{{ row.unit_packing_value }} @{{ row.unit_of_measure }}</td>
                                    <td><input name="quantity[]" type="number" class="form-control w-auto p-0 form-control-sm text-center" readonly value="@{{ row.direct_detect_quantity }}" required></td>
                                    <td class="child-td py-0 px-1">
                                        <textarea name="remarks[]" class="form-control h-100 w-100"></textarea>
                                    </td>
                                    <td class="text-center">
                                        <i ng-click="removeDirectDetectRow(index)" class="btn btn-sm border shadow btn-light rounded-pill bi bi-x"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-end">
                            <button class="btn btn-primary rounded-pill">Click to Confirm deduction</button>
                        </div>
                    </form>
                </div>
                <div ng-if="withdrawalType == 'DEDUCT_TRACK_USAGE'">
                    <form action="{{ route('withdrawal.deduct-track-usage') }}" method="POST" style="border: 0 !important">
                        @csrf
                        <table class="table bg-white table-bordered table-hover table-centered">
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th class="bg-dark text-center text-white" style="padding: 5px !important" colspan="8"><span class="text-center">Bulk vol tracking logsheet</span></th>
                                </tr>
                                <tr>
                                    <th class="table-th child-td-lg"> Item Description</th>                    
                                    <th class="table-th child-td">Batch/Serial#</th>
                                    <th class="table-th child-td">Last accessed</th>
                                    <th class="table-th">Date&time stamp</th> 
                                    <th class="table-th">Used Amt (@{{ deductTrackUsage[0].material.unit_of_measure.name }})</th>
                                    <th class="table-th">Remain Amt (@{{ deductTrackUsage[0].material.unit_of_measure.name }})</th>
                                    <th class="table-th">Remarks</th>
                                    <th class="table-th"> <i class="text-danger bi bi-trash3-fill"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="batch in  deductTrackUsage[0].deduct_track_usage">
                                    <td>
                                        <span>
                                            @{{ batch.item_description }}
                                        </span> 
                                    </td>
                                    <td>@{{ batch.batch_serial }}</td>
                                    <td class="child-td">@{{ batch.last_accessed }}</td>
                                    <td class="child-td">@{{ batch.created_at  | date:'yyyy-MM-dd HH:mm:ss' }}</td>
                                    <td class="child-td">@{{ batch.used_amount }}</td>
                                    <td class="child-td">@{{ batch.remain_amount }}</td>
                                    <td class="child-td">@{{ batch.remarks }}</td>
                                    <td class="child-td"></td>
                                </tr>
                                <tr ng-repeat="(i,row) in deductTrackUsage">
                                    <td>
                                        <span>
                                            @{{ row.material.item_description }}
                                        </span>
                                        <input type="hidden" name="id"  value="@{{ row.id }}">
                                        <input type="hidden" name="category_selection"  value="@{{ row.material.category_selection }}">
                                    </td>
                                    <td>@{{ row.batch }} / @{{ row.serial }}</td>
                                    <td class="child-td">  {{ auth_user()->alias_name }} </td>
                                    <td class="child-td">{{ \Carbon\Carbon::now()->toDateTimeString() }}</td>
                                    <td class="child-td">
                                        <input ng-disabled="row.material.end_of_material_product == 1" name="used_value" type="number" required ng-model="used_value" ng-max="row.material.unit_packing_value" max="@{{ row.material.unit_packing_value }}" class="form-control w-50 text-center mx-auto p-0">
                                    </td>
                                    <td class="child-td">
                                        @{{ row.unit_packing_value - used_value }}
                                    </td>
                                    <td class="child-td py-0 px-1">
                                        <textarea ng-disabled="row.material.end_of_material_product == 1" name="remarks" required class="form-control h-100 w-100"></textarea>
                                    </td>
                                    <td class="child-td">
                                        <i ng-click="removeDeductTrackUsageRow(i)" class="btn btn-sm border shadow btn-light rounded-pill bi bi-x"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-flex align-items-center border-top pt-3"> 
                           
                            <div class="col-6 ms-auto text-end"> 
                                <label for="end_of_material_product" class="p-2">
                                    <input type="checkbox" ng-checked="deductTrackUsage[0].material.end_of_material_product == 1" name="end_of_material_product" value="1" class="form-check-input me-2" id="end_of_material_product"> 
                                    End of material/product
                                </label>
                                {{-- <label for="export_logsheet" class="p-2">
                                    <input type="checkbox" name="export_logsheet" value="1" class="form-check-input me-2" id="export_logsheet"> 
                                    Export Logsheet
                                </label> --}}
                                <button type="submit" ng-disabled="deductTrackUsage[0].material.end_of_material_product == 1" class="btn btn-primary h-100 rounded-pill">Click to Confirm deduction</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div ng-if="withdrawalType == 'DEDUCT_TRACK_OUTLIFE'"> 
                    <form action="{{ route('withdrawal.deduct-track-outlife') }}" method="POST">
                        @csrf 
                        <table class="table bg-white table-bordered table-centered text-center">
                            <thead>
                                <tr class="bg text-white">
                                    <th class="bg-dark text-center text-white" style="padding: 5px !important;" colspan="11"><span class="text-center">Withdrawal Cart</span></th>
                                </tr>
                                <tr class="bg-primary text-white">
                                    <th class="table-th child-td">Item description</th>
                                    <th class="table-th child-td">Brand</th>
                                    <th class="table-th child-td">Batch#/ Serial#</th>
                                    <th class="table-th child-td">Last accessed</th>
                                    <th class="table-th child-td">Date & time stamp</th>
                                    <th class="table-th child-td">Unique Barcode Label</th>
                                    <th class="table-th child-td">Pkt size</th>
                                    <th class="table-th child-td">Qty</th>
                                    <th class="table-th child-td">Remarks</th>
                                    <th class="table-th child-td">Outlife expiry from last date/time</th>
                                    <th class="table-th child-td">Outlife expiry from current date/time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="row in deductTrackOutlife[0].repack_outlife | orderBy:'$index':true" ng-if="row.draw_in == 1 && row.draw_out == 1">
                                    <td class="p-0"><small> @{{ deductTrackOutlife[0].item_description }} </small></td>
                                    <td class="p-0"><small> @{{ deductTrackOutlife[0].brand }} </small></td>
                                    <td class="p-0"><small> <small class="text-primary">@{{ deductTrackOutlife[0].batch }}</small> / <small class="text-info">@{{ deductTrackOutlife[0].serial }}</small> </small></td>
                                    <td class="p-0"><small> {{ auth_user()->alias_name }}  </small></td>
                                    <td class="p-0"><small> @{{ row.current_date_time }} </small></td>
                                    <td class="p-0"><small> @{{ deductTrackOutlife[0].barcode_number }} </small></td>
                                    <td class="p-0"><small> @{{ row.repack_size }} </small></td>
                                    <td class="p-0"><small> @{{ row.qty_cut }} </small></td>
                                    <td class="p-0 py-0 px-1">
                                        <input type="hidden" name="id[]" value="@{{ row.id }}">
                                        <textarea name="remarks[]" required class="form-control h-100 w-100">@{{ row.remarks }}</textarea>
                                    </td>
                                    <td class="child-td"><small class="text-dark">@{{ row.updated_outlife }}</small></td>
                                    <td class="child-td"><small class="text-dark">@{{ row.current_outlife_expiry }}</small></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-end ">
                            <label for="print_outlife_expiry" class="p-2">
                                <input type="checkbox" name="print_outlife_expiry" value="1" class="form-check-input me-2" id="print_outlife_expiry"> 
                                Print outlife expiry
                            </label>
                            <button class="btn btn-info rounded-pill">Confirm Deduction</button> 
                        </div>
                    </form>
                </div>
            </section>
        </div>

        {{-- ======= START : App Models ==== --}}
            @include('crm.material-products.modals.view-batch-list')
            @include('crm.material-products.modals.view-list')
            @include('crm.material-products.modals.advance-search')
            @include('crm.material-products.modals.saved-search')
            @include('crm.material-products.modals.transfer')
            @include('crm.material-products.modals.repack-transfers')
            @include('crm.material-products.modals.repack-outlife')
            @include('crm.material-products.modals.import-from-excel')
        {{-- ======= END : App Models ==== --}}
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('public/asset/css/vendors/date-picker.css') }}" />
@endsection
@section('scripts')
    <input type="hidden" id="page-name" value="{{ $page_name }}">
    <input type="hidden" id="get-material-products" value="{{ route('get-material-products') }}">
    <input type="hidden" id="delete-material-products" value="{{ route('delete-material-products') }}">
    <input type="hidden" id="delete-material-products-batch" value="{{ route('delete-material-products-batch') }}">
    <input type="hidden" id="get-save-search" value="{{ route('get-save-search') }}">
    <input type="hidden" id="get-batch-material-products" value="{{ route("get-batch-material-products") }}">
    <input type="hidden" id="get-batch" value="{{ route("get-batch") }}">
    <input type="hidden" id="get_masters" value="{{ route("get_masters") }}">
    <input type="hidden" id="transfer_batch" value="{{ route("transfer-batch") }}"> 
    <input type="hidden" id="repack_batch" value="{{ route("repack-batch") }}"> 
    <input type="hidden" id="auth-id" value="{{ Sentinel::getUser()->id }}">
    <input type="hidden" id="auth-role" value="{{ Sentinel::getUser()->roles[0]->slug }}"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('public/asset/js/vendors/daterangepicker.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script> --}}
    <script src="https://code.angularjs.org/snapshot/angular-sanitize.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-messages/1.6.4/angular-messages.js"></script>    
    <script src="{{ asset('public/asset/js/vendors/date-picker.js') }}"></script>
    <script src="{{ asset('public/asset/js/modules/RootApp.js') }}"></script>
    <script src="{{ asset('public/asset/js/controllers/RootController.js') }}"></script>
    <script src="{{ asset('public/asset/js/directives/pagePagination.js') }}"></script>
    <script src="{{ asset('public/asset/js/directives/RepackOutlife.js') }}"></script>  
    <script>
            wordMatchSuggest = (element) => {
            $.ajax({
                type    :   'GET',
                url     :   "{{ route('suggestion') }}",
                data    :  {
                    "name"  : element.name,
                    "value" : element.value,
                } ,
                success:function(response){
                    $(`#${element.list.id}`).html('')
                    if(response.data != undefined || response.data != null) {
                        Object.values(response.data).map((item) => { 
                            if(element.value !== item) {
                                $(`#${element.list.id}`).append(`<option value="${item}">`)
                            }
                        })
                    }
                }
            });
        }
    </script>
@endsection
 