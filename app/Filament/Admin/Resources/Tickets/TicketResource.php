<?php

namespace App\Filament\Admin\Resources\Tickets;

use BackedEnum;
use App\Models\Ticket;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Admin\Resources\Tickets\Pages\ViewTicket;
use App\Filament\Admin\Resources\Tickets\Pages\ListTickets;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

    protected static ?string $recordTitleAttribute = 'ticket_number';

    protected static ?string $modelLabel = 'Tiket';

    protected static ?string $pluralModelLabel = 'Tiket';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return 'Transaksi';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'active')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('No. Tiket')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->fontFamily('mono'),

                TextColumn::make('order.order_number')
                    ->label('No. Order')
                    ->searchable()
                    ->sortable()
                    ->fontFamily('mono'),

                TextColumn::make('passenger.name')
                    ->label('Penumpang')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('order.schedule.route.origin.name')
                    ->label('Asal')
                    ->sortable(),

                TextColumn::make('order.schedule.route.destination.name')
                    ->label('Tujuan')
                    ->sortable(),

                TextColumn::make('order.travel_date')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'used' => 'info',
                        'cancelled' => 'danger',
                        'expired' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Aktif',
                        'used' => 'Digunakan',
                        'cancelled' => 'Dibatalkan',
                        'expired' => 'Kadaluarsa',
                        default => $state,
                    }),

                TextColumn::make('used_at')
                    ->label('Digunakan')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Aktif',
                        'used' => 'Digunakan',
                        'cancelled' => 'Dibatalkan',
                        'expired' => 'Kadaluarsa',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                Action::make('downloadPdf')
                    ->label('Download PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->url(fn (Ticket $record): string => route('ticket.pdf.single', [
                        'ticketNumber' => $record->ticket_number,
                        'token' => \App\Http\Controllers\TicketPdfController::generateToken($record->order),
                    ]))
                    ->openUrlInNewTab(),
                Action::make('markAsUsed')
                    ->label('Tandai Digunakan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Tandai Tiket Sebagai Digunakan')
                    ->modalDescription('Apakah Anda yakin ingin menandai tiket ini sebagai sudah digunakan?')
                    ->visible(fn (Ticket $record): bool => $record->status === 'active')
                    ->action(fn (Ticket $record) => $record->markAsUsed('Admin')),
                Action::make('cancel')
                    ->label('Batalkan')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Batalkan Tiket')
                    ->modalDescription('Apakah Anda yakin ingin membatalkan tiket ini?')
                    ->visible(fn (Ticket $record): bool => $record->status === 'active')
                    ->action(fn (Ticket $record) => $record->cancel()),
            ])
            ->bulkActions([]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Tiket')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('ticket_number')
                                    ->label('No. Tiket')
                                    ->fontFamily('mono')
                                    ->size('lg')
                                    ->weight('bold')
                                    ->copyable(),

                                TextEntry::make('qr_code')
                                    ->label('QR Code')
                                    ->fontFamily('mono')
                                    ->copyable(),

                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'active' => 'success',
                                        'used' => 'info',
                                        'cancelled' => 'danger',
                                        'expired' => 'warning',
                                        default => 'gray',
                                    }),
                            ]),
                    ]),

                Section::make('Informasi Order')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('order.order_number')
                                    ->label('No. Order')
                                    ->fontFamily('mono'),

                                TextEntry::make('order.contact_name')
                                    ->label('Nama Kontak'),

                                TextEntry::make('order.contact_email')
                                    ->label('Email'),
                            ]),
                    ]),

                Section::make('Informasi Penumpang')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('passenger.name')
                                    ->label('Nama Penumpang'),

                                TextEntry::make('passenger.id_type')
                                    ->label('Tipe ID')
                                    ->formatStateUsing(fn (string $state): string => strtoupper($state)),

                                TextEntry::make('passenger.id_number')
                                    ->label('No. Identitas'),
                            ]),
                    ]),

                Section::make('Informasi Perjalanan')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('order.schedule.route.origin.name')
                                    ->label('Asal'),

                                TextEntry::make('order.schedule.route.destination.name')
                                    ->label('Tujuan'),

                                TextEntry::make('order.schedule.ship.name')
                                    ->label('Kapal'),

                                TextEntry::make('order.travel_date')
                                    ->label('Tanggal')
                                    ->date('d F Y'),

                                TextEntry::make('order.schedule.departure_time')
                                    ->label('Waktu Berangkat')
                                    ->time('H:i'),

                                TextEntry::make('valid_until')
                                    ->label('Berlaku Sampai')
                                    ->dateTime('d/m/Y H:i'),
                            ]),
                    ]),

                Section::make('Penggunaan')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('used_at')
                                    ->label('Waktu Digunakan')
                                    ->dateTime('d/m/Y H:i')
                                    ->placeholder('-'),

                                TextEntry::make('used_by')
                                    ->label('Digunakan Oleh')
                                    ->placeholder('-'),

                                TextEntry::make('notes')
                                    ->label('Catatan')
                                    ->placeholder('-'),
                            ]),
                    ])
                    ->visible(fn (Ticket $record): bool => $record->status !== 'active'),

                Section::make('QR Code')
                    ->schema([
                        ImageEntry::make('qr_code_path')
                            ->label('')
                            ->disk('public')
                            ->height(200),
                    ])
                    ->visible(fn (Ticket $record): bool => !empty($record->qr_code_path)),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTickets::route('/'),
            'view' => ViewTicket::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Tickets are only created automatically
    }
}
