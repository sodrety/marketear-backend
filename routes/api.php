<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\UsersController;
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
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'createUser']);
    Route::post('/login', [AuthController::class, 'loginUser']);
    Route::post('/logout', [AuthController::class, 'logoutUser']);
    Route::post('/verifyotp', [AuthController::class, 'verifyOtp'])->middleware('auth:sanctum');
    Route::get('/generateotp', [AuthController::class, 'generateOtp'])->middleware('auth:sanctum');
    Route::put('/profile', [AuthController::class, 'updateUser'])->middleware('auth:sanctum');
    Route::put('/change-password', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');

    Route::post('/forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
    Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

    Route::get('/social', [AuthController::class, 'handleProviderCallback']);
});

Route::prefix('tiktok')->group(function() {
    Route::post('/scrape', [TiktokController::class, 'scrape']);
});

Route::middleware('auth:sanctum')->prefix('campaign')->group(function () {
    Route::get('', [CampaignController::class, 'index']);
    Route::get('/{id}', [CampaignController::class, 'detail']);
    Route::get('/{id}/intent', [CampaignController::class, 'intent']);
    Route::post('/create', [CampaignController::class, 'create']);
    Route::get('/{id}/report', [CampaignController::class, 'report']);
});

Route::middleware('auth:sanctum')->prefix('workspace')->group(function () {
    Route::post('/create', [WorkspaceController::class, 'create']);
    Route::post('/url-create', [WorkspaceController::class, 'createUrl']);
    Route::get('/categories',[WorkspaceController::class, 'getCategory']);
    Route::get('/list', [WorkspaceController::class, 'getWorkspace']);
    Route::get('/reintent', [WorkspaceController::class, 'reintent']);
    Route::get('/recreator', [WorkspaceController::class, 'recreator']);
    Route::get('/detail/{id}', [WorkspaceController::class, 'getDetail']);
    Route::get('/creator/{username}', [WorkspaceController::class, 'getCreator']);
    Route::put('/update/{id}', [WorkspaceController::class,'update']);
    Route::post('/delete/{id}', [WorkspaceController::class,'deleteWorkspace']);
    Route::put('/update/comment/{id}', [WorkspaceController::class,'updateIntent']);
});

Route::middleware('auth:sanctum')->prefix('users')->group(function () {
    Route::get('/roles',[UsersController::class, 'roles']);
    Route::get('/list',[UsersController::class, 'list']);
    Route::post('/add',[UsersController::class, 'create']);
    Route::get('/remove/{id}',[UsersController::class, 'removeUser']);
});

Route::post('test-scrape', [SrapeService::class, 'scrape']);

Route::get("test", function() {
    echo "masuk aja ya";
});