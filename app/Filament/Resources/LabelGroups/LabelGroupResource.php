<?php

namespace App\Filament\Resources\LabelGroups;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\LabelGroups\Pages\ListLabelGroups;
use App\Filament\Resources\LabelGroups\Pages\EditLabelGroup;
use Filament\Forms;
use Filament\Tables;
use App\Models\LabelGroup;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LabelGroupResource\Pages;
use App\Filament\Resources\LabelGroupResource\RelationManagers;
use App\Filament\Resources\Users\Schemas\LabelGroupForm;

use function Ramsey\Uuid\v1;

class LabelGroupResource extends Resource
{
    protected static ?string $model = LabelGroup::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Configurações';

    protected static ?string $label = 'Grupo de Etiquetas';
    
    protected static ?string $modelLabel = 'Grupo de Etiquetas';

    protected static ?string $pluralLabel = 'Grupos de Etiquetas';

    protected static ?string $pluralModelLabel = 'Grupos de Etiquetas';

    protected static bool $hasTitleCaseModelLabel = false;

    protected static ?string $slug = 'grupos-de-etiqueta';

    public static function form(Schema $schema): Schema
    {
        return LabelGroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Imagem'),

                TextColumn::make('name')
                    ->label('Nome do Grupo de Etiquetas')
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
                        ->before(function (DeleteAction $action, LabelGroup $record) {
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
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLabelGroups::route('/'),
            'edit' => EditLabelGroup::route('/{record}/edit'),

        ];
    }
}
