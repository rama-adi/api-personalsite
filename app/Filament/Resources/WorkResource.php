<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkResource\Pages;
use App\Filament\Resources\WorkResource\RelationManagers;
use App\Models\Work;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use FilamentCurator\Forms\Components\MediaPicker;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkResource extends Resource
{
    protected static ?string $model = Work::class;

    protected static ?string $navigationGroup = "Content";
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Body content')
                    ->columns(1)
                    ->columnSpan(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        MediaPicker::make('image')
                            ->required()
                            ->buttonLabel('Pick an image for the work')
                            ->label('Header image'),
                        TiptapEditor::make('body')
                            ->required()
                            ->maxLength(65535),
                    ]),
                Forms\Components\Fieldset::make('Information')
                    ->columns(1)
                    ->columnSpan(1)
                    ->schema([
                        Forms\Components\TextInput::make('visit')
                            ->label('Link to visit')
                            ->maxLength(255),
                        MediaPicker::make('og-image')
                            ->label('Opengraph thumbnail')
                            ->buttonLabel('Pick an opengraph thumbnail'),
                        Forms\Components\MultiSelect::make('tools_used')
                            ->options(['PHP', 'Laravel', 'React', 'Tailwindcss', 'Vuejs']),
                    ])
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('image'),
                Tables\Columns\TextColumn::make('body'),
                Tables\Columns\TextColumn::make('visit'),
                Tables\Columns\TextColumn::make('tools_used'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
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
            'index' => Pages\ListWorks::route('/'),
            'create' => Pages\CreateWork::route('/create'),
            'edit' => Pages\EditWork::route('/{record}/edit'),
        ];
    }
}
