<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Pictogram;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PictogramResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PictogramResource\RelationManagers;

class PictogramResource extends Resource
{
    protected static ?string $model = Pictogram::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Pictograma';

    protected static ?string $navigationGroup = 'Configurações';
    
    protected static ?string $modelLabel = 'Pictograma';

    protected static ?string $pluralLabel = 'Pictogramas';

    protected static ?string $pluralModelLabel = 'Pictogramas';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?string $slug = 'pictogramas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->label('Descrição do Pictograma')
                    ->required()
                    ->maxLength(255),

                Forms\Components\FileUpload::make('image')
                    ->label('Imagem do Pictograma')
                    ->required()
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Pictograma')
                    ->square(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição do Pictograma')
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
                        ->before(function (Tables\Actions\DeleteAction $action, Pictogram $record) {
                            if ($record->products()->exists()) {
                                Notification::make()
                                    ->danger()
                                    ->title('A exclusão falhou!')
                                    ->body('O pictograma possui produtos relacionados e não pode ser excluído.')
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
            'index' => Pages\ManagePictograms::route('/'),
        ];
    }
}
