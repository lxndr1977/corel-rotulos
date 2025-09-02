<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\Package;
use App\Models\Product;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use App\Filament\Resources\Products\ProductResource;

class PackageTable
{
   public static function configure(Table $table): Table
   {
      return $table
         ->defaultSort('description')
         ->columns([
            ImageColumn::make('image')
               ->label('Embalagem')
               ->disk('public'),

            TextColumn::make('description')
               ->label('Descrição')
         ])
         ->filters([
         ])
         ->recordActions([
            ActionGroup::make([

               EditAction::make(),

               DeleteAction::make()
                  ->before(function (DeleteAction $action, Package $record) {
                     if ($record->products()->exists()) {
                        Notification::make()
                           ->danger()
                           ->title('A exclusão falhou!')
                           ->body('A embalagem possui produtos relacionados e não pode ser excluída.')
                           ->persistent()
                           ->send();

                        $action->cancel();
                     }
                  }),
            ])
         ])
         ->toolbarActions([]);
   }
}
