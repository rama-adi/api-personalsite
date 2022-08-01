<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobLogResource\Pages;
use App\Filament\Resources\JobLogResource\RelationManagers;
use App\Models\JobLog;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobLogResource extends Resource
{
    protected static ?string $model = JobLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';
    protected static ?string $navigationGroup = 'System';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('')
                    ->schema([
                        Forms\Components\Tabs\Tab::make('Summary')
                            ->schema([
                                Forms\Components\Grid::make(4)
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->columnSpan(3)
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('status')
                                            ->required()
                                            ->columns(1)
                                            ->maxLength(255),
                                    ]),

                                Forms\Components\TextInput::make('job_class')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\DateTimePicker::make('finished_at'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Log')
                            ->schema([
                                Forms\Components\Textarea::make('log')
                                    ->label('Log data')
                            ])
                    ]),

            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        "warning" => "WORKING",
                        "success" => "DONE"
                    ]),
                Tables\Columns\TextColumn::make('finished_at')
                    ->label('Finished at')
                    ->since(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListJobLogs::route('/'),
        ];
    }
}
