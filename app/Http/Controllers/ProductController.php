<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\Stock;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // to get all the products from the database
        $products = Product::with('user', 'category')->get();
        $productCategory = Category::with('products')->get();

        return view('products.index', compact('products', 'productCategory'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryProducts = Category::with('products')->get();
        $attributes = Attribute::get();
        $productImages = ProductImages::with('product_color')->get();
        // dd($productImages->toArray());
        $productImageColors = $productImages->toArray();
        $product_color = array();

        foreach ($productImageColors as $product) {
            $colorName = $product['product_color']['name'];

            // if the color doesn't exist then only push the color in the array
            if (!in_array($colorName, $product_color)) {
                array_push($product_color, $colorName);
            }
        }



        return view('products.create', compact('categoryProducts', 'attributes', 'product_color'));
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
            'colorValue' => 'array', // Check if colorValue is an array
            'colorValue.*' => 'string', // Validate each colorValue as a string
            'variantImage.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'variantPrice.*' => 'numeric',
            'variantStock.*' => 'numeric',
            'attribute' => 'array',
            'attribute.*' => 'numeric',
            'stock' => 'numeric',
            'attributesInput' => 'nullable',
            'variantValue.*' => 'string',
        ]);


        // dd(json_decode($validatedData['attributesInput']));

        // this data will hold the variant product information 
        $variants = [];

        $containsVariantProductName = $validatedData['name'];
        $containsVariantAttribute = $validatedData['attribute'];
        $containsVariantColorValue = $validatedData['colorValue'] ?? "";
        // dd($containsVariantColorValue);
        // dd(json_encode($containsVariantColorValue));
        $containsVariantImages = $validatedData['variantImage'];
        $containsVariantPrice = $validatedData['variantPrice'];
        $containsVariantStock = $validatedData['variantStock'];
        $containsVariantNames = $validatedData['variantValue'];
        $containsAttributeInput = $validatedData['attributesInput'];
        // dd($containsAttributeInput);
        $colorsAssocArray = [];
        foreach ($containsVariantColorValue as $index => $color) {
            $colorsAssocArray[$index] = $color;
        }

        // Now, $colorsAssocArray is an associative array with key-value pairs
        $jsonFormattedColor = json_encode($colorsAssocArray);
        // dd($jsonFormat);

        // it contains the attributes name that has been selected in the view panel
        $containsAttributeNamesOnly = [];

        foreach ($containsVariantAttribute as $attribute) {
            $productName = Attribute::where('id', $attribute)->pluck('name')->first();
            array_push($containsAttributeNamesOnly, $productName);
        }
        

        // Loop through each variant
        for ($i = 0; $i < count($containsVariantImages); $i++) {
            // Get the current variant's name
            $variantName = $containsVariantProductName . '-' . $containsVariantNames[$i];

            // Check if the variant name is already a key in the $variants array
            if (!isset($variants[$variantName])) {
                // If not, create a new sub-array for the variant name

                $variants[$variantName] = [];
            }

            // Add the variant information to the sub-array
            $variants[$variantName] = [
                'variantImage' => $containsVariantImages[$i],
                'price' => $containsVariantPrice[$i],
                'stock' => $containsVariantStock[$i]
            ];
        }
        // dd($variants);

        $imageName = time() . '.' . $request->image->extension();
        $imagePath = $request->file('image')->move('images', $imageName);

        // if the data has been passed as the color value and attribute 
        if (isset($containsVariantColorValue) || !isEmpty($containsVariantAttribute)) {


            $product = Product::create([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'user_id' => auth()->user()->id,
                'category_id' => $request->input('category_id'),
                'image' => $imagePath,
                'attributes' =>$containsAttributeInput,
                'colors' => json_encode($containsVariantColorValue),
                'isVariant' => 1,
            ]);
        // dd($product);

            $variantImagePaths = [];

            // Check if variants exist
            if (!empty($variants)) {
                foreach ($variants as $key => $variantData) {

                    $variantImage = null;

                    if (!empty($variantData['variantImage'])) {
                        // Generate a unique name for the variant image
                        $variantImageName = $key . time() . "." . $variantData['variantImage']->extension();

                        // Define the path to the "images" folder within the public directory
                        $variantImagePath = public_path('images/' . $variantImageName);

                        // Ensure the directory exists or create it if it doesn't
                        $imageDirectory = public_path('images');
                        if (!is_dir($imageDirectory)) {
                            mkdir($imageDirectory, 0777, true);
                        }

                        // Move the variant image to the specified path
                        $variantData['variantImage']->move($imageDirectory, $variantImageName);

                        // Add the variant image path to the array
                        $variantImagePaths[$key] = 'images/' . $variantImageName;

                        // Create a variant for the product with the variantImage
                        $variant = Variant::create([
                            'product_id' => $product->id,
                            'name' => $key,
                            'image' => $variantImagePaths[$key],
                            'price' => $variantData['price'],
                            'stock' => $variantData['stock'],
                        ]);
                    }
                }
            }
            $stockAdd = Stock::create(
                [
                    'product_id' => $product->id,
                    'quantity' => $request->input('stock'),
                ]
            );
        } else {
            // creating a new data using the validated data
            $product = Product::create([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'user_id' => auth()->user()->id,
                'category_id' => $request->input('category_id'),
                'image' => $imagePath,
                'isVariant' => 0,
            ]);

            $stockAdd = Stock::create(
                [
                    'product_id' => $product->id,
                    'quantity' => $request->input('stock'),
                ]
            );
        }

        // If a product is deleted, delete its associated images
        // $product->deleting(function ($product) {
        //     // Delete the normal product image
        //     if (!empty($product->image)) {
        //         Storage::disk('public')->delete($product->image);
        //     }

        //     // Delete variant images associated with the product's variants
        //     foreach ($product->variants as $variant) {
        //         if (!empty($variant->image)) {
        //             Storage::disk('public')->delete($variant->image);
        //         }
        //     }
        // });


        // if it is successfull redirect the user
        return redirect()->route('products.index')->with('success', 'Product created Successfully!');
    }

    public function newArrival()
    {
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
        $product->variants()->delete();
        $product->stocks()->delete();
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
