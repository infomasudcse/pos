<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
   public $title = "Item-Settings";
   public $subtitle = "Category";



    public function index()
    {
        $data = ['title'=>$this->title, 'subtitle'=>$this->subtitle];
        return view('admin.category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create',['title'=>$this->title, 'subtitle'=>$this->subtitle,]);
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
            'name' => 'required|max:30', 
            'br_code'=>  'required|max:99|min:10|numeric|unique:categories',       
            'tax_code' => 'required|max:50|numeric'
        ]);
        //validate
        $newCategory = new Category;           
        $newCategory->name = ucfirst($request->name); 
        $newCategory->br_code = $request->br_code;           
        $newCategory->tax_code = $request->tax_code;
            if($newCategory->save()){
                return redirect('categories')->with('status', 'Category Just Created!');
            }else{
                return redirect('categories/create')->with('status', 'Something went wrong, Try Again');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {       
    
        return view('admin.category.update',['title'=>$this->title, 'subtitle'=>$this->subtitle,'category'=>$category]);
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
         $validatedData = $request->validate([          
            'name' => 'required|max:30',  
            'br_code'=>  'required|max:99|min:10|numeric',         
            'tax_code' => 'required|max:50|numeric'
        ]);

        //validate

         $category->name = ucfirst($request->name);
         $category->br_code = $request->br_code;
         $category->tax_code = $request->tax_code;
        if($category->save()){
            return redirect('categories')->with('status', 'Category Updated!');
        }else{
            return redirect('categories/'.$category->$id.'/edit')->with('status', 'Something went wrong, Try Again');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }

    function getCategory(){

        $categories = Category::all();
         $categoryData =[]; 
         $i=1;       
         foreach($categories as $category){
            $action = "<div class='btn-group'>
                        <a type='button' href='".url('categories/'.$category->id.'/edit')."' class='btn btn-default btn-sx'>Edit</a>
                        </div>";

                $categoryData['data'][] = array($i,$category->br_code,$category->name,$category->tax_code,$action);
                $i++;
         }
        return json_encode($categoryData);
    }
   

//end     
}

?>