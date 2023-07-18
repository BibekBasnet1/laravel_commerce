<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // to get all the products from the database

        $products = Product::with('user', 'category')->get();
        // dd($products);
        $productCategory = Category::with('products')->get();
        return view('products.index', compact('products', 'productCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryProducts = Category::with('products')->get();
        return view('products.create', compact('categoryProducts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //it is used to store the data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'numeric',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $imagePath = $request->file('image')->move('images', $imageName);;
        // dd($imagePath);
        // creating a new data using the validated data
        $product = Product::create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'user_id' => auth()->user()->id, // Assuming you want to associate the product with the currently authenticated user
            'category_id' => $request->input('category_id'),
            'image' => $imagePath,
        ]);
        
        $stockAdd = Stock::create([
                'product_id' => $product->id,
                'quantity' => $request->input('stock'),
            ]
        );

        // if it is successfull redirect the user
        return redirect()->route('products.index')->with('success', 'Product created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // to get all the products
        $products = Product::get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // to take the id that matches with it
        $product = Product::where('id', $id)->first();
        // it will return view for the products
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validation = $request->validate([
            'name' => 'string|required',
            'price' => 'numeric|required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // dd($request->all());
        $product = Product::findOrFail($id);

        // Update the name and price
        $product->name = $validation['name'];
        $product->price = $validation['price'];
        // Check if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            // if ($product->image) {
            //     Storage::disk('public')->delete($product->image);
            // }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('images', $imageName);
            // Store the new image and update the image path
            // $imagePath = $request->file('image')->store('public/images');
            $product->image = $imageName;
        }

        $product->save();

        return redirect()->back()->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // to get the $product based on the id
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with("success", "Product delete successfully");
    }


    public function deletedData()
    {
        // to retrieve all the delete data
        $products = Product::onlyTrashed()->get();
        return view('products.deletedData', compact('products'));
    }

    public function restore($id)
    {
        // to find the deleted product based on the product id
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->back()->with('success', 'Products restored Successfully!');
    }
}
