<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'thumbnail',
        'url_file',
        'url_video',
        'about',
        'category_id',
        'recipe_author_id',
        'slug'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function author()
    {
        return $this->belongsTo(RecipeAuthor::class, 'recipe_author_id');
    }
    public function photos()
    {
        return $this->hasMany(RecipePhoto::class,'recipe_id');
    }
    public function tutorials()
    {
        return $this->hasMany(RecipeTutorial::class);
    }
    public function recipeIngredients()
    {
        return $this->hasMany(RecipeIngredient::class);
    }
}
