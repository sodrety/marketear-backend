<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\TiktokController;
use App\Http\Controllers\ProjectController;
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

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/verifyotp', [AuthController::class, 'verifyOtp']);
        Route::get('/generateotp', [AuthController::class, 'generateOtp']);
        Route::put('/profile', [AuthController::class, 'updateUser']);
        Route::put('/change-password', [AuthController::class, 'changePassword']);
    });

    Route::post('/forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
    Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

    Route::get('/social', [AuthController::class, 'handleProviderCallback']);
});

Route::prefix('tiktok')->group(function() {
    Route::post('/scrape', [TiktokController::class, 'scrape']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('workspace')->group(function () {
        Route::get('', [\App\Http\Controllers\WorkspaceController::class, 'getWorkspace']);
    });

    Route::prefix('campaign')->group(function () {
        Route::get('', [CampaignController::class, 'index']);
        Route::get('/{id}', [CampaignController::class, 'detail']);
        Route::get('/{id}/intent', [CampaignController::class, 'intent']);
        Route::post('/create', [CampaignController::class, 'create']);
        Route::get('/{id}/report', [CampaignController::class, 'report']);
    });

    Route::prefix('project')->group(function () {
        Route::post('/create', [ProjectController::class, 'create']);
        Route::post('/url-create', [ProjectController::class, 'createUrl']);
        Route::get('/categories',[ProjectController::class, 'getCategory']);
        Route::get('/list', [ProjectController::class, 'getProject']);
        Route::get('/reintent', [ProjectController::class, 'reintent']);
        Route::get('/recreator', [ProjectController::class, 'recreator']);
        Route::get('/detail/{id}', [ProjectController::class, 'getDetail']);
        Route::get('/creator/{username}', [ProjectController::class, 'getCreator']);
        Route::put('/update/{id}', [ProjectController::class,'update']);
        Route::post('/delete/{workspace}/{id}', [ProjectController::class,'deleteProject']);
        Route::put('/update/comment/{id}', [ProjectController::class,'updateIntent']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/roles',[UsersController::class, 'roles']);
        Route::get('/list',[UsersController::class, 'list']);
        Route::post('/add',[UsersController::class, 'create']);
        Route::get('/remove/{id}',[UsersController::class, 'removeUser']);
    });

    Route::prefix('subscription')->group(function () {
        Route::get('/plans', [\App\Http\Controllers\Api\SubcriptionController::class, 'getPlans']);
        Route::get('/detail', [\App\Http\Controllers\Api\SubcriptionController::class, 'getSubscription']);
        Route::get('/change', [\App\Http\Controllers\Api\SubcriptionController::class, 'changeSubscription']);
    });

});

Route::post('test-scrape', [SrapeService::class, 'scrape']);

Route::get("test", function() {
    echo "masuk aja ya";
});