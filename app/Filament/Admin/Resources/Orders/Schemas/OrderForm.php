<?php

namespace App\Filament\Admin\Resources\Orders\Schemas;

use App\Models\Schedule;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                // Main Order Info
                Section::make('Informasi Pesanan')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        Placeholder::make('order_number')
                            ->label('Nomor Pesanan')
                            ->content(fn ($record) => $record?->order_number ?? 'Otomatis')
                            ->hiddenOn('create'),

                        Select::make('schedule_id')
                            ->label('Jadwal')
                            ->relationship('schedule', 'id')
                            ->getOptionLabelFromRecordUsing(fn (Schedule $record) => "{$record->route->origin->name} → {$record->route->destination->name} ({$record->departure_time_formatted})"
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        DatePicker::make('travel_date')
                            ->label('Tanggal Perjalanan')
                            ->required()
                            ->native(false),

                        TextInput::make('passenger_count')
                            ->label('Jumlah Penumpang')
                            ->numeric()
                            ->required()
                            ->minValue(1),

                        TextInput::make('total_amount')
                            ->label('Total Pembayaran')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),

                        Select::make('status')
                            ->label('Status Pesanan')
                            ->options([
                                'pending' => 'Menunggu',
                                'confirmed' => 'Dikonfirmasi',
                                'cancelled' => 'Dibatalkan',
                                'completed' => 'Selesai',
                            ])
                            ->default('pending')
                            ->required(),

                        Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'unpaid' => 'Belum Dibayar',
                                'pending' => 'Menunggu Konfirmasi',
                                'paid' => 'Lunas',
                                'refunded' => 'Dikembalikan',
                            ])
                            ->default('unpaid')
                            ->required(),

                        Textarea::make('notes')
                            ->label('Catatan')
                            ->columnSpanFull()
                            ->rows(2),
                    ]),

                // Contact Info
                Section::make('Informasi Kontak')
                    ->columnSpan(1)
                    ->schema([
                        TextInput::make('contact_name')
                            ->label('Nama Kontak')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('contact_email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(100),

                        TextInput::make('contact_phone')
                            ->label('Telepon')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                    ]),

                // Passengers
                Section::make('Data Penumpang')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('passengers')
                            ->label('')
                            ->relationship()
                            ->columns(4)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama')
                                    ->required()
                                    ->maxLength(100),

                                Select::make('type')
                                    ->label('Tipe')
                                    ->options([
                                        'adult' => 'Dewasa',
                                        'child' => 'Anak',
                                        'infant' => 'Bayi',
                                    ])
                                    ->default('adult')
                                    ->required(),

                                Select::make('gender')
                                    ->label('Jenis Kelamin')
                                    ->options([
                                        'male' => 'Laki-laki',
                                        'female' => 'Perempuan',
                                    ])
                                    ->required(),

                                TextInput::make('id_number')
                                    ->label('No. Identitas'),

                                Placeholder::make('ticket_code')
                                    ->label('Kode Tiket')
                                    ->content(fn ($record) => $record?->ticket_code ?? 'Otomatis'),
                            ])
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Penumpang')
                            ->reorderable(false),
                    ]),
            ]);
    }
}
