<?php

namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Salepayments;

use App\Models\Inventory;

use Cart;

trait SaleTrait {
  

    public function getBranchInfo($id){

         $branch = DB::table('branches')->find($id);            

        return $branch;

    }



    public function getConfig(){

        $config = DB::table('configs')->first();

        return $config;

    }

    public function deleteSaleInfo(){

         Cart::destroy();

        //empty payments               

        session()->forget('payment');

        session()->forget('discount');

    }

    public function cancelSale(){

        $this->deleteSaleInfo();

        return redirect('/sales');

    }



    public function removeFromCart($rowId){

        Cart::remove($rowId);

        return redirect('/sales');

    }





    public function deletePayment(Request $request){

    	$request->session()->forget('payment');

    	return redirect('/sales');

    }



    public function getInventory($sku, $branch){

    	 $inventroy = DB::table('inventories')

            ->where('sku', $sku)

            ->where('branch_id', $branch)

            ->where('qty','>',0)

            ->get()->first();

            return $inventroy; 

    }

    public function getInventoryAnyBranch($sku){

         $inventroy = Inventory::with('branch')

            ->where('sku', $sku)            

            ->where('qty','>',0)

            ->get();

            return $inventroy; 

    }

    public function getItem($id){

    	$item = DB::table('items')

            ->where('items.id', $id)

            ->join('categories', 'items.category_id', '=', 'categories.id')

            ->select('items.name','categories.tax_code')

            ->get()->first();

            return $item; 

    }



    public function addPayment(Request $request) {        

        //use session

        $validatedData = $request->validate([          

            'amount' => 'required|min:0|numeric',

            'payment_type' => 'required'

        ]);     

        $payment = ['payment_type'=>$validatedData['payment_type'],'amount'=>$validatedData['amount']];

        $request->session()->push('payment', $payment);

        return redirect('/sales');

    }



    public function addDiscount(Request $request){

         //use session

        $validatedData = $request->validate([          

            'amount' => 'required|min:0|numeric',

            'discount_type' => 'required'

        ]);     

        $discount = ['type'=>$validatedData['discount_type'],'amount'=>$validatedData['amount']];

        $request->session()->put('discount', $discount);       

        return redirect('/sales');

    }



    public function savePayments($saleId){

        $payments = session('payment');

         if($payments){

            foreach($payments as $paid){



                    $salePayment = new Salepayments;

                    $salePayment->sale_id = $saleId;

                    $salePayment->type = $paid['payment_type'] ;

                    $salePayment->amount = $paid['amount'] ;

                    $salePayment->save();

            }

        }

    }



    

    public function getTotalPayment(){

    	 $payments = session('payment');

    	 $totalPaid = 0.00;

    	 if($payments){

    	 	foreach($payments as $paid){

    	 		$totalPaid += floatval($paid['amount']);

    	 	}

    	 }

    	 return $totalPaid;

    }





    public function getDue(){

         $due = $this->getCartTotal() - $this->getTotalPayment();

         return $due;

    }





    public function setCartTax($rowId,$code){

        Cart::setTax($rowId, $code);

    }



    public function addItemToCart($sku,$name,$qty,$price,$weight,$optionId,$mode,$stock){

        $cart = Cart::add($sku, $name, $qty, $price, $weight, ['inv_id' => $optionId, 'mode' => $mode,'stock'=>$stock]);

        return $cart;

    }





    public function getTotalDiscount(){

        $amount = 0.00;

        $disq = session('discount');

        if($disq){

           $value = floatval($disq['amount']);

            if($disq['type']=='percent'){

                $amount = ($this->getCartSubtotal() * $value) /100;

            }else{

                $amount = $value;

            }

        }

        return $amount;

    }



    public function getCartSubtotal(){

       $cartContent = $this->getCartContent();

         $subtotal =0.00;

         if($cartContent){

             foreach($cartContent as $cart){

                $subtotal +=  $cart->qty * $cart->price;

            }

        }

        return floatval($subtotal); 

    }



    public function getCartTotal(){

        $total = 0.00;

        $subtot = $this->getCartSubtotal();

        $tax = $this->getCartTax();

        $disq = $this->getTotalDiscount();

        $total = $subtot+$tax-$disq;

        return $total;

    }



    public function getCartContent(){

        return Cart::content();

    }

    public function getCartCount(){

        $cartContent = $this->getCartContent();

         $count =0.00;

         if($cartContent){

             foreach($cartContent as $cart){

                $count +=  abs($cart->qty);

            }

        }

        return $count;

    }



    public function getCartTax(){

        $saleTax = 0.00;

        $returnTax = 0.00;

        $cartContent = $this->getCartContent();

        foreach($cartContent as $cart){

            if($cart->qty > 0 && $cart->options->mode =='sale'){ //sale

                $item_tax = $this->getItemTax($cart->price , $cart->taxRate);

                $saleTax += $cart->qty * $item_tax ;  

            }else if($cart->qty < 0 && $cart->options->mode =='return'){ //return

                $item_tax = $this->getItemTax($cart->price , $cart->taxRate);

                $returnTax += abs($cart->qty) * $item_tax ;

             }

        }



        //var_dump($saleTax);

       // var_dump($returnTax);

        $tax = $saleTax - $returnTax; 

        return $tax; 

    }







    public function getItemTax($price, $rate){

        $amount = ($price * $rate) / 100 ;

        return $amount;

    }





//end of file 

}