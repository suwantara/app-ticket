<?php

namespace App\Filament\Admin\Resources\Pages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->color('gray'),
                TextColumn::make('template')
                    ->label('Template')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'home' => 'success',
                        'about' => 'info',
                        'contact' => 'warning',
                        default => 'gray',
                    }),
                IconColumn::make('is_published')
                    ->label('Publik')
                    ->boolean(),
                IconColumn::make('is_in_navbar')
                    ->label('Navbar')
                    ->boolean(),
                TextColumn::make('navbar_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Status Publikasi'),
                TernaryFilter::make('is_in_navbar')
                    ->label('Tampil di Navbar'),
                SelectFilter::make('template')
                    ->label('Template')
                    ->options([
                        'default' => 'Default',
                        'home' => 'Home Page',
                        'about' => 'About Page',
                        'contact' => 'Contact Page',
                        'full-width' => 'Full Width',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('navbar_order', 'asc');
    }
}
