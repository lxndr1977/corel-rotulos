<?php

namespace App\Filament\Resources\HazardClasses;

use App\Filament\Resources\HazardClasses\Pages\CreateHazardClass;
use App\Filament\Resources\HazardClasses\Pages\EditHazardClass;
use App\Filament\Resources\HazardClasses\Pages\ListHazardClasses;
use App\Filament\Resources\HazardClasses\Pages\ViewHazardClass;
use App\Filament\Resources\HazardClasses\Schemas\HazardClassForm;
use App\Filament\Resources\HazardClasses\Schemas\HazardClassInfolist;
use App\Filament\Resources\HazardClasses\Tables\HazardClassesTable;
use App\Models\HazardClass;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;


class HazardClassResource extends Resource
{
   protected static ?string $model = HazardClass::class;

   protected static string | UnitEnum | null $navigationGroup = 'Configurações';

   protected static ?string $recordTitleAttribute = 'class_number';

   protected static ?string $label = 'Classe de Risco';

   protected static ?string $modelLabel = 'Classe de Risco';

   protected static ?string $pluralModelLabel = 'Classes de Risco';

   protected static bool $hasTitleCaseModelLabel = false;

   protected static ?string $slug = 'classes-de-risco';

   public static function form(Schema $schema): Schema
   {
      return HazardClassForm::configure($schema);
   }

   public static function infolist(Schema $schema): Schema
   {
      return HazardClassInfolist::configure($schema);
   }

   public static function table(Table $table): Table
   {
      return HazardClassesTable::configure($table);
   }

   public static function getRelations(): array
   {
      return [
         //
      ];
   }

   public static function getPages(): array
   {
      return [
         'index' => ListHazardClasses::route('/'),
         'create' => CreateHazardClass::route('/create'),
         'edit' => EditHazardClass::route('/{record}/edit'),
      ];
   }
}
