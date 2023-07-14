<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // to get all the data from the database 
        $categories = Category::with("sliders","subcategory",'products')->get();
        // dd($categories->toArray());
        return view('categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // to getting the categories based on the name 
        $categories = Category::orderby('name', 'asc')->get();
        // dd($categories->toArray());
        return view('categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // to validate the request first 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'parent_id' => 'required|numeric',
           
        ]);
 
        // if validation fails it returns with certain errors
        if ($validator->fails()) {
            // dd($validator->getMessageBag());
            return back()->withErrors($validator)->withInput();
        }

        $categories = new Category();
        $categories->name = $request->name;
        $categories->parent_id = $request->parent_id;
        $categories->save();

        return redirect()->route('categories.index')->with('success',"Created categories succcesfully");

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
        // $slider = Slider::with('category')->get();
        // return redirect()->route('ca);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // get the id we want to edit 
        $categories = Category::where('id',$id)->first();
        return view('categories.edit',compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // to validate the request first 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'parent_id' => 'required|numeric',
        ]);
 
        // if validation fails it returns with certain errors
        if ($validator->fails()) {
            // dd($validator->getMessageBag());
            return back()->withErrors($validator)->withInput();
        }

        // search for the data we are trying to update
        $categoryId = Category::findOrFail($id);
        $categoryId->name = $request['name'];
        $categoryId->parent_id = $request->parent_id;
        $categoryId->save();

        // this will redirect to the index page as soon as it
        return redirect()->route('categories.index')->with('success','updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // to get the data wit the associate id
        $categoryId = Category::where('id',$id);
        if($categoryId->exists())
        {
            $categoryId->delete();
        }

        return redirect()->back()->with('success','Deleted successfully');
    }
}
