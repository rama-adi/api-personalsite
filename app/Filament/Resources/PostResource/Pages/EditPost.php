<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Jobs\OpengraphCreator\PostOpengraphGenerator;
use App\Models\Post;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function afterSave(): void
    {
        PostOpengraphGenerator::dispatch($this->record->id);
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
