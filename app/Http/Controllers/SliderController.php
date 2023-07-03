<?php

namespace App\Http\Controllers;

use App\Models\Category;
use \App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // to get all the aliders
        $sliders  = Slider::with('category')->get();
        return view('sliders.index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
    */

    public function create()
    {
        
        $categories = Category::with('sliders')->get();
        return view('sliders.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // to store the categories in the db
        // to validate the request first 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'caption' => 'required|string',
            'image' => 'required|string',
            'category_id' => 'required|numeric',
        ]);
        
        // if validation fails it returns with certain errors
        if ($validator->fails()) {
            // dd($validator->getMessageBag());
            return back()->withErrors($validator)->withInput();
        }

        // to get the categories too
        // $sliderName = Category::with('categories')->get();
        $slider = Slider::with("category")->get();

        //  to store in the db model call sliders 
        $sliders = new Slider();
        $sliders->name = $request->name;
        $sliders->caption = $request->caption;
        $sliders->image = $request->image;
        $sliders->category_id = $request->category_id;
        $sliders->save();

        return redirect()->route('sliders.index')->with('success',"Created sliders succcesfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // it will get the slider with the id we need
        $slider = Slider::where('id',$id)->first();
        $sliders  = Slider::with('category')->get();
        return view('sliders.edit',compact('slider','sliders'));

    }

    /**
     * Update the specified resource in storage.
    */

    public function update(Request $request, string $id)
    {
        // to store the categories in the db
        // to validate the request first 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'caption' => 'required|string',
            'image' => 'required|string',
            'category_id' => 'required|numeric',
        ]);
        
        // if validation fails it returns with certain errors
        if ($validator->fails()) {
            // dd($validator->getMessageBag());
            return back()->withErrors($validator)->withInput();
        }


        // to update the following data 

        $slider = Slider::findOrFail($id);

        $slider->name = $request->input('name');
        $slider->caption = $request->input('caption');
        $slider->image = $request->input('image');
        $slider->save();

        return redirect()->back()->with('success','Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
