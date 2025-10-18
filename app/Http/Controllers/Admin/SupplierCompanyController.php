<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use Illuminate\Http\Request;
use App\Models\SupplierCompany;
use App\Models\AuthorizedPerson;
use App\Models\ProductVariation;
use App\Models\SupplierProduct;
use Illuminate\Support\Str;

class SupplierCompanyController extends GlobalController
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function index(){

        $supplier = SupplierCompany::where('is_delete',0)->get();

        return view('admin.supplier.list',compact('supplier'));
    }

    public function create(){
        return view('admin.supplier.add');
    }

    public function store(Request $request){

        $uuid = (string) Str::uuid();

        $supplier = new SupplierCompany;
        $supplier->uuid = $uuid;
        if(isset($request->company_logo)){
            $fileName = $this->uploadImage($request->company_logo,'supplier'.$uuid);
            $supplier->company_logo = $fileName;
        }
        $supplier->company_name = $request->company_name;
        $supplier->address = $request->address;
        $supplier->state_id = $request->state_id;
        $supplier->mobile = $request->mobile_number;
        $supplier->email = $request->email_id;
        $supplier->gstn = $request->gstn;
        $supplier->iec_code = $request->iec_code;
        $supplier->pancard = $request->pan_number;
        if(isset($request->gstn_image)){
            $fileName = $this->uploadImage($request->gstn_image,'supplier/'.$uuid);
            $supplier->gstn_image = $fileName;
        }
        if(isset($request->iec_code_image)){
            $fileName = $this->uploadImage($request->iec_code_image,'supplier/'.$uuid);
            $supplier->iec_code_image = $fileName;
        }
        if(isset($request->pancard_image)){
            $fileName = $this->uploadImage($request->pancard_image,'supplier/'.$uuid);
            $supplier->pancard_image = $fileName;
        }
        $supplier->save();

        
        if(!is_null($request->authorized)){
            foreach($request->authorized as $ak => $av){
                $authorized = new AuthorizedPerson;
                $authorized->supplier_company_id = $supplier->id;
                $authorized->name = $av['name'];
                $authorized->email = $av['email'];
                $authorized->mobile = $av['mobile_number'];
                $authorized->save();
            }
        }

        if(!is_null($request->product)){
            foreach($request->product as $ak => $av){
                $product = new SupplierProduct;
                $product->supplier_company_id = $supplier->id;
                $product->product_id = $av['product_id'];
                $product->capacity = $av['capacity'];
                $product->unit = $av['unit'];
                $product->save();
            }
        }

        $route = $request->btn_value == 'save_and_update' ? 'admin.supplier.create' : 'admin.supplier.index';
        
        return redirect(route($route))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Supplier Company',
                'message' => 'Supplier Company successfully added',
            ],
        ]); 
    }

    public function edit($id){

        $detail = SupplierCompany::where('id',base64_decode($id))->with(['authorized','product' => function($q) { $q->with(['variation' => function($q) { $q->with(['product']); }]); }])->first();

        return view('admin.supplier.edit',compact('detail'));
    }

    public function update(Request $request){

        $supplier = SupplierCompany::findOrFail($request->id);
        if(isset($request->company_logo)){
            $fileName = $this->uploadImage($request->company_logo,'supplier');
            $supplier->company_logo = $fileName;
        }
        $supplier->company_name = $request->company_name;
        $supplier->address = $request->address;
        $supplier->state_id = $request->state_id;
        $supplier->mobile = $request->mobile_number;
        $supplier->email = $request->email_id;
        $supplier->gstn = $request->gstn;
        $supplier->iec_code = $request->iec_code;
        $supplier->pancard = $request->pan_number;
        if(isset($request->gstn_image)){
            $fileName = $this->uploadImage($request->gstn_image,'supplier/'.$uuid);
            $supplier->gstn_image = $fileName;
        }
        if(isset($request->iec_code_image)){
            $fileName = $this->uploadImage($request->iec_code_image,'supplier/'.$uuid);
            $supplier->iec_code_image = $fileName;
        }
        if(isset($request->pancard_image)){
            $fileName = $this->uploadImage($request->pancard_image,'supplier/'.$uuid);
            $supplier->pancard_image = $fileName;
        }
        $supplier->save();

        if(!is_null($request->authorized)){
            AuthorizedPerson::where('supplier_company_id',$request->id)->delete();
            foreach($request->authorized as $ak => $av){
                $authorized = new AuthorizedPerson;
                $authorized->supplier_company_id = $request->id;
                $authorized->name = $av['name'];
                $authorized->email = $av['email'];
                $authorized->mobile = $av['mobile_number'];
                $authorized->save();
            }
        }

        if(!is_null($request->product)){
            SupplierProduct::where('supplier_company_id',$request->id)->delete();
            foreach($request->product as $ak => $av){
                $product = new SupplierProduct;
                $product->supplier_company_id = $supplier->id;
                $product->product_id = $av['product_id'];
                $product->capacity = $av['capacity'];
                $product->unit = $av['unit'];
                $product->save();
            }
        }

        return redirect(route('admin.supplier.index'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Supplier Company',
                'message' => 'Supplier Company successfully updated',
            ],
        ]);
    }

    public function delete($id){

        $deleteInvestor = SupplierCompany::where('id',base64_decode($id))->update(['is_delete' => 1]);

        return redirect(route('admin.supplier.index'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Supplier Company',
                'message' => 'Supplier Company successfully deleted',
            ],
        ]); 
    }

    public function checkSupplierGst(Request $request){

        $query = SupplierCompany::where('gstn',$request->gstn);
        if(isset($request->id)){
            $query->where('id','!=',$request->id);
        }
        $email = $query->where('is_delete',0)->first();

        return $email ? 'false' : 'true';
    }

    public function getProductList(Request $request){

        $variation = ProductVariation::whereHas('product',function($q) use ($request){
                                         $q->where('product_type','LIKE','%'.$request->title.'%');
                                     })
                                     ->with(['product'])->get();

        $productJson = array();

        if(!is_null($variation)){
            foreach($variation as $vk => $vv){
                $productJson[$vk]['label'] = $vv->product->product_type." - ".$vv->grade;
                $productJson[$vk]['value'] = $vv->id;
                $productJson[$vk]['unit'] = $vv->unit;
            }
        }

        return $productJson;
    }

    public function getAuthorizedPerson(Request $request){

        $getAuthorizedPerson = AuthorizedPerson::where('supplier_company_id',$request->id)->get();

        return view('admin.supplier.authorized_person',compact('getAuthorizedPerson'));
    }
}
