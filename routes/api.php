<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\ApiResource;
use App\Models\Prodi;
use App\Models\Wave;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */

Route::get('/program-studi', function () {
    return new ApiResource(200, 'LIST_PRODI', Prodi::where('status', 1)->get());
});

Route::get('/gelombang', function () {
    return new ApiResource(200, 'LIST_GELOMBANG', Wave::getActiveData());
});
