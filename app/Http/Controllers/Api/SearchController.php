<?php

namespace App\Http\Controllers\Api;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\RecipeResource;

class SearchController extends Controller
{
    public function index (Request $request){
        // input adalah key pada url
        $quary = $request->input('query');
        $recipes = Recipe::with('author')->where('name', 'LIKE', "%{$quary}%")->get();
        return RecipeResource::collection($recipes);
    }
}
