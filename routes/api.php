<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GeneralController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/event',[GeneralController::class, 'get_event']);
Route::post('/event/reedem',[GeneralController::class, 'reedem']);
Route::post('/event/reedem/upload',[GeneralController::class, 'upload']);

Route::post('/callback/validation/image',[GeneralController::class, 'callback']);
