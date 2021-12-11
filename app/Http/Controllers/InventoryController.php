<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Inventory;
use App\Models\Variation;
use App\Models\Variationval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Skucounter;
use App\Traits\InventoryTrait;
use App\Helper\Helper;

class InventoryController extends Controller
{
  use InventoryTrait;
    public $title = "Inventory";

    public function index()
    {
        $inventories = Inventory::with('item','branch')->orderBy('id', 'desc')->simplePaginate(10);
        $branches = Branch::all();
        return view('admin.inventori.index',['inventories'=>$inventories,'branches'=>$branches,'title'=>$this->title]); 
    }

    public function create()
    {
        $branches =Branch::orderBy('id','asc')->get(); 
        
        $variations = Variation::all();       
        $varyData = array();
        foreach($variations as $variation){
            $varyData[]= ['v_id'=>$variation->id,
                          'v_name'=>$variation->name,
                          'variationvals' => Variationval::where('variation_id', $variation->id)->get()];
        }       
        return view('admin.inventori.create',[
            'title'=>$this->title,
            'branches'=>$branches,
            'variations'=>$varyData
        ]); 
        
    }
    public function store(Request $request)
    {   
        $validatedData = $request->validate([ 
            'product_id' =>'required|numeric',
            'branch_id' =>'required|numeric',                     
            'qty' => 'required|numeric',
            'costp' =>'required|numeric',
            'salep' =>'required|numeric',
            ]);
        $variation_json = array();
        if($request->vaval_id !=''){
            $variation_ids = array_filter($request->vaval_id);
            
            foreach($variation_ids as $key=>$val){
                $variationData = Variationval::where('id',$val)->with('variation')->first();
                $variation_json[]  = array('vvid'=> $variationData->id,'variation'=>$variationData->variation->name, 'value'=>$variationData->value); 
            }
        }
        //the join query find category and subcategory br code to create sku

        $cods = DB::table('items')
            ->where('items.id', '=', $request->product_id)
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->join('subcategories', 'items.subcategory_id', '=', 'subcategories.id')
            ->select('categories.br_code as br_cat', 'subcategories.br_code as br_sub')
            ->get()->first();
       
        //check last sku 
        $counter=0;    
        $last_sku =  DB::table('skucounters')->latest('id')->first();       
        if($last_sku){
            $counter = intval( trim($last_sku->skus));
            $counter++;         
        }else{
            $counter = 11;
        }
        
        //make sku
        $sku = $cods->br_cat.$cods->br_sub.$counter;
    
        $inventory = [
           'branch_id' => $request->branch_id,
           'item_id' => $request->product_id,
           'sku' => $sku,
           'variation' => json_encode($variation_json),
           'qty' => $request->qty,
           'cost_price' => $request->costp,
           'unit_price' => $request->salep
        ];
        $newInventory = Inventory::create($inventory);
        if($newInventory){
            //trak inventory 

            $this->SaveTrackInventory($newInventory->id,$newInventory->item_id,auth()->user()->id,$newInventory->branch_id,$newInventory->sku,$newInventory->qty,'Manual Add');
            
            //update sku counter 
            $skucounters = new Skucounter;
            $skucounters->skus = $counter;
            $skucounters->save();           
            $status = $newInventory->sku.' Inventory Saved! ';
        }else{
            $status = 'Something went wrong, Try Again';
        }
        return redirect('inventories/create')->with('status',$status);
        //return view('admin.item.index',['title'=>$this->title]); 
    }
    public function edit(Inventory $inventory)
    {
        $branches =Branch::all(); 
        $variations = Variation::all();       
        $varyData = array();
        foreach($variations as $variation){
            $varyData[]= ['v_id'=>$variation->id,
                          'v_name'=>$variation->name,
                          'variationvals' => Variationval::where('variation_id', $variation->id)->get()];
        } 
        return view('admin.inventori.update',[
            'title'=>$this->title,
            'inventory'=>$inventory,
            'branches'=>$branches,
            'variations'=>$varyData]); 
    }
    public function update(Request $request, Inventory $inventory)
    {
        //print_r($request->input()) ;
        $validatedData = $request->validate([             
            'branch_id' =>'required|numeric',                     
            'qty' => 'required|numeric',
            'costp' =>'required|numeric',
            'salep' =>'required|numeric',
            ]);
        if($request->vaval_id !=''){
            $variation_ids = array_filter($request->vaval_id);
            if(!empty($variation_ids)){
                $variation_json = array();
                foreach($variation_ids as $key=>$val){
                    $variationData = Variationval::where('id',$val)->with('variation')->first();
                    $variation_json[]  = array('vvid'=> $variationData->id,'variation'=>$variationData->variation->name, 'value'=>$variationData->value); 
                }

                $inventory->variation = json_encode($variation_json);
            }
        }

        $inventory->branch_id = $request->branch_id;    
        $inventory->qty = $request->qty;
        $inventory->cost_price = $request->costp;
        $inventory->unit_price = $request->salep;
        if($inventory->save()){
            return redirect('inventories')->with('status', 'Inventory Updated!');
        }else{
            return redirect('inventories/'.$inventory->$id.'/edit')->with('status', 'Something went wrong, Try Again');
        }       

    }
    public function destroy(Inventory $inventory)
    {
        if($inventory->delete()){
            return redirect('inventories')->with('status', 'Deleted ! ');
        }
    }

