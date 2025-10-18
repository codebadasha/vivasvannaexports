<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use Illuminate\Http\Request;
use App\Models\CreditRequest;
use App\Models\CreditData;
use App\Models\CreditFinancialData;
use Auth;

class CreditController extends GlobalController
{
    public function add(){

        $creditRequest = CreditRequest::where('client_id',Auth::guard('client')->user()->id)->with(['sheet','statement'])->first();

        if(!is_null($creditRequest)){
            return view('client.credit.view_statement',compact('creditRequest'));    
        }
        
        return view('client.credit.apply');
    }

    public function store(Request $request){
        
        $credit = new CreditRequest;
        $credit->client_id = Auth::guard('client')->user()->id;
        $credit->save();

        if(!is_null($request->item)){
            foreach($request->item as $ik => $iv){
                $statement = new CreditData;
                $statement->credit_request_id = $credit->id;
                if(isset($iv['statement'])){
                    $fileName = $this->uploadImage($iv['statement'],'bank_statement');
                    $statement->bank_statement = $fileName;
                }
                $statement->bank_id = $iv['bank'];
                $statement->save();
            }
        }

        if(!is_null($request->balance)){
            foreach($request->balance as $ik => $iv){
                $balance = new CreditFinancialData;
                $balance->credit_request_id = $credit->id;
                $balance->year = $iv['label'];
                if(isset($iv['file'])){
                    $fileName = $this->uploadImage($iv['file'],'balance_sheet');
                    $balance->file = $fileName;
                }
                $balance->save();
            }
        }

        return redirect()->back()->with('messages', [
            [
                'type' => 'success',
                'title' => 'Credit',
                'message' => 'Credit application successfully submitted',
            ],
        ]); 
    }

    public function getStatement(Request $request){

        $view = view('client.credit.statement',compact('request'))->render();

        return \Response::json(['html' => $view]);
    }
}
