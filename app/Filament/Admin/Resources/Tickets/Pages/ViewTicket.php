<?php

namespace App\Filament\Admin\Resources\Tickets\Pages;

use App\Filament\Admin\Resources\Tickets\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('markAsUsed')
                ->label('Tandai Digunakan')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status === 'active')
                ->action(fn () => $this->record->markAsUsed('Admin')),
            Actions\Action::make('cancel')
                ->label('Batalkan Tiket')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status === 'active')
                ->action(fn () => $this->record->cancel()),
        ];
    }
}
