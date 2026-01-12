<?php

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    public function getTitle(): string
    {
        return 'Edit Pengguna: '.$this->record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus')
                ->before(function () {
                    // Prevent deleting own account
                    if ($this->record->id === auth()->id()) {
                        Notification::make()
                            ->danger()
                            ->title('Tidak Dapat Menghapus')
                            ->body('Anda tidak dapat menghapus akun Anda sendiri.')
                            ->send();

                        $this->halt();
                    }
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Pengguna Diperbarui')
            ->body('Data pengguna telah berhasil diperbarui.');
    }
}
