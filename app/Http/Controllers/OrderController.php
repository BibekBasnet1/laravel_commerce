<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
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
        $carts = Cart::where('user_id',$userId)->get();

        // Create a new order instance
        $order = new Order();
        // Assign the current user's ID
        $order->user_id = $userId;
        
        // Set the order details and total amount from the request

        // since the order_details will come in json format we are encoding it 
        $order->order_details = json_encode($request->order_details);

        // taking the total value that has come from the request
        $order->total = $request->total;
        
        // Save the order to the database
        $order->save();

        // to find the last saved id 
        $orderId = $order->id; 

        // Delete all retrieved data
        $carts->each(function ($item) {
            $item->delete();
        });
        
        // returning the order in the json format
        
        return response()->json(
        [ 
            'orderId'=> $orderId,
            'success' => true,
        ]);

    }


    public function  orderCheckout($id)
    {

        // inner join the orders table with the users table if the user-id matches 
        // in the users table with orders
        $userOrder = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('users.name','orders.order_details','orders.total','orders.id')
            ->where("orders.id",$id)
            ->first();

        // this will return the view for the order checkout and $userorders details
        return view('frontends.orderCheckout',compact('userOrder'));
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
