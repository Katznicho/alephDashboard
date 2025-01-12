<?php

namespace App\Filament\Resources\AboutusResource\Pages;

use App\Filament\Resources\AboutusResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAboutus extends ViewRecord
{
    protected static string $resource = AboutusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
