<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ReportTrait;
use App\Models\Branch;

class BranchreportController extends Controller
{
    use ReportTrait;
	public $title = 'Report';	

    public function index(){
    	return view('branch.report.index',['title'=>$this->title]);
    }

    public function todayDetails(){
    	$branch = auth()->user()->id;
    	$data['branchinfo'] = Branch::find($branch);
    	$date = Date('Y-m-d');
    	$data['from_to'] = $date.' / '.$date; 
    	$data['sales'] = $this->getDetailsSale($branch,$date,$date);
    	$data['summary'] = $this->getSummaryOfDetails($branch,$date,$date);
    	return view('branch.report.sale',$data);
    }

    function saleDetails(Request $request){
    	$validatedData = $request->validate([ 
            'fromDate' =>'required',
            'toDate' =>'required'            
            ]);
    	$from = $request->fromDate;
    	$to = $request->toDate;
    	$branch = auth()->user()->id;
    	$data['branchinfo'] = Branch::find($branch);
    	$data['from_to'] = $request->fromDate.' / '.$request->toDate;    	
    	$data['sales'] = $this->getDetailsSale($branch,$request->fromDate,$request->toDate); 
    	$data['summary'] = $this->getSummaryOfDetails($branch,$request->fromDate,$request->toDate);
    	return view('branch.report.sale',$data);
    }
//end class 

}

?>