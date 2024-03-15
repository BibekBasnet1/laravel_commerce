<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailToRespectiveUsers;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function order(Request $request)
    {

        $userId = auth()->user()->id;

        // to take out all the cart details for the users  
        $carts = Cart::where('user_id', $userId)->get();

        // Create a new order instance
        $order = new Order();
        // Assign the current user's ID
        $order->user_id = $userId;

        // Set the order details and total amount from the request

        // since the order_details will come in json format we are encoding it 
        $order->order_details = json_encode($request->order_details);

        foreach ($request->order_details as $item) {
            $productName = $item['name'];
            $quantity = $item['quantity'];


            // if the stock name matches with the product name in the orders table with stocks
            $product = Product::with('stocks')->where('name', $productName)->first();
            if ($quantity > $product->stocks->quantity) {
                // returning the order in the json format
                return response()->json([
                    'success' => false,
                    'message' => $productName . " out of stock ",
                ]);
            }
        }

        // taking the total value that has come from the request
        $order->total = $request->total;

        // $stock = Product::with('stocks')->where('name','Camera')->first();


        // Save the order to the database
        $order->save();

        // Access the order object of the recently saved order
        $recentlySavedOrder = $order;

        // to find the last saved id 
        $orderId = $order->id;

        // Access the order details property
        $orderDetails = json_decode($recentlySavedOrder->order_details, true);
        // dd($orderDetails);        
        // join the table if the product_id is equal to the product id 

        $sum = 0;
        foreach ($orderDetails as $item) {
            $productName = $item['name'];
            $quantity = $item['quantity'];

            // $sum+= $quantity;
            // if the stock name matches with the product name in the orders table with stocks
            $product = Product::with('stocks')->where('name', $productName)->first();

            // if the quantity is less than the quantity we have on stock 
            if ($quantity < $product->stocks->quantity) {
            }

            if ($product) {

                // reducing the stock quantity with the quantity
                $product->stocks->quantity -= $quantity;
                $product->stocks->save();

                // for order details 
                $orderDetails = new OrderDetails();

                // recently saved orderid
                $orderDetails->order_id = $orderId;

                // this is the product Id
                $orderDetails->product_id = $product->id;

                // this is the quantity 
                $orderDetails->quantity = $quantity;

                $orderDetails->price = $product->price * $orderDetails->quantity;
                $orderDetails->save();
            }
        }


        // Delete all retrieved data
        $carts->each(function ($item) {
            $item->delete();
        });

        // returning the order in the json format
        return response()->json([
            'success' => true,
            // pass in the recently saved orderId
            'orderId' => $orderId,
            'message' => 'stored successfully',
        ]);
    }


    public function  orderCheckout(Request $request, $id)
    {
        

        // inner join the orders table with the users table if the user-id matches 
        // in the users table with orders
        $userOrder = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('users.name', 'orders.order_details', 'orders.total', 'orders.id')
            ->where("orders.id", $id)
            ->first();

        // Dispatch the job to the queue, passing $userOrder as an argument
        SendMailToRespectiveUsers::dispatch($userOrder);

        // this will return the view for the order checkout and $userorders details
        return view('frontends.orderCheckout', compact('userOrder'));
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
