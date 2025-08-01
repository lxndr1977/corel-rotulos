<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\UnitMeasurement;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UnitMeasurementResource\Pages;
use App\Filament\Resources\UnitMeasurementResource\RelationManagers;

class UnitMeasurementResource extends Resource
{
    protected static ?string $model = UnitMeasurement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Unidade de Medida';

    protected static ?string $navigationGroup = 'Configurações';
    
    protected static ?string $modelLabel = 'Unidade de Medida';

    protected static ?string $pluralLabel = 'Unidades de Medida';

    protected static ?string $pluralModelLabel = 'Unidades de Medida';

    protected static bool $hasTitleCaseModelLabel = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('unit_name')
                    ->label('Nome da Unidade de Medida')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('unit_symbol')
                    ->label('Símbolo da Unidade de Medida')
                    ->required()
                    ->maxLength(10),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('unit_name')
                    ->label('Nome da Unidade de Medida')
                    ->searchable()
                    ->sortable(), 

                Tables\Columns\TextColumn::make('unit_symbol')
                    ->label('Símbolo da Unidade de Medida')
                    ->sortable(), 
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    
                    Tables\Actions\EditAction::make(),

                    Tables\Actions\DeleteAction::make()
                        ->before(function (Tables\Actions\DeleteAction $action, UnitMeasurement $record) {
                            if ($record->products()->exists()) {
                                Notification::make()
                                    ->danger()
                                    ->title('A exclusão falhou!')
                                    ->body('A unidade de medida possui produtos relacionados e não pode ser excluída')
                                    ->persistent()
                                    ->send();
                    
                                    // This will halt and cancel the delete action modal.
                                    $action->cancel();
                            }
                        }),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUnitMeasurements::route('/'),
        ];
    }
}
