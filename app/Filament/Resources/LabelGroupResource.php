<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\LabelGroup;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LabelGroupResource\Pages;
use App\Filament\Resources\LabelGroupResource\RelationManagers;

use function Ramsey\Uuid\v1;

class LabelGroupResource extends Resource
{
    protected static ?string $model = LabelGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Grupo de Etiquetas';

    protected static ?string $navigationGroup = 'Configurações';
    
    protected static ?string $modelLabel = 'Grupo de Etiquetas';

    protected static ?string $pluralLabel = 'Grupos de Etiquetas';

    protected static ?string $pluralModelLabel = 'Grupos de Etiquetas';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?string $slug = 'grupos-de-etiqueta';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Fieldset::make('Configurações Gerais')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nome do Grupo de Etiquetas')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\FileUpload::make('image')
                        ->label('Imagem da Etiqueta')
                        ->image()
                        ->required(),

                    Forms\Components\TextInput::make('page_size')
                        ->label('Tamanho da Página')
                        ->required(),

                    Forms\Components\TextInput::make('page_orientation')
                        ->label('Orientação da Página')
                        ->required(),
                ]),

            Forms\Components\Fieldset::make('Margens da Página')
                ->schema([
                    Forms\Components\TextInput::make('page_margin_top')
                        ->label('Margem Superior da Página (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('page_margin_right')
                        ->label('Margem Direita da Página (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('page_margin_bottom')
                        ->label('Margem Inferior da Página (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('page_margin_left')
                        ->label('Margem Esquerda da Página (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),
                ]),

            Forms\Components\Fieldset::make('Configurações do Rótulo')
                ->schema([

                    Forms\Components\TextInput::make('printing_area_width')
                        ->label('Largura da Área de Impressão (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('printing_area_height')
                        ->label('Altura da Área de Impressão (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('label_width')
                        ->label('Largura do Rótulo (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('label_height')
                        ->label('Altura do Rótulo (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('labels_per_row')
                        ->label('Etiquetas por Linha')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('labels_per_page')
                        ->label('Etiquetas por Página')
                        ->numeric()
                        ->required(),

                    Forms\Components\TextInput::make('labels_row_gap')
                        ->label('Espaçamento entre Linhas (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('labels_column_gap')
                        ->label('Espaçamento entre Colunas (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),
                ]),

            Forms\Components\Fieldset::make('Configurações do Nome do Produto')
                ->schema([
                    Forms\Components\TextInput::make('product_name_top')
                        ->label('Distância do Nome do Produto do Topo (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_name_left')
                        ->label('Distância do Nome do Produto da Esquerda (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_name_width')
                        ->label('Largura do Nome do Produto (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_name_height')
                        ->label('Altura do Nome do Produto (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_name_text_align')
                        ->label('Alinhamento do Texto do Nome do Produto')
                        ->required(),

                    Forms\Components\TextInput::make('product_name_font_size')
                        ->label('Tamanho da Fonte do Nome do Produto')
                        ->required(),
                ]),

            Forms\Components\Fieldset::make('Configurações das Propriedades do Produto')
                ->schema([
                    Forms\Components\TextInput::make('product_properties_left')
                        ->label('Distância das Propriedades do Produto da Esquerda (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_properties_width')
                        ->label('Largura das Propriedades do Produto (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_property_cure_top')
                        ->label('Distância da Propriedade de Cura do Topo (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_property_viscosity_top')
                        ->label('Distância da Propriedade de Viscosidade do Topo (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_property_thickness_top')
                        ->label('Distância da Propriedade de Espessura do Topo (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_property_width')
                        ->label('Largura das Propriedades do Produto (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_property_height')
                        ->label('Altura das Propriedades do Produto (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\Select::make('product_properties_visibility')
                        ->label('Visibilidade das Propriedades do Produto')
                        ->options([
                            'visible' => 'Visível',
                            'hidden' => 'Oculto',
                        ])
                        ->required(),
                ]),

            Forms\Components\Fieldset::make('Configurações das Informações do Produto')
                ->schema([
                    Forms\Components\TextInput::make('product_info_top')
                        ->label('Distância das Informações do Produto do Topo (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_info_left')
                        ->label('Distância das Informações do Produto da Esquerda (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_info_width')
                        ->label('Largura das Informações do Produto (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_info_font_size')
                        ->label('Tamanho da Fonte das Informações do Produto')
                        ->required(),

                    Forms\Components\TextInput::make('product_info_line_height')
                        ->label('Altura da Linha das Informações do Produto')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_info_padding')
                        ->label('Preenchimento das Informações do Produto (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\Select::make('product_info_visibility')
                        ->label('Visibilidade dos Informações do Produto')
                        ->options([
                            'visible' => 'Visível',
                            'hidden' => 'Oculto',
                        ])
                        ->required(),
                ]),

            Forms\Components\Fieldset::make('Configurações do Lote do Produto')
                ->schema([
                    Forms\Components\TextInput::make('product_batch_top')
                        ->label('Distância do Lote do Produto do Topo (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_batch_left')
                        ->label('Distância do Lote do Produto da Esquerda (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_batch_width')
                        ->label('Largura do Lote do Produto (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_batch_height')
                        ->label('Altura do Lote do Produto (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_batch_font_size')
                        ->label('Tamanho da Fonte do Lote do Produto')
                        ->required(),

                    Forms\Components\TextInput::make('product_batch_text_align')
                        ->label('Alinhamento do Texto do Lote do Produto')
                        ->required(),

                    Forms\Components\TextInput::make('product_batch_padding')
                        ->label('Preenchimento do Lote do Produto (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\Select::make('product_batch_visibility')
                        ->label('Visibilidade dos Lotes')
                        ->options([
                            'visible' => 'Visível',
                            'hidden' => 'Oculto',
                        ])
                        ->required(),
                ]),
 
            Forms\Components\Fieldset::make('Configurações do Código de Barras')
                ->schema([
                    Forms\Components\TextInput::make('product_barcode_top')
                        ->label('Distância do Código de Barras do Topo (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_barcode_left')
                        ->label('Distância do Código de Barras da Esquerda (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_barcode_width')
                        ->label('Largura do Código de Barras (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_barcode_height')
                        ->label('Altura do Código de Barras (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_barcode_padding')
                        ->label('Preenchimento do Código de Barras (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),
                ]),

            Forms\Components\Fieldset::make('Configurações dos Pictogramas do Produto')
                ->schema([
                    Forms\Components\TextInput::make('product_pictograms_top')
                        ->label('Distância dos Pictogramas do Topo (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_pictograms_left')
                        ->label('Distância dos Pictogramas da Esquerda (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_pictograms_width')
                        ->label('Largura dos Pictogramas (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_pictograms_height')
                        ->label('Altura dos Pictogramas (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_pictograms_padding')
                        ->label('Preenchimento dos Pictogramas (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_pictograms_image_width')
                        ->label('Largura da Imagem dos Pictogramas (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\Select::make('product_pictograms_visibility')
                        ->label('Visibilidade dos Pictogramas')
                        ->options([
                            'visible' => 'Visível',
                            'hidden' => 'Oculto',
                        ])
                        ->required(),

                    Forms\Components\TextInput::make('product_pictograms_gap')
                        ->label('Espaçamento entre Pictogramas (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),
                ]),

            Forms\Components\Fieldset::make('Configurações do Peso do Produto')
                ->schema([
                    Forms\Components\TextInput::make('product_weight_top')
                        ->label('Distância do Peso do Produto do Topo (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_weight_left')
                        ->label('Distância do Peso do Produto da Esquerda (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_weight_width')
                        ->label('Largura do Peso do Produto (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_weight_height')
                        ->label('Altura do Peso do Produto (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_weight_font_size')
                        ->label('Tamanho da Fonte do Peso do Produto')
                        ->required(),

                    Forms\Components\TextInput::make('product_weight_text_align')
                        ->label('Alinhamento do Texto do Peso do Produto')
                        ->required(),
                ]),

            Forms\Components\Fieldset::make('Configurações da Proporção do Produto')
                ->schema([
                    Forms\Components\TextInput::make('proportion_top')
                        ->label('Distância da Proporção do Topo (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('proportion_left')
                        ->label('Distância da Proporção da Esquerda (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('proportion_width')
                        ->label('Largura da Proporção (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('proportion_height')
                        ->label('Altura da Proporção (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('proportion_text_align')
                        ->label('Alinhamento do Texto da Proporção')
                        ->required(),

                    Forms\Components\TextInput::make('proportion_font_size')
                        ->label('Tamanho da Fonte da Proporção')
                        ->required(),
                    
                    Forms\Components\Select::make('proportion_visibility')
                        ->label('Visibilidade da Proporção')
                        ->options([
                            'visible' => 'Visível',
                            'hidden' => 'Oculto',
                        ])
                        ->required(),                        
                ]),   
                
            Forms\Components\Fieldset::make('Configurações da Descrição do Produto')
                ->schema([
                    Forms\Components\TextInput::make('product_description_top')
                        ->label('Distância da Descrição do Topo (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_description_left')
                        ->label('Distância da Descrição da Esquerda (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_description_width')
                        ->label('Largura da Descrição (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_description_height')
                        ->label('Altura da Descrição (cm)')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),

                    Forms\Components\TextInput::make('product_description_text_align')
                        ->label('Alinhamento do Texto da Descrição')
                        ->required(),

                    Forms\Components\TextInput::make('product_description_font_size')
                        ->label('Tamanho da Fonte da Descrição')
                        ->required(),
                    
                    Forms\Components\Select::make('product_description_visibility')
                        ->label('Visibilidade da Descrição')
                        ->options([
                            'visible' => 'Visível',
                            'hidden' => 'Oculto',
                        ])
                        ->required(),                        
                ]),                  
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Imagem'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nome do Grupo de Etiquetas')
                    ->searchable()
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
                        ->before(function (Tables\Actions\DeleteAction $action, LabelGroup $record) {
                            if ($record->products()->exists()) {
                                Notification::make()
                                    ->danger()
                                    ->title('A exclusão falhou!')
                                    ->body('O grupo de etiquetas possui produtos relacionados e não pode ser excluído.')
                                    ->persistent()
                                    ->send();
                    
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
            'index' => Pages\ListLabelGroups::route('/'),
            'edit' => Pages\EditLabelGroup::route('/{record}/edit'),

        ];
    }
}
