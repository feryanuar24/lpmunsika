<?php

use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Article\CategoryController;
use App\Http\Controllers\Article\TagController;
use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\Article\CommentController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Media\EmbedController;
use App\Http\Controllers\PermissionRole\PermissionController;
use App\Http\Controllers\PermissionRole\PermissionRoleController;
use App\Http\Controllers\PermissionRole\RoleController;
use App\Http\Controllers\Media\PlatformController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Media\FooterController;
use App\Http\Controllers\Media\SliderController;
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/category/{category:slug}', [LandingController::class, 'category'])->name('category');
Route::get('/tag/{tag:slug}', [LandingController::class, 'tag'])->name('tag');
Route::get('/search', [LandingController::class, 'search'])->name('search');

Route::get('/detail/{article:slug}', [LandingController::class, 'show'])->name('detail');
Route::post('/like', [LandingController::class, 'like'])->name('like');
Route::post('/comment', [LandingController::class, 'comment'])->name('comment');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])
    ->middleware(['throttle:6,1']);

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])
    ->middleware(['throttle:6,1']);

Route::get('/forgot-password', [PasswordResetController::class, 'create'])
    ->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'store'])
    ->middleware(['throttle:6,1'])
    ->name('password.email');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'update'])
    ->name('password.update');

Route::get('/files/{path}', [FileController::class, 'show'])->where('path', '.*')->name('files');

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [VerificationController::class, 'create'])
        ->name('verification.notice');
    Route::post('/email/verification-notification', [VerificationController::class, 'store'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'update'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/menus', [MenuController::class, 'index'])->middleware('permission:dashboard-access')->name('menus');
    Route::resource('/chats', ChatController::class)->middleware('permission:dashboard-access');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);

    Route::resource('/users', UserController::class)->middleware('permission:users-management');

    Route::get('/articles/datatable', [ArticleController::class, 'datatable'])->middleware('permission:articles-management')->name('articles.datatable');
    Route::resource('/articles', ArticleController::class)->middleware('permission:articles-management');
    Route::resource('/categories', CategoryController::class)->middleware('permission:categories-management');
    Route::resource('/tags', TagController::class)->middleware('permission:tags-management');
    Route::resource('/comments', CommentController::class)->middleware('permission:articles-management');
    Route::post('/ckeditor/upload', [ArticleController::class, 'uploadImage'])->name('ckeditor.upload')->middleware('permission:articles-management');

    Route::resource('/platforms', PlatformController::class)->middleware('permission:platforms-management');
    Route::resource('/embeds', EmbedController::class)->middleware('permission:embeds-management');
    Route::resource('/sliders', SliderController::class)->middleware('permission:sliders-management');
    Route::resource('/footers', FooterController::class)->middleware('permission:footers-management');

    Route::resource('/permissions', PermissionController::class)->middleware('permission:permission-role-management');
    Route::resource('/roles', RoleController::class)->middleware('permission:permission-role-management');
    Route::resource('/permission-role', PermissionRoleController::class)->middleware('permission:permission-role-management')->except('destroy');
    Route::delete('/permission-role', [PermissionRoleController::class, 'destroy'])->middleware('permission:permission-role-management')->name('permission-role.destroy');

    Route::delete('/logout', [LoginController::class, 'destroy'])->name('logout');
});
