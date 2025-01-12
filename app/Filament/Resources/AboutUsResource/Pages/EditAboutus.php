<?php

namespace App\Filament\Resources\AboutusResource\Pages;

use App\Filament\Resources\AboutusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAboutus extends EditRecord
{
    protected static string $resource = AboutusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
