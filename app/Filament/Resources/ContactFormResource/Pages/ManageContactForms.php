<?php

namespace App\Filament\Resources\ContactFormResource\Pages;

use App\Filament\Resources\ContactFormResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageContactForms extends ManageRecords
{
    protected static string $resource = ContactFormResource::class;
    protected static ?string $title = "Contact form submission";


    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
