<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\APIDataController;

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


Route::group(['middleware' => ['XSS']], function () {

    Route::group(array('namespace' => 'api'), function () {

        /*Get Room Type & Rate Plan Mapping Request - Hotel user login*/
        Route::post('/get/mapping', [APIDataController::class, 'userLogin']);

        /*Availability Update based on room type Request*/
        Route::post('/update/inventory', [APIDataController::class, 'updateAvailabilityRoomType']);

        /*Rate Update based on room type Request*/
        Route::post('/update/rate/restriction', [APIDataController::class, 'updateRateRoomType']);
    });
});