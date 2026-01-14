<?php

namespace App\Filament\Admin\Resources\Messages;

use App\Filament\Admin\Resources\Messages\Pages\CreateMessage;
use App\Filament\Admin\Resources\Messages\Pages\EditMessage;
use App\Filament\Admin\Resources\Messages\Pages\ListMessages;
use App\Filament\Admin\Resources\Messages\Schemas\MessageForm;
use App\Filament\Admin\Resources\Messages\Tables\MessagesTable;
use App\Models\Message;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Pesan Kontak';

    protected static ?string $modelLabel = 'Pesan';

    protected static ?string $pluralModelLabel = 'Pesan';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): ?string
    {
        return 'Komunikasi';
    }



    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'unread')->count() ?: null;
    }

    public static function form(Schema $schema): Schema
    {
        return MessageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MessagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMessages::route('/'),
            'create' => CreateMessage::route('/create'),
            'edit' => EditMessage::route('/{record}/edit'),
        ];
    }
}
