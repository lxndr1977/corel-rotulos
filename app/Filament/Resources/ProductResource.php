<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use App\Models\Pictogram;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers\BatchesRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\VariationsRelationManager;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $label = 'Produto';

    protected static ?string $modelLabel = 'Produto';

    protected static ?string $pluralLabel = 'Produtos';

    protected static ?string $pluralModelLabel = 'Produtos';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?string $slug = 'produtos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                // Basic information

                Forms\Components\Section::make('Identificação do Produto')
                    ->schema([
                        Forms\Components\TextInput::make('comercial_name')
                                ->label('Nome Comercial')
                                ->required()
                                ->maxLength(255),

                        Forms\Components\TextInput::make('label_name')
                                ->label('Nome para Impressão no Rótulo')
                                ->required()
                                ->maxLength(25),


                        // Forms\Components\TextInput::make('label_product_description')
                        //     ->label('Descrição para Impressão no Rótulo')
                        //     ->maxLength(150),

                        Forms\Components\TextInput::make('internal_name')
                                ->label('Nome de Uso Interno')
                                ->maxLength(255),
                    ]),

                // Properties

                Forms\Components\Section::make('Propriedades')
                    ->schema([  
                        Forms\Components\Select::make('cure')
                            ->label('Tipo de Cura')
                            ->options([
                                'na' => 'Não se aplica',
                                'lenta' => 'Lenta',
                                'rapida' => 'Rápida',
                            ])
                            ->required(),
        
                        Forms\Components\Select::make('viscosity')
                            ->label('Viscosidade')
                            ->options([
                                'na' => 'Não se aplica',
                                'baixa' => 'Baixa',
                                'media' => 'Média',
                                'alta' => 'Alta',
                            ])
                            ->required(),     
                        
                        Forms\Components\Select::make('thickness')
                            ->label('Espessura')
                            ->options([
                                'na' => 'Não se aplica',
                                'alta' => 'Alta',
                                'baixa' => 'Baixa',
                            ])
                            ->required(),
                    ])->columns(3),

                // Technical Information
                
                Forms\Components\Section::make('Informacões Técnicas')
                    ->schema([  
                        Forms\Components\TextInput::make('chemycal_type')
                            ->label('Tipo Químico')
                            ->columnSpanFull()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('liquid_substance')
                            ->label('Substância Líquida')
                            ->columnSpanFull()
                            ->maxLength(255),                    
                        
                        Forms\Components\TextInput::make('technical_features')
                            ->label('Características Técnicas')
                            ->columnSpanFull()
                            ->maxLength(255),
                    ]),

                // Identification and risks

                Forms\Components\Section::make('Identificação e Riscos')
                    ->schema([  
                        Forms\Components\TextInput::make('un_number')
                            ->label('Número ONU')
                            ->maxLength(255), 
                            
                        Forms\Components\Select::make('hazard_class_id')
                            ->label('Classe de Risco')
                            ->relationship('hazardClass', 'class_number')
                            ->required(),
                    ])->columns(2),    

                // Pictograms

                Forms\Components\Section::make('Pictogramas')
                    ->schema([
                        Forms\Components\Select::make('pictograms')
                        ->label('Pictogramas')
                        ->relationship('pictograms', 'description')
                        ->native(false)
                        ->multiple()
                        ->allowHtml() 
                        ->options(
                            Pictogram::all()->mapWithKeys(function ($pictogram) {
                                return [
                                    $pictogram->id => 
                                        "<div style='display: flex; align-items: center;'>
                                            <img src='" . Storage::url($pictogram->image) . "' style='width: 40px; height: 40px; margin-right: 10px;'/>
                                            <span>" . $pictogram->description . "</span>
                                        </div>"
                                ];
                            })->toArray()
                        ),
                    ]),


                // Others informations

                Forms\Components\Section::make('Outras Informações')
                    ->schema([  
                        Forms\Components\TextInput::make('proportion')
                            ->label('Proporção de Mistura ou Shore')
                            ->maxLength(50), 

                        Forms\Components\Textarea::make('description')
                            ->label('Informações de uso interno')
                            ->rows(10)
                            ->cols(20),
                        ]),                    
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('comercial_name')
                    ->label('Nome Comercial')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('internal_name')
                    ->sortable()
                    ->searchable()
                    ->label('Nome Interno'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('print')
                    ->label('Imprimir')
                    ->icon('heroicon-o-printer')
                    ->url(fn (Product $record): string => ProductResource::getUrl('print', ['record' => $record])),  
                
                Tables\Actions\EditAction::make(),
                
                Tables\Actions\ActionGroup::make([
                        Tables\Actions\ViewAction::make(),
                        Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->searchOnBlur(true);
    }

    public static function getRelations(): array
    {
        return [
           BatchesRelationManager::class,
           VariationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'print' => Pages\PrintLabel::route('/{record}/imprimir-etiqueta'),
        ];
    }
}
