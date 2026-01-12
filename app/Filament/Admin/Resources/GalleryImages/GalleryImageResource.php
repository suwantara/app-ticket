<?php

namespace App\Filament\Admin\Resources\GalleryImages;

use App\Filament\Admin\Resources\GalleryImages\Pages\CreateGalleryImage;
use App\Filament\Admin\Resources\GalleryImages\Pages\EditGalleryImage;
use App\Filament\Admin\Resources\GalleryImages\Pages\ListGalleryImages;
use App\Filament\Admin\Resources\GalleryImages\Schemas\GalleryImageForm;
use App\Filament\Admin\Resources\GalleryImages\Tables\GalleryImagesTable;
use App\Models\GalleryImage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GalleryImageResource extends Resource
{
    protected static ?string $model = GalleryImage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Galeri';

    protected static ?string $modelLabel = 'Gambar Galeri';

    protected static ?string $pluralModelLabel = 'Galeri';

    protected static ?string $recordTitleAttribute = 'caption';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return 'Pariwisata';
    }

    public static function form(Schema $schema): Schema
    {
        return GalleryImageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GalleryImagesTable::configure($table);
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
            'index' => ListGalleryImages::route('/'),
            'create' => CreateGalleryImage::route('/create'),
            'edit' => EditGalleryImage::route('/{record}/edit'),
        ];
    }
}
