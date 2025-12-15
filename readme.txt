=== KR Theme ===

Contributors: kerkeniaziz
Tags: blog, e-commerce, portfolio, elementor, lightweight
Requires at least: 6.0
Tested up to: 6.4
Stable tag: 1.4.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Ultra-lightweight, blazing-fast, and SEO-optimized multipurpose WordPress theme.

== Description ==

KR Theme is a minimal, performance-focused WordPress theme that provides:

* Ultra-lightweight CSS (under 10KB)
* Blazing-fast loading speeds
* SEO optimized structure
* Full Elementor support
* WooCommerce ready
* Mobile responsive
* RTL language support
* Accessibility ready
* Dark mode support
* GitHub-powered auto-updates

== System Requirements ==

=== Minimum Requirements (Theme Only) ===
* WordPress: 6.0 or higher
* PHP: 7.4 or higher
* MySQL: 5.7 or higher

=== Required Plugins for Full Functionality ===

1. **Elementor Page Builder** (Version 3.16.0+)
   - Website: https://elementor.com
   - Repository: https://wordpress.org/plugins/elementor/
   - Status: REQUIRED - Theme requires Elementor for page building
   - Installation: Will be suggested automatically upon theme activation

2. **Essential Addons for Elementor** (Version 5.0+)
   - Website: https://essential-addons.com
   - Repository: https://wordpress.org/plugins/essential-addons-for-elementor-lite/
   - Status: REQUIRED - Provides 60+ free widgets used by theme
   - Installation: Will be suggested automatically upon theme activation

3. **KR Toolkit Plugin** (Version 1.2.7+)
   - GitHub: https://github.com/kerkeniaziz/kr-toolkit
   - Status: REQUIRED - Provides header/footer builder and demo import
   - Installation: Will be suggested automatically upon theme activation
   - Note: This is a companion plugin for extended theme functionality

=== Optional Plugins ===

1. **WooCommerce** (Version 6.0+)
   - For e-commerce functionality (product catalogs, shopping cart, checkout)
   - Not required if you're not selling products
   - Theme is fully WooCommerce compatible

2. **Contact Form 7**
   - For adding contact forms to your website
   - Not required if you don't need contact forms

== Installation ==

1. **Activate the Theme**
   - Upload the theme files to `/wp-content/themes/kr-theme/`
   - Go to Appearance > Themes in WordPress admin
   - Click "Activate" next to KR Theme

2. **Install Required Plugins**
   - Upon activation, you'll see a notice: "Install Recommended Plugins"
   - Navigate to Appearance > Install Plugins
   - You'll see these required plugins:
     * Elementor Page Builder (REQUIRED)
     * Essential Addons for Elementor (REQUIRED)
     * KR Toolkit (REQUIRED)
     * WooCommerce (Optional)
   
3. **Installation Steps for Each Plugin**
   - Click "Install" next to each required plugin
   - Click "Activate" once installation completes
   - The theme will automatically detect when all requirements are met

== Verification of Requirements ==

The theme includes an automatic requirement checker that:

✓ Verifies PHP version (minimum 7.4)
✓ Verifies WordPress version (minimum 6.0)
✓ Checks if Elementor is installed and activated
✓ Checks if Essential Addons is installed and activated
✓ Checks if KR Toolkit is installed and activated
✓ Verifies plugin versions meet minimum requirements
✓ Displays admin notices if any requirements are missing

If any required plugin is not activated, you will see a notice in the WordPress admin dashboard explaining what needs to be installed.

== What Each Required Component Does ==

=== Elementor Page Builder ===
* Provides visual drag-and-drop page builder interface
* Allows non-developers to create beautiful pages
* Powers the entire KR Theme design system
* Required for header, footer, and page building

=== Essential Addons for Elementor ===
* Provides 60+ additional Elementor widgets
* Includes advanced animations and effects
* Provides form builders and advanced features
* Essential for the theme's full functionality

=== KR Toolkit Plugin ===
* Provides header and footer builder interface
* Includes demo import system for quick setup
* Provides custom widgets for KR Theme
* Manages theme-specific customizations
* Powers the admin panel extensions

== Frequently Asked Questions ==

= Do I need all these plugins? =

Yes, for the full theme functionality. All three (Elementor, Essential Addons, and KR Toolkit) are required:
- **Elementor** powers the page building system
- **Essential Addons** provides the extended widgets
- **KR Toolkit** provides theme-specific features

WooCommerce is optional and only needed if you want e-commerce functionality.

= What if I don't install the required plugins? =

The theme will still activate, but:
- You won't be able to use the page builder
- Header/footer builder won't work
- You'll see admin notices about missing requirements
- Many theme features will be unavailable

= Can I use the theme without these plugins? =

Technically yes, but it's not recommended. The theme is built around these plugins and depends on them for full functionality. You can use basic WordPress features without them, but you won't be able to access the page builder or advanced features.

= How do I get updates? =

- **WordPress.org plugins**: Updates are automatic
- **KR Toolkit**: Updates are delivered from GitHub (auto-update enabled)
- **KR Theme**: Updates are delivered from GitHub

You'll see update notifications in your WordPress dashboard just like WordPress.org themes.

= Where can I get support? =

- Theme: https://github.com/kerkeniaziz/kr-theme/issues
- KR Toolkit: https://github.com/kerkeniaziz/kr-toolkit/issues

== Changelog ==

= 1.4.0 - 2024-12-15 =
* Added: System Requirements Checker with automatic verification
* Added: Admin notifications for missing required plugins
* Added: Plugin installation flow documentation
* Improved: readme.txt with complete system requirements
* Improved: Plugin installer messaging and clarity

= 1.3.2 - 2024-12-14 =
* Added: System Requirements Checker with automatic verification
* Added: Admin notifications for missing requirements
* Improved: Plugin installation flow now shows all requirements
* Improved: Requirements verification on theme activation
* Updated: readme.txt with comprehensive requirements documentation
* Updated: Theme to check plugin versions

= 1.2.5 - 2024-12-09 =
* Major: Complete CSS rewrite for ultra-lightweight performance
* Added: Minified CSS for maximum speed (under 10KB)
* Added: Dark mode support with prefers-color-scheme
* Added: Enhanced mobile-first responsive design
* Improved: Plugin installer now pulls KR Toolkit from GitHub
* Improved: Reduced CSS file size by 70%
* Improved: Better accessibility and focus states
* Fixed: Mobile navigation improvements

= 1.2.4 - 2024-12-10 =
* Added: GitHub auto-update functionality
* Improved: Update notification system
* Improved: Performance optimizations
* Updated: Compatible with WordPress 6.4
* Fixed: Minor CSS fixes

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.3.2 =
Important: This version adds automatic requirement checking. Make sure you have all required plugins installed for full functionality.

= 1.2.5 =
Major performance update with ultra-lightweight CSS rewrite. Faster loading and better mobile experience. Update recommended for all users.


