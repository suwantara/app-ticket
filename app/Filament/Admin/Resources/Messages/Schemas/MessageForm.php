<?php

namespace App\Filament\Admin\Resources\Messages\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class MessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pengirim')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->maxLength(20),
                    ])
                    ->columns(2),

                Section::make('Pesan')
                    ->schema([
                        Select::make('subject')
                            ->label('Subjek')
                            ->required()
                            ->options([
                                'booking' => 'Pertanyaan Pemesanan',
                                'payment' => 'Pembayaran',
                                'refund' => 'Refund/Pembatalan',
                                'partnership' => 'Kerjasama',
                                'other' => 'Lainnya',
                            ]),

                        Textarea::make('message')
                            ->label('Pesan')
                            ->required()
                            ->rows(5)
                            ->maxLength(5000),

                        Select::make('status')
                            ->label('Status')
                            ->required()
                            ->options([
                                'unread' => 'Belum Dibaca',
                                'read' => 'Sudah Dibaca',
                                'replied' => 'Sudah Dibalas',
                            ])
                            ->default('unread'),
                    ]),
            ]);
    }
}
