<?php

namespace App\Filament\Admin\Resources\Schedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class SchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('route.code')
                    ->label('Rute')
                    ->description(fn ($record) => $record->route?->origin?->name . ' → ' . $record->route?->destination?->name)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ship.name')
                    ->label('Kapal')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('departure_time')
                    ->label('Berangkat')
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('arrival_time')
                    ->label('Tiba')
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('available_seats')
                    ->label('Kursi')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('days_label')
                    ->label('Hari')
                    ->badge()
                    ->color('info'),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('valid_from')
                    ->label('Berlaku Dari')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('valid_until')
                    ->label('Sampai')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('departure_time')
            ->filters([
                SelectFilter::make('route_id')
                    ->label('Rute')
                    ->relationship('route', 'code')
                    ->preload()
                    ->searchable(),
                SelectFilter::make('ship_id')
                    ->label('Kapal')
                    ->relationship('ship', 'name')
                    ->preload()
                    ->searchable(),
                TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
