<?php

namespace App\Filament\Admin\Resources\Schedules\Schemas;

use App\Models\Route;
use App\Models\Ship;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Rute & Kapal')
                    ->description('Pilih rute dan kapal untuk jadwal ini')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('route_id')
                                    ->label('Rute')
                                    ->options(function () {
                                        return Route::with(['origin', 'destination'])
                                            ->where('is_active', true)
                                            ->get()
                                            ->mapWithKeys(fn ($route) => [
                                                $route->id => "{$route->code} - {$route->origin->name} → {$route->destination->name}",
                                            ]);
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('ship_id')
                                    ->label('Kapal')
                                    ->options(function () {
                                        return Ship::where('is_active', true)
                                            ->orderBy('name')
                                            ->get()
                                            ->mapWithKeys(fn ($ship) => [
                                                $ship->id => "{$ship->name} ({$ship->capacity} penumpang)",
                                            ]);
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set) {
                                        if ($state) {
                                            $ship = Ship::find($state);
                                            if ($ship) {
                                                $set('available_seats', $ship->capacity);
                                            }
                                        }
                                    }),
                            ]),
                    ]),

                Section::make('Waktu Keberangkatan')
                    ->description('Atur jam keberangkatan dan kedatangan')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TimePicker::make('departure_time')
                                    ->label('Jam Berangkat')
                                    ->required()
                                    ->seconds(false),

                                TimePicker::make('arrival_time')
                                    ->label('Jam Tiba')
                                    ->required()
                                    ->seconds(false),
                            ]),

                        CheckboxList::make('days_of_week')
                            ->label('Hari Operasi')
                            ->options([
                                1 => 'Senin',
                                2 => 'Selasa',
                                3 => 'Rabu',
                                4 => 'Kamis',
                                5 => 'Jumat',
                                6 => 'Sabtu',
                                0 => 'Minggu',
                            ])
                            ->columns(7)
                            ->default([0, 1, 2, 3, 4, 5, 6])
                            ->helperText('Kosongkan untuk jadwal setiap hari'),
                    ]),

                Section::make('Harga & Kapasitas')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('price')
                                    ->label('Harga Tiket')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(0)
                                    ->placeholder('150000'),

                                TextInput::make('available_seats')
                                    ->label('Kursi Tersedia')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->helperText('Otomatis terisi dari kapasitas kapal'),
                            ]),
                    ]),

                Section::make('Periode Berlaku')
                    ->description('Jadwal hanya berlaku dalam periode ini')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('valid_from')
                                    ->label('Berlaku Dari')
                                    ->helperText('Kosongkan jika berlaku mulai sekarang'),

                                DatePicker::make('valid_until')
                                    ->label('Berlaku Sampai')
                                    ->helperText('Kosongkan jika tidak ada batas waktu'),
                            ]),
                    ]),

                Section::make('Pengaturan')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Jadwal aktif akan muncul di hasil pencarian'),

                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(2)
                            ->placeholder('Catatan internal...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
