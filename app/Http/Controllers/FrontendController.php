<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Stock;
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
        $featuredProducts = Product::get();
        $products = Product::cursorPaginate(6);
        $categories = Category::with('subcategory')->where('parent_id',null)->get();    
        // dd($categories->toArray());
        return view('frontends.show',compact('slider','products','categories','featuredProducts'));
    }

    public function showCategory(int $id)
    {
        //  to get the products based on the category 
        $categories = Category::with('products')->where('id',$id)->get();
        // dd($categories->toArray());
        // $sidebarCategories = Category::with('subcategory')->where('parent_id',$id)->get();
        return view('frontends.categories', compact('categories'));
    }

    public function sidebarCategory($id)
    {
        $sidebarCategories = Category::with('products','subcategory')->where('parent_id',$id)->get();
        // dd($sidebarCategories->toArray());
        return view('frontends.sidebarCategories', compact('sidebarCategories'));
    }

    public function sortByPrice(Request $request)
    {

    //     // fetching the asc or descending from fetch 
        $sortValue = strval($request->sortBy);
        $searchValue = $request->searchValue;

        // for searching the products based on the product name with categories
        $productName = Product::where('name','like','%' . $searchValue . '%')->get();

        // to take out the category_id of the product
        $productCategory = $productName->pluck('category_id')->toArray();
               
        // it removes the element that doesn't match with the condition 
        $products = Product::whereIn('category_id',$productCategory)
        ->orderBy('price',$sortValue)
        ->get();
       

        // for the json 
        return response()->json(
            [
                'success' => true,
                'products' =>$products,
            ]
        );
       
    }

    


    public function checkout()
    {
        // to see which is being checkout out
        
        // inner join products table with carts if user_id is same in products table and the carts table 
        $products = DB::table('carts')
        ->select('products.*','carts.*')
        ->join('products', 'carts.product_id', '=', 'products.id')
        ->get();
        // dd($products->toArray());
        $id = auth()->user()->id;
        
        $orders = Order::where('user_id',$id)->get();
        // dd($products->toArray());
        return view('frontends.checkout',compact('products','orders'));
    }

    // for searching the data
    public function search(Request $request)
    {
        $product = $request->search;

        // Search for products based on the name
        $productsNames = Product::where('name', 'like', '%' . $product . '%')->get();
        
        $products = $productsNames->toArray();
        // dd($products);
      

        // Return the response
        return response()->json([
            'success' => true,
            'products' => $products,
        ]);

    }

    public function searchInput(Request $request)
    {
        
        // to search the data
        $product = $request->input('search');

        // for searching the products based on the product name with categories
        $productName = Product::where('name','like','%' . $product . '%')->get();

        // to take out the category_id of the product
        $productCategory = $productName->pluck('category_id')->toArray();
        
        // it removes the element that doesn't match with the condition 
        $products = Product::whereIn('category_id',$productCategory)->get();


        $categories = Category::get(['id','name'])->keyBy('id');
        // return the view with category based products
        return view('frontends.searchInput',compact('products','categories'));

    }

    public function searchCategories()
    {

        return view('frontends.searchInput');
    }

    public function imageCheckout(int $id )
    {
        $product = Product::with('stocks')->findOrFail($id); 
        // dd($product->toArray()); 
        return view('frontends.productDescription',compact('product'));
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
