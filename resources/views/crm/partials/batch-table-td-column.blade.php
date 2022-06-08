<div class="box" ng-show="on_item_description"></div>   
 
@foreach ($tableAllColumns as $column) 
    <div ng-if="on_{{ $column['name'] }}" class="box">
        @if ($column['name']=="iqc_status")
            <small class="badge bg-success rounded-pill">PASS</small>
            @elseif($column['name']=="date_of_expiry")
                {{ $column['batch'] }}
                <i class="ms-1 text-{{ $column['name']  == 1 ? "success" : "danger"}} dot-sm bi bi-circle-fill"></i>
            @elseif($column['name']=="used_for_td_expt_only")
                - 
            @else
                {!! $column['batch'] !!}
        @endif
    </div>
@endforeach

 

<div class="box d-flex align-items-center  border-start {{ $page_name !== 'PRINT_BARCODE_LABEL'  ? "box-sm" : null}}" >
    <div class="d-flex align-items-center justify-content-between">
        <div class="dropdown mx-1">
            <a class="ropdown-toggle text-secondary"  id="topnav-dashboards" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bi bi-three-dots"></i>
            </a> 
            <div class="dropdown-menu"  > 
                @if ($page_name === 'MATERIAL_SEARCH_OR_ADD')
                        <a class="dropdown-item text-secondary"  ng-click="view_batch_details(row, batch)"><i class="bi bi-eye"></i> View batch details</a>
                        <a class="dropdown-item text-secondary"  ng-click="editOrDuplicate('duplicate',row.id, batch.id)"><i class="bi bi-back me-1"></i>Duplicate batch</a>
                        <a class="dropdown-item text-secondary"  ng-click="editOrDuplicate('edit',row.id, batch.id)"><i class="bi bi-pencil-square me-1"></i>Edit batch</a>
                        <a class="dropdown-item text-secondary"  ng-click="Transfers(batch.id)"><i class="bi bi-arrows-move me-1"></i>Transfer</a>

                        {{--  ==== REPACK OUTLIFE ====  --}}
                            <a ng-if="batch.require_outlife_tracking ==  1" class="dropdown-item text-secondary" ng-click="RepackTransfers('view',batch , row)">
                                <i class="bi bi-box-seam me-1"></i>Repack/Transfer 
                            </a>
                            <a ng-if="batch.require_outlife_tracking ==  0 || batch.require_outlife_tracking ===  null" class="dropdown-item text-secondary link-disabled">
                                <i class="bi bi-box-seam me-1"></i>Repack/Transfer 
                            </a>
                        {{--  ==== REPACK OUTLIFE ====  --}}

                        {{--  ==== REPACK OUTLIFE ====  --}}
                            <a ng-if="batch.require_outlife_tracking ==  1" class="dropdown-item text-secondary"  data-bs-toggle="modal" data-bs-target="#RepackOutlife">
                                <i class="bi bi-box2-fill me-1"></i>Repack/outlife
                            </a>
                            <a ng-if="batch.require_outlife_tracking ==  0 || batch.require_outlife_tracking ===  null" class="dropdown-item link-disabled">
                                <i class="bi bi-box2-fill me-1"></i>Repack/outlife
                            </a>
                        {{--  ==== REPACK OUTLIFE ====  --}}

                        <a class="dropdown-item text-secondary" onclick="printModal()" ><i class="bi bi-upc-scan me-1"></i>Print Barcode/Label</a>
                        <a class="dropdown-item text-danger" ng-click="delete_batch_material_product(batch.id)" href="javascript:void(0)"><i class="bi bi-trash3-fill me-1"></i> Delete batch</a> 
                    @elseif ($page_name === 'PRINT_BARCODE_LABEL')
                    <a class="dropdown-item text-secondary"  ng-click="view_batch_details(row, batch)"><i class="bi bi-eye"></i> View batch details</a>
                @endif 
            </div>
        </div>
        @if ($page_name === 'PRINT_BARCODE_LABEL')
            <div class="btn-group">
                <input type="number" class="btn ps-1 pe-0 bg-white btn-sm custom_number_input" value="1" min="1" max="3">
                <button class="btn btn-light btn-sm "><i class="fa fa-print"></i></button>
            </div>
        @endif
    </div>
</div>