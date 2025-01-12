<?php

namespace App\Filament\Resources\AboutusResource\Pages;

use App\Filament\Resources\AboutusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAboutus extends CreateRecord
{
    protected static string $resource = AboutusResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'About us Created';
    }
}
