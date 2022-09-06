<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;




class BookController extends Controller
{
    public function addBook(Request $request){
        
        $request-> validate([
            'name' => 'required | string',
            'description' => 'required | string | max:1000',
            'author' => 'required | string', 
            // 'image' => 'required | image | mimes:jpg,png,jpeg,gif,svg,webp | max:5MB',  
            'image' => 'required | string',
            'price' => 'required | integer', 
            'quantity' => 'required | integer',
        ]);


        $book = Book::create([

            'name' => $request->name,
            'description' => $request->description,
            'author' => $request->author,
            'image' => $request->image,
            'price' => $request->price,
            'quantity' => $request->quantity

        ]);
        

        return response()->json([
            'message' => 'Book Added Successfully',
            'book' => $book
        ], 200);

    }

    // -----------API Function to display Books-------------------
    public function display_Books()
    {
        $book = Book::all();
        return response()->json(['success' => $book]);
    }


    // ------------API Function to display Book by ID------------
    public function display_Book_ID($id)
    {
        $book = Book::find($id);
        if($book)
        {
            return response()->json(['success' => $book]);
        }
        else
        {
            return response()->json(['Message' => "No Book found with that ID"]);
        }
    }


    // -----------API Function to Update Books by ID--------------
    public function update_Book_ID(Request $request, $id)
    {
       
        //validating the data to make it not to be null
        $request-> validate([
            'name' => 'required | string',
            'description' => 'required | string | max:1000',
            'author' => 'required | string', 
            // 'image' => 'required | image | mimes:jpg,png,jpeg,gif,svg,webp | max:5MB',  
            'image' => 'required | string',
            'price' => 'required | integer', 
            'quantity' => 'required | integer',
        ]);

        $book = Book::find($id);
        if($book)
        {
            $book->name = $request->name;
            $book->description = $request->description;
            $book->author = $request->author;
            $book->image = $request->image;
            $book->price = $request->price;
            $book->quantity = $request->quantity;

            
            $book ->update();
            return response()->json(['message'=>'book Updated Successfully'],200);
        }
        else
        {
            return response()->json(['message'=>'No book Found with that ID'],404);
        }
      
    }


    // -----------API Function to delete Book by ID--------------
    public function delete_Book_ID(Request $request, $id)
    {       
        $book = Book::find($id);
        if($book)
        {
            $book ->delete();
            return response()->json(['message'=>'Data Deleted Successfully'],200);
        }
        else
        {
            return response()->json(['message'=>'No Book Found with that ID'],404);
        }
    }


    // -----------API Function to Update Quantity of Books by ID--------------
    public function addQuantityForExistingBook(Request $request)
    {       
        $request-> validate([ 
            'id' => 'required | integer',
            'quantity' => 'required | integer',
        ]);

        $response = DB::table('books')->where('id', $request->id)->update(['quantity'=>$request->quantity]);
        if($response)
        {            
            return response()->json(['message'=>'Quantity of Books Updated Successfully'],200);
        }
        else
        {
            return response()->json(['message'=>'No book Found with that ID'],404);
        }
      
    }

}
