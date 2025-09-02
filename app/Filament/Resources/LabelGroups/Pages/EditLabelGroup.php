<?php

namespace App\Filament\Resources\LabelGroups\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\LabelGroups\LabelGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLabelGroup extends EditRecord
{
    protected static string $resource = LabelGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
