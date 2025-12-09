# KR Theme Update System

This theme uses GitHub for automatic updates.

## How It Works

Same as plugin - WordPress checks GitHub for new releases automatically.

## GitHub Repository

https://github.com/kerkeniaziz/kr-theme

## For Users

Updates appear in:
- Dashboard → Updates
- Appearance → Themes

Click "Update Now" when available.

## For Developers

### Creating a New Release

1. Update version numbers in:
   - `style.css` (theme header Version)
   - `functions.php` (KR_THEME_VERSION constant)
   - `readme.txt` (Stable tag)

2. Commit and push:
```bash
git add .
git commit -m "Version 1.2.5"
git push origin main
```

3. Create GitHub Release:
   - Go to: https://github.com/kerkeniaziz/kr-theme/releases
   - Tag: `v1.2.5`
   - Title: `Version 1.2.5`
   - Description: Changelog
   - Publish

### Testing

Force check for updates:
```php
delete_site_transient( 'update_themes' );
```

## Requirements

- PHP 7.4+
- WordPress 6.0+
- Plugin Update Checker library (included)
- Public GitHub repository

## Support

Report issues: https://github.com/kerkeniaziz/kr-theme/issues