<?php

namespace App\Http\Controllers;

use App\Models\Variation;
use Illuminate\Http\Request;

class VariationController extends Controller
{
 
  public $title = "Item-Settings";
  public $subtitle = "Variations";


    public function index()
    {
        $data = ['title'=>$this->title, 'subtitle'=>$this->subtitle];
        return view('admin.variations.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.variations.create',['title'=>$this->title,'subtitle'=>$this->subtitle]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $validatedData = $request->validate([          
            'name' => 'required|max:30|unique:App\Models\Variation,name'
        ]);
        //validate
        $newObj = new Variation;           
        $newObj->name = ucfirst($request->name); 
            if($newObj->save()){
                return redirect('variations')->with('status', 'One New Variation Just Created!');
            }else{
                return redirect('variations/create')->with('status', 'Something went wrong, Try Again');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Variation  $variation
     * @return \Illuminate\Http\Response
     */
    public function show(Variation $variation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Variation  $variation
     * @return \Illuminate\Http\Response
     */
    public function edit(Variation $variation)
    {
        return view('admin.variations.update',['title'=>$this->title,'subtitle'=>$this->subtitle,'variation'=>$variation]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Variation  $variation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Variation $variation)
    {
        //dd($request);
        $validatedData = $request->validate([          
            'name' => 'required|max:30|unique:App\Models\Variation,name'
        ]);
        //validate
                  
        $variation->name = ucfirst($request->name); 
            if($variation->save()){
                return redirect('variations')->with('status', 'Variation Just Updated!');
            }else{
                return redirect('variations/'.$variation->$id.'/edit')->with('status', 'Something went wrong, Try Again');
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Variation  $variation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variation $variation)
    {
        //
    }

    function getVariation(){
         $variations = Variation::all();
         $variationData =[]; 
         $i=1;       
         foreach($variations as $variation){
            $action = "<div class='btn-group'>
                        <a type='button' href='".url('variations/'.$variation->id.'/edit')."' class='btn btn-default btn-sx'>Edit</a>
                        </div>";

                $variationData['data'][] = array($i,$variation->name,date('d-m-Y',strtotime($variation->created_at)),$action);
                $i++;
         }
        return json_encode($variationData);
    }
  //end  
}
?>