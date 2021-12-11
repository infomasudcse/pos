<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\SaleTrait;
use App\Models\Sale;
use App\Models\Saleitems;
use App\Models\Inventory;
use App\Traits\InventoryTrait;
use App\Helper\Helper;

class SaleController extends Controller
{
  	use SaleTrait;
    use InventoryTrait;
    public $title = 'Sale';

    function index(){
        $data['branchInfo'] = $this->getBranchInfo(Auth()->user()->branch_id);
        $data['total'] = $this->getCartTotal();
        $data['subtotal'] = $this->getCartSubtotal();
        $data['counts'] = $this->getCartCount();
        $data['cartContent'] = $this->getCartContent();
        $data['tax'] = $this->getCartTax();
        $data['discount'] = $this->getTotalDiscount();
        $data['payment'] = $this->getTotalPayment();
        $data['due'] = $this->getDue();
        
        return view('branch.index',$data);
    }


    function addToCart(Request $request){
        //validate
    	$validatedData = $request->validate([          
            'sku' => 'required|numeric',
            'mode' => 'required'
        ]);
        //set variable
        $qty = 0;
        $status='';
        //get mode and set variable
        $mode = $validatedData['mode'];
        switch($mode){
            case 'sale':
                $qty = 1;$mode='sale';break;
            case 'return':
                $qty = -1;$mode='return';break;
            default:
            $qty = 0;
        }
        //quantity not set can not sale
        if($qty === 0){
            $status .= ' Sale or return ??';
        }else{ 
            //get logged branch
            $branchId = auth()->user()->branch_id;
            //search inventory
            $itemInventory = $this->getInventory($validatedData['sku'], $branchId);
            if(!$itemInventory){
                //item not found in this branch
                $status = ' Item Not Found in this branch '; 
                //search inventory to other branch
                $anyBranchInventory = $this->getInventoryAnyBranch($validatedData['sku']);
                if(count($anyBranchInventory)>0){                    
                    foreach($anyBranchInventory as $otherBranchInventory){
                        $status .=' but found '.$otherBranchInventory->qty.'pcs in '.$otherBranchInventory->branch->title.' , ';
                    }
                }else{
                    $status .= 'not found any of branch or unable to sale ! ';
                }
            }else{
                //item found in this branch      
                $item = $this->getItem($itemInventory->item_id);
                //add to cart
                $cart = $this->addItemToCart($itemInventory->sku, $item->name, $qty, $itemInventory->unit_price, 0, $itemInventory->id, $mode,$itemInventory->qty);
                // $sku,$name,$qty,$price,$weight,$optionId,$mode,$stock
                $this->setCartTax($cart->rowId, $item->tax_code);
            }
        }
		return redirect('/sales')->with('status',$status);
    }

   
    function doSale(Request $request){
    	//get cart Item update inventori
        $cartTotal = $this->getCartTotal();
        if($cartTotal == 0){
            $request->session()->push('payment', ['payment_type'=>'none','amount'=>0.00]);
        }
        $cartTotPayment =  $this->getTotalPayment();
        $changeAmount  = $cartTotal - $cartTotPayment; 
        if($changeAmount <= 0){
            $data['cartContent'] = $this->getCartContent();
            $data['payments'] = session('payment');
            $data['salesman'] = auth()->user()->name;
            //sale
            // if($cartContent)
            $saleData = [
                'total_item' =>  $this->getCartCount(), 
                'subtotal' => $this->getCartSubtotal(),
                'total_sale' => $cartTotal,
                'totalWTax' =>$cartTotal + $this->getCartTax(),
                'changeamount'=> $changeAmount,
                'total_payment' => $cartTotPayment,
                'total_tax'=> $this->getCartTax(),
                'total_discount' => $this->getTotalDiscount(),
                'user_id' =>  auth()->user()->id,
                'branch_id' =>  auth()->user()->branch_id
            ];
            //save sale and get instance 
            $data['sale'] = Sale::create($saleData);     
            foreach($data['cartContent'] as $cartItem){
                $inventory =  Inventory::find($cartItem->options->inv_id);
                //save sale or return
                $saleitem = new Saleitems;
                $saleitem->sale_id = $data['sale']->id;
                $saleitem->inventory_id = $inventory->id;
                $saleitem->item_id = $inventory->item_id;
                $saleitem->sku = $cartItem->id;
                $saleitem->qty = $cartItem->qty;
                $saleitem->cost_price = $inventory->cost_price;
                $saleitem->unit_price = $cartItem->price;
                $saleitem->tax_code = $cartItem->taxRate;
                $saleitem->tax_amount =$this->getItemTax($cartItem->price, $cartItem->taxRate);
                $saleitem->save();
                $mode = $cartItem->options->mode; 
                if($mode == 'sale' && $cartItem->qty > 0){                    
                    $remain_qty =   intval($inventory->qty) -  intval($cartItem->qty);         
                    //update inventory for sale
                    $inventory->qty = $remain_qty ;
                    $inventory->save();
                }else if($mode == 'return' && $cartItem->qty < 0){
                    //update qty for return
                    $new_qty =   intval($inventory->qty) + ( -1 * intval($cartItem->qty));         
                    $inventory->qty = $new_qty ;
                    $inventory->save();
                }
                   
                //in all case Track Entry
                $tracQty = -1 * $cartItem->qty;
                $viewSaleId = Helper::viewSaleId($data['sale']->id);
                $this->SaveTrackInventory($inventory->id,$inventory->item_id,$data['sale']->user_id,$data['sale']->branch_id,$cartItem->id,$tracQty,$viewSaleId);
               
                
            }
         //create receipt        
        $data['branchinfo'] = $this->getBranchInfo($data['sale']->branch_id);
        $data['config'] = $this->getConfig();
        $data['title'] = $this->title;
        //save payments
        $this->savePayments($data['sale']->id);
        //remove sales info 
        $this->deleteSaleInfo(); 
        
        return view('branch.receipt',$data);        
            
        }else{
             return redirect('/sales/index')->with('status', 'Check Total Sale / Payment !');
              //return redirect()->route('sale',['status','Check Total Sale / Payment !']);
        }
    	
    }
  //end
}