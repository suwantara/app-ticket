<?php

namespace App\Filament\Admin\Resources\Messages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject')
                    ->label('Subjek')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'booking' => 'Pertanyaan Pemesanan',
                        'payment' => 'Pembayaran',
                        'refund' => 'Refund/Pembatalan',
                        'partnership' => 'Kerjasama',
                        'other' => 'Lainnya',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'booking' => 'info',
                        'payment' => 'success',
                        'refund' => 'warning',
                        'partnership' => 'primary',
                        default => 'gray',
                    }),

                TextColumn::make('message')
                    ->label('Pesan')
                    ->limit(50)
                    ->wrap(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'unread' => 'Belum Dibaca',
                        'read' => 'Sudah Dibaca',
                        'replied' => 'Sudah Dibalas',
                        default => $state,
                    })
                    ->colors([
                        'danger' => 'unread',
                        'warning' => 'read',
                        'success' => 'replied',
                    ]),

                TextColumn::make('created_at')
                    ->label('Dikirim')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'unread' => 'Belum Dibaca',
                        'read' => 'Sudah Dibaca',
                        'replied' => 'Sudah Dibalas',
                    ]),

                SelectFilter::make('subject')
                    ->label('Subjek')
                    ->options([
                        'booking' => 'Pertanyaan Pemesanan',
                        'payment' => 'Pembayaran',
                        'refund' => 'Refund/Pembatalan',
                        'partnership' => 'Kerjasama',
                        'other' => 'Lainnya',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
