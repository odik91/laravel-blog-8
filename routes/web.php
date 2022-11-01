<?php

use App\Http\Controllers\BlogingController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\Admin\SubmenuController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect()->route('article.index');
});

Auth::routes();


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'isAdmin']], function () {
// Route::group(['prefix' => 'admin'], function () {
    Route::get('/', function () {
        return redirect()->route('home');
    });

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Category
    Route::resource('categories', CategoriesController::class);
    Route::get('/trash/categories', [CategoriesController::class, 'trash'])->name('categories.trash');
    Route::get('/restore/categories/{id}', [CategoriesController::class, 'trashRestore'])->name('categories.restore');
    Route::delete('/remove/categories/{id}', [CategoriesController::class, 'destroyItem'])->name('categories.remove');

    // Subcategories
    Route::resource('subcategories', SubcategoryController::class);
    Route::get('/trash/subcategories', [SubcategoryController::class, 'trash'])->name('subcategories.trash');
    Route::get('/restore/subcategories/{id}', [SubcategoryController::class, 'trashRestore'])->name('subcategories.restore');
    Route::delete('/remove/subcategories/{id}', [SubcategoryController::class, 'destroyItem'])->name('subcategories.remove');

    // Post
    Route::resource('posts', PostController::class);
    Route::get('/ajax-subcategories/{id}', [PostController::class, 'loadSubcategory']);
    Route::post('/ajax-test/{id}', [PostController::class, 'ajaxTest']);
    Route::get('/trash/posts', [PostController::class, 'trash'])->name('posts.trash');
    Route::get('/restore/posts/{id}', [PostController::class,'trashRestore'])->name('posts.restore');
    Route::delete('/remove/posts/{id}', [PostController::class,'destroyItem'])->name('posts.remove');
    Route::post('/ajaxUploadImage', [PostController::class,'ajaxUploadImage'])->name('ajax.upload');
    Route::post('/ajaxDeleteImage', [PostController::class,'ajaxDeleteImage'])->name('ajax.delete');
    Route::post('/uploadImage', [PostController::class,'uploadImage'])->name('upload.image');

    // Role
    Route::resource('role', RoleController::class);
    Route::get('roles/trash', [RoleController::class,'trash'])->name('role.trash');
    Route::get('roles/trash/restore/{id}', [RoleController::class,'trashRestore'])->name('role.restore');
    Route::delete('roles/{id}', [RoleController::class,'trashRemove'])->name('role.remove');

    // Users
    Route::resource('users', UsersController::class);
    Route::get('user/trash', [UsersController::class,'userTrash'])->name('users.trash');
    Route::get('user/restore/{id}', [UsersController::class,'trashRestore'])->name('users.restore');
    Route::delete('user/trash/{id}', [UsersController::class,'destroyItem'])->name('users.remove');

    // Message
    Route::get('message', [MessageController::class, 'index'])->name('message.index');
    Route::get('message/{id}/read', [MessageController::class,'read'])->name('message.read');
    Route::post('message/next-message-page', [MessageController::class,'nextPage'])->name('message.nextPage');
    Route::delete('message/{id}/delete', [MessageController::class,'delete'])->name('message.deleteing');

    // message trash
    Route::get('message/trash', [MessageController::class,'trash'])->name('message.trash');
    Route::post('message/trash/restore', [MessageController::class,'restoreMessage'])->name('message.restoreMessage');
    Route::post('message/next-trash-page', [MessageController::class, 'nextTrashPage'])->name('message.nextTrashPage');

    Route::post('message/next-page-inbox', [MessageController::class, 'nextPageInbox'])->name('message.nextPageInbox');
    Route::post('message/delete', [MessageController::class, 'deleteMessage'])->name('message.delete');
    Route::post('message/reply', [MessageController::class, 'replyMessage'])->name('message.reply');
    Route::post('message/send-multy', [MessageController::class, 'sendMulty'])->name('message.sendMulty');
    Route::post('message/sending-multy', [MessageController::class, 'sendingMulty'])->name('message.sendingMulty');
    Route::get('message/compose', [MessageController::class, 'compose'])->name('message.compose');
    Route::post('message/send-mail', [MessageController::class, 'send'])->name('message.send');
    Route::post('message/drafts-mail', [MessageController::class, 'toDrafts'])->name('message.drafts');
    Route::get('message/forward/{id}', [MessageController::class, 'forward'])->name('message.forward');
    Route::get('message/{id}/star', [MessageController::class, 'star'])->name('message.star');
    Route::post('message/mark-as-read', [MessageController::class, 'markRead'])->name('message.markRead');
    Route::post('message/count', [MessageController::class, 'checkInboxCount'])->name('message.inboxCount');
    Route::get('message/sent', [MessageController::class, 'sent'])->name('message.sent');
    Route::post('message/next-sent-page', [MessageController::class, 'nextSentPage'])->name('message.nextSentPage');
    Route::get('message/{id}/edit', [MessageController::class, 'editMessage'])->name('message.editMessage');
    Route::get('message/drafts', [MessageController::class, 'drafts'])->name('message.list-drafts');
    Route::post('message/next-drafts-page', [MessageController::class, 'nextDraftsPage'])->name('message.nextDraftsPage');

    // menu route
    Route::resource('menu', MenuController::class);
    Route::get('menus/trash', [MenuController::class, 'trash'])->name('menu.trash');
    Route::get('menus/{id}/restore', [MenuController::class, 'restoreMenu'])->name('menu.restore');
    Route::delete('menus/{id}/delete', [MenuController::class, 'delete'])->name('menu.delete');

    // submenu route
    Route::resource('submenu', SubmenuController::class);
    Route::get('/submenus/trash', [SubmenuController::class, 'trash'])->name('submenu.trash');
    Route::get('/submenus/{id}/restore', [SubmenuController::class, 'restoreSubmenu'])->name('submenu.restore');
    Route::delete('/submenus/{id}/delete', [SubmenuController::class, 'deleteSubmenu'])->name('submenu.delete');

    // permission
    Route::resource('permission', PermissionController::class);

    // comments
    Route::get('/comment', [CommentController::class, 'index'])->name('comment.index');
    Route::get('/comment/reply/{id}', [CommentController::class, 'getReply'])->name('comment.getreply');
    Route::delete('/comment/destroy/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');

    // profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['put', 'patch'], 'profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
});

