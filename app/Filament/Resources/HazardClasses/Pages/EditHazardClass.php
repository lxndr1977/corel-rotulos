<?php

namespace App\Filament\Resources\HazardClasses\Pages;

use App\Filament\Resources\HazardClasses\HazardClassResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditHazardClass extends EditRecord
{
    protected static string $resource = HazardClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
