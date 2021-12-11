<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use App\Traits\InventoryTrait;

class BranchTransferController extends Controller
{
     use InventoryTrait;

    public function index(){
    	$fromBranch = Branch:: find( auth()->user()->branch_id );
    	$toBranch = Branch:: find(1);
    	$data['fromBranch'] = $fromBranch->title;
    	$data['toBranch'] = $toBranch->title;
    	$setItems = session()->get('branchTrans');
    	$data['itemCount'] = $setItems ? count($setItems): 0;
    	return view('branch.transfer.index', $data);
    }

    public function startOverTransfer(){
		$this->forgetItemToDistribute();
		return redirect('/branchTransfer')->with('status','You can start Again !');
	}
	function forgetItemToDistribute(){
		session()->pull('branchTrans');
	}

	public function startMassTransfer(Request $request){
		$setItems = $request->session()->get('branchTrans');		
		$to_branch_id = 1;
		//get inventory
		$sum = 0;		
		if(count($setItems) > 0){
			foreach($setItems as $invItem){

				$this->transfer($invItem['id'],$to_branch_id,$invItem['qty'],'Branch Tranfer');
				$sum += $invItem['qty'];
			}
		}
		$status = $sum.' Items should be transferred ! ';
		
		$this->forgetItemToDistribute();
		
		return redirect('/branchTransfer')->with('status',$status);
	}

    public function addTo(Request $request){
    	$validatedData = $request->validate([            
            'sku' =>'required'
        ]);
        $status = '';
    	$from_branch_id = auth()->user()->branch_id; 
        $sku = $validatedData['sku'];
        //get Inventory
        $inventory = DB::table('inventories')->where('branch_id', $from_branch_id)->where('sku',$sku)->where('qty','>',0)->get()->first();

        	if($inventory){
        		$origin_qty = $inventory->qty;	        	
	        	if($request->session()->has('branchTrans')){
	        		$setItems = $request->session()->get('branchTrans');
	        		$key = array_search($validatedData['sku'], array_column($setItems, 'sku'));
		        	//print_r($key);		        	
		        	if($key>-1){		        		
		        		if($origin_qty > $setItems[$key]['qty']){
		        			$setItems[$key]['qty'] += 1;
		        			$request->session()->pull('branchTrans');	        			
		        			$request->session()->put('branchTrans', $setItems);
		        		}else{		        			
		        			$status = 'Check Quantity ! ';		        		}
		        	}else{
		        		$items = ['sku'=>$sku,'qty'=>1,'id'=>$inventory->id];
						$request->session()->push('branchTrans', $items);
		        	}
	        	}else{
	        		$items = ['sku'=>$sku,'qty'=>1,'id'=>$inventory->id];
					$request->session()->push('branchTrans', $items);
	        	}
        	}else{ $status = 'Check Inventory ! ';}
         return redirect('/branchTransfer')->with('status',$status);	
    }


//end class
}