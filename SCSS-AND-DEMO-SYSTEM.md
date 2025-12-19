# KR Theme - SCSS Compilation System & Demo Importer

## 🎨 Complete System Overview

This document describes the fully integrated SCSS compilation system and demo importer for KR Theme, mirroring the professional setup found in Pricom theme.

---

## 📦 What's Included

### 1. **SCSS Compilation System**

The KR Theme now includes a complete SCSS architecture with:

- **Gulpfile.js** - Build system for SCSS compilation
- **package.json** - NPM dependencies management
- **assets/scss/** - Organized SCSS folder structure

#### Folder Structure:

```
kr-theme/assets/scss/
├── style.scss                 # Main SCSS entry point
├── abstracts/
│   ├── _variables.scss       # All theme variables (colors, fonts, spacing, etc.)
│   ├── _mixins.scss          # Reusable SCSS mixins
│   └── _functions.scss       # Custom SCSS functions
├── layout/
│   ├── _base.scss            # Global base styles
│   ├── _typography.scss      # Typography styles
│   ├── _grid.scss            # Grid system
│   ├── _header.scss          # Header styles
│   ├── _footer.scss          # Footer styles
│   └── _sidebar.scss         # Sidebar styles
├── components/
│   ├── _buttons.scss         # Button components
│   ├── _forms.scss           # Form components
│   ├── _modals.scss          # Modal dialogs
│   ├── _pagination.scss      # Pagination
│   ├── _breadcrumbs.scss     # Breadcrumbs
│   └── _cards.scss           # Card components
├── theme/
│   ├── _home.scss            # Home page styles
│   ├── _blog.scss            # Blog page styles
│   ├── _pages.scss           # Pages styles
│   ├── _single.scss          # Single post styles
│   ├── _archive.scss         # Archive page styles
│   ├── _search.scss          # Search page styles
│   └── _404.scss             # 404 page styles
├── woocommerce/
│   ├── _shop.scss            # Shop page styles
│   ├── _single-product.scss  # Single product styles
│   ├── _cart.scss            # Cart page styles
│   └── _checkout.scss        # Checkout page styles
├── elementor/
│   ├── _widgets.scss         # Elementor widget styles
│   └── _sections.scss        # Elementor section styles
├── utilities/
│   ├── _spacing.scss         # Spacing utility classes
│   ├── _colors.scss          # Color utility classes
│   ├── _display.scss         # Display utility classes
│   ├── _flexbox.scss         # Flexbox utility classes
│   └── _responsive.scss      # Responsive utility classes
└── vendor/
    └── _normalize.scss       # Normalize reset styles
```

---

## 🚀 Getting Started with SCSS

### Installation

1. **Install Node Dependencies**
   ```bash
   cd kr-theme
   npm install
   ```

2. **Compile SCSS**
   ```bash
   # Watch for changes during development
   npm run dev
   
   # Or watch with auto-refresh
   npm run watch
   
   # Build for production (minified)
   npm run build
   
   # Just compile once
   npm run compile
   ```

### Available NPM Commands

- `npm run dev` - Start development with watch mode
- `npm run watch` - Watch SCSS files for changes
- `npm run build` - Production build (minified CSS)
- `npm run compile` - Single compilation

---

## 🎯 SCSS Features

### Variables System

All theme variables are centralized in `abstracts/_variables.scss`:

```scss
// Colors
$primary-color: #2563eb;
$text-color: #1f2937;
$border-color: #e5e7eb;

// Spacing
$spacing-xs: 0.25rem;
$spacing-md: 1rem;
$spacing-lg: 1.5rem;

// Breakpoints
$breakpoint-md: 768px;
$breakpoint-lg: 992px;

// And many more...
```

### Mixins (Reusable Code)

Common SCSS mixins are available:

```scss
// Responsive design
@include media-query('md') { ... }

// Flexbox utilities
@include flex-center;
@include flex-between;

// Transitions
@include transition(all);

// Shadows
@include box-shadow('lg');
```

### Functions

Custom SCSS functions for common operations:

```scss
// Convert pixels to rem
to-rem(16px)  // Returns: 1rem

// Get spacing value
get-spacing('lg')  // Returns: 1.5rem

// Text utilities
@include text-truncate;
@include text-clamp(2);
```

---

## 📥 Demo Importer System

The KR Theme includes a professional demo importer, fully integrated into the theme options panel.

### Features

✅ **One-Click Import** - Import complete demo websites instantly  
✅ **Multiple Demos** - Pre-built professional demos included  
✅ **Content Import** - Posts, pages, and media automatically imported  
✅ **Settings Sync** - Theme options, customizer settings imported  
✅ **Safe Import** - Backup and restore capabilities  
✅ **Progress Tracking** - Real-time import progress updates  

### Available Demos

1. **Free Business Demo** (`free-business`)
   - Professional business website
   - Services section, portfolio, testimonials
   - Contact form and team section
   - Full blog integration

2. **Free Portfolio Demo** (`free-portfolio`)
   - Creative portfolio showcase
   - Project gallery layouts
   - About and contact pages
   - Photography-focused design

### Accessing the Importer

1. Go to **Appearance → KR Theme Options** in WordPress admin
2. Click the **"Demo Importer"** tab
3. Browse available demos
4. Click **"Import Demo"** button
5. Wait for import to complete

### Import Structure

Each demo includes:

```
kr-theme/demos/demo-slug/
├── config.json           # Demo configuration
├── content.xml          # Posts, pages, media
├── customizer.json      # Customizer settings
├── theme-options.json   # Theme options
├── widgets.json         # Widget configuration
└── screenshot.png       # Demo preview image
```

### Creating Custom Demos

To create a new demo:

1. Create a folder in `kr-theme/demos/your-demo-slug/`
2. Add a `config.json` file:

```json
{
  "slug": "your-demo-slug",
  "name": "Your Demo Name",
  "description": "Description of your demo",
  "demo_url": "https://demo.krtheme.com/your-demo",
  "screenshot": "screenshot.png",
  "is_pro": false,
  "features": [
    "Feature 1",
    "Feature 2",
    "Feature 3"
  ]
}
```

3. Add import files:
   - `content.xml` - WordPress export file
   - `customizer.json` - Customizer settings (optional)
   - `theme-options.json` - Theme options (optional)
   - `widgets.json` - Widget data (optional)

---

## 🔧 PHP Classes

### KR_Theme_Demo_Importer

Main class handling demo imports:

```php
// Get available demos
$importer = new KR_Theme_Demo_Importer();
$demos = $importer->get_available_demos();

// Check if demo is imported
$is_imported = $importer->is_demo_imported('free-business');

// Get imported demos
$imported = $importer->get_imported_demos();
```

### Location

- **File**: `kr-theme/inc/class-demo-importer.php`
- **Loaded**: Automatically in `functions.php`
- **AJAX Hooks**:
  - `wp_ajax_kr_import_demo`
  - `wp_ajax_kr_get_import_status`

---

## 🎨 Customization Guide

### Adding New SCSS Partials

1. Create a file in the appropriate folder (e.g., `layout/_custom.scss`)
2. Add `@import 'layout/custom'` to `style.scss`
3. Run `npm run compile`

### Modifying Variables

All variables are in `abstracts/_variables.scss`. Change them globally:

```scss
// Change primary color
$primary-color: #your-color;

// Change base font size
$base-font-size: 18px;

// Add new breakpoint
$breakpoint-xl: 1400px;
```

### Using Mixins

Apply mixins in your SCSS code:

```scss
.my-button {
    @include button-base;
    @include transition(all);
    
    @include media-query('md') {
        padding: 1rem 2rem;
    }
}
```

---

## 📱 Utility Classes

The SCSS compilation generates utility classes for quick styling:

### Spacing Utilities
```html
<div class="m-lg">           <!-- Margin -->
<div class="p-md">           <!-- Padding -->
<div class="mt-xl">          <!-- Margin-top -->
<div class="pb-lg">          <!-- Padding-bottom -->
```

### Color Utilities
```html
<p class="text-primary">     <!-- Primary color text -->
<div class="bg-success">     <!-- Success background -->
```

### Display Utilities
```html
<div class="d-flex">         <!-- Flex display -->
<div class="flex-center">    <!-- Centered flex -->
<div class="justify-between"> <!-- Space between -->
```

### Responsive Utilities
```html
<div class="d-md-none">      <!-- Hidden on medium+ screens -->
<div class="show-lg">        <!-- Visible on large+ screens -->
```

---

## 🚨 Troubleshooting

### SCSS Not Compiling

1. Check if Node is installed: `node --version`
2. Install dependencies: `npm install`
3. Check gulpfile.js for errors
4. Run: `npm run compile`

### Demo Not Importing

1. Check `kr-theme/demos/demo-slug/config.json` exists
2. Verify file permissions on demo folders
3. Check PHP error logs
4. Ensure WordPress has write permissions

### CSS Not Updating

1. Clear browser cache (Ctrl+F5 or Cmd+Shift+R)
2. Clear WordPress cache if using a cache plugin
3. Verify compiled CSS file exists in `assets/css/`
4. Check for minified CSS interfering

---

## 📊 Build System Details

### Gulp Tasks

- **compile-sass** - Compiles with source maps
- **minify-sass** - Minifies for production
- **watch** - Watches for changes
- **dev** - Development mode with watch
- **build** - Production build

### Output Files

- Development: `assets/css/style.css` (with source maps)
- Production: `assets/css/style.css` (minified)
- Source maps: `assets/css/maps/`

---

## 📝 File Inclusion

The demo importer is automatically included in:

```php
// functions.php
if ( file_exists( get_template_directory() . '/inc/class-demo-importer.php' ) ) {
    require_once get_template_directory() . '/inc/class-demo-importer.php';
}
```

---

## 🔐 Security Notes

- All demo imports verify user capabilities (`manage_options`)
- AJAX requests use WordPress nonces
- File paths are validated before import
- Content is properly escaped on output

---

## 📦 Version Information

- **Theme**: KR Theme v1.4.0
- **SCSS**: Dart Sass (gulp-sass)
- **Build System**: Gulp 4
- **Node Version**: 14.0.0+
- **NPM Version**: 6.0.0+

---

## 🤝 Support

For issues or questions:
- Check the demo importer AJAX console for errors
- Review PHP error logs
- Verify file permissions
- Check demo config JSON is valid

---

## 📚 Additional Resources

- Pricom Theme Documentation
- KR Toolkit Demo Importer
- Redux Framework Documentation
- SCSS Documentation: https://sass-lang.com/

---

**Created**: 2025  
**Last Updated**: December 16, 2025  
**Status**: Production Ready ✅
