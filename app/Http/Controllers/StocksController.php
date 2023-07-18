<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StocksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all the stocks from the database
        $stocks = DB::table('stocks')
        ->join('products', function (JoinClause $join) {
            $join->on('stocks.product_id', '=', 'products.id');
        })
        ->get();
        // dd($stocks);
        return view('stocks.index',compact('stocks'));
    }   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // take out name and id of the product
        $products = Product::get();
        // dd($products->toArray());    
        return view('stocks.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // to validate
        $validated = $request->validate([
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        // taking the data
        $productId = $request->product_id;
        $quantity = $request->quantity;

        $stock = new Stock();
        $stock->product_id = $productId;
        $stock->quantity = $quantity;

        $stock->save();

        return redirect()->route('stocks.index');
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
    public function edit($id)
    {
        $stock = Stock::where('product_id',$id)->first();
        $id = $stock->product_id;   
        $product = Product::where('id',$id)->pluck('name')->first();

        return view('stocks.edit',compact('stock','product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)    
    {

        $validator = Validator::make($request->all(), [
            // 'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
          
        ]);
        
        // if validation fails it returns with certain errors
        if ($validator->fails()) {
            // dd($validator->getMessageBag());
            return back()->withErrors($validator)->withInput();
        }

        // find the stock id from the table 
        $stockUpdate  = Stock::findOrFail($id);

        // update the quantity from the stock table 
        $stockUpdate->update(['quantity' => $request->input('quantity')]);
        
        return redirect()->route("stocks.index");

    }   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stockProduct = Stock::where('product_id',$id)->first();
        $id = $stockProduct->id;
        if($stockProduct)
        {
            $stockProduct->delete();
        }

        return redirect()->back()->with("success","Product delete successfully");
    }
}
