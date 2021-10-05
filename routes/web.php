<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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
Route::get('/',
function ()
  {
  return view('login');
  });

// route to show the login form
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
// route to process the form
Route::post('login', [AuthController::class, 'doLogin']);
Route::get('logout', [AuthController::class, 'doLogout'])->name('logout');

// route to show the Registration form
Route::get("register", [AuthController::class, 'showRegistration'])->name('register');
// route to process the form
Route::post("register", [AuthController::class, 'register']);