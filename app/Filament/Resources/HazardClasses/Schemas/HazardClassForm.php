<?php

namespace App\Filament\Resources\HazardClasses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HazardClassForm
{
   public static function configure(Schema $schema): Schema
   {
      return $schema
         ->components([
            Section::make('Classe de Risco')
               ->columnSpanFull()
               ->schema([
                  Grid::make()
                     ->columns(2)
                     ->schema([
                        TextInput::make('class_number')
                           ->label('Número da Classe')
                           ->required(),

                        TextInput::make('class_description')
                           ->label('Descrição da Classe')
                           ->required(),

                        TextInput::make('division_number')
                           ->label('Número da Divisão')
                           ->default(null),

                        TextInput::make('division_description')
                           ->label('Descrição da Divisão')
                           ->default(null),
                     ])
               ])
         ]);
   }
}
