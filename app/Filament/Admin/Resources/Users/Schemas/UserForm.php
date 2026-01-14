<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun')
                    ->description('Data dasar pengguna')
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->minLength(3)
                            ->maxLength(100)
                            ->placeholder('Masukkan nama lengkap')
                            ->columnSpan(2),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('email@example.com')
                            ->columnSpan(2),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                            ->rule(Password::min(8)->mixedCase()->numbers()->symbols())
                            ->helperText('Min. 8 karakter, huruf besar/kecil, angka, dan simbol')
                            ->placeholder('Kosongkan jika tidak ingin mengubah')
                            ->columnSpan(1),

                        TextInput::make('password_confirmation')
                            ->label('Konfirmasi Password')
                            ->password()
                            ->revealable()
                            ->same('password')
                            ->requiredWith('password')
                            ->dehydrated(false)
                            ->placeholder('Ulangi password')
                            ->columnSpan(1),
                    ]),

                Section::make('Role & Status')
                    ->description('Pengaturan hak akses')
                    ->icon('heroicon-o-shield-check')
                    ->columns(2)
                    ->schema([
                        Select::make('role')
                            ->label('Role')
                            ->options([
                                'admin' => 'Administrator',
                                'staff' => 'Petugas',
                                'user' => 'Pengguna',
                            ])
                            ->required()
                            ->default('staff')
                            ->native(false)
                            ->helperText('Admin: akses penuh, Staff: boarding system, User: publik')
                            ->columnSpan(1),

                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->helperText('Nonaktifkan untuk mencegah login')
                            ->columnSpan(1),
                    ]),
            ]);
    }
}
