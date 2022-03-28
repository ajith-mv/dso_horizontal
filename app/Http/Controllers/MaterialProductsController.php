<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MaterialProductsRequest;
use App\Models\Masters\MasterCategories;
use App\Models\Masters\StatutoryBody;
use App\Models\Masters\StorageRoom;
use App\Models\Masters\PackingSizeData;
use App\Models\Masters\HouseTypes;
use App\Models\Masters\Departments;
use App\Models\MaterialProducts;
use Laracasts\Flash\Flash;
use Storage;
use Illuminate\Http\Response;

use App\Interfaces\MartialProductRepositoryInterface;

class MaterialProductsController extends Controller
{
    private   $MartialProductRepository;

    public function __construct(MartialProductRepositoryInterface $MartialProductRepository) 
    {
        $this->MartialProductRepository = $MartialProductRepository;
    }

    public function index(Request $request)
    {
        if($request->filters) {
            $material_product       =  MaterialProducts::where('barcode_number', 'LIKE', "%{$request->filters}%")->get();
            return response(['status' => true, 'data' => $material_product], Response::HTTP_OK);
        }
        if($request->bulk_search) {

            $bulk_search = (object) $request->bulk_search;
            
            $material_product = MaterialProducts::orWhere('item_description' , $bulk_search->item_description)
                                                ->orWhere('brand', $bulk_search->brand)
                                                ->orWhere('department', $bulk_search->dept)
                                                ->orWhere('storage_room', $bulk_search->storage_area)
                                                ->orWhere('date_in', $bulk_search->date_in)
                                                ->get();

            return response(['status' => true, 'data' => $material_product], Response::HTTP_OK);
        }
        $material_product       =   MaterialProducts::latest()->get();
        return response(['status' => true, 'data' => $material_product], Response::HTTP_OK);
    }

    public function list_index()
    {
        $storage_room_db    =   StorageRoom::all();
        $departments_db     =   Departments::all();
        return view('crm.material-products.list', compact('storage_room_db','departments_db'));  
    }

    public function change_product_category(Request $request)
    {
        $request->session()->put('category_type', $request->type);
         
        return response(['status' => true, 'message' => trans('Category to be changed !')], Response::HTTP_OK);
    }

