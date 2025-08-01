<?php

namespace App\Filament\Resources\LabelGroupResource\Pages;

use App\Filament\Resources\LabelGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLabelGroups extends ManageRecords
{
    protected static string $resource = LabelGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
    