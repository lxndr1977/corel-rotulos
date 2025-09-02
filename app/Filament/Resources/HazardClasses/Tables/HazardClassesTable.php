<?php

namespace App\Filament\Resources\HazardClasses\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HazardClassesTable
{
   public static function configure(Table $table): Table
   {
      return $table
         ->columns([
            TextColumn::make('class_number')
               ->label('Número da Classe')
               ->searchable(),

            TextColumn::make('class_description')
               ->label('Descrição')
               ->searchable(),

            TextColumn::make('created_at')
               ->dateTime()
               ->sortable()
               ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('updated_at')
               ->dateTime()
               ->sortable()
               ->toggleable(isToggledHiddenByDefault: true),
         ])
         ->filters([
            //
         ])
         ->recordActions([
            ActionGroup::make([
               EditAction::make(),
               DeleteAction::make(),
            ])

         ])
         ->toolbarActions([
            BulkActionGroup::make([
               DeleteBulkAction::make(),
            ]),
         ]);
   }
}
