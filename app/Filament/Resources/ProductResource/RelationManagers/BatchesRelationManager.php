<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BatchesRelationManager extends RelationManager
{
    protected static string $relationship = 'batches';

    protected static ?string $title = 'Lotes';

    protected static ?string $label = 'Lote';

    protected static ?string $modelLabel = 'Lote';

    protected static ?string $pluralLabel = 'Lotes';

    protected static ?string $pluralModelLabel = 'Lotes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('supplier_id')
                    ->label('Fornecedor')
                    ->relationship('supplier', 'company_name')
                    ->required(),

                Forms\Components\TextInput::make('identification')
                    ->label('Identificação')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('expiration_month')
                    ->label('Mês de Validade')
                    ->required()
                    ->maxLength(2),    
                
                Forms\Components\TextInput::make('expiration_year')
                    ->label('Ano de Validade')
                    ->required()
                    ->maxLength(4),                     
            ]);
    }
 
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('identification')
            ->columns([
                Tables\Columns\TextColumn::make('supplier.company_name')
                    ->label('Fornecedor'),

                Tables\Columns\TextColumn::make('identification')
                    ->label('Identificação'),

                Tables\Columns\TextColumn::make('expiration_month')
                    ->label('Mês de Validade'),

                Tables\Columns\TextColumn::make('expiration_year')
                    ->label('Ano de Validade'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
