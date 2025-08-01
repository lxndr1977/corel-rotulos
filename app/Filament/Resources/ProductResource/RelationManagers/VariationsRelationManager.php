<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Package;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource;
use App\Filament\Forms\Components\SelectPackages;
use App\Models\LabelGroup;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class VariationsRelationManager extends RelationManager
{
    protected static string $relationship = 'variations';

    protected static ?string $title = 'Variações de peso';

    protected static ?string $label = 'Variações';

    protected static ?string $modelLabel = 'Variações';

    protected static ?string $pluralLabel = 'Variações de peso';

    protected static ?string $pluralModelLabel = 'Variações de peso';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // SelectPackages::make('package_id')
                //     ->label('Embalagem')
                //     ->required(),

                Forms\Components\Select::make('package_id')
                    ->label('Embalagem')
                    ->relationship('package', 'description')
                    ->required()
                    ->native(false)
                    ->selectablePlaceholder(false)
                    ->allowHtml() // Permite HTML nas opções
                    ->options(
                        Package::all()->mapWithKeys(function ($pack) {
                            return [
                                $pack->id => "<div style='display: flex; align-items: center;'>
                                                <img src='" . Storage::url($pack->image) . "' style='width: 40px; height: 40px; margin-right: 10px;'/>
                                                <span>" . $pack->description . "</span>
                                            </div>"
                            ];
                        })->toArray()
                    ),

                Forms\Components\Select::make('label_group_id')
                    ->label('Rótulo')
                    ->relationship('labelGroup', 'name')
                    ->required()
                    ->native(false)
                    ->selectablePlaceholder(false)
                    ->allowHtml() // Permite HTML nas opções
                    ->options(
                        LabelGroup::all()->mapWithKeys(function ($label) {
                            return [
                                $label->id => "<div style='display: flex; align-items: center;'>
                                                <img src='" . Storage::url($label->image) . "' style='width: 40px; height: 40px; margin-right: 10px;'/>
                                                <span>" . $label->name . "</span>
                                            </div>"
                            ];
                        })->toArray()
                    ),
                                   

                    
                Forms\Components\TextInput::make('weight')
                    ->label('Peso')
                    ->numeric()
                    ->inputMode('decimal'),
                
                Forms\Components\Select::make('unit_measurement_id')
                    ->label('Unidade de Medida')
                    ->relationship('unitMeasurement', 'unit_symbol')
                    ->required(), 


                Forms\Components\TextInput::make('gtin')
                    ->label('GTIN - Número do Código de Barras')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('weight')
                    ->label('Peso')
                    ->formatStateUsing(fn($record) => $record->formattedWeight() . ' ' . $record->unitMeasurement->unit_symbol), 

                Tables\Columns\TextColumn::make('gtin')
                    ->label('Código de Barras'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\Action::make('print')
                //     ->label('Imprimir')
                //     ->icon('heroicon-o-printer')
                //     ->url(fn (ProductVariation $record): string => ProductResource::getUrl('print', ['record' => $record])),  
              
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
