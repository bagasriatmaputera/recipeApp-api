<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecipePhoto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'recipe_photos';
    protected $fillable = [
        'photo',
        'recipe_id'
    ];

    public function recipe(){
        return $this->belongsTo(Recipe::class,'recipe_id');
    }
}
