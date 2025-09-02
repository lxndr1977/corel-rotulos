<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
   protected static string $resource = ProductResource::class;

   protected function getRedirectUrl(): string
   {
      return $this->previousUrl ?? $this->getResource()::getUrl('index');
   }
}
