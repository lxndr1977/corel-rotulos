<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\HazardClass;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HazardClassResource\Pages;
use App\Filament\Resources\HazardClassResource\RelationManagers;

class HazardClassResource extends Resource
{
    protected static ?string $model = HazardClass::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $label = 'Classe de Risco';

    protected static ?string $navigationGroup = 'Configurações';
    
    protected static ?string $modelLabel = 'Classe de Risco';

    protected static ?string $pluralLabel = 'Classes de Risco';

    protected static ?string $pluralModelLabel = 'Classes de Risco';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?string $slug = 'classes-de-risco';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('class_number')
                    ->label('Número da Classe')
                    ->maxLength(10)
                    ->required(),

                Forms\Components\TextInput::make('class_description')
                    ->label('Descrição da Classe')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\TextInput::make('division_number')
                    ->label('Número da Subclasse')
                    ->maxLength(15),

                Forms\Components\TextInput::make('division_descrition')
                    ->label('Descrição da Subclasse')
                    ->maxLength(255)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('class_number')
                    ->label('Número da Classe')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('class_description')
                    ->label('Descrição da Classe')
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
                        ->before(function (Tables\Actions\DeleteAction $action, HazardClass $record) {
                            if ($record->products()->exists()) {
                                Notification::make()
                                    ->danger()
                                    ->title('A exclusão falhou!')
                                    ->body('A classe de risco possui produtos relacionados e não pode ser excluída.')
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
            'index' => Pages\ManageHazardClasses::route('/'),
        ];
    }
}
