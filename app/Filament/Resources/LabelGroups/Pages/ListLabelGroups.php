<?php

namespace App\Filament\Resources\LabelGroups\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\LabelGroups\LabelGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLabelGroups extends ListRecords
{
    protected static string $resource = LabelGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
