# Fitur Kompresi Gambar Otomatis

## Gambaran Umum

Fitur ini secara otomatis mengompresi gambar yang diunggah melalui Filament admin panel ketika ukurannya melebihi 1MB. Fitur ini membantu mengoptimalkan penyimpanan dan meningkatkan performa loading halaman.

## Komponen yang Telah Diupdate

### 1. ImageCompressionService

Service ini menangani logika kompresi gambar:
- Menggunakan library Intervention Image
- Mengompresi gambar jika ukuran > 1MB
- Mendukung format: JPEG, PNG, WebP
- Resize otomatis jika dimensi > 2000px
- Kualitas default: 80%

### 2. CompressedFileUpload Component

Custom Filament form component yang meng-extend `FileUpload`:
- Menambahkan kompresi otomatis setelah upload
- Configurable threshold dan kualitas
- Menampilkan helper text tentang kompresi

### 3. Form yang Diupdate

Semua form upload gambar telah diupdate:

#### a. GalleryImageForm
- Upload gambar galeri dengan kompresi otomatis

#### b. DestinationForm
- Upload gambar utama destinasi
- Upload multiple gambar galeri

#### c. ShipForm
- Upload foto kapal
- Upload logo operator

## Cara Penggunaan

### Menggunakan CompressedFileUpload di Form Baru

```php
use App\Filament\Forms\Components\CompressedFileUpload;

CompressedFileUpload::make('image')
    ->label('Gambar')
    ->image()
    ->directory('uploads')
    ->compressThreshold(1024) // 1MB (default)
    ->compressQuality(80) // 80% (default)
    ->helperText('Gambar lebih dari 1MB akan dikompresi otomatis');
```

### Konfigurasi

1. **Threshold**: Ukuran minimum untuk kompresi (dalam KB)
2. **Quality**: Kualitas gambar setelah kompresi (0-100)
3. **Max Dimension**: Resize otomatis jika > 2000px

## Testing

Test coverage untuk fitur ini:
1. `ImageCompressionServiceTest` - Test service kompresi
2. `GalleryImageResourceTest` - Test resource dengan upload gambar

## Keuntungan

1. **Optimasi Storage**: Gambar besar dikompresi otomatis
2. **Performas**: Loading halaman lebih cepat
3. **User Experience**: Upload lebih cepat, tidak perlu kompres manual
4. **Konsistensi**: Semua gambar memiliki ukuran optimal

## Catatan Teknis

- Library: Intervention Image v3.11
- Format yang didukung: JPEG, PNG, WebP
- Error handling: Jika kompresi gagal, file asli tetap dipertahankan
- Logging: Error dicatat di Laravel log

## Troubleshooting

### Gambar Tidak Dikompresi
1. Pastikan ukuran > threshold (default 1MB)
2. Cek format gambar (harus JPEG, PNG, atau WebP)
3. Cek Laravel log untuk error

### Error Upload
1. Pastikan GD extension aktif di PHP
2. Cek permission folder storage
3. Cek ukuran file maksimum di PHP config

## Update Selanjutnya

1. Support untuk format gambar tambahan
2. Batch compression untuk multiple files
3. Progress indicator untuk kompresi besar
4. Custom compression algorithm per format
