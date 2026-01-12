<?php

namespace App\Filament\Admin\Resources\Destinations\Schemas;

use Filament\Schemas\Components\FileUpload;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Components\Textarea;
use Filament\Schemas\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\RichEditor;
use Filament\Schemas\Components\TagsInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DestinationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dasar')
                    ->description('Informasi utama destinasi')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Destinasi')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                                TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                            ]),
                        Select::make('type')
                            ->label('Tipe Destinasi')
                            ->options([
                                'harbor' => 'Pelabuhan',
                                'island' => 'Pulau',
                                'city' => 'Kota',
                            ])
                            ->default('harbor')
                            ->required()
                            ->native(false),
                        TextInput::make('short_description')
                            ->label('Deskripsi Singkat')
                            ->maxLength(255)
                            ->helperText('Deskripsi singkat untuk preview card'),
                        RichEditor::make('description')
                            ->label('Deskripsi Lengkap')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'link',
                                'orderedList',
                                'bulletList',
                                'h2',
                                'h3',
                            ]),
                    ]),

                Section::make('Media')
                    ->description('Gambar dan galeri destinasi')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Gambar Utama')
                            ->image()
                            ->directory('destinations')
                            ->imageEditor()
                            ->columnSpanFull(),
                        FileUpload::make('gallery')
                            ->label('Galeri Foto')
                            ->image()
                            ->multiple()
                            ->directory('destinations/gallery')
                            ->reorderable()
                            ->maxFiles(10)
                            ->columnSpanFull(),
                    ]),

                Section::make('Lokasi')
                    ->description('Informasi lokasi dan koordinat')
                    ->schema([
                        TextInput::make('location')
                            ->label('Alamat/Lokasi')
                            ->placeholder('Contoh: Bali, Indonesia'),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('latitude')
                                    ->label('Latitude')
                                    ->numeric()
                                    ->placeholder('-8.409518'),
                                TextInput::make('longitude')
                                    ->label('Longitude')
                                    ->numeric()
                                    ->placeholder('115.188919'),
                            ]),
                    ])
                    ->collapsed(),

                Section::make('Fasilitas & Highlight')
                    ->description('Fitur unggulan destinasi')
                    ->schema([
                        TagsInput::make('facilities')
                            ->label('Fasilitas')
                            ->placeholder('Tambah fasilitas')
                            ->suggestions([
                                'Toilet',
                                'Parkir',
                                'Restoran',
                                'Musholla',
                                'Lounge',
                                'WiFi',
                                'ATM',
                                'Toko Souvenir',
                            ]),
                        TagsInput::make('highlights')
                            ->label('Highlight')
                            ->placeholder('Tambah highlight')
                            ->suggestions([
                                'Pantai Indah',
                                'Snorkeling',
                                'Diving',
                                'Sunset View',
                                'Kuliner Lokal',
                                'Budaya Tradisional',
                            ]),
                    ])
                    ->collapsed(),

                Section::make('Pengaturan')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Aktif')
                                    ->helperText('Tampilkan destinasi')
                                    ->default(true),
                                Toggle::make('is_popular')
                                    ->label('Populer')
                                    ->helperText('Tandai sebagai populer')
                                    ->default(false),
                                TextInput::make('order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0),
                            ]),
                    ]),
            ]);
    }
}
