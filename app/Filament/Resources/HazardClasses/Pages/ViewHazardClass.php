<?php

namespace App\Filament\Resources\HazardClasses\Pages;

use App\Filament\Resources\HazardClasses\HazardClassResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewHazardClass extends ViewRecord
{
    protected static string $resource = HazardClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
