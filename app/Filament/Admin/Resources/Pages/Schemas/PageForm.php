<?php

namespace App\Filament\Admin\Resources\Pages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konten Halaman')
                    ->description('Informasi utama halaman')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Halaman')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                                TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->helperText('URL-friendly version of the title'),
                            ]),
                        RichEditor::make('content')
                            ->label('Konten')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'orderedList',
                                'bulletList',
                                'h2',
                                'h3',
                                'blockquote',
                                'codeBlock',
                                'redo',
                                'undo',
                            ]),
                        FileUpload::make('featured_image')
                            ->label('Gambar Utama')
                            ->image()
                            ->directory('pages')
                            ->imageEditor()
                            ->columnSpanFull(),
                    ]),

                Section::make('SEO & Meta')
                    ->description('Optimasi mesin pencari')
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(60)
                            ->helperText('Maksimal 60 karakter'),
                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(160)
                            ->rows(3)
                            ->helperText('Maksimal 160 karakter'),
                    ]),

                Section::make('Pengaturan')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Toggle::make('is_published')
                                    ->label('Publikasikan')
                                    ->helperText('Tampilkan halaman ke publik')
                                    ->default(false),
                                Toggle::make('is_in_navbar')
                                    ->label('Tampilkan di Navbar')
                                    ->helperText('Tambahkan ke menu navigasi')
                                    ->default(false),
                                TextInput::make('navbar_order')
                                    ->label('Urutan Navbar')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Urutan tampilan di navbar'),
                            ]),
                        Select::make('template')
                            ->label('Template Halaman')
                            ->options([
                                'default' => 'Default',
                                'home' => 'Home Page',
                                'about' => 'About Page',
                                'contact' => 'Contact Page',
                                'full-width' => 'Full Width',
                            ])
                            ->default('default')
                            ->required(),
                    ]),
            ]);
    }
}
