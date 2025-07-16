<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource ;

class CategoryController extends Controller
{
    public function index()
    {
        // mengambil jumlah resep yang dimiliki setiap kategori
        $categroies = Category::withCount('recipes')->get();
        // data koleksi kategori diformat rapi
        return CategoryResource::collection($categroies);
    }

    public function show(Category $category)
    {
        // mengurangi lazy loading dengan load
        $category->load('recipes');
        $category->loadCount('recipes');
        // ubah data kategori menjadi format JSON
        return new CategoryResource($category);
    }
}
