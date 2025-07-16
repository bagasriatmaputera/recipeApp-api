<?php

namespace App\Http\Controllers\Api;

use App\Models\Recipe;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\RecipeResource;

class RecipeController extends Controller
{
    public function index()
    {
        // pada recipeIngredients sekaligus mengambil relasi ingredien pada model RecipeIngredient
        $recipes = Recipe::with(['photos', 'category', 'author', 'tutorials', 'recipeIngredients.ingredient'])->get();
        return RecipeResource::collection($recipes);
    }

    public function show(Recipe $recipe)
    {
        $recipe->load(['photos', 'category', 'author', 'tutorials', 'recipeIngredients.ingredient']);
        return new RecipeResource($recipe);
    }
}