// public pages
Route::prefix('blog')->group(function () {
    Route::resource('article', BlogingController::class);
    Route::get('article/{slug}/view', [BlogingController::class, 'singlePage'])->name('article.view');
    Route::get('article/category/{slug}', [BlogingController::class, 'postByCategory'])->name('article.category');
    Route::get('article/subcategory/{id}', [BlogingController::class, 'postBySubategory'])->name('article.subcategory');
    Route::post('articles/test/ajax', [BlogingController::class, 'loadArticleData'])->name('article.loadData');
    Route::post('articles/category/post', [BlogingController::class, 'loadArticleCategory'])->name('article.loadDataCategory');
    Route::get('articles/{year}/{month}/archive', [BlogingController::class, 'postArchive'])->name('article.archive');
    Route::post('articles/archive/post', [BlogingController::class, 'loadPostArchive'])->name('article.loadArchive');
    Route::post('articles/comment/reply', [BlogingController::class, 'postReplay'])->name('article.replay');
    Route::get('articles/search/', [BlogingController::class, 'searchQuery'])->name('article.search');
    Route::get('articles/about', [BlogingController::class, 'about'])->name('article.about');
    Route::get('articles/contact', [BlogingController::class, 'contact'])->name('article.contact');
    Route::post('articles/contact', [BlogingController::class, 'sendMessage'])->name('article.sendMessage');

    // test view
    Route::get('articles/test-view', [BlogingController::class, 'testView'])->name('article.test-view');
});
