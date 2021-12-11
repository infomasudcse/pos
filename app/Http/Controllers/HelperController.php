<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Models\Inventory;
use App\Traits\InventoryTrait;
use DNS1D;

class HelperController extends Controller
{
   use InventoryTrait;
	function printBarcode(Request $request){
		$data['title']='Inventory';
		//print_r($request->all());
		$validatedData = $request->validate([            
            'sku' =>'required|numeric',                     
            'qty' => 'required|numeric',
            'data_inv'=>'required|numeric'
            ]);
		//get config data
		//get inventori data with item
		$data['qty'] = $validatedData['qty'];
		$data['configs'] = DB::table('configs')->get()->first();
 		$data['inv'] = DB::table('inventories')
            ->where('inventories.id', '=', $validatedData['data_inv'])
            ->join('items', 'items.id', '=', 'inventories.item_id')            
            ->select('inventories.*','items.name')
            ->get()->first();
        //load view    
		return view('admin.barcode',$data);
		
	}

	function setBranchForTransfer(Request $request){
		$validatedData = $request->validate([            
            'from_branch' =>'required|different:to_branch',
            'to_branch' =>'required|',
            'from_branch_name' =>'required',
            'to_branch_name' =>'required'
        ]);
       // $branch = DB::table('branches')->find($validatedData['branch_id']);
		$request->session()->put('branch_for_transfer', ['from_branch_id'=>$validatedData['from_branch'],'from_branch_name'=>$validatedData['from_branch_name'],'to_branch_id'=>$validatedData['to_branch'],'to_branch_name'=>$validatedData['to_branch_name']]);
		return redirect('/inventory/massDistribute');
	}
	function startOverDistribute(){
		$this->unselectBranch();
		$this->forgetItemToDistribute();
		return redirect('/inventory/massDistribute');
	}
	function unselectBranch(){
		session()->pull('branch_for_transfer');
	}
	function forgetItemToDistribute(){
		session()->pull('adminTrans');
	}

	function addToAdminTransfer(Request $request){
		$validatedData = $request->validate([            
            'sku' =>'required'
        ]);
        $status = '';
        if($request->session()->has('branch_for_transfer')){
        	$from_branch_id = $request->session()->get('branch_for_transfer')['from_branch_id']; 
        	$sku = $validatedData['sku'];
        	//get Inventory
        	$inventory = DB::table('inventories')->where('branch_id', $from_branch_id)->where('sku',$sku)->where('qty','>',0)->get()->first();

        	if($inventory){
        		$origin_qty = $inventory->qty;
	        	//print_r($inventory);
	        	//die();
	        	if($request->session()->has('adminTrans')){
	        		$setItems = $request->session()->get('adminTrans');
	        		$key = array_search($validatedData['sku'], array_column($setItems, 'sku'));
		        	//print_r($key);
		        	
		        	if($key>-1){
		        		
		        		if($origin_qty > $setItems[$key]['qty']){
		        			$setItems[$key]['qty'] += 1;
		        			$request->session()->pull('adminTrans');	        			
		        			$request->session()->put('adminTrans', $setItems);
		        		}else{
		        			
		        			$status = 'Check Quantity ! ';
		        		}
		        	}else{
		        		$items = ['sku'=>$validatedData['sku'],'qty'=>1,'id'=>$inventory->id];
						$request->session()->push('adminTrans', $items);
		        	}

	        	}else{
	        		$items = ['sku'=>$validatedData['sku'],'qty'=>1,'id'=>$inventory->id];
					$request->session()->push('adminTrans', $items);
	        	}
        	}else{ $status = 'Check Inventory ! ';}

        }else{ $status = 'Set Branch First  ! ';}
		
        return redirect('/inventory/massDistribute')->with('status',$status);

	}

	function startMassDistribute(Request $request){
		$setItems = $request->session()->get('adminTrans');
		$branchData = $request->session()->get('branch_for_transfer');
		
		$to_branch_id = $branchData['to_branch_id'];
		//get inventory
		$sum = 0;
		
		if(count($setItems) > 0){
			foreach($setItems as $invItem){

				$this->transfer($invItem['id'],$to_branch_id,$invItem['qty'],'Mass-Tranfer');
				$sum += $invItem['qty'];
			}
		}
		$status = $sum.' Items should be transferred ! ';
		$this->unselectBranch();
		$this->forgetItemToDistribute();
		
		return redirect('inventories')->with('status', $status);
	}

	


	function transferTo(Request $request){

		//print_r($request->all());
		$validatedData = $request->validate([            
            'data_origin_inv' =>'required|numeric',                     
            'qty' => 'required|numeric|min:1',
            'tobranch'=>'required'
            ]);
		
		$status = $this->transfer($validatedData['data_origin_inv'],$validatedData['tobranch'],$validatedData['qty'],'Single-Transfer');	
		
			
		return redirect('inventories')->with('status',$status);
	}


    //csrf 
	function getCSRF(){
		return csrf_token();
	}


    //end
}
?>