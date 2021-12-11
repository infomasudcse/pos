<?php

namespace App\Http\Controllers;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SizeController extends Controller
{
    public $title = "Item-Settings";
    public $subtitle = "Size";



    public function index()
    {
        $data = ['title'=>$this->title, 'subtitle'=>$this->subtitle];
        return view('admin.size.index',$data);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.size.create',['title'=>$this->title, 'subtitle'=>$this->subtitle,]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //print_r( $request->input());          
        $validatedData = $request->validate([         
            'measure'=>  'required|unique:sizes'   
          
        ]);
        //validate
        $newSize = new Size;           
        $newSize->measure = $request->measure;      
            if($newSize->save()){
                return redirect('sizes')->with('status', 'Sizes Just Created!');
            }else{
                return redirect('sizes/create')->with('status', 'Something went wrong, Try Again');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Size $size)
    {       
    
        return view('admin.size.update',['title'=>$this->title, 'subtitle'=>$this->subtitle,'size'=>$size]);
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Size $size)
    {
         $validatedData = $request->validate([
            'measure'=>  'required'
        ]);
        //validate
         $size->measure = $request->measure;
         $size->br_code = $request->br_code;
  
        if($size->save()){
            return redirect('sizes')->with('status', 'Size Updated!');
        }else{
            return redirect('sizes/'.$size->$id.'/edit')->with('status', 'Something went wrong, Try Again');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Size $size)
    {
        //
    }

    function getSize(){

        $sizes = Size::all();
         $sizeData =[]; 
         $i=1;       
         foreach($sizes as $size){
            $action = "<div class='btn-group'>
                        <a type='button' href='".url('categories/'.$size->id.'/edit')."' class='btn btn-default btn-sx'>Edit</a>
                        </div>";

                $sizeData['data'][] = array($i,$size->measure,$action);
                $i++;
         }
        return json_encode($sizeData);
    }
   

//end     
}

?>