<?php

namespace App\Filament\Admin\Resources\GalleryImages\Pages;

use App\Filament\Admin\Resources\GalleryImages\GalleryImageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGalleryImage extends CreateRecord
{
    protected static string $resource = GalleryImageResource::class;

    /**
     * Get the actions for the header.
     */
    protected function getHeaderActions(): array
    {
        return [];
    }

    /**
     * Get the form actions (buttons at the bottom of the form).
     */
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCreateAnotherFormAction(),
            $this->getCancelFormAction(),
        ];
    }

    /**
     * Redirect to create page after save to allow quick multiple uploads.
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('create');
    }
}
