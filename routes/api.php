<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/recipe/search',[SearchController::class, 'index']);
Route::get('/category/{category:slug}',[CategoryController::class, 'show']);
Route::apiResource('/categories', CategoryController::class);
Route::get('/recipe/{recipe:slug}',[RecipeController::class, 'show']);
Route::apiResource('/recipes', RecipeController::class);
