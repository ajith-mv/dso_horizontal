<?php

namespace App\Repositories;

use App\Interfaces\MartialProductRepositoryInterface;
use App\Models\BarCodeFormat;
use App\Models\Batches;
use App\Models\DeductTrackUsage;
use App\Models\MaterialProducts;
use App\Models\RepackOutlife;
use Faker\Provider\Barcode;
use Illuminate\Support\Facades\Log;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Storage;

class MartialProductRepository implements MartialProductRepositoryInterface {

    public function save_material_product($material_product_id=null, $batch_id=null, $request) {
        $inputs = $request->except([
            '_token',
            'coc_coa_mill_cert',
            'iqc_result',
            'sds',
            'extended_qc_result',
            'disposal_certificate',
        ]);
 
        $fillable   = []; 
        foreach($inputs as $column => $row) {
            $fillable[$column] = $row;
        }
         
        $material_product       =   MaterialProducts::updateOrCreate(['id' => $material_product_id], $fillable);
        $batch                  =   $material_product->Batches()->updateOrCreate(['id' => $batch_id], $fillable); 

        if(wizard_mode() == 'create' || wizard_mode() == 'edit') {
            $batch->update(["system_stock"  => $batch->quantity]);
        }
         
        // $batch                  =   Batches::updateOrCreate(['material_product_id' => $material_product->id], $fillable);
 
        RepackOutlife::updateOrCreate(['batch_id' => $batch->id],[
            'batch_id'            => $batch->id,
            'input_repack_amount' => $batch->unit_packing_value
        ]); 

        $this->storeFiles($request, $batch);
        
        if(wizard_mode() == 'duplicate' || wizard_mode() == 'create')  {
            $request->session()->put('material_product_id', $material_product->id);
            $request->session()->put('batch_id', $batch->id);
        } 
        return Flash::success(__('global.inserted'));
    }
 
    public function storeFiles($request, $batch)
    {
        if($request->has('coc_coa_mill_cert')) {
            $multi_name = [];
            
            foreach ($request->coc_coa_mill_cert as $key => $files) {
                $OriginalName       =   $files->getClientOriginalName();
                $OriginalExtension  =   $files->getClientOriginalExtension();
                $baseName           =   basename($OriginalName, '.'.$OriginalExtension);
                $newFileName        =   $baseName.'_'.time().'.'.$OriginalExtension;
                $multi_name[$key]   =   $files->storeAs('public/files/coc_coa_mill_cert', str_replace(' ','_',$newFileName) );
            }  
            // $multi_name
            if($batch->coc_coa_mill_cert !== null) {
                foreach (json_decode($batch->coc_coa_mill_cert) as $key => $files) {
                    if(Storage::exists($files)){
                        Storage::delete($files);
                    }
                }
            }
            
            $batch  ->  coc_coa_mill_cert = json_encode($multi_name);
            $batch  ->  save();
        }
        if($request->has('iqc_result')) {
            if(Storage::exists($batch->iqc_result)){
                Storage::delete($batch->iqc_result);
            }
            $iqc_result              =   storeFiles('iqc_result');
            $batch  ->  iqc_result   =   $iqc_result;
            $batch  ->  save();
        }
        if($request->has('sds')) {
            if(Storage::exists($batch->sds)){
                Storage::delete($batch->sds);
            }
            $sds              =   storeFiles('sds');
            $batch  ->  sds   =   $sds;
            $batch  ->  save();
            // dd($batch);
        }
        if($request->has('extended_qc_result')) {
            if(Storage::exists($batch->extended_qc_result)){
                Storage::delete($batch->extended_qc_result);
            }
            $extended_qc_result              =   storeFiles('extended_qc_result');
            $batch  ->  extended_qc_result   =   $extended_qc_result;
            $batch  ->  save();
        }

        if($request->has('disposal_certificate')) {
            if(Storage::exists($batch->disposal_certificate)){
                Storage::delete($batch->disposal_certificate);
            }
            $disposal_certificate              =    storeFiles('disposal_certificate');
            $batch  ->  disposal_certificate   =    $disposal_certificate;
            $batch  ->  save();
        }
    } 
}