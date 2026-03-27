<?php

use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\PublicController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\EmbedController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PermissionRoleController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PlatformController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Public\SitemapController;
use App\Http\Controllers\Admin\UserController;

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

Route::get('/', [PublicController::class, 'landing'])->name('landing');
Route::get('/search', [PublicController::class, 'search'])->name('search');
Route::get('/category/{category:slug}', [PublicController::class, 'category'])->name('category');
Route::get('/tag/{tag:slug}', [PublicController::class, 'tag'])->name('tag');
Route::get('/detail/{article:slug}', [PublicController::class, 'detail'])->name('detail');
Route::post('/like', [PublicController::class, 'like'])->name('like');
Route::post('/comment', [PublicController::class, 'comment'])->name('comment');

Route::get('/files/{path}', FileController::class)->where('path', '.*')->name('files');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/menus/datatable', [MenuController::class, 'datatable'])->middleware('permission:dashboard-management')->name('menus.datatable');
    Route::resource('/menus', MenuController::class)->middleware('permission:dashboard-management');

    Route::resource('/chats', ChatController::class)->middleware('permission:dashboard-management');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);

    Route::get('/users/datatable', [UserController::class, 'datatable'])->middleware('permission:users-management')->name('users.datatable');
    Route::post('/users/save-fcm-token', [UserController::class, 'saveFcmToken'])->name('users.save-fcm-token');
    Route::post('/users/read-notification', [UserController::class, 'readNotification'])->name('users.read-notification');
    Route::post('/users/read-all-notifications', [UserController::class, 'readAllNotifications'])->name('users.read-all-notifications');
    Route::resource('/users', UserController::class)->middleware('permission:users-management');

    Route::get('/articles/datatable', [ArticleController::class, 'datatable'])->middleware('permission:articles-management')->name('articles.datatable');
    Route::post('/articles/upload-image', [ArticleController::class, 'uploadImage'])->middleware('permission:articles-management')->name('articles.upload-image');
    Route::delete('/articles/comments/{comment}', [ArticleController::class, 'deleteComment'])->middleware('permission:articles-management')->name('articles.delete-comment');
    Route::resource('/articles', ArticleController::class)->middleware('permission:articles-management');

    Route::get('/categories/datatable', [CategoryController::class, 'datatable'])->middleware('permission:categories-management')->name('categories.datatable');
    Route::resource('/categories', CategoryController::class)->middleware('permission:categories-management');

    Route::get('/tags/datatable', [TagController::class, 'datatable'])->middleware('permission:tags-management')->name('tags.datatable');
    Route::resource('/tags', TagController::class)->middleware('permission:tags-management');

    Route::get('/platforms/datatable', [PlatformController::class, 'datatable'])->middleware('permission:platforms-management')->name('platforms.datatable');
    Route::resource('/platforms', PlatformController::class)->middleware('permission:platforms-management');

    Route::get('/embeds/datatable', [EmbedController::class, 'datatable'])->middleware('permission:embeds-management')->name('embeds.datatable');
    Route::resource('/embeds', EmbedController::class)->middleware('permission:embeds-management');

    Route::get('/sliders/datatable', [SliderController::class, 'datatable'])->middleware('permission:sliders-management')->name('sliders.datatable');
    Route::resource('/sliders', SliderController::class)->middleware('permission:sliders-management');

    Route::get('/footers/datatable', [FooterController::class, 'datatable'])->middleware('permission:footers-management')->name('footers.datatable');
    Route::resource('/footers', FooterController::class)->middleware('permission:footers-management');

    Route::get('/permissions/datatable', [PermissionController::class, 'datatable'])->middleware('permission:permission-role-management')->name('permissions.datatable');
    Route::resource('/permissions', PermissionController::class)->middleware('permission:permission-role-management');

    Route::get('/roles/datatable', [RoleController::class, 'datatable'])->middleware('permission:permission-role-management')->name('roles.datatable');
    Route::resource('/roles', RoleController::class)->middleware('permission:permission-role-management');

    Route::get('/permission-role/datatable', [PermissionRoleController::class, 'datatable'])->middleware('permission:permission-role-management')->name('permission-role.datatable');
    Route::resource('/permission-role', PermissionRoleController::class)->middleware('permission:permission-role-management')->except('destroy');
    Route::delete('/{permission}/{role}/permission-role', [PermissionRoleController::class, 'destroy'])->middleware('permission:permission-role-management')->name('permission-role.destroy');
});

require __DIR__ . '/auth.php';