    public function form_one_index(Request $request)
    {
        $material_product       =   MaterialProducts::find(entry_id());
        $category_selection_db  =   MasterCategories::pluck('name','id');
        $statutory_body_db      =   StatutoryBody::pluck('name','id');
        $unit_packing_size_db   =   PackingSizeData::pluck('name','id');
        $euc_material_db        =   ['Yes', 'No'];
        $edit_mode  = false;

        return view('crm.material-products.wizard.mandatory-one', compact([
            'category_selection_db',
            'statutory_body_db',
            'unit_packing_size_db',
            'material_product',
            'euc_material_db',
            'edit_mode'
        ]));
    }
    public function form_one_store(MaterialProductsRequest $request)
    {    
        $material_product = MaterialProducts::updateOrCreate([
            'category_selection'            =>   $request->session()->get('category_type'),
            'barcode_number'                =>   random_int(100000, 999999),
            'item_description'              =>   $request->item_description,
            'in_house_product_logsheet_id'  =>   $request->in_house_product_logsheet_id,
            'brand'                         =>   $request->brand,
            'supplier'                      =>   $request->supplier,
            'unit_packing_size'             =>   $request->unit_packing_size,
            'quantity'                      =>   $request->quantity,
            'batch'                         =>   $request->batch,
            'serial'                        =>   $request->serial,
            'po_number'                     =>   $request->po_number,
            'statutory_body'                =>   $request->statutory_body,
            'euc_material'                  =>   $request->euc_material,
        ]);
        
        $request->session()->put('material_product_id', $material_product->id);
         
        Flash::success(__('global.inserted'));

        return redirect()->route('mandatory-form-two');
    }
    public function form_two_index(Request $request)
    {
        $material_product   =   MaterialProducts::find(entry_id()); 
        $storage_room_db    =   StorageRoom::pluck('name','id');
        $house_type_db      =   HouseTypes::pluck('name','id');
        $departments_db     =   Departments::pluck('name','id');
        $iqc_status         =   ["Pass", "Fail"];

        return view('crm.material-products.wizard.mandatory-two', compact([
            'storage_room_db',
            'house_type_db',
            'departments_db',
            'material_product',
            'iqc_status'
        ]));
    }
    public function form_two_store(Request $request)
    {
        $result =  $this->MartialProductRepository->update_form_two(entry_id(), $request);         
        Flash::success(__('global.inserted'));
        return redirect()->route('non-mandatory-form');
    }
    public function non_mandatory_form_index(Request $request)
    { 
        $material_product       =   MaterialProducts::find(entry_id());
        $extended_qc_status     =   ['Pass','Fail'];

        return view('crm.material-products.wizard.non-mandatory', compact('extended_qc_status','material_product'));  
    }
    public function non_mandatory_form_store(Request $request)
    {         
        $result  =   $this->MartialProductRepository->update_form_three(entry_id(), $request);
        Flash::success(__('dso.material_products_created'));
        return redirect()->route('list-material-products');
    } 
    // Edit Function
    public function edit_form_one(Request $request, $id=null)
    {
        $material_product       =   MaterialProducts::findOrFail($id);
        $category_selection_db  =   MasterCategories::pluck('name','id');
        $statutory_body_db      =   StatutoryBody::pluck('name','id');
        $unit_packing_size_db   =   PackingSizeData::pluck('name','id');
        $euc_material_db        =   ['Yes', 'No'];
        $edit_mode  = true;

        return view('crm.material-products.edit-wizard.mandatory-one', compact([
            'category_selection_db',
            'statutory_body_db',
            'unit_packing_size_db',
            'material_product',
            'euc_material_db',
            'edit_mode'
        ]));
    }
    public function update_edit_form_one(Request $request, $id=null)
    {
        $result  =   $this->MartialProductRepository->update_form_one($id, $request);
        Flash::success(__('global.updated'));
        return redirect()->route('material-product.edit-form-two', $id);
    }
    public function edit_form_two(Request $request, $id=null)
    {
        $material_product =  MaterialProducts::findOrFail($id);
        $storage_room_db  =  StorageRoom::pluck('name','id');
        $house_type_db    =  HouseTypes::pluck('name','id');
        $departments_db   =  Departments::pluck('name','id');
        $iqc_status       =  ["Pass", "Fail"];
        $edit_mode        =  true;

        return view('crm.material-products.edit-wizard.mandatory-two', compact([
            'storage_room_db',
            'house_type_db',
            'departments_db',
            'material_product',
            'iqc_status',
            'edit_mode'
        ]));
    }
    public function update_edit_form_two(Request $request, $id=null)
    {
        $result  =   $this->MartialProductRepository->update_form_two($id, $request);
        Flash::success(__('global.inserted'));
        return redirect()->route('material-product.edit-form-three', $id);
    }
    public function edit_form_three(Request $request, $id=null)
    {
        $material_product       =   MaterialProducts::findOrFail($id);
        $extended_qc_status     =   ['Pass','Fail'];
        return view('crm.material-products.edit-wizard.non-mandatory', compact('extended_qc_status','material_product'));  
    }
    public function update_edit_form_three(Request $request, $id=null)
    {
        $result  =   $this->MartialProductRepository->update_form_three($id, $request);
        Flash::success(__('dso.material_products_created'));
        return redirect()->route('list-material-products');
    }

    public function destroy(Request $request, $id)
    {
        $data   =   MaterialProducts::find($id);
        if(Storage::exists($data->sds_mill_cert_document)){
            Storage::delete($data->sds_mill_cert_document);
        }
        if(Storage::exists($data->coc_coa_mill_cert_document)){
            Storage::delete($data->coc_coa_mill_cert_document);
        }
        if(Storage::exists($data->iqc_result)){
            Storage::delete($data->iqc_result);
        }
        if(Storage::exists($data->upload_disposal_certificate)){
            Storage::delete($data->upload_disposal_certificate);
        }
        if(Storage::exists($data->extended_qc_result)){
            Storage::delete($data->extended_qc_result);
        }
        $data->delete();
        return response(['status' => true,  'message' => trans('response.delete')], Response::HTTP_OK);
    }
}