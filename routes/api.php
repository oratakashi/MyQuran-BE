<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CrawlerController;
use App\Http\Controllers\Api\SurahController;

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

Route::controller(CrawlerController::class)->group(function() {
    Route::prefix('crawler')->group(function () {
        Route::get("/", "index");

        Route::get("/surah", "getSurah");
        Route::put("/surah", "updateAyat");

        Route::get("/surah/{id}", "show");
    });
});

Route::apiResource('/surah', SurahController::class);

