<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/',[\App\Http\Controllers\VisitorController::class, 'index'])->name("VPage");

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/order/{id}/status', [HomeController::class, 'changeStatus'])->name('order.status');

// Category
Route::get('/category',[CategoryController::class, 'index'])->name("cat.index");
Route::post('/category/store',[CategoryController::class, 'store'])->name("cat.store");
Route::delete('/category/delete/{id}',[CategoryController::class, 'destroy'])->name("cat.delete");
Route::post('/category/update/{id}',[CategoryController::class, 'update'])->name("cat.update");

// Meal
Route::get('/meal',[MealController::class, 'index'])->name("meal.index");
Route::get('/meal/create',[MealController::class, 'create'])->name("meal.create");
Route::post('/meal/store',[MealController::class, 'store'])->name("meal.store");
Route::get('/meal/edit/{id}',[MealController::class, 'edit'])->name("meal.edit");
Route::put('/meal/update/{id}',[MealController::class, 'update'])->name("meal.update");
Route::delete('/meal/delete/{id}',[MealController::class, 'destroy'])->name("meal.delete");
Route::get('/meal/show/{id}',[MealController::class, 'show'])->name("meal.details");

// Orders Route
Route::post('/order/store',[OrderController::class, 'store'])->name("order.store");
Route::get('/order/show',[OrderController::class, 'show_order'])->name("order.show");

