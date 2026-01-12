<?php

use App\Services\ImageCompressionService;
use Illuminate\Http\UploadedFile;

it('can compress image when size exceeds threshold', function () {
    // Buat file gambar dummy (kecil)
    $smallImage = UploadedFile::fake()->image('small.jpg', 100, 100)->size(500); // 500KB

    $service = new ImageCompressionService;

    // Threshold 1MB, file 500KB tidak boleh dikompresi
    $result = $service->compressIfNeeded($smallImage, 1024, 80);

    expect($result)->toBe($smallImage);
});

it('returns original file for non-image files', function () {
    // Buat file non-gambar
    $pdfFile = UploadedFile::fake()->create('document.pdf', 2000); // 2MB

    $service = new ImageCompressionService;

    $result = $service->compressIfNeeded($pdfFile, 1024, 80);

    expect($result)->toBe($pdfFile);
});

it('can get file size information', function () {
    $image = UploadedFile::fake()->image('test.jpg', 100, 100)->size(1500); // 1.5MB

    $service = new ImageCompressionService;

    $info = $service->getFileSizeInfo($image);

    expect($info)->toHaveKeys(['bytes', 'kb', 'mb', 'original_name', 'mime_type'])
        ->and($info['bytes'])->toBe(1500 * 1024)
        ->and($info['mb'])->toBeGreaterThan(1.4)
        ->and($info['mb'])->toBeLessThan(1.6);
});

it('handles compression errors gracefully', function () {
    // Buat file corrupt atau tidak valid
    $invalidImage = UploadedFile::fake()->create('corrupt.jpg', 2000);

    $service = new ImageCompressionService;

    // Should return original file without throwing exception
    $result = $service->compressIfNeeded($invalidImage, 1024, 80);

    expect($result)->toBe($invalidImage);
});
