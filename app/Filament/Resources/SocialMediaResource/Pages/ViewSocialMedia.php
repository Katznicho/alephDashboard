<?php

namespace App\Filament\Resources\SocialMediaResource\Pages;

use App\Filament\Resources\SocialMediaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSocialMedia extends ViewRecord
{
    protected static string $resource = SocialMediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
