<?php

namespace App\Filament\Admin\Resources\GalleryImages\Pages;

use App\Filament\Admin\Resources\GalleryImages\GalleryImageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGalleryImage extends CreateRecord
{
    protected static string $resource = GalleryImageResource::class;
}
