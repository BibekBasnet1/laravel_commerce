<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // to store the the data in the database when being clicked 
        // to validate the request first 
        $validator = Validator::make($request->all(), [
            // 'user_id' => 'numeric',
            'product_id'=> 'numeric|required',
        ]);
 
        // if validation fails it returns with certain errors
        if ($validator->fails()) {
            // dd($validator->getMessageBag());
            return back()->withErrors($validator)->withInput();
        }

        // $cart = new Cart();
        $userId = auth()->user()->id;
        $productId = $request->product_id;

        // update the product_id and the user_id by the name if it exists otherwise create a new row for it 
        $cart = Cart::updateOrCreate(
            [
                'product_id' => $productId,
                'user_id' => $userId
            ],
            [
                'quantity' => DB::raw('quantity + ' . 1),
            ]
        );
        
        // Return a response indicating success
        return response()->json([
            'success' => true,
            'message' => 'successfully Stored',
        ]);
        
    }

    // for storing the number of products at once when user adds to the cart

    public function addToCart(Request $request)
    {
       
        //  to store the the data in the database when being clicked
        
        // to validate the request first 
        $validator = Validator::make($request->all(), [
            // 'user_id' => 'numeric',
            'product_id'=> 'numeric|required',
            'product_quantity'=> 'numeric|required',
        ]);
 
        // if validation fails it returns with certain errors
        if ($validator->fails()) {
            // dd($validator->getMessageBag());
            return back()->withErrors($validator)->withInput();
        }

        $userId = auth()->user()->id;
        $productId = $request->product_id;
        $product_quantity = $request->product_quantity;
    
        $carts = $cart = Cart::updateOrCreate(
            [
                'product_id' => $productId,
                'user_id' => $userId
            ],
            [
                'quantity' => DB::raw('quantity + ' . $product_quantity),
            ]
        );
         
        // Return a response indicating success
        return response()->json([
            'success' => true,
            'message' => 'successfully Stored',
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        // to get all the cards 
        
    }
    
    public function getCartDetails(Request $request)
    {
        $userId = auth()->user()->id;

        // inner join the carts table if the products_id is equal to the carts product_id and carts userid 
        // is equal to the user id of the products table 
        $cartProducts = DB::table('carts')
            ->select('products.*','carts.*')
            ->join('products', 'products.id', '=', 'carts.product_id')->where('carts.user_id',$userId)->get();
            // dd($cartProducts);
        return response()->json(['cartItems' => $cartProducts]);
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
    public function destroy(Request $request)
    {
        $id = $request->input('product_id');
        // to see if the cart exists
        $cart = Cart::where('product_id',$id)->first();
        // if there is cart with the id then delete it 
        if($cart)
        {
            $cart->delete();
            return response()->json([
                'status' => true,
                'cartDetails'=> "deleted successfully"
            ]);
        }else{

        return response()->json([
            'status' => false,
            'cartDetails'=> "Failed"
        ]);
        }
    }
}
