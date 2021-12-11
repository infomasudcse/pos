<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Helper\Helper;

class ItemController extends Controller
{
  public $title = 'Item';
   
    
    public function index()
    {
        return view('admin.item.index',['title'=>$this->title]); 
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
            return view('admin.item.create',['title'=>$this->title,'categories'=>$categories]); 
        }else{
           return redirect('items')->with('status', 'You must create a Category First. ');
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
        //print_r($request->all());
        $validatedData = $request->validate([ 
            'category_id' =>'required|numeric',
            'subcategory_id' =>'required|numeric',                     
            'name' => 'required|max:30',
            'active' =>'numeric',
            ]);
        //validate
        $item = new Item;           
        $item->category_id = $request->category_id;
        $item->subcategory_id = $request->subcategory_id;            
        $item->name = ucwords($request->name);
        $item->active = $request->active;
       
        if($item->save()){
            $status = 'A new Item has just Created!';
        }else{
            $status = 'Something went wrong, Try Again';
        }
        return redirect('items/create')->with('status',$status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $categories =Category::all(); 
        $current_cat = $categories->find($item->category_id);
        $subcategories = Subcategory::where('category_id',$item->category_id)->get();
        return view('admin.item.update',['title'=>$this->title,'item'=>$item,'categories'=>$categories,'current_cat'=>$current_cat,'subcategories'=>$subcategories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //print_r($request->input());
        $validatedData = $request->validate([ 
            'category_id' =>'required|numeric',
            'subcategory_id' =>'required|numeric',                     
            'name' => 'required|max:30'
            ]);
        //validate                   
        $item->category_id = $request->category_id;
        $item->subcategory_id = $request->subcategory_id;            
        $item->name = ucwords($request->name);
               
        if($item->save()){
            return redirect('items')->with('status', ' Item Updated !');
        }else{
            return redirect('items/'.$item->id.'/edit')->with('status', 'Something went wrong, Try Again');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //inventory check
        //details check
        //media check
        $delete = true; 
        $status = '';
        $inventories = Inventory::where('item_id',$item->id)->get();
        if($inventories->count()){
            $delete = false;
            $status = 'Delete Inventory first !'; 
        }        
        if($delete){ 
            $item->delete();
            $status = 'Deleted ! ';           
         }
        return redirect('items')->with('status', $status);   
    }

    function getSuggestion($query){
        $query = Helper::cleanStr($query);
       $items = Item::where('name', 'LIKE', '%'.$query.'%')->get();
        $str = '';
        if($items->count()){ 
            foreach($items as $item){
                $str .= '<li class="list-group-item suggested-item" data-id="'.$item->id.'" >'.$item->name.'</li>';
            }         
        }
        return json_encode($str);
    }

    function getItems(){
         $items = Item::with('subcategory')->get();
         $itemData =[]; 
         $i=1;       
         foreach($items as $item){
            $action = "<div class='btn-group'>                       
                        <a href='#' type='button' title='Details' class='btn btn-sm btn-default mr-3 btn-item-table'><i class='fas fa-info-circle'></i> Details</a>
                        <a href='#' type='button' title='photo/video' class='btn btn-sm btn-default mr-3 btn-item-table'><i class='fas fa-photo-video'></i> Media</a>
                        <a href='#' type='button' title='photo/video' class='btn btn-sm btn-default mr-3 btn-item-table'><i class='fab fa-facebook-square'></i> Facebook</a>

                        <a type='button' title='Edit' href='".url('items/'.$item->id.'/edit')."' class='btn btn-sm btn-default mr-3 btn-item-table'><i class='fas fa-edit'></i> Edit</a>
                        <form action='items/".$item->id."' method='post'>
                        <input type='hidden' name='_token' value='".csrf_token()."' />
                        <input type='hidden' name='_method' value='DELETE'/>
                        <button type='submit' title='Delete' class='btn btn-default btn-sm btn-item-table delete'  onClick='return askConfirm()' ><i class='fas fa-trash'></i></button>
                        </form>
                        </div>";

                $itemData['data'][] = array($i,$item->subcategory->name,$item->name,$action);
                $i++;
         }
        return json_encode($itemData);
    }
  //end  
}
?>