<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function count()
    {
        $userId = auth()->user()->id;
        $wishlistCount = Wishlist::where('user_id', $userId)->count();
        return json_encode(
            [
                'success' => true,
                'count' => $wishlistCount,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // currently authenticated user
        $user = Auth::id();

        // Find the current user 
        $currentUser = User::findOrFail($user);

        // first take the data through request 
        $productId = $request->productId;


        // see if the current User with the wishlist already exists
        if ($currentUser->wishlists()->where('product_id', $productId)->exists()) {
            return json_encode(
                [
                    'success' => false,
                    'message' => 'Already Added to the Wishlist',

                ]
            );
        }
        // count the number of rows of the product
        // $wishlistCount = Wishlist::where('user_id', $user)->count();

        $wishList = new Wishlist();
        // retieving the current authenticated user
        $wishList->user_id = $user;
        // putting the value of the productId that we retreived from the ajax request 
        $wishList->product_id = $productId;

        $wishList->save();

        $wishlistCount = Cart::where('user_id', auth()->user()->id)->count();

        return json_encode(
            [
                'success' => true,
                'message' => 'Successfully Added to the Wishlist',
                // 'count' => $wishlistCount,
            ]
        );
    }


    public function getWishListDetails(Request $request)
    {

        // get the userId 
        $userId = auth()->user()->id;

        // join the wishlists table with the products table if the user_id is same in both table 
        $userProducts = DB::table('wishlists')
            ->join('products', function (JoinClause $join) {
                $join->on('wishlists.product_id', '=', 'products.id');
            })
            ->get();
        
        return json_encode
        (
            [
                'wishListProduct' => $userProducts,
            ]
        );

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
    public function destroy(Request $request)
    {
        // to get the product id 
        $productId = $request->product_id;

        $product = Wishlist::where('product_id', $productId)->first();
        // if there is cart with the id then delete it 
        if ($product) {
            $product->delete();
            return response()->json([
                'status' => true,
                'wishlistDetails' => "deleted successfully"
            ]);
        } else {

            return response()->json([
                'status' => false,
                'wishlistDetails' => "Failed"
            ]);
        }
    }
}
