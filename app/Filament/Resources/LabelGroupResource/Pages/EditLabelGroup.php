<?php

namespace App\Filament\Resources\LabelGroupResource\Pages;

use App\Filament\Resources\LabelGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLabelGroup extends EditRecord
{
    protected static string $resource = LabelGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
