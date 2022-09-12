<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum'])->group(function(){

    Route::post('addBookTocart',[CartController::class, 'addBookTocart']);
    Route::get('displayAllBooksInCart',[CartController::class, 'display_Books_In_Cart']);
    Route::delete('removeBookFromCart',[CartController::class, 'removeBookFromCart']);
    Route::post('updateBookInCart',[CartController::class, 'updateBookInCart']);
    Route::post('updateQuantityInCart',[CartController::class, 'update_Quantity_In_Cart']);

    Route::POST('addBook',[BookController::class,'addBook']);
    Route::GET('displayBooks',[BookController::class,'display_Books']);
    Route::GET('displayBookbyID/{id}',[BookController::class,'display_Book_ID']);
    Route::POST('updateBookID/{id}',[BookController::class,'update_Book_ID']);
    Route::POST('updateBookQuantitybyID',[BookController::class,'addQuantityForExistingBook']);
    Route::delete('deleteBookID/{id}',[BookController::class,'delete_Book_ID']);

    Route::post('searchBook',[BookController::class,'searchBook']);
    Route::GET('sortByPriceLowToHigh',[BookController::class,'sortBooks_Price_LowToHigh']);
    Route::GET('sortByPriceHighToLow',[BookController::class,'sortBook_Price_HighToLow']);

    Route::post('addBookToWishlist', [WishlistController::class, 'addBookToWishlist']);
    Route::get('displayBooksFromWishlists', [WishlistController::class, 'displayBooksFromWishlists']);
    Route::delete('removeBookFromWishlists', [WishlistController::class, 'removeBookFromWishlists']);

    Route::post('addAddress', [AddressController::class, 'addAddress']);
    Route::post('updateAddressById', [AddressController::class, 'update_Address_Id']);
    Route::get('displayAllAddresses', [AddressController::class, 'display_AllAddresses']);
    Route::delete('deleteAddressByID', [AddressController::class, 'delete_Address_ID']);
    
    Route::post('placeOrder', [OrderController::class, 'placeOrder']);
    Route::post('cancelOrder', [OrderController::class, 'cancelOrder']);
    Route::get('getBookById', [OrderController::class, 'getBookById']);
    
    
});


Route::post('changePassword',[PasswordController::class,'changePassword']);
Route::post('forgotPassword',[PasswordController::class,'forgotPassword']);
Route::post('resetPassword',[PasswordController::class,'resetPassword']);

Route::POST('registration',[UserController::class,'Registerdata']);
Route::POST('login',[UserController::class,'login']);
Route::POST('logout',[UserController::class,'logout']);








