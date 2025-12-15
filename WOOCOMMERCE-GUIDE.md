# KR Theme - WooCommerce Integration Guide

## Overview

KR Theme now includes full WooCommerce support with a light, modern design that matches the theme's aesthetic. The integration is lightweight and production-ready.

## Features

### Core Features
- ✅ Custom product meta fields (New, Hot, Video URL)
- ✅ Product badges and labels
- ✅ Product filtering and sorting
- ✅ Responsive product grid
- ✅ Light theme styling
- ✅ Admin product columns
- ✅ Shop page with sidebar
- ✅ Single product pages
- ✅ Cart and checkout pages
- ✅ WooCommerce widgets support

### Color Palette
```
Primary Blue:     #667eea
Secondary Purple: #a855f7
Text Color:       #1e293b
Light Text:       #64748b
Background:       #ffffff
Light Background: #f8fafc
Border:           #e2e8f0
Success:          #10b981 (New badge)
Danger:           #ef4444 (Hot badge)
```

## Files Created

### Functions & Hooks
- `inc/compatibility/woocommerce-functions.php` - Core WooCommerce functions and hooks

### Styling
- `inc/compatibility/woocommerce-styles.css` - Complete WooCommerce styling

### Templates
- `woocommerce/archive-product.php` - Shop page template
- `woocommerce/content-product.php` - Product item template
- `woocommerce/single-product.php` - Single product page template

## Setup Instructions

### 1. Install & Activate WooCommerce Plugin
```
1. Go to WordPress Admin > Plugins > Add New
2. Search for "WooCommerce"
3. Install and activate the official WooCommerce plugin
```

### 2. Create WooCommerce Pages
```
1. Go to WooCommerce > Settings > Advanced
2. Set the following pages:
   - Shop Page: Create a new page with slug "shop"
   - Cart Page: Create a new page with [woocommerce_cart] shortcode
   - Checkout Page: Create a new page with [woocommerce_checkout] shortcode
   - Account Page: Create a new page with [woocommerce_my_account] shortcode
```

### 3. Configure Products
```
1. Go to Products > Add New
2. Fill in basic product information
3. Scroll to "Product Data" section:
   - Set price
   - Add product images
   - Check "Mark as New Product" to display green badge
   - Check "Mark as Hot/Trending" to display red badge
   - Optionally add Video URL (YouTube or Vimeo)
```

### 4. Configure Shop Settings
```
1. Go to WooCommerce > Settings > Products
2. Configure:
   - Products per page
   - Display settings
   - Product archive display
3. Go to WooCommerce > Settings > Display
4. Configure shop colors and layouts
```

### 5. Add Sidebar Widgets
```
1. Go to Appearance > Widgets
2. Find "WooCommerce Sidebar"
3. Add widgets:
   - Product Categories
   - Product Filter (if WooCommerce Filters plugin installed)
   - Price Filter
   - Recent Products
   - Top Rated Products
```

## Custom Product Meta Fields

### Mark as New Product
- **Key:** `kr_product_new`
- **Value:** 'yes' or 'no'
- **Display:** Green badge on product item
- **Admin:** Checkbox in Product Data section

### Mark as Hot/Trending
- **Key:** `kr_product_hot`
- **Value:** 'yes' or 'no'
- **Display:** Red badge on product item
- **Admin:** Checkbox in Product Data section

### Video URL
- **Key:** `kr_product_video_url`
- **Value:** YouTube or Vimeo URL
- **Display:** Can be shown in product tabs (requires custom template)
- **Admin:** Text input in Product Data section

## Helper Functions

### Check if Product is New
```php
if ( kr_get_product_is_new( $product_id ) ) {
    // Product is marked as new
}
```

### Check if Product is Hot
```php
if ( kr_get_product_is_hot( $product_id ) ) {
    // Product is marked as hot
}
```

### Get Product Video URL
```php
$video_url = kr_get_product_video_url( $product_id );
if ( $video_url ) {
    // Display video
}
```

## Template Customization

### Override Product Template
To customize a template, copy it from `kr-theme/woocommerce/` to your child theme `woocommerce/` folder.

```
Example: To override archive-product.php
Create: child-theme/woocommerce/archive-product.php
```

### Hooks Available
```php
// Before shop loop
do_action( 'woocommerce_before_shop_loop' );

// After shop loop
do_action( 'woocommerce_after_shop_loop' );

// Before product
do_action( 'woocommerce_before_shop_loop_item' );

// After product
do_action( 'woocommerce_after_shop_loop_item' );
```

## Styling Customization

### Add Custom CSS
Add to your child theme's `style.css` or in Customizer:

```css
/* Change primary button color */
.woocommerce a.button,
.woocommerce button.button {
    background-color: #your-color !important;
    border-color: #your-color !important;
}

/* Change product grid columns */
.kr-woocommerce-products {
    grid-template-columns: repeat(4, 1fr) !important;
}
```

### Customizer Options
1. Go to Appearance > Customize
2. Add custom CSS in "Additional CSS" section
3. Customize colors in Custom Colors section

## Responsive Behavior

### Desktop
- Product grid: 3 columns
- Sidebar: Fixed width (250px)
- Product images: 200px height

### Tablet
- Product grid: 2 columns
- Sidebar: Full width on mobile
- Product images: 150px height

### Mobile
- Product grid: 2 columns
- Sidebar: Below products
- Product images: 120px height

## Performance Optimization

### Image Optimization
- Use optimized product images
- Set featured image size: 400x300px minimum
- Use WebP format if available

### Caching
- Enable WooCommerce caching
- Use object caching plugin
- Enable page caching

### Database
- Regularly optimize database
- Remove old product revisions
- Clean up meta fields

## Troubleshooting

### Products Not Showing
1. Check if WooCommerce is activated
2. Verify shop page is created
3. Check if products are published
4. Clear browser cache

### Styling Issues
1. Ensure WooCommerce styles are enqueued
2. Check for CSS conflicts
3. Use browser DevTools to inspect
4. Clear WordPress cache

### Badge Not Showing
1. Save product meta again
2. Check if `kr_product_new` or `kr_product_hot` is saved
3. Verify product is in shop loop
4. Check WooCommerce output filters

### Sidebar Not Appearing
1. Go to Appearance > Widgets
2. Verify WooCommerce Sidebar widget area exists
3. Add widgets to sidebar
4. Check if sidebar CSS is enqueued

## Support

For issues or questions:
1. Check WooCommerce documentation: https://docs.woocommerce.com/
2. Check KR Theme documentation
3. Review WordPress error logs
4. Contact theme support

## Future Enhancements

Potential features to add:
- [ ] Product comparison widget
- [ ] Wishlist functionality
- [ [ YITH integration
- [ ] Advanced product filters
- [ ] Product quick view
- [ ] Related products carousel
- [ ] Product recommendations
- [ ] Variation swatches

## Changelog

### Version 1.3.2
- Initial WooCommerce integration
- Product meta fields (New, Hot, Video)
- Custom product badges
- Responsive product grid
- Shop page styling
- Single product template
- Cart and checkout styling
- WooCommerce sidebar
