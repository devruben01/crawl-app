<?php

use App\Constants\RouteName;
use App\Http\Controllers\Api\CrawlerController;
use App\Http\Controllers\Api\SampleController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'prefix' => 'v1',
    'as' => 'v1.',
], function () {
    Route::get('/crawler', [CrawlerController::class, 'index'])->name(RouteName::CRAWLER);
    Route::post('login', [AuthController::class, 'login'])->name(RouteName::LOGIN);
});

Route::group([
    'middleware' => ['api', 'auth'],
    'prefix' => 'v1',
    'as' => 'v1.',
], function ($router) {
    Route::post('logout', [AuthController::class, 'logout'])->name(RouteName::LOGOUT);
    Route::post('refresh', [AuthController::class, 'refresh'])->name(RouteName::REFRESH);
    Route::post('me', [AuthController::class, 'me'])->name(RouteName::ME);

    // Sample management
    Route::get('samples', [SampleController::class, 'index'])->name(RouteName::SAMPLE_INDEX);
    Route::post('samples', [SampleController::class, 'store'])->name(RouteName::SAMPLE_STORE);
    Route::get('samples/{id}', [SampleController::class, 'show'])->name(RouteName::SAMPLE_SHOW);
    Route::put('samples/{id}', [SampleController::class, 'update'])->name(RouteName::SAMPLE_UPDATE);
    Route::delete('samples/{id}', [SampleController::class, 'destroy'])->name(RouteName::SAMPLE_DESTROY);
});

Route::fallback(function () {
    return 'Hm, the routing is wrong, you idiot';
});
