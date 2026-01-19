# Production Optimization Guide

## Laravel Caching Commands

Run these commands after deploying to production:

```bash
# Cache configuration files
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# All-in-one optimization
php artisan optimize

# Clear all caches (if needed)
php artisan optimize:clear
```

## Image Optimization

The site uses large PNG images that should be converted to WebP format:

### Manual Conversion (Recommended)

Use [Squoosh.app](https://squoosh.app/) to convert:

1. `public/img/hero-section.png` (1.8MB) → target: ~150KB WebP
2. `public/img/logo-semabu.png` (197KB) → target: ~20KB WebP

Settings:
- Format: WebP
- Quality: 75-85%
- Resize if needed (hero: 1920px max width)

### After Conversion

Update blade templates to use WebP with PNG fallback:

```blade
<picture>
    <source srcset="{{ asset('img/hero-section.webp') }}" type="image/webp">
    <img src="{{ asset('img/hero-section.png') }}" alt="Hero">
</picture>
```

## Cloudinary Auto-Format

For Cloudinary images, add `f_auto,q_auto` to URL:

```blade
{{ str_replace('/upload/', '/upload/f_auto,q_auto/', $imageUrl) }}
```

This automatically serves WebP/AVIF to supported browsers.

## OPcache (PHP)

Ensure OPcache is enabled in php.ini:

```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=20000
opcache.validate_timestamps=0  # Set to 0 in production
```

## Heroku-Specific

Heroku free/eco tier has cold starts (~2s). Consider:
- Using a paid dyno for consistent performance
- Adding a keep-alive ping service
