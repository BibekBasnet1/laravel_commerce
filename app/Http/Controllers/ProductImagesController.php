<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductColors;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductImagesController extends Controller
{
    /**
     * Display a listing of the resource.
    */

    public function index()
    {
 
        $products = Product::with('images')->get();
        $productImages = ProductImages::with('product_color')->get();

        return view('product_images.index', ['products' => $products,'productImages'=>$productImages]);

    }

    /**
     * Show the form for creating a new resource.
     * 
    */

    public function create()
    {

        $productsDetail = DB::table('products')
            ->whereNull('deleted_at')
            ->select('id', 'name')
            ->get();
        $productImages = ProductImages::with('product_color')->get();
        $productColors = ProductColors::get();

        // foreach($productImages as $productImage)
        // {

        //     dd($productImage->product_color->name);
        // }
        return view('product_images.create', ['productsDetails' => $productsDetail,'productImages' => $productImages,'productColors'=>$productColors]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //it is used to store the data
        // $validatedData = $request->validate([
        //     'product_id' => 'required|numeric',
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

        // ]);

        $validator = Validator::make($request->all(), [
            'productId' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'productColor' => 'numeric',

        ]);


        $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $imagePath = $request->file('image')->move('images', $imageName);

        // creating a new data using the validated data
        $product = ProductImages::create([
                'product_id' => $request->productId,
                'image_path' => $imagePath,
                'color_id' => $request->productColor,
            ]);

        // if it is successfull redirect the user
        return redirect()->route('productImages.index')->with('success', 'Product Image Added SuccesFully!');
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

    // logic for deleting the image 
    // protected static function boot()
    // {

    //     parent::boot();
    //     // Listen for the "deleting" event
    //     static(function ($product) {
    //         // Delete the associated image from storage if it exists
    //         if ($product->image) {
    //             Storage::disk('public')->delete($product->image);
    //         }
    //     });
    // }

}
