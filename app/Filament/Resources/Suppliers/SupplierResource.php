<?php

namespace App\Filament\Resources\Suppliers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Suppliers\Pages\ManageSuppliers;
use Filament\Forms;
use Filament\Tables;
use App\Models\Supplier;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SupplierResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SupplierResource\RelationManagers;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $label = 'Fornecedor';

    protected static string | \UnitEnum | null $navigationGroup = 'Configurações';
    
    protected static ?string $modelLabel = 'Fornecedor';

    protected static ?string $pluralLabel = 'Fornecedores';

    protected static ?string $pluralModelLabel = 'Fornecedores';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?string $slug = 'fornecedores';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('company_name')
                    ->label('Nome do Fornecedor')
                    ->required()
                    ->maxLength(255),//
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_name')
                    ->label('Nome do Fornecedor')
                    ->searchable()
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
                        ->before(function (DeleteAction $action, Supplier $record) {
                            if ($record->batches()->exists()) {
                                Notification::make()
                                    ->danger()
                                    ->title('A exclusão falhou!')
                                    ->body('O fornecedor possui lotes de produtos relacionados e não pode ser excluído.')
                                    ->persistent()
                                    ->send();
                    
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
            'index' => ManageSuppliers::route('/'),
        ];
    }
}
