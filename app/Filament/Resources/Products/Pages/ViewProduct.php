<?php

namespace App\Filament\Resources\Products\Pages;

use Filament\Actions;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Actions\Modal\Actions\Action;
use App\Filament\Resources\Products\ProductResource;
use App\Filament\Resources\Products\Schemas\Schemas\ProductForm;

class ViewProduct extends ViewRecord
{
   protected static string $resource = ProductResource::class;

   public function hasCombinedRelationManagerTabsWithContent(): bool
   {
      return true;
   }

   protected function getHeaderActions(): array
   {
      return [
         EditAction::make()
      ];
   }
}
