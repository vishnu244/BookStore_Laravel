<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\BookController;



class CartController extends Controller
{
    public function addBookTocart(Request $request){
        $request->validate([
            'book_id' => 'required|integer',
            'book_quantity' => 'required|integer'
        ]);
        $cart = new Cart();
        $book = new Book();
        $checkUser = $request->user()->id;
        $cart->user_id = $checkUser;
        $checkBookId = DB::table('books')->where('id', $request->book_id)->first();

        $checkBookInCart = DB::table('cart')->where('book_id', $request->book_id)->where('user_id', $checkUser)->first();
        if($checkBookInCart){
            Log::channel('custom')->error("Book already exists in cart");
        }
        else{
            if($checkBookId){
                $cart->book_id = $request->input('book_id');
                $cart->book_quantity = $request->input('book_quantity');
                $cart->save();
                return response()->json(["message"=>"book added to cart successfully", "success"=>200]);
            }
            else{
                Log::channel('custom')->error("Book is not available");
            }
        }      
    }


    public function display_Books_In_Cart(Request $request)
    {
        $book = Cart::all(); 
        if($book)
        {
            return response()->json(['success' => $book],201);
            Log::channel('custom')->info("Books Displayed successfully");

        }
        else
        {
            return response()->json(['Message' => "No Book found to display"],401);
            Log::channel('custom')->info("No Book found to display");
        }   
    
    }


    public function removeBookFromCart(Request $request){
        $request->validate([
            'id' => 'required|integer'
        ]);
        $response = DB::table('cart')->where('id', $request->id)->delete();
        if($response){
            return response()->json(["message"=>"Book removed from cart"],200);
            Log::channel('custom')->info("Book removed from cart");
        }
        else{
            return response()->json(['message'=>'No Book Found with that ID in Cart'],401);
            Log::channel('custom')->error("No Book Found with that ID in Cart");
        }
    }


    public function updateBookInCart(Request $request){
        $request->validate([
            'id' => 'required',
            'book_id' => 'required|integer',
            'book_quantity' => 'required|integer'
        ]);
        $cart = new Cart();
        $checkUser = $request->user()->id;
        $cart->user_id = $checkUser;
        $checkBookId = DB::table('books')->where('id', $request->book_id)->first();
        if($checkBookId){
            $response = DB::table('cart')->where('id', $request->id)->update(['book_id'=>$request->book_id, 'user_id'=>$checkUser, 'book_quantity'=>$request->book_quantity]);
            return response()->json(["message"=>"book updated successfully", "successstatus"=>200]);
        }
        else{
            Log::channel('custom')->error("Book is not available");
        }
    }


   


    public function update_Quantity_In_Cart(Request $request)
    {
        $request->validate([
            'id' =>'required|integer',
            'book_quantity' => 'required|integer'
        ]);

        $response = DB::table('cart')->where('id', $request->id)->update(['book_quantity'=>$request->book_quantity]);
        if($response)
        {
            return response()->json(['message'=>'Quantity of Books Updated Successfully'],201);
            Log::channel('custom')->info("Quantity of Books Updated Successfully");
        }
        else{
            return response()->json(['message'=>'No book Found with that ID'],401);
            Log::channel('custom')->info("No Book found with that ID");
        }
    }
}