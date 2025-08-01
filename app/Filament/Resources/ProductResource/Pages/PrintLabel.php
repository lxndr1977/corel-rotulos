<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;


class PrintLabel extends Page
{
    use InteractsWithRecord;
    
    protected static string $resource = ProductResource::class;

    protected static string $view = 'filament.resources.product-resource.pages.print-label'; 

    protected static ?string $title = 'Imprimir Etiqueta';

    protected static ?string $slug = 'custom-url-slug';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }


    
}
