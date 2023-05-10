<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\TiktokController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\SrapeService;
use Illuminate\Support\Facades\Broadcast;

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
Broadcast::routes(['middleware' => ['auth:sanctum']]);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('/auth/logout', [AuthController::class, 'logoutUser']);


Route::prefix('tiktok')->group(function() {
    Route::post('/scrape', [TiktokController::class, 'scrape']);
});

Route::prefix('campaign')->group(function () {
    Route::get('', [CampaignController::class, 'index']);
    Route::get('/{id}', [CampaignController::class, 'detail']);
    Route::get('/{id}/intent', [CampaignController::class, 'intent']);
    Route::post('/create', [CampaignController::class, 'create']);
    Route::get('/{id}/report', [CampaignController::class, 'report']);
});

Route::prefix('workspace')->group(function () {
    Route::post('/create', [WorkspaceController::class, 'create']);
    Route::post('/url-create', [WorkspaceController::class, 'createUrl']);
    Route::get('/categories',[WorkspaceController::class, 'getCategory']);
    Route::get('/list', [WorkspaceController::class, 'getWorkspace']);
    Route::get('/reintent', [WorkspaceController::class, 'reintent']);
    Route::get('/recreator', [WorkspaceController::class, 'recreator']);
    Route::get('/detail/{id}', [WorkspaceController::class, 'getDetail']);
    Route::get('/creator/{username}', [WorkspaceController::class, 'getCreator']);
});

Route::post('test-scrape', [SrapeService::class, 'scrape']);

Route::get("test", function() {
    echo "masuk";
});