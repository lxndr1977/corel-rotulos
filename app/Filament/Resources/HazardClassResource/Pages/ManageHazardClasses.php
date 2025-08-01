<?php

namespace App\Filament\Resources\HazardClassResource\Pages;

use App\Filament\Resources\HazardClassResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageHazardClasses extends ManageRecords
{
    protected static string $resource = HazardClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
