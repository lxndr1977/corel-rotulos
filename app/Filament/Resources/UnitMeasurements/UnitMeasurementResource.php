<?php

namespace App\Filament\Resources\UnitMeasurements;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\UnitMeasurements\Pages\ManageUnitMeasurements;
use Filament\Forms;
use Filament\Tables;
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

    protected static ?string $label = 'Unidade de Medida';

    protected static string | \UnitEnum | null $navigationGroup = 'Configurações';
    
    protected static ?string $modelLabel = 'Unidade de Medida';

    protected static ?string $pluralLabel = 'Unidades de Medida';

    protected static ?string $pluralModelLabel = 'Unidades de Medida';

    protected static bool $hasTitleCaseModelLabel = false;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('unit_name')
                    ->label('Nome da Unidade de Medida')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('unit_symbol')
                    ->label('Símbolo da Unidade de Medida')
                    ->required()
                    ->maxLength(10),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unit_name')
                    ->label('Nome da Unidade de Medida')
                    ->searchable()
                    ->sortable(), 

                TextColumn::make('unit_symbol')
                    ->label('Símbolo da Unidade de Medida')
                    ->sortable(), 
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    
                    EditAction::make(),

                    DeleteAction::make()
                        ->before(function (DeleteAction $action, UnitMeasurement $record) {
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
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageUnitMeasurements::route('/'),
        ];
    }
}
