<?php

namespace App\Filament\Resources\HazardClasses\Pages;

use App\Filament\Resources\HazardClasses\HazardClassResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHazardClasses extends ListRecords
{
    protected static string $resource = HazardClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
