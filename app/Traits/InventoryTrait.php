<?php

namespace App\Traits;

use App\Models\Trackinventory;
use App\Models\Transfer;
use App\Models\Inventory;

trait InventoryTrait {

	function SaveTrackInventory($invId,$itemId,$userId,$branchId,$sku,$qty,$comment){
		$trackitem = new Trackinventory;
        $trackitem->inventory_id = $invId;
        $trackitem->item_id = $itemId;
        $trackitem->user_id = $userId;
        $trackitem->branch_id = $branchId;
        $trackitem->sku = $sku;
        $trackitem->qty = $qty;
        $trackitem->comment = $comment;
        $trackitem->save();

	}

	function saveTransfer($sku,$from,$to,$qty,$user,$comment){
		$trans = new Transfer;
		$trans->sku = $sku;
		$trans->from_branch = $from;
		$trans->to_branch = $to;
		$trans->qty = $qty;
		$trans->user_id = $user;
		$trans->comment = $comment;
		$trans->save(); 
	}

	function transfer($inventory_id,$branch_to_id,$qty,$comment=''){
		$msg = '';
		$user = auth()->user()->id;		
		$originInventory = Inventory::find($inventory_id);
		
		if($originInventory){
			//check if from and to branch are same
			if($originInventory->branch_id != $branch_to_id){

				$remainQty = intval($originInventory->qty) - intval($qty);
				if($remainQty >= 0 ){
					//save new inventory
					// check previous inventory then create/update
					$newInventory = Inventory::where('branch_id',$branch_to_id)->where('sku',$originInventory->sku)->get()->first();
					//set a variable 
					$trackTransfer = false;
					if($newInventory){
						//update inv
						$newInventory->qty += $qty;
						$newInventory->save();
						$trackTransfer = true;
						$msg .= $newInventory->sku." - Item added to Branch.";
					}else{			
						//create new
						$Inventory = ['branch_id' => $branch_to_id,
			   				'item_id' => $originInventory->item_id,
			   				'sku' => $originInventory->sku,
			   				'variation' => $originInventory->variation,
			   				'qty' => $qty,
			   				'cost_price' => $originInventory->cost_price,
			   				'unit_price' => $originInventory->unit_price];
			   		$newInventory = Inventory::create($Inventory);
			   		$trackTransfer = true;
					$msg .= $newInventory->sku." - Item transfered to Branch .";
			   }
			   	if($newInventory){
					//update old inventory
			   		$originInventory->qty = $remainQty;
			   		$originInventory->save();
			   		//track new inventory
			   		$this->SaveTrackInventory($newInventory->id,$newInventory->item_id,$user,$newInventory->branch_id,$newInventory->sku,$qty,'Transfer-Add');
			   		//track old inventory
			   		$this->SaveTrackInventory($originInventory->id,$originInventory->item_id,$user,$originInventory->branch_id,$originInventory->sku,$qty,'Transfer-To');
			   		//save to transfer table
			   		$this->saveTransfer($newInventory->sku,$originInventory->branch_id,$newInventory->branch_id,$qty,$user,$comment);

			   	}
		   	}else{
				   $msg = 'Can not transfer more then what you have ! ';
			   }
			}else{
				$msg = 'Can not transfer to same branch ! ';
			}	
		}else{
			$msg = 'Origin of Inventory not found ! ';
		}

		return $msg;

	}

//end of trait 
}