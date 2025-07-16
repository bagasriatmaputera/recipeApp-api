<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'thumbnail' => $this->thumbnail,
            'url_file' => $this->url_file,
            'url_video' => $this->url_video,
            'about' => $this->about,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'author' => new RecipeAuthorResource($this->whenLoaded('author')),
            'slug' => $this->slug,
            'tutorials' => RecipeTutorialResource::collection($this->whenLoaded('tutorials')),
            'recipe_ingredient' => RecipeIngredientResource::collection($this->whenLoaded('recipeIngredients'))
        ];
    }
}
