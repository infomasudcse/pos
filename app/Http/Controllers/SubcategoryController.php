<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

class SubcategoryController extends Controller
{
  public $title = "Item-Settings";
  public $subtitle = "Sub Category";


    public function index()
    {   $data = ['title'=>$this->title, 'subtitle'=>$this->subtitle];
        return view('admin.subcategory.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories =Category::all();       
        if($categories->count() > 0){
            
            return view('admin.subcategory.create',['title'=>$this->title,'subtitle'=>$this->subtitle,'categories'=>$categories]); 
        }else{
           return redirect('subcategories')->with('status', 'You must create a Category First. ');
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
            'category_id' =>'required|numeric',
            'br_code'=>  'required|max:999|min:100|numeric|unique:subcategories',         
            'name' => 'required|max:30'
            ]);
        //validate
        $newSubCategory = new Subcategory;           
        $newSubCategory->category_id = $request->category_id;            
        $newSubCategory->name = ucfirst($request->name);
        $newSubCategory->br_code = $request->br_code;
       
        if($newSubCategory->save()){
            return redirect('subcategories')->with('status', 'Sub Category Created!');
        }else{
            return redirect('subcategories/create')->with('status', 'Something went wrong, Try Again');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $Subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcategory  $Subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategory $Subcategory)
    {
        $categories =Category::all();
        return view('admin.subcategory.update',['title'=>$this->title,'subtitle'=>$this->subtitle,'subcategory'=>$Subcategory,'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $Subcategory)
    {
        //print_r($request->input());
        $validatedData = $request->validate([ 
            'category_id' =>'required|numeric',
             'br_code'=>  'required|max:999|min:100|numeric',          
            'name' => 'required|max:30'
            ]);
        //validate
       // $newSubCategory = new SubCategory;           
        $Subcategory->category_id = $request->category_id;            
        $Subcategory->name = ucfirst($request->name);
        $Subcategory->br_code = $request->br_code;
       
        if($Subcategory->save()){
            return redirect('subcategories')->with('status', 'Sub Category Update!');
        }else{
            return redirect('subcategories/'.$Subcategory->id.'/edit')->with('status', 'Something went wrong, Try Again');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $Subcategory)
    {
        //check item    
        $delete = true; 
        $status = '';
        $items = Item::where('subcategory_id',$Subcategory->id)->get();
        if($items->count()){
            $delete = false;
            $status = 'Can not delete due to usage !'; 
        }        
        if($delete){ 
            $Subcategory->delete();
            $status = 'Deleted ! ';           
         }
        
        return redirect('subcategories')->with('status', $status);
    }

    function getSubCategory(){
        $subCategories = Subcategory::with('category')->get();
         $subCategoryData =[]; 
         $i=1;       
         foreach($subCategories as $subCategory){
            $action = "<div class='btn-group'>
                        <a type='button' href='".url('subcategories/'.$subCategory->id.'/edit')."' class='btn btn-warning btn-xs mr-2'>Edit</a>
                        <form class='delete-form' action='subcategories/".$subCategory->id."' method='post'>
                        <input type='hidden' name='_token' value='".csrf_token()."' />
                        <input type='hidden' name='_method' value='DELETE'/>
                        <button type='submit' onClick='return askConfirm()' class='btn btn-default btn-xs delete'>Delete</button>
                        </form>
                        </div>";

                $subCategoryData['data'][] = array($i,$subCategory->name,$subCategory->br_code,$subCategory->category->name,$action);
                $i++;
         }
        return json_encode($subCategoryData);
    }

    function getSubCategoryByCatId($id){
        $subcategories = Subcategory::where('category_id', $id)->get();
        $options = '';
        foreach($subcategories as $subcategory){
            $options.= '<option value="'.$subcategory->id.'">'.$subcategory->name.'</option>';
        }
        return $options;
    }
  //end  
}
?>