<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;

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



Route::post('changePassword',[PasswordController::class,'changePassword']);
Route::post('forgotPassword',[PasswordController::class,'forgotPassword']);
Route::post('resetPassword',[PasswordController::class,'resetPassword']);

Route::POST('registration',[UserController::class,'Registerdata']);
Route::POST('login',[UserController::class,'login']);
Route::POST('logout',[UserController::class,'logout']);

Route::POST('addBook',[BookController::class,'addBook']);
Route::GET('displayBooks',[BookController::class,'display_Books']);
Route::GET('displayBookbyID/{id}',[BookController::class,'display_Book_ID']);
Route::POST('updateBookID/{id}',[BookController::class,'update_Book_ID']);
Route::POST('updateBookQuantitybyID',[BookController::class,'addQuantityForExistingBook']);
Route::delete('deleteBookID/{id}',[BookController::class,'delete_Book_ID']);

Route::post('searchBook',[BookController::class,'searchBook']);
Route::GET('sortByPriceLowToHigh',[BookController::class,'sortBooks_Price_LowToHigh']);
Route::GET('sortByPriceHighToLow',[BookController::class,'sortBook_Price_HighToLow']);

Route::post('addBookTocart',[CartController::class, 'addBookTocart']);
Route::post('deleteBookFromCart',[CartController::class, 'deleteBookFromCart']);
Route::get('getAllBooks',[CartController::class, 'getAllBooks']);
Route::post('updateBookInCart',[CartController::class, 'updateBookInCart']);
Route::post('updateQuantityInCart',[CartController::class, 'updateQuantityInCart']);


Route::post('addBookToWishlist', [WishlistController::class, 'addBookToWishlist']);
Route::get('getAllBooksFromWishlists', [WishlistController::class, 'getAllBooksFromWishlists']);
Route::post('deleteBookFromWishlists', [WishlistController::class, 'deleteBookFromWishlists']);


