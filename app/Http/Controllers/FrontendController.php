<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // to get the id 

        

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $slider = Slider::get();
        $products = Product::get();
        
        return view('frontends.show',compact('slider','products'));
    }

    public function showCategory(int $id)
    {
        // $category = Category::findOrFail($id);
        $categories = Category::with('products')->where('id',$id)->first();
        return view('frontends.categories', compact('categories'));
    }


    public function checkout()
    {
        // to see which is being checkout out
        
        // inner join products table with carts if user_id is same in products table and the carts table 
        $products = DB::table('carts')
        ->select('products.*')
        ->join('products', 'carts.product_id', '=', 'products.id')
        ->get();
        $id = auth()->user()->id;
        $orders = Order::where('user_id',$id)->get();
        // dd($products->toArray());
        return view('frontends.checkout',compact('products','orders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
