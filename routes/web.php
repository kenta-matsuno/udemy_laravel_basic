<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ContactFormController;

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

Route::get('tests/test', [ TestController::class, 'index' ]); 

//Route::resource('contacts', ContactFormController::class)

Route::get('contacts', [ ContactFormController::class, 'index'])->name('contacts.index');

Route::prefix('contacts') // 頭に contacts をつける
 ->middleware(['auth']) // 認証
 ->controller(ContactFormController::class) // コントローラ指定(laravel9から)
 ->name('contacts.') // ルート名
 ->group(function(){ // グループ化
   Route::get('/', 'index')->name('index'); // 名前つきルート
   Route::get('/create', 'create')->name('create'); 
   Route::post('/', 'store')->name('store'); // 追記
   Route::get('/{id}', 'show')->name('show'); // {id}でviewからのルートパラメータを取得できる
   Route::get('/{id}/edit', 'edit')->name('edit');
   Route::post('/{id}', 'update')->name('update'); 
   Route::post('/{id}/destroy', 'destroy')->name('destroy');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
