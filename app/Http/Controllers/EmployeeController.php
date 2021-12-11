<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helper\Helper;

class EmployeeController extends Controller
{
  
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public $title = 'Employees'; 

    function index(){        
        return view('admin.employee.index',['title'=>$this->title]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches =Branch::all();        
        if($branches->count() > 0){
            return view('admin.employee.create',['title'=>$this->title,'branches'=>$branches]); 
        }else{
           return redirect('employees')->with('status', 'You must create Branch First. ');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //print_r($request->input());
        $validatedData = $request->validate([ 
            'branch_id' =>'required|numeric',         
            'name' => 'required|max:30',
            'phone' => 'required|digits_between:8,20|numeric'            
        ]);
        //validate
        $newEmployee = new User;           
        $newEmployee->branch_id = $request->branch_id;            
        $newEmployee->name = $request->name; 
        $newEmployee->username = $request->username;
        $newEmployee->password = Hash::make($request->password);
        $newEmployee->phone = $request->phone;
        $newEmployee->role = 'staff';
        $newEmployee->unit_salary = $request->unit_salary;
        if($newEmployee->save()){
            return redirect('employees')->with('status', 'Employee Created!');
        }else{
            return redirect('employees/create')->with('status', 'Something went wrong, Try Again');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
      
        $branches =Branch::all();
        
        return view('admin.employee.update',['title'=>$this->title,'employee'=>$employee,'branches'=>$branches]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([ 
            'branch_id' =>'required|numeric',         
            'name' => 'required|max:30',                  
            'phone' => 'required|digits_between:8,20|numeric'            
        ]);
        //validate

               
        $employee->branch_id = $request->branch_id;            
        $employee->name = $request->name;     
        $employee->username = $request->username;
        if($request->password!=''){
            $employee->password = Hash::make($request->password);
        }
       
        $employee->phone = $request->phone;
        $employee->unit_salary = $request->unit_salary;
        if($employee->save()){
            return redirect('employees')->with('status', 'Employee Updated!');
        }else{
            return redirect('employees/'.$employee->id.'/edit')->with('status', 'Something went wrong, Try Again');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect('employees')->with('status','Employee Deleted ! ');
    }

    public function changeEmplopyeeStatus($id){
        $user = User::find($id);
        if($user){
            $status = $user->status;
            if($status==1){
                $user->status = 0;
            }else{
                $user->status = 1;
            }
            $user->save();
        }
        return redirect('employees')->with('status','Changed ! ');
    }

    public function changeTranserMode($id){
        $user = User::find($id);
        if($user){
            $mode = $user->canTransfer;
            if($mode==1){
                $user->canTransfer = 0;
            }else{
                $user->canTransfer = 1;
            }
            $user->save();
        }
        return redirect('employees')->with('status','Changed ! ');
    }

    function getEmplopyee(){
        $employees = User::with('branch')->get();
         $employeeData =[]; 
         $i=1;       
         foreach($employees as $employee){
            $action = "<div class='btn-group'>
                        <a type='button' href='".url('employees/'.$employee->id.'/edit')."' class='btn btn-warning btn-xs mr-2'>Edit</a>
                        <form action='employees/".$employee->id."' method='post'>
                        <input type='hidden' name='_token' value='".csrf_token()."' />
                        <input type='hidden' name='_method' value='DELETE'/>
                        <button type='submit' class='btn btn-default btn-xs delete'  onClick='return askConfirm()' >Delete</button>
                        </form>
                        </div>";
               $salary = Helper::toCurrency($employee->unit_salary);
               $pstatus = "<a href='/employee/status/".$employee->id."' class='clink'>". Helper::getUserStatus($employee->status) ."</a>";
               $canTransfer =  "<a href='/employee/canTransferMode/".$employee->id."' class='clink'>". Helper::canTransfer($employee->canTransfer) ."</a>";        

                $employeeData['data'][] = array($employee->branch->name,$employee->name,$employee->phone,$employee->username,$salary,$pstatus,$canTransfer,$action);
                $i++;
         }
        return json_encode($employeeData);
    }


  //end  
}
?>