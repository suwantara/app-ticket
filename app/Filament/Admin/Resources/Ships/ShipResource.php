<?php

namespace App\Filament\Admin\Resources\Ships;

use App\Filament\Admin\Resources\Ships\Pages\CreateShip;
use App\Filament\Admin\Resources\Ships\Pages\EditShip;
use App\Filament\Admin\Resources\Ships\Pages\ListShips;
use App\Filament\Admin\Resources\Ships\Schemas\ShipForm;
use App\Filament\Admin\Resources\Ships\Tables\ShipsTable;
use App\Models\Ship;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ShipResource extends Resource
{
    protected static ?string $model = Ship::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Kapal';

    protected static ?string $pluralModelLabel = 'Kapal';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return 'Operasional';
    }

    public static function form(Schema $schema): Schema
    {
        return ShipForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShipsTable::configure($table);
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
            'index' => ListShips::route('/'),
            'create' => CreateShip::route('/create'),
            'edit' => EditShip::route('/{record}/edit'),
        ];
    }
}
