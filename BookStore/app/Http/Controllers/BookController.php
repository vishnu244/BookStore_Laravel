<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class BookController extends Controller
{
    //----------API to Add Book----------
    public function addBook(Request $request){
        $request->validate([
            'name' => 'required | string',
            'description' => 'required | string | min:5 | max:1000',
            'image' => 'required | image | mimes:jpg,png,jpeg,gif,svg,webp | max:1024',  
            'author' => 'required | string', 
            'price' => 'required | integer', 
            'quantity' => 'required | integer',
        ]);

        $getUser = $request->user()->id;
        $book = new Book();
        $book->user_id = $getUser;
        $book->name = $request->name;
        $book->description = $request->description;
        $book->author = $request->author;
        $book->price = $request->price;
        $book->quantity = $request->quantity;

       
        $path = Storage::disk('s3')->put('images', $request->image);
        $url = env('AWS_URL') . $path;
        $book->image = $url;

        $book->save();
        $response = $book;
        return response()->json(['message' => 'Book Added Successfully','book' => $book],201);
        Log::channel('custom')->info("Book is added sucessfully");
    }
       
// -----------API Function to Update Books by ID--------------
public function update_Book_ID(Request $request)
{
    $request->validate([
        'id' => 'required',
        'name' => 'required | string | min:4',
        'description' => 'required | string | min:5 | max:1000',
        'author' => 'required | string', 
        'image' => 'required',  
        'price' => 'required | integer', 
    ]);
    $data = DB::table('books')->where('id', $request->id)->update(['name'=>$request->name, 
        'description'=>$request->description, 
        'author'=>$request->author, 
        'price'=>$request->price, 'quantity'=>$request->quantity, 'image'=>$request->image]);
    
    return response()->json(['message'=>'Book Updated Successfully'],200);
    Log::channel('custom')->info("Book Updated Successfully");
}



/**
     * @OA\GET(
     *   path="/api/displayBooks",
     *   summary="Display Books",
     *   description="display ALL Books ",
     *   @OA\RequestBody(
     *    ),
     *   @OA\Response(response=201, description="success"),
     *   @OA\Response(response=401, description="No Book Found to Display"),
     * )
     * 
     *
     * @return \Illuminate\Http\JsonResponse
     */

    // -----------API Function to display Books-------------------
public function display_Books()
{
    $book = Book::all();
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


/**
     * @OA\GET(
     *   path="/api/displayBookbyID/{id}",
     *   summary="Display Books by ID",
     *   description="Display Book Based on ID",
     *   @OA\RequestBody(
     *    ),
     *   @OA\Response(response=201, description="success"),
     *   @OA\Response(response=401, description="No Book Found with That ID to Display"),
     * )
     * 
     *
     * @return \Illuminate\Http\JsonResponse
     */

    // ------------API Function to display Book by ID------------
    public function display_Book_ID($id)
    {
        $book = Book::find($id);
        if($book)
        {
            return response()->json(['success' => $book],201);
            Log::channel('custom')->info("Book Displayed successfully based on ID");
        }
        else
        {
            return response()->json(['Message' => "No Book found with that ID"],401);
            Log::channel('custom')->info("No Book found with that ID");

        }
    }


/**
     * @OA\DELETE(
     *   path="/api/deleteBookID/{id}",
     *   summary="Delete Book",
     *   description="Delete users Books by ID",
     *   @OA\RequestBody(
     *    ),
     *   @OA\Response(response=201, description="Book Deleted Successfully"),
     *   @OA\Response(response=401, description="No Book Found with that ID to Delete"),
     * )
     * 
     *
     * @return \Illuminate\Http\JsonResponse
     */

    // -----------API Function to delete Book by ID--------------
    public function delete_Book_ID(Request $request, $id)
    {       
        $book = Book::find($id);
        if($book)
        {
            $book ->delete();
            return response()->json(['message'=>'Data Deleted Successfully'],201);
            Log::channel('custom')->info("Data Deleted Successfully");
        }
        else
        {
            return response()->json(['message'=>'No Book Found with that ID'],401);
            Log::channel('custom')->info("No Book found with that ID");
        }
    }


 /**
     * @OA\POST(
     *   path="/api/updateBookQuantitybyID",
     *   summary="Add Quantity to Existing Books",
     *   description="Adding Quantity of Books based on ID",
     *   @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"id","Description"},
     *               @OA\Property(property="id", type="integer"),
     *               @OA\Property(property="quantity", type="integer"),
     *               
     *            ),
     *        ),
     *    ),
     *   @OA\Response(response=201, description="Quantity of Books Updated Successfully"),
     *   @OA\Response(response=401, description="No Book Found with that ID to Update"),
     *   
     * )
     * 
     *
     * @return \Illuminate\Http\JsonResponse
     */

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
            return response()->json(['message'=>'Quantity of Books Updated Successfully'],201);
            Log::channel('custom')->info("Quantity of Books Updated Successfully");
        }
        else
        {
            return response()->json(['message'=>'No book Found with that ID'],401);
            Log::channel('custom')->info("No Book found with that ID");
        }
      
    }


/**
     * @OA\POST(
     *   path="/api/searchBook",
     *   summary="Search Books",
     *   description="Search Books based on name,id and author",
     *   @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"data"},
     *               @OA\Property(property="data", type="string"),
     *               
     *            ),
     *        ),
     *    ),
     *   @OA\Response(response=201, description="Success"),
     *   @OA\Response(response=401, description="No book Found with the entered Value"),
     *   
     * )
     * 
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // -----------API Function to Search Books by Id or Name or Author-------------------
    public function searchBook(Request $request)
    {
        $request->validate([
            'data' => 'required'
        ]);
    
        $response = DB::table('books')->where('name', $request->data)->
                                    orWhere('id', $request->data)->
                                    orWhere('author', $request->data)->get();
        if($response){
            return response()->json(['success' => $response],201);
            Log::channel('custom')->info("success");
        }
        else{
           return response()->json(['message'=>'No book Found with the entered Value'],401);
           Log::channel('custom')->info("No book Found with the entered Value");
        }
    }


/**
     * @OA\GET(
     *   path="/api/sortByPriceLowToHigh",
     *   summary="Sort Books by price Low to High",
     *   description="Sort Books Based on Price from Low to High",
     *   @OA\RequestBody(
     *    ),
     *   @OA\Response(response=201, description="success"),
     *   @OA\Response(response=401, description="No Book Found with That ID to Display"),
     * )
     * 
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // -----------API Function to display Books-------------------
    public function sortBooks_Price_LowToHigh(){
        $books = Book::select('*')->orderBy("price", "asc")->get();
        
        if($books){
            return response()->json(['success' => $books],201);
            Log::channel('custom')->info("success");
        }
        else{
           return response()->json(['message'=>'No book Found to Display'],401);
           Log::channel('custom')->info("No book Found to Display");
        }
    }


 /**
     * @OA\GET(
     *   path="/api/sortByPriceHighToLow",
     *   summary="Sort Books by price High to Low",
     *   description="Sort Books Based on Price from High to Low",
     *   @OA\RequestBody(
     *    ),
     *   @OA\Response(response=201, description="success"),
     *   @OA\Response(response=401, description="No Book Found with That ID to Display"),
     * )
     * 
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sortBook_Price_HighToLow(){
        $books = Book::select('*')->orderBy("price", "desc")->get();
        if($books){
            return response()->json(['success' => $books],201);
            Log::channel('custom')->info("success");
        }
        else{
           return response()->json(['message'=>'No book Found to Display'],401);
           Log::channel('custom')->info("No book Found to Display");
        }
    }



}