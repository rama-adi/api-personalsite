<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use FilamentCurator\Forms\Components\MediaPicker;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Livewire\TemporaryUploadedFile;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationGroup = "Content";


    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Content')
                    ->columns(1)
                    ->columnSpan(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        TiptapEditor::make('body')
                            ->required(),
                    ]),
                Forms\Components\Fieldset::make('Meta & SEO')
                    ->columns(1)
                    ->columnSpan(1)
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Author')
                            ->required()
                            ->relationship('user', 'name'),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Published_at'),
                        Forms\Components\SpatieTagsInput::make('tags')
                            ->type('post-tags'),
                    ]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Creator'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\SpatieTagsColumn::make('tags')
                    ->type('post-tags'),
                Tables\Columns\BooleanColumn::make('published_at')
                    ->default(false)
                    ->label('Is published?'),
                Tables\Columns\TextColumn::make('created_at')
                    ->date(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
