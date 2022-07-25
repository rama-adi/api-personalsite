<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Jobs\CreateOpengraphImage;
use App\Jobs\OpengraphCreator\PostOpengraphGenerator;
use App\Models\Post;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;


    protected function afterCreate(): void
    {
        PostOpengraphGenerator::dispatch($this->record->id);
    }

    protected function getCreatedNotificationMessage(): ?string
    {
        return "Post has been created. Please wait for the opengraph thumbnail to be generated...";
    }
}