    public function getInventory()
    {
        $inventories = Inventory::with('item','branch')->get();
         $inventoryData =[]; 
         $i=1;       
         foreach($inventories as $inventory){
            $variations = json_decode($inventory->variation);
            $str ='';
            foreach($variations as $vary){
                $str .= $vary->variation.':'.$vary->value.', ';
            }

            $action = "<div class='btn-group'>
                        <a type='button' title='Edit' href='".url('inventories/'.$inventory->id.'/edit')."' class='btn btn-sm btn-default mr-3 btn-item-table'><i class='fas fa-edit'></i></a>
                        <form action='inventories/".$inventory->id."' method='post'>
                        <input type='hidden' name='_token' value='".csrf_token()."' />
                        <input type='hidden' name='_method' value='DELETE'/>
                        <button type='submit' title='Delete' class='btn btn-default btn-sm btn-item-table delete'  onClick='return askConfirm()' ><i class='fas fa-trash'></i></button>
                        </form>
                        </div>";

                $inventoryData['data'][] = array($i,$inventory->sku,$inventory->item->name,$inventory->qty,$inventory->branch->name,$inventory->cost_price,$inventory->unit_price,$str,$action);
                $i++;
         }
        return json_encode($inventoryData);
    }


    function massDistribute(){
         $branches = DB::table('branches')->get();
        return view('admin.inventori.distribute',['title'=>$this->title,'branches'=>$branches]);
    }

     function searchSku($query){
        $query = Helper::cleanStr($query);
       $items = Inventory::where('sku', 'LIKE', '%'.$query.'%')->get();
        $str = '';
        if($items->count()){ 
            foreach($items as $item){
                $str .= '<li class="list-group-item suggested-sku" data-id="'.$item->id.'" >'.$item->sku.'</li>';
            }         
        }
        return json_encode($str);
    }

    function getInventoryById($id){
        $inventories = Inventory::where('id',$id)->with('item','branch')->get();
         $inventoryData =[]; 
         $html = ''; 

         foreach($inventories as $inventory){
            $variations = json_decode($inventory->variation);
            $str ='';
            foreach($variations as $vary){
                $str .= $vary->variation.':'.$vary->value.', ';
            }
            $html .= "<tr class='bg-gray'>";
            $html .= "<td>#</td><td>". $inventory->sku ."</td>
                    <td>". $inventory->item->name ."</td>
                    <td>". $inventory->qty ." </td>
                    <td>". $inventory->branch->name ." </td>
                    <td>". Helper::toCurrency($inventory->cost_price) ."</td>
                    <td>". Helper::toCurrency($inventory->unit_price) ." </td>
                    <td>". $str ." </td>";
                       
            $bc = '<span  data-toggle="modal" data-target="#inventoryModal" data-inv="'.$inventory->id.'" data-whatever="'.$inventory->sku.'" data-qty="'.$inventory->qty.'" class="btn mr-2 btn-default btn-sm btn-item-table" title="print Barcode" data-location="'. url('HelperController/getCSRF') .'"><i class="fas fa-barcode"></i></span>';
            $tr = '<span  data-toggle="modal" data-target="#transferModal" data-origin_inv_id="'. $inventory->id .'" data-origin-code="'. $inventory->sku .'" data-origin-branch="'. $inventory->branch->name .'" data-origin-qty="'.$inventory->qty .'" class="btn mr-2 btn-default btn-sm btn-item-table" title="Transfer to another branch"  data-location="'. url('HelperController/getCSRF') .'"><i class="fas fa-share-square"></i></span>';


            $edt = '<a type="button" title="Edit" href="'. url('inventories/'.$inventory->id.'/edit').'" class="btn btn-sm btn-default mr-2 btn-item-table"><i class="fas fa-edit"></i></a>';

            $del = '<form action="'. url('inventories/'. $inventory->id.'') .'" method="post">
                                <input type="hidden" name="_token" value="'. csrf_token() .'" />
                                <input type="hidden" name="_method" value="DELETE"/>
                                <button type="submit" title="Delete" class="btn btn-default btn-sm btn-item-table delete"  onClick="return askConfirm()" ><i class="fas fa-trash"></i></button>
                              </form>';
            $html .="<td><div class='btn-group'>".$bc.$tr.$edt.$del."</div></td>";                  
            
            $html .= "</tr>";

        } 
         return json_encode($html);   

    }

    //end
}
?>