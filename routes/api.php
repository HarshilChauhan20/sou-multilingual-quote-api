<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuoteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// User Registration Route (Step 1: Register with NULL quote)
Route::post('/user-details', [UserController::class, 'store']);

// User Quote Selection Route (Step 2: Select and store a quote)
Route::post('/users/{userId}/select-quote', [UserController::class, 'selectQuote']);

// Latest 8 user names
Route::get('/latest-names', [UserController::class, 'latestNamesApi'])
    ->name('latest-names');

// Quote Routes for displaying language-specific quotes
Route::prefix('quotes')->group(function () {
    // Get a random quote by language
    Route::get('/random', [QuoteController::class, 'getQuoteByLanguage']);
    
    // Get all quotes by language
    Route::get('/by-language', [QuoteController::class, 'getQuotesByLanguage']);
    
    // Get all available languages
    Route::get('/languages', [QuoteController::class, 'getAvailableLanguages']);
});


