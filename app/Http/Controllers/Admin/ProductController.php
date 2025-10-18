<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\GlobalController;
use App\Models\Product;
use App\Models\ProductVariation;

class ProductController extends GlobalController
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function index(){

        $product = Product::where('is_delete',0)->get();

        return view('admin.product.list',compact('product'));
    }

    public function create(){
        return view('admin.product.add');
    }

    public function store(Request $request){

        $product = new Product;
        $product->product_type = $request->product_type;
        $product->gst = $request->gst;
        $product->save();

        if(isset($request->variation)){
            foreach($request->variation as $vk => $vv){
                $variation = new ProductVariation;
                $variation->product_id = $product->id;
                $variation->grade = $vv['grade'];
                $variation->hsn_code = $vv['hsn_code'];
                $variation->unit = implode(',',$vv['unit']);
                $variation->remarks = $vv['remark'];
                $variation->save();
            }
        }

        $route = $request->btn_value == 'save_and_update' ? 'admin.product.create' : 'admin.product.index';
        
        return redirect(route($route))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Product',
                'message' => 'Product successfully created',
            ],
        ]);
    }

    public function edit($id){

        $detail = Product::where('id',base64_decode($id))->with(['variation'])->first();

        return view('admin.product.edit',compact('detail'));
    }

    public function update(Request $request){

        $product = Product::findOrFail($request->id);
        $product->product_type = $request->product_type;
        $product->gst = $request->gst;
        $product->save();

        $variationId = [];
        if(isset($request->variation)){
            foreach($request->variation as $vk => $vv){
                $variation = isset($vv['variation_id']) ? ProductVariation::findOrFail($vv['variation_id']) : new ProductVariation;
                $variation->product_id = $request->id;
                $variation->grade = $vv['grade'];
                $variation->unit = implode(',',$vv['unit']);
                $variation->remarks = $vv['remark'];
                $variation->save();

                $variationId[] = $variation->id;
            }
        }

        ProductVariation::where('product_id',$request->id)->whereNotIn('id',$variationId)->delete();


        return redirect(route('admin.product.index'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Product',
                'message' => 'Product successfully updated',
            ],
        ]);
    }

    public function delete($id){

        $deleteProduct = Product::where('id',base64_decode($id))->update(['is_delete' => 1]);

        return redirect(route('admin.product.index'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Product',
                'message' => 'Product successfully deleted',
            ],
        ]);
    }

    public function checkProductName(Request $request){

        $query = Product::where('product_type',$request->product_type);
        if(isset($request->id)){
            $query->where('id','!=',$request->id);
        }
        $email = $query->where('is_delete',0)->first();

        return $email ? 'false' : 'true';
    }
}
