<?php

namespace App\Filament\Resources\HazardClasses\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class HazardClassInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('class_number'),
                TextEntry::make('class_description'),
                TextEntry::make('division_number'),
                TextEntry::make('division_description'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
