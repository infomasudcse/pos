<?php



namespace App\Traits;

use Illuminate\Support\Facades\DB;

use App\Models\Sale;

use App\Models\Branch;



trait ReportTrait{

	function getItems(){
		$items = DB::table('items')->get();
		return $items;
	}

	function getSystemStatus(){
		$status = DB::table('systemstatus')->first();
		return $status;
	}

	function getBranches(){

		$branches =  Branch::all();

		return $branches;

	}

	function getConfig(){
		return DB::table('configs')->first();
	}
	function getBranchesRows(){

		$branches =  DB::table('branches')->get();

		return $branches;

	}



	function getDetailsSale($branch,$from,$to){

		$to = $to.' 23:59:59';

		$from = $from.' 00:00:01';

		$sale = Sale::with('saleitems')            	

             	->where('sales.created_at', '>',$from)

             	->where('sales.created_at', '<',$to)

             	->where('sales.branch_id',$branch)             	

             	->get();        



		return $sale;	        	

	}



	function getSummaryOfDetails($branch,$from,$to){

		$to = $to.' 23:59:59';

		$from = $from.' 00:00:01';

		$sale = DB::table('sales')					

             	->select(DB::raw('sum(subtotal) as subtotal,sum(total_sale) as totals, sum(total_item) as items, sum(total_tax) as taxs, sum(total_discount) as discounts'))

             	->where('created_at', '>',$from)

             	->where('created_at', '<',$to)

             	->where('branch_id',$branch)->get();

        return $sale;     	

	}





	function getSummarySale($branch='',$from='',$to=''){



		$to = $to.' 23:59:59';

		$from = $from.' 00:00:01';

		if($branch ==''){

			$sale = DB::table('sales')					

             	->select('branch_id',DB::raw('sum(total_sale) as total'))

             	->where('created_at', '>',$from)

             	->where('created_at', '<',$to)

             	->groupBy('branch_id');

            $data = DB::table('branches')

			    ->joinSub($sale, 'sales', function ($join) {

			            $join->on('branches.id', '=', 'sales.branch_id');

			    })->get(); 

		}else{


			$sale = DB::table('sales')					

             	->select('branch_id',DB::raw('sum(total_sale) as total'))

             	->where('created_at', '>',$from)

             	->where('created_at', '<',$to)

             	->where('branch_id',$branch)

             	->groupBy('branch_id');

            $data = DB::table('branches')

			    ->joinSub($sale, 'sales', function ($join) {

			            $join->on('branches.id', '=', 'sales.branch_id');

			    })->get(); 

		

		}
		//dd($data);

        return $data;	   

	}

	

	function getSale($date=''){

		$tot = 0.00;

		if($date=='')$date=date('Y-m-d');

		$sale = DB::table('sales')

             ->select(DB::raw('sum(total_sale) as total'))

             ->whereDate('created_at', $date)

             ->get()->first();

        $tot +=$sale->total;      

		return $tot;

	}



	function getAttendence(){

		$tot = 0.00;

		return $tot;

	}



	function getExpense(){

		$tot = 0.00;

		return $tot;

	}

	function getTransfers($from,$to,$fromBranch='',$toBranch=''){
		$to = $to.' 23:59:59';
		$from = $from.' 00:00:01';
		if($fromBranch !='' && $toBranch !=''){
			$transfer = DB::table('transfers')
				->join('inventories','transfers.sku','=','inventories.sku')
             	->select('transfers.created_at','transfers.sku','transfers.from_branch','transfers.to_branch','transfers.qty','inventories.unit_price')	
				->where('transfers.created_at', '>',$from)
             	->where('transfers.created_at', '<',$to)
             	->where('transfers.from_branch', $fromBranch)
             	->where('transfers.to_branch', $toBranch)
            	->groupBy('transfers.created_at','transfers.qty','transfers.sku','transfers.from_branch','transfers.to_branch','inventories.unit_price')				
				->get();
		}else{
			$transfer = DB::table('transfers')
				->join('inventories','transfers.sku','=','inventories.sku')
             	->select('transfers.created_at','transfers.sku','transfers.from_branch','transfers.to_branch','transfers.qty','inventories.unit_price')
				->where('transfers.created_at', '>',$from)
             	->where('transfers.created_at', '<',$to)				
				->groupBy('transfers.created_at','transfers.qty','transfers.sku','transfers.from_branch','transfers.to_branch','inventories.unit_price')				
            	->get();
        }  	
        return $transfer;    	
	}

