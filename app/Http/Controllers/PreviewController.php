<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreviewController extends Controller
{
    //sale receipt
    public function saleReceipt($id){
    	$data['sale'] =DB::table('sales')->find($id);
    	if($data['sale'] != null){
    	
	    	$data['cartContent'] = DB::table('saleitems')->where('sale_id',$data['sale']->id)->join('items', 'saleitems.item_id', '=', 'items.id')->get();
	        $data['payments'] = DB::table('salepayments')->where('sale_id',$data['sale']->id)->get();   	
	    	$data['salesman'] = DB::table('users')->find($data['sale']->user_id)->name;
	    	$data['branchinfo'] = DB::table('branches')->find($data['sale']->branch_id);
	        $data['config'] = DB::table('configs')->first();
	        $data['title'] = 'Sale';
	        return view('receipt',$data);
    	}else{
    		return '<h1>Data Error ! </h1>';
    	}
    }

    public function BusinessPad(Request $request){
        $data['date'] = $request->fromDate;
        $data['owner'] = $request->owner;
        $data['config'] = DB::table('configs')->first();
        $data['title'] = 'Business Pad';
        return view('pad', $data);
    }


    //end class
}
