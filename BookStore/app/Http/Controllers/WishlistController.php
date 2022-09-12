<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Wishlist;


class WishlistController extends Controller
{
    public function addBookToWishlist(Request $request)
    {
        $request->validate([
            'cart_id'=>'required|integer',
            'book_id' => 'required|integer'
        ]);

        $wishlist = new Wishlist();
        $cart = DB::table('cart')->where('id', $request->cart_id)->first();
        $bookData = DB::table('cart')->where('book_id', $cart->book_id)->first();
        
        $getUser = $request->user()->id;
        
        $checkWishlist = DB::table('wishlists')->where('user_id', $getUser)->where('book_id', $request->book_id)->first();
        if($checkWishlist)
        {
            Log::channel('custom')->error("Book already exists in wishlist");
        }
        else{
            if($bookData)
            {
                $wishlist->book_id = $cart->book_id;
                $wishlist->user_id = $getUser;
                $wishlist->cart_id = $request->input('cart_id');
                $wishlist->save();
                return response()->json(["data"=>"Book added to wishlist", 'successstatus'=>200]);
            }
            else
            {
                Log::channel('custom')->error("Book is not available in your cart");
            }
        }
    }


    public function displayBooksFromWishlists()
    {
        $wishlist = Wishlist::all();
        if($wishlist)
        {
            return response()->json(['success' => $wishlist],201);
            Log::channel('custom')->info("Success");
        }
        else
        {
            return response()->json(['Message' => "No Book found to display"],401);
            Log::channel('custom')->info("No Book found to display");
        }
    }
    


    public function removeBookFromWishlists(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $response = DB::table('wishlists')->where('id', $request->id)->delete();
        if($response)
        {   
            return response()->json(["message"=>"Book removed from wishlists"],201);
            Log::channel('custom')->info("Book removed from wishlist");
        }
        else
        {
            return response()->json(['message'=>'No Book Found with that ID to Remove'],401);
            Log::channel('custom')->info("No Book Found with that ID to Remove");
        }
    }
}