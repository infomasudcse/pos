<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{
    public $title = 'Configuration';    
    public $subtitle = "Config";

    function index(){
        $config = Config::where('id',1)->first();
        
        return view('admin.config',['cf' => $config,'title'=>$this->title,'subtitle'=>$this->subtitle]);
    }

    function changeState(){
        $status = DB::table('systemstatus')->first();
        if($status){
            $currentStatus = $status->status;
            if($currentStatus=='on'){
                DB::table('users')->where('role','staff')->update(['status' => 0]);
                 DB::table('systemstatus')->where('id', 1)->update(['status' => 'off']);
            }else{
                 DB::table('users')->where('role','staff')->update(['status' => 1]);
                 DB::table('systemstatus')->where('id', 1)->update(['status' => 'on']);
            }
        }
        return redirect('dashboard');
    }

    function store(Request $request){
       // print_r( $request->input());
        $validatedData = $request->validate([
            'business_name' => 'required|max:30',
            'slogan' => 'required|max:50',
            'owner_name' => 'required|max:50',
            'address' => 'required|max:50',
            'contact' => 'required|max:50'
        ]);
        //validate
        $newConfig = [
            'business_name'=>$request->input('business_name'),
            'slogan'=>$request->input('slogan'),
            'owner_name'=>$request->input('owner_name'),
            'address'=>$request->input('address'),
            'contact'=>$request->input('contact'),
            'return_policy'=>$request->input('return_policy'),
            'default_tax_name'=>$request->input('default_tax_name'),
            'default_tax'=>$request->input('default_tax'),
            'email'=>$request->input('email')
            ];
        $res = Config::where('id', 1)->update($newConfig);    
         
        return redirect('configs')->with('status', 'Configuration Updated!');


    }    

    //end
}

?>