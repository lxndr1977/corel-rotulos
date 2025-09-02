<?php

namespace App\Filament\Resources\Pictograms;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Pictograms\Pages\ManagePictograms;
use Filament\Forms;
use Filament\Tables;
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

    protected static ?string $label = 'Pictograma';

    protected static string | \UnitEnum | null $navigationGroup = 'Configurações';
    
    protected static ?string $modelLabel = 'Pictograma';

    protected static ?string $pluralLabel = 'Pictogramas';

    protected static ?string $pluralModelLabel = 'Pictogramas';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?string $slug = 'pictogramas';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('description')
                    ->label('Descrição do Pictograma')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('image')
                    ->label('Imagem do Pictograma')
                    ->required()
                    ->disk('public')
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
             ImageColumn::make('image')
                  ->label('Pictograma')
                  ->disk('public'),

                TextColumn::make('description')
                    ->label('Descrição do Pictograma')
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
                        ->before(function (DeleteAction $action, Pictogram $record) {
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
            ->toolbarActions([
            
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePictograms::route('/'),
        ];
    }
}