	function getCurrentInventory($branchId,$itemId){
		if($branchId != '0' && $itemId != '0'){
			
			$inventory = DB::table('inventories')
						->where('branch_id',$branchId)
						->where('item_id',$itemId)
						->join('branches', 'inventories.branch_id', '=', 'branches.id')
           				->join('items', 'inventories.item_id', '=', 'items.id')
            			->select('inventories.*', 'branches.title', 'items.name')
						->get();
                			
		}else if($branchId == '0' && $itemId != '0'){
			$inventory = DB::table('inventories')						
						->where('item_id',$itemId)
						->join('branches', 'inventories.branch_id', '=', 'branches.id')
           				->join('items', 'inventories.item_id', '=', 'items.id')
            			->select('inventories.*', 'branches.title', 'items.name')
						->get();
						
		}else if($branchId != '0' && $itemId == '0'){

			$inventory = DB::table('inventories')
						->where('branch_id',$branchId)						
						->join('branches', 'inventories.branch_id', '=', 'branches.id')
           				->join('items', 'inventories.item_id', '=', 'items.id')
            			->select('inventories.*', 'branches.title', 'items.name')
						->get();
					
		}else{
			$inventory = DB::table('inventories')						
						->join('branches', 'inventories.branch_id', '=', 'branches.id')
           				->join('items', 'inventories.item_id', '=', 'items.id')
            			->select('inventories.*', 'branches.title', 'items.name')
						->get();
						
		}		

		return $inventory;
	}

	function getCurrentSummary($branchId,$itemId){
		if($branchId != '0' && $itemId != '0'){
			$summary  = DB::table('inventories')										
                		->select( DB::raw(" SUM(`qty`) as total_qty, sum(`cost_price`*`qty`) as total_cost, sum(`unit_price`*`qty`) as total_unit "))
                		->where('branch_id',$branchId)
						->where('item_id',$itemId)
						->where('qty','>',0)->get();
                			
		}else if($branchId == '0' && $itemId != '0'){
			$summary  = DB::table('inventories')										
                		->select( DB::raw(" SUM(`qty`) as total_qty, sum(`cost_price`*`qty`) as total_cost, sum(`unit_price`*`qty`) as total_unit "))
                		->where('item_id',$itemId)
						->where('qty','>',0)->get();
                						
		}else if($branchId != '0' && $itemId == '0'){
			$summary  = DB::table('inventories')										
                		->select( DB::raw(" SUM(`qty`) as total_qty, sum(`cost_price`*`qty`) as total_cost, sum(`unit_price`*`qty`) as total_unit "))
                		->where('branch_id',$branchId)
						->where('qty','>',0)->get();
                						
		}else{
			$summary  = DB::table('inventories')										
                		->select( DB::raw(" SUM(`qty`) as total_qty, sum(`cost_price`*`qty`) as total_cost, sum(`unit_price`*`qty`) as total_unit "))              		
						->where('qty','>',0)->get();
                						
		}		

		return $summary;
	}

	function getInventory($from, $to, $branchId){
		if($branchId === '0'){
			$inventory = DB::table('inventories')	
						->where('inventories.created_at','>',$from)	
						->where('inventories.created_at','<',$to)					
						->join('branches', 'inventories.branch_id', '=', 'branches.id')
           				->join('items', 'inventories.item_id', '=', 'items.id')
            			->select('inventories.*', 'branches.title', 'items.name')
						->get();
		}else{
			$inventory = DB::table('inventories')
						->where('inventories.branch_id',$branchId)	
						->where('inventories.created_at','>',$from)	
						->where('inventories.created_at','<',$to)					
						->join('branches', 'inventories.branch_id', '=', 'branches.id')
           				->join('items', 'inventories.item_id', '=', 'items.id')
            			->select('inventories.*', 'branches.title', 'items.name')
						->get();
		}
		return $inventory;

	}

	function getSummary($from, $to, $branchId){
		if($branchId === '0'){
			$summary  = DB::table('inventories')						
					->where('inventories.created_at','>',$from)	
					->where('inventories.created_at','<',$to)											
                	->select( DB::raw(" SUM(`qty`) as total_qty, sum(`cost_price`*`qty`) as total_cost, sum(`unit_price`*`qty`) as total_unit "))              		
					->where('qty','>',0)->get();
		}else{
			$summary  = DB::table('inventories')
					->where('inventories.branch_id',$branchId)	
					->where('inventories.created_at','>',$from)	
					->where('inventories.created_at','<',$to)											
                	->select( DB::raw(" SUM(`qty`) as total_qty, sum(`cost_price`*`qty`) as total_cost, sum(`unit_price`*`qty`) as total_unit "))              		
					->where('qty','>',0)->get();
		}
		return $summary;				
	}


//end

}

?>