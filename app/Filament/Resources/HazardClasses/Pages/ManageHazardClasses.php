<?php

namespace App\Filament\Resources\HazardClasses\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\HazardClasses\HazardClassResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageHazardClasses extends ManageRecords
{
    protected static string $resource = HazardClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
