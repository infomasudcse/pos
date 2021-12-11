<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Config;
use Illuminate\Http\Request;

class BranchController extends Controller
{
   public $title = 'Branches'; 

    function index(){ 
       // dd(Auth()->user());

        return view('admin.branch.index',['title'=>$this->title]);
    }

    function create(){
        $config = Config::find(1)->get()->first();
        $branch_limit = $config->branch_qty;
        $availableBranch = Branch::all()->count();
        $limit = intval($branch_limit) - intval($availableBranch);
        if($limit>0){
            return view('admin.branch.create',['title'=>$this->title,'status'=>'Your branch limit is '.$branch_limit.' , You can Create '.$limit.' branch.']);
        }else{          
            return redirect('branches')->with('status', 'You have reached your branch limit. ');
        }   
    }

    function store(Request $request){
          //print_r( $request->input());
          
        $validatedData = $request->validate([
            'title' => 'required|max:30',
            'name' => 'required|max:30',
            'address' => 'required|max:80',
           'phone' => 'required|digits_between:8,20|numeric',
           'discount'=>'numeric|max:1',
           'bin'=>'numeric',
           'musak'=>'numeric'
        ]);
        //validate
        $newBranch = new Branch; 
        
            $newBranch->title = $validatedData['title'];
            $newBranch->name = $validatedData['name'];
            $newBranch->address = $validatedData['address'];
            $newBranch->phone = $validatedData['phone'];
            $newBranch->bin = $validatedData['bin'];
            $newBranch->musak = $validatedData['musak'];
            $newBranch->discount = $validatedData['discount'];
            if($newBranch->save()){
                return redirect('branches')->with('status', 'Branch Created!');
            }else{
                return redirect('branches/create')->with('status', 'Something went wrong, Try Again');
            }
    }

    function edit($id){     
        //echo $id;
        $branch = Branch::where('id',$id)->get()->first();
        return view('admin.branch.update',['title'=>$this->title,'branch'=>$branch]);
    }

    function update(Request $request, $id){
        //print_r($request->input());
        //echo $id;
         $validatedData = $request->validate([
            'title' => 'required|max:30',
            'name' => 'required|max:30',
            'address' => 'required|max:80',
           'phone' => 'required|digits_between:8,20|numeric',
           'discount'=>'numeric|max:1',
           'bin'=>'numeric',
           'musak'=>'numeric'
        ]);
        //validate        
        $newBranch = Branch::find($id);

        $newBranch->title = $validatedData['title'];
            $newBranch->name = $validatedData['name'];
            $newBranch->address = $validatedData['address'];
            $newBranch->phone = $validatedData['phone'];
            $newBranch->bin = $validatedData['bin'];
            $newBranch->musak = $validatedData['musak'];
            $newBranch->discount = $validatedData['discount'];
       
        if($newBranch->save()){
            return redirect('branches')->with('status', 'Branch Updated!');
        }else{
            return redirect('branches/'.$id.'/edit')->with('status', 'Something went wrong, Try Again');
        }

    }

    function getBranch(){

        $branches = Branch::all();
         $branchData =[];        
         foreach($branches as $branch){
            $action = "<div class='btn-group'>
                        <a type='button' href='".url('branches/'.$branch->id.'/edit')."' class='btn btn-default btn-sx'>Edit</a>
                        </div>";
            $discount = (($branch->discount == 1)?'ON':'OFF');            
            $branchData['data'][] = array($branch->title,$branch->name,$branch->address,$branch->phone,$branch->musak.' / '.$branch->bin,$discount,$action);
         }
        return json_encode($branchData);
    }

     


}
