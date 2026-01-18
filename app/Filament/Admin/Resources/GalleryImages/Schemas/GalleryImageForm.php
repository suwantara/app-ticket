<?php

namespace App\Filament\Admin\Resources\GalleryImages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GalleryImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Gambar')
                    ->description('Unggah dan atur gambar galeri')
                    ->schema([
                        FileUpload::make('image_path')
                            ->label('File Gambar')
                            ->image()
                            ->disk(env('CLOUDINARY_URL') ? 'cloudinary' : 'public')
                            ->directory('gallery')
                            ->visibility('public')
                            ->imageEditor()
                            ->required()
                            ->helperText('Unggah gambar untuk galeri.')
                            ->columnSpanFull(),
                        Textarea::make('caption')
                            ->label('Keterangan')
                            ->rows(3)
                            ->placeholder('Tambahkan keterangan untuk gambar ini')
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ]),

                Section::make('Hubungan')
                    ->description('Tautkan gambar ke destinasi')
                    ->schema([
                        Select::make('destination_id')
                            ->label('Destinasi')
                            ->relationship('destination', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih destinasi (opsional)')
                            ->helperText('Pilih destinasi yang terkait dengan gambar ini'),
                    ]),
            ]);
    }
}
