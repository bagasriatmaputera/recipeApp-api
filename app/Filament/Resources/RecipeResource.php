<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Recipe;
use Filament\Forms\Form;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RecipeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RecipeResource\RelationManagers;
use App\Filament\Resources\RecipeResource\RelationManagers\TutorialsRelationManager;
use App\Models\Ingredient;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class RecipeResource extends Resource
{
    protected static ?string $model = Recipe::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->helperText('Masukan nama reseo dengan benar.')
                    ->required(),
                FileUpload::make('thumbnail')
                    ->image()
                    ->required(),
                Textarea::make('about')
                    ->rows(10)
                    ->cols(20)
                    ->required(),

                Repeater::make('recipeIngredients')
                    ->relationship()
                    ->schema([
                        Select::make('ingredient_id')
                            ->relationship('ingredient', 'name')
                            ->required(),
                    ]),

                Repeater::make('photos')
                    ->relationship('photos')
                    ->schema([
                        FileUpload::make('photo')
                            ->required()
                    ]),

                Select::make('recipe_author_id')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                FileUpload::make('url_file')
                    ->nullable(),

                TextInput::make('url_video')
                    ->nullable()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->searchable(),
                ImageColumn::make('author.photo')
                    ->circular(),
                ImageColumn::make('thumbnail')
                    ->circular()
            ])
            ->filters([
                // FIlter by Author
                SelectFilter::make('recipe_author_id')
                    ->label('Author')
                    ->relationship('author', 'name'),
                // FIlter by Category
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name'),
                // FIlter by Ingredient
                SelectFilter::make('ingredient_id')
                    ->label('Ingredient')
                    ->options(fn() => Ingredient::orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->placeholder('Pilih bahan...')
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            $query->whereHas('recipeIngredients', function ($query) use ($data) {
                                $query->where('ingredient_id', $data['value']);
                            });
                        }
                    }),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            TutorialsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecipes::route('/'),
            'create' => Pages\CreateRecipe::route('/create'),
            'edit' => Pages\EditRecipe::route('/{record}/edit'),
        ];
    }
}
