<?php

namespace App\Http\Controllers;

use App\Models\Variationval;
use App\Models\Variation;
use Illuminate\Http\Request;

class VariationvalController extends Controller
{
   public $title = "Item-Settings";
   public $subtitle =  "Variation value";


    public function index()
    {
        $data = ['title'=>$this->title, 'subtitle'=>$this->subtitle];
        return view('admin.variations.index-val',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $variations =Variation::all();       
        if($variations->count() > 0){
            return view('admin.variations.create-val',['title'=>$this->title,'subtitle'=>$this->subtitle,'variations'=>$variations]); 
        }else{
           return redirect('variationvals')->with('status', 'You must create a Variation First in order to create variation value ! . ');
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
       // print_r($request->input());
       // die();
        $validatedData = $request->validate([ 
            'variationid' =>'required|numeric',         
            'val' => 'required|max:30|unique:App\Models\Variationval,value'
            ]);
        //validate
        $newVVal = new VariationVal;           
        $newVVal->variation_id = $request->variationid;            
        $newVVal->value = ucfirst($request->val);
       
        if($newVVal->save()){
            return redirect('variationvals')->with('status', 'Variation New Value Just Saved!');
        }else{
            return redirect('variationvals/create')->with('status', 'Something went wrong, Try Again');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VariationVal  $variationVal
     * @return \Illuminate\Http\Response
     */
    public function show(Variationval $variationval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VariationVal  $variationVal
     * @return \Illuminate\Http\Response
     */
    public function edit(Variationval $variationval)
    {
        $variations =Variation::all();
        return view('admin.variations.update-val',['title'=>$this->title,'subtitle'=>$this->subtitle,'variationval'=>$variationval,'variations'=>$variations]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VariationVal  $variationVal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Variationval $variationval)
    {
        // print_r($request->input());
       // die();
        $validatedData = $request->validate([ 
            'variationid' =>'required|numeric',         
            'val' => 'required|max:30|unique:App\Models\Variationval,value'
            ]);
        //validate
                  
        $variationval->variation_id = $request->variationid;            
        $variationval->value = ucfirst($request->val);
       
        if($variationval->save()){
            return redirect('variationvals')->with('status', 'Variation Value Just Updated!');
        }else{
             return redirect('variationvals/'.$variationval->id.'/edit')->with('status', 'Something went wrong, Try Again');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VariationVal  $variationVal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variationval $variationval)
    {
        $variationval->delete();
        return redirect('variationvals')->with('status',' Deleted ! ');
    }

    function getVariationval(){
         $vvals = Variationval::with('variation')->get();
         $vvalsData =[]; 
         $i=1;       
         foreach($vvals as $vval){
            $action = "<div class='btn-group'>
                        <a type='button' href='".url('variationvals/'.$vval->id.'/edit')."' class='btn btn-warning btn-xs mr-2'>Edit</a>
                        <form action='variationvals/".$vval->id."' method='post'>
                        <input type='hidden' name='_token' value='".csrf_token()."' />
                        <input type='hidden' name='_method' value='DELETE'/>
                        <button type='submit' class='btn btn-default btn-xs delete'  onClick='return askConfirm()' >Delete</button>
                        </form>
                        </div>";

                $vvalsData['data'][] = array($i,$vval->variation->name,$vval->value,$action);
                $i++;
         }
        return json_encode($vvalsData);



    }
  //end  
}
?>