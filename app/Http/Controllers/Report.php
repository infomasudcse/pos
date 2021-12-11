<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ReportTrait;

class Report extends Controller
{
   use ReportTrait; 
 	public $title = 'Report';
    
    function home(){
    	$data['title'] = 'Index';
    	$data['sale'] = $this->getSale();
    	$data['attendence'] = $this->getAttendence();
    	$data['expense'] = $this->getExpense();
        $data['status'] = $this->getSystemStatus();
    	return view('admin.home',$data);
    }
    function index(){
    	$branches = $this->getBranches();
        $items = $this->getItems();
    	return view('admin.report.index',['title'=>$this->title,'branches'=>$branches,'items'=>$items]);
    }
    function saleDetails(Request $request){
    	//print_r($request->all());
    	//die();
    	$validatedData = $request->validate([ 
            'fromDate' =>'required',
            'toDate' =>'required',
            'branch'=>'required'
            ]);
    	$from = $request->fromDate;
    	$to = $request->toDate;
    	$data['from_to'] = $request->fromDate.' / '.$request->toDate;    	
    	$data['sales'] = $this->getDetailsSale($request->branch,$request->fromDate,$request->toDate); 
    	$data['summary'] = $this->getSummaryOfDetails($request->branch,$request->fromDate,$request->toDate);
        $data['config'] = $this->getConfig();  
    	return view('admin.report.sale.details', $data);
    }

    function saleSummary(Request $request){
    	$validatedData = $request->validate([ 
            'fromDate' =>'required',
            'toDate' =>'required'
            ]);
    	$from = $request->fromDate;
    	$to = $request->toDate;
    	$data['from_to'] = $from.' / '.$to;    	
    	$data['sales'] = $this->getSummarySale($request->branch,$from,$to);
        $data['config'] = $this->getConfig();      	
    	return view('admin.report.sale.summary', $data);
		
	}

    function todaySale(){
    	$date = Date('Y-m-d');
    	$data['from_to'] = $date.' / '.$date;    	
    	$data['sales'] = $this->getSummarySale('',$date,$date);
        $data['config'] = $this->getConfig();  
    	return view('admin.report.sale.summary', $data);
    }

    function distributeToday(){        
        $date = Date('Y-m-d');
        $data['from_to'] = $date.' / '.$date;
        $data['from_to_branch'] = '';       
        $data['transfers'] = $this->getTransfers($date,$date);
        
        $branches = $this->getBranchesRows();
        $qty = 0;
        $total = 0;        
        foreach($data['transfers'] as $key=>$val){

            foreach($branches as $branch){
                if($val->from_branch == $branch->id){
                    $data['transfers'][$key]->from_branch = $branch->name;
                }
                if($val->to_branch == $branch->id){
                    $data['transfers'][$key]->to_branch = $branch->name;
                }
            }
             $qty += intval($val->qty);
            $total += intval($val->qty) * floatval($val->unit_price);
        }
        $data['totQty'] = $qty;
        $data['totTotal'] = $total;
        $data['config'] = $this->getConfig();        
        return view('admin.report.transfer.details', $data);
    } 
    function distributeHistory(Request $request){ 
        $validatedData = $request->validate([ 
            'fromDate' =>'required',
            'toDate' =>'required',
            'frombranch'=>'required',
            'tobranch'=>'required'
            ]);
        $from = Date('Y-m-d', strtotime($request->fromDate));
        $to = Date('Y-m-d', strtotime($request->toDate));

        $data['from_to'] = $from.' / '.$to;
        $fromBranch = $request->frombranch;
        $toBranch = $request->tobranch;
        
            
        $data['transfers'] = $this->getTransfers($from,$to,$fromBranch,$toBranch);
       
        $branches = $this->getBranchesRows();
        foreach($branches as $branch){
                if($fromBranch == $branch->id){ $fromBranch = $branch->name;}
                if($toBranch == $branch->id){ $toBranch = $branch->name; }
        }         
        $data['from_to_branch'] = $fromBranch.' -->  '.$toBranch; 
        $qty = 0;
        $total = 0;      
        foreach($data['transfers'] as $key=>$val){
            $data['transfers'][$key]->from_branch = $fromBranch;
            $data['transfers'][$key]->to_branch = $toBranch;
            $qty += intval($val->qty);
            $total += intval($val->qty) * floatval($val->unit_price);
        }
        $data['totQty'] = $qty;
        $data['totTotal'] = $total;
        $data['config'] = $this->getConfig();
      
        return view('admin.report.transfer.details', $data);
    } 

    function presentInventory(Request $request){
        
        $vdata = $request->validate([ 
            'branch' =>'required',
            'item' =>'required'
            ]);
        $data['inventories'] = $this->getCurrentInventory($vdata['branch'],$vdata['item']);
        $data['summary'] = $this->getCurrentSummary($vdata['branch'],$vdata['item']);
        $data['config'] = $this->getConfig();

        return view('admin.report.inventory.details',$data);
    }

    function todayInventory(Request $request){
        $vdata = $request->validate([ 
            'branch' =>'required'
            ]);
        $to = Date('Y-m-d').' 23:59:59';
        $from = Date('Y-m-d').' 00:00:01';    
        $data['inventories'] = $this->getInventory($from, $to, $vdata['branch']);
        $data['summary'] = $this->getSummary($from, $to, $vdata['branch']);
        $data['config'] = $this->getConfig();

        return view('admin.report.inventory.details',$data);
    }



    //end
}
?>