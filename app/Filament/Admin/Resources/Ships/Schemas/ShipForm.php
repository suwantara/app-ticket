<?php

namespace App\Filament\Admin\Resources\Ships\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ShipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kapal')
                    ->description('Detail kapal fast boat')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Kapal')
                                    ->required()
                                    ->placeholder('Express Bahari 1'),

                                TextInput::make('code')
                                    ->label('Kode Kapal')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('EB-01'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('operator')
                                    ->label('Nama Operator')
                                    ->placeholder('Express Bahari'),

                                TextInput::make('capacity')
                                    ->label('Kapasitas')
                                    ->numeric()
                                    ->default(50)
                                    ->suffix('penumpang')
                                    ->minValue(1),
                            ]),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->placeholder('Deskripsi singkat tentang kapal...')
                            ->columnSpanFull(),
                    ]),

                Section::make('Media')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Foto Kapal')
                                    ->image()
                            ->disk('public')
                                    ->directory('ships')
                                    ->visibility('public')
                                    ->maxSize(2048)
                                    ->imageEditor()
                                    ->helperText('Unggah foto kapal'),

                                FileUpload::make('operator_logo')
                                    ->label('Logo Operator')
                                    ->image()
                            ->disk('public')
                                    ->directory('operators')
                                    ->visibility('public')
                                    ->maxSize(1024)
                                    ->helperText('Unggah logo operator'),
                            ]),
                    ]),

                Section::make('Fasilitas')
                    ->schema([
                        TagsInput::make('facilities')
                            ->label('Fasilitas Kapal')
                            ->placeholder('Tambah fasilitas')
                            ->suggestions([
                                'AC', 'Toilet', 'Life Jacket', 'Asuransi',
                                'Bagasi', 'TV', 'Musik', 'Snack', 'Air Mineral',
                                'Deck Terbuka', 'WiFi', 'USB Charger',
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('Pengaturan')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Aktif')
                                    ->default(true)
                                    ->helperText('Kapal aktif dapat dijadwalkan'),

                                TextInput::make('order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0),
                            ]),
                    ]),
            ]);
    }
}
