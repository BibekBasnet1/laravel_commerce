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

        $cart = new Cart();
        // to assign the currently authenticated user id
        $cart->user_id = auth()->user()->id;

        // take the product id of the cart being clicked 
        $cart->product_id = $request->product_id;
        $cart->save();

        // Return a response indicating success
        return response()->json(['success' => true]);
        
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
        // $request->produ
        // $cartItems = Cart::where('user_id', $userId)->get();
        // $cartProducts = Cart::where('user_id',$userId)->get();
        $cartProducts = DB::table('carts')
            ->select('products.*','carts.*')
            ->join('products', 'products.id', '=', 'carts.product_id')->get();
        
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
    public function destroy(string $id)
    {
        //
    }
}
