<?php
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClinetController;

//dashbord routes

 //admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/',[AdminController::class,'index'])->name('index');

    //clients routes
    Route::get('clients/trash', [ClinetController::class, 'trash'])->name('clients.trash');
    Route::get('clients/{id}/restore', [ClinetController::class, 'restore'])->name('clients.restore');
    Route::delete('clients/{id}/forcedelete', [ClinetController::class, 'forcedelete'])->name('clients.forcedelete');
    Route::resource('clients',ClinetController::class);

});



// Route::view('not','not_allawd');


//->middleware('auth','check_user')

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
