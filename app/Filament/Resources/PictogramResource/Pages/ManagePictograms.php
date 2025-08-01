<?php

namespace App\Filament\Resources\PictogramResource\Pages;

use App\Filament\Resources\PictogramResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePictograms extends ManageRecords
{
    protected static string $resource = PictogramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
