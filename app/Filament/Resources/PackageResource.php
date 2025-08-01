<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Package;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PackageResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PackageResource\RelationManagers;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Configurações';

    protected static ?string $label = 'Embalagem';

    protected static ?string $modelLabel = 'Embalagem';

    protected static ?string $pluralLabel = 'Embalagens';

    protected static ?string $pluralModelLabel = 'Embalagens';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?string $slug = 'embalagens';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //                
                Forms\Components\FileUpload::make('image')
                    ->label('Imagem da Embalagem')
                    ->image()
                    ->required(),

                Forms\Components\TextInput::make('description')
                    ->label('Descrição'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\ImageColumn::make('image')
                    ->label('Embalagem'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição da embalagem'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    
                    Tables\Actions\EditAction::make(),

                    Tables\Actions\DeleteAction::make()
                        ->before(function (Tables\Actions\DeleteAction $action, Package $record) {
                            if ($record->products()->exists()) {
                                Notification::make()
                                    ->danger()
                                    ->title('A exclusão falhou!')
                                    ->body('A embalagem possui produtos relacionados e não pode ser excluída.')
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
            'index' => Pages\ManagePackages::route('/'),
        ];
    }
}
