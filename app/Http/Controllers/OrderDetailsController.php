<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderDetails = Order::with('order_details.product','user')->get();
        // dd($orderDetails->toArray());
        // dd($orderDetails->toArray());
        return view('order_details.index',compact('orderDetails'));
    }

    public function viewProduct(Request $request)
    {
        // dd("Hello");
        // take the orderId from the client side ajax request 
        $orderId = $request->input('orderId');
        // dd($orderId);
        // to take the product information with the help of products
        $productInformation = Order::with('order_details.product', 'user')->findOrFail($orderId);
        // dd($productInformation);
        

        return json_encode(
            [
                'success' => true,
                'message' => $productInformation,
            ]
        );

    }


    public function product_sold_details(Request $request)
    {

        $productInformation = OrderDetails::select('name','product_id',DB::raw('SUM(quantity) as total_quantity'))
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->groupBy('product_id')
            ->get();

        
        // dd($productInformation->toArray());
        return view('product_details.index',compact('productInformation'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
// 
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
}
