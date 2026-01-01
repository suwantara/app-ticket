<?php

namespace App\Filament\Admin\Resources\Routes\Schemas;

use App\Models\Destination;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class RouteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Rute')
                    ->description('Detail rute perjalanan fast boat')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('code')
                                    ->label('Kode Rute')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('SAN-NP')
                                    ->helperText('Kode unik untuk rute, contoh: SAN-NP')
                                    ->maxLength(20),

                                TextInput::make('base_price')
                                    ->label('Harga Dasar')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('Rp')
                                    ->suffix('/ orang')
                                    ->minValue(0),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('origin_id')
                                    ->label('Asal')
                                    ->relationship('origin', 'name')
                                    ->options(function () {
                                        return Destination::query()
                                            ->where('is_active', true)
                                            ->orderBy('name')
                                            ->pluck('name', 'id');
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn ($set, $get) => static::updateCode($set, $get)),

                                Select::make('destination_id')
                                    ->label('Tujuan')
                                    ->relationship('destination', 'name')
                                    ->options(function () {
                                        return Destination::query()
                                            ->where('is_active', true)
                                            ->orderBy('name')
                                            ->pluck('name', 'id');
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->different('origin_id')
                                    ->live()
                                    ->afterStateUpdated(fn ($set, $get) => static::updateCode($set, $get)),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('distance')
                                    ->label('Jarak')
                                    ->numeric()
                                    ->suffix('km')
                                    ->minValue(0)
                                    ->placeholder('25'),

                                TextInput::make('duration')
                                    ->label('Durasi Perjalanan')
                                    ->numeric()
                                    ->suffix('menit')
                                    ->minValue(0)
                                    ->placeholder('45')
                                    ->helperText('Estimasi waktu perjalanan dalam menit'),
                            ]),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->placeholder('Deskripsi singkat tentang rute perjalanan...')
                            ->columnSpanFull(),
                    ]),

                Section::make('Pengaturan')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Aktif')
                                    ->default(true)
                                    ->helperText('Rute aktif akan ditampilkan di halaman pemesanan'),

                                TextInput::make('order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->helperText('Urutan tampil di daftar rute'),
                            ]),
                    ]),
            ]);
    }

    protected static function updateCode($set, $get): void
    {
        $originId = $get('origin_id');
        $destinationId = $get('destination_id');

        if ($originId && $destinationId) {
            $origin = Destination::find($originId);
            $destination = Destination::find($destinationId);

            if ($origin && $destination) {
                $originCode = Str::upper(Str::substr($origin->name, 0, 3));
                $destCode = Str::upper(Str::substr($destination->name, 0, 3));
                $set('code', "{$originCode}-{$destCode}");
            }
        }
    }
}
