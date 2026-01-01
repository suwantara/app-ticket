<?php

namespace App\Filament\Admin\Resources\Routes;

use App\Filament\Admin\Resources\Routes\Pages\CreateRoute;
use App\Filament\Admin\Resources\Routes\Pages\EditRoute;
use App\Filament\Admin\Resources\Routes\Pages\ListRoutes;
use App\Filament\Admin\Resources\Routes\Schemas\RouteForm;
use App\Filament\Admin\Resources\Routes\Tables\RoutesTable;
use App\Models\Route;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RouteResource extends Resource
{
    protected static ?string $model = Route::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    protected static ?string $recordTitleAttribute = 'code';

    protected static ?string $modelLabel = 'Rute';

    protected static ?string $pluralModelLabel = 'Rute';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return 'Pariwisata';
    }

    public static function form(Schema $schema): Schema
    {
        return RouteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RoutesTable::configure($table);
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
            'index' => ListRoutes::route('/'),
            'create' => CreateRoute::route('/create'),
            'edit' => EditRoute::route('/{record}/edit'),
        ];
    }
}
