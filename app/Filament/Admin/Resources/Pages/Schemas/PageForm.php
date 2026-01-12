<?php

namespace App\Filament\Admin\Resources\Pages\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\KeyValue;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('page_tabs')
                    ->tabs([
                        Tab::make('Konten')
                            ->icon('heroicon-o-document-text')
                            ->schema([
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
                                            ->label('Konten Utama')
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
                            ]),

                        Tab::make('Section Builder')
                            ->icon('heroicon-o-squares-plus')
                            ->schema([
                                Section::make('Bangun Section Kustom')
                                    ->description('Tambahkan section yang dapat dikustomisasi sepenuhnya')
                                    ->schema([
                                        Repeater::make('sections')
                                            ->label('Sections')
                                            ->schema([
                                                TextInput::make('section_title')
                                                    ->label('Judul Section')
                                                    ->placeholder('Contoh: Galeri Kapal'),

                                                Select::make('section_type')
                                                    ->label('Tipe Section')
                                                    ->options([
                                                        'hero' => '🎨 Hero Banner',
                                                        'text' => '📝 Teks/Konten',
                                                        'gallery' => '🖼️ Galeri Foto',
                                                        'cards' => '📦 Kartu/Grid',
                                                        'features' => '⭐ Features List',
                                                        'cta' => '📣 Call to Action',
                                                        'testimonials' => '💬 Testimonial',
                                                        'contact' => '📧 Informasi Kontak',
                                                        'map' => '🗺️ Peta/Lokasi',
                                                        'custom_html' => '🔧 HTML Kustom',
                                                    ])
                                                    ->required()
                                                    ->reactive(),

                                                // Layout options
                                                Grid::make(3)
                                                    ->schema([
                                                        Select::make('layout')
                                                            ->label('Layout')
                                                            ->options([
                                                                'full' => 'Full Width',
                                                                'contained' => 'Container',
                                                                'narrow' => 'Sempit',
                                                            ])
                                                            ->default('contained'),
                                                        Select::make('columns')
                                                            ->label('Kolom')
                                                            ->options([
                                                                '1' => '1 Kolom',
                                                                '2' => '2 Kolom',
                                                                '3' => '3 Kolom',
                                                                '4' => '4 Kolom',
                                                            ])
                                                            ->default('3'),
                                                        Select::make('text_align')
                                                            ->label('Posisi Teks')
                                                            ->options([
                                                                'left' => 'Kiri',
                                                                'center' => 'Tengah',
                                                                'right' => 'Kanan',
                                                            ])
                                                            ->default('center'),
                                                    ]),

                                                // Style options
                                                Grid::make(3)
                                                    ->schema([
                                                        ColorPicker::make('background_color')
                                                            ->label('Warna Background'),
                                                        ColorPicker::make('text_color')
                                                            ->label('Warna Teks'),
                                                        Select::make('padding')
                                                            ->label('Padding')
                                                            ->options([
                                                                'sm' => 'Kecil',
                                                                'md' => 'Sedang',
                                                                'lg' => 'Besar',
                                                                'xl' => 'Ekstra Besar',
                                                            ])
                                                            ->default('lg'),
                                                    ]),

                                                FileUpload::make('background_image')
                                                    ->label('Gambar Background')
                                                    ->image()
                                                    ->directory('sections')
                                                    ->imageEditor(),

                                                RichEditor::make('section_content')
                                                    ->label('Konten Section')
                                                    ->toolbarButtons([
                                                        'bold',
                                                        'italic',
                                                        'underline',
                                                        'link',
                                                        'orderedList',
                                                        'bulletList',
                                                        'h2',
                                                        'h3',
                                                    ])
                                                    ->columnSpanFull(),

                                                // Items for gallery/cards/features
                                                Repeater::make('items')
                                                    ->label('Item')
                                                    ->schema([
                                                        TextInput::make('title')
                                                            ->label('Judul Item'),
                                                        Textarea::make('description')
                                                            ->label('Deskripsi')
                                                            ->rows(2),
                                                        FileUpload::make('image')
                                                            ->label('Gambar')
                                                            ->image()
                                                            ->directory('sections/items')
                                                            ->imageEditor(),
                                                        TextInput::make('link')
                                                            ->label('Link URL')
                                                            ->url(),
                                                        TextInput::make('icon')
                                                            ->label('Icon (FontAwesome)')
                                                            ->placeholder('fa-solid fa-ship')
                                                            ->helperText('Gunakan class FontAwesome'),
                                                    ])
                                                    ->collapsible()
                                                    ->collapsed()
                                                    ->columnSpanFull()
                                                    ->visible(fn ($get) => in_array($get('section_type'), ['gallery', 'cards', 'features', 'testimonials'])),

                                                // CTA specific fields
                                                Grid::make(2)
                                                    ->schema([
                                                        TextInput::make('cta_button_text')
                                                            ->label('Teks Tombol')
                                                            ->placeholder('Pesan Sekarang'),
                                                        TextInput::make('cta_button_link')
                                                            ->label('Link Tombol')
                                                            ->url(),
                                                    ])
                                                    ->visible(fn ($get) => $get('section_type') === 'cta'),

                                                // Map specific
                                                TextInput::make('map_embed')
                                                    ->label('Google Maps Embed URL')
                                                    ->url()
                                                    ->columnSpanFull()
                                                    ->visible(fn ($get) => $get('section_type') === 'map'),

                                                // Custom HTML
                                                Textarea::make('custom_html')
                                                    ->label('HTML Kustom')
                                                    ->rows(10)
                                                    ->columnSpanFull()
                                                    ->visible(fn ($get) => $get('section_type') === 'custom_html'),

                                                Toggle::make('is_visible')
                                                    ->label('Tampilkan Section')
                                                    ->default(true),
                                            ])
                                            ->itemLabel(fn (array $state): ?string => $state['section_title'] ?? 'Section Baru')
                                            ->collapsible()
                                            ->collapsed()
                                            ->reorderable()
                                            ->cloneable()
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Section::make('SEO & Meta')
                                    ->description('Optimasi mesin pencari')
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
                            ]),

                        Tab::make('Pengaturan')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Section::make('Pengaturan Halaman')
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
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
