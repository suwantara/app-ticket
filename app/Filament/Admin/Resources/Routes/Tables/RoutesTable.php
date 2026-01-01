<?php

namespace App\Filament\Admin\Resources\Routes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class RoutesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('origin.name')
                    ->label('Asal')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-map-pin'),

                TextColumn::make('destination.name')
                    ->label('Tujuan')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-flag'),

                TextColumn::make('distance')
                    ->label('Jarak')
                    ->suffix(' km')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('duration')
                    ->label('Durasi')
                    ->formatStateUsing(fn ($state) => $state ? floor($state / 60) . 'j ' . ($state % 60) . 'm' : '-')
                    ->sortable(),

                TextColumn::make('base_price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                SelectFilter::make('origin_id')
                    ->label('Asal')
                    ->relationship('origin', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('destination_id')
                    ->label('Tujuan')
                    ->relationship('destination', 'name')
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
