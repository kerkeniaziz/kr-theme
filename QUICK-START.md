# 🚀 KR Theme SCSS & Demo Importer - Quick Start Guide

## ⚡ 5-Minute Setup

### Step 1: Install Dependencies
```bash
cd kr-theme
npm install
```

### Step 2: Start Compiling SCSS
```bash
npm run dev
```

This will:
- ✅ Watch for SCSS changes
- ✅ Auto-compile to CSS
- ✅ Generate source maps for debugging
- ✅ Show notifications when done

### Step 3: Import Your First Demo

1. Go to **WordPress Admin → Appearance → KR Theme Options**
2. Click the **"Demo Importer"** tab
3. Choose a demo and click **"Import Demo"**
4. Wait for import to complete
5. See your demo website live!

---

## 📁 Project Structure

```
kr-theme/
├── assets/
│   ├── css/              ← Compiled CSS goes here (auto-generated)
│   ├── scss/             ← Your SCSS source files
│   └── js/
├── demos/                ← Pre-built demo websites
│   ├── free-business/
│   └── free-portfolio/
├── inc/                  ← PHP includes
│   └── class-demo-importer.php  ← Demo importer code
├── functions.php         ← Theme initialization
├── gulpfile.js          ← Build configuration
├── package.json         ← Dependencies
└── SCSS-AND-DEMO-SYSTEM.md  ← Full documentation
```

---

## 🎨 Working with SCSS

### View SCSS Files
Open `assets/scss/` to see the organized structure:

- **abstracts/** - Variables, mixins, functions
- **layout/** - Header, footer, grid, typography
- **components/** - Buttons, forms, cards, modals
- **theme/** - Home, blog, pages, single post, etc.
- **utilities/** - Spacing, colors, display classes
- **woocommerce/** - WooCommerce-specific styles
- **elementor/** - Elementor widget styles

### Make Changes

1. Edit any SCSS file in `assets/scss/`
2. Save the file
3. Gulp automatically compiles it
4. CSS appears in `assets/css/style.css`
5. Refresh browser to see changes

### Example: Change Primary Color

Edit `assets/scss/abstracts/_variables.scss`:

```scss
// Change this:
$primary-color: #2563eb;

// To your color:
$primary-color: #ff0000;
```

Save → Gulp compiles → Refresh browser → Done! ✨

---

## 📥 Demo Importer Guide

### Available Demos

**1. Free Business Demo** 🏢
- Modern homepage
- Services showcase
- Portfolio gallery
- Team section
- Testimonials
- Contact form
- Blog posts

**2. Free Portfolio Demo** 🎨
- Creative layouts
- Project showcase
- Photography gallery
- About page
- Services list
- Contact section

### How to Import

#### Via Theme Options (Recommended)

1. Login to WordPress Admin
2. Go to **Appearance → KR Theme Options**
3. Click **"Demo Importer"** tab
4. Click **"Import Demo"** button
5. Confirm the action
6. Wait for import (1-2 minutes)
7. Done! Your demo is live

#### What Gets Imported

✅ Posts and pages  
✅ Images and media  
✅ Homepage design  
✅ Menu structure  
✅ Sidebar widgets  
✅ Theme options  
✅ Customizer settings  

---

## 🛠️ NPM Commands Reference

```bash
# Start development (watch + auto-compile)
npm run dev

# Watch files without starting fresh
npm run watch

# Compile once
npm run compile

# Production build (minified)
npm run build
```

---

## 💾 File Watching

When you run `npm run dev` or `npm run watch`:

- Gulp monitors all files in `assets/scss/`
- Any change triggers automatic compilation
- Look for "SCSS compiled successfully!" notification
- Compiled CSS appears instantly in `assets/css/style.css`

---

## 🎯 Common Tasks

### Add New Styling

1. Create a new `.scss` file in appropriate folder
2. Example: `assets/scss/components/_cards.scss`
3. Add to imports in `assets/scss/style.scss`:
   ```scss
   @import 'components/cards';
   ```
4. Save and Gulp auto-compiles

### Create Custom Demo

1. Create folder: `kr-theme/demos/my-demo/`
2. Create `config.json`:
   ```json
   {
     "slug": "my-demo",
     "name": "My Custom Demo",
     "description": "Description here",
     "demo_url": "https://your-demo-url.com",
     "screenshot": "screenshot.png",
     "is_pro": false,
     "features": ["Feature 1", "Feature 2"]
   }
   ```
3. Add import files:
   - `content.xml` (WordPress export)
   - `customizer.json` (optional)
   - `theme-options.json` (optional)
4. Demo appears in importer automatically!

### Modify Theme Variables

All variables are in `assets/scss/abstracts/_variables.scss`:

```scss
// Colors
$primary-color: #2563eb;
$secondary-color: #6366f1;

// Fonts
$base-font-family: 'Inter', sans-serif;
$heading-font-family: 'Poppins', sans-serif;

// Spacing
$spacing-md: 1rem;
$spacing-lg: 1.5rem;

// Breakpoints
$breakpoint-md: 768px;
$breakpoint-lg: 992px;
```

Change any value and Gulp recompiles everything automatically!

---

## 🔧 Troubleshooting

### Gulp Not Working
```bash
# Delete node_modules
rm -rf node_modules

# Reinstall
npm install

# Try again
npm run dev
```

### CSS Not Updating
- Clear browser cache (Ctrl+Shift+Delete)
- Check `assets/css/style.css` file exists
- Look for Gulp error messages
- Restart: `npm run dev`

### Demo Not Importing
- Check demo folder exists: `kr-theme/demos/slug/`
- Verify `config.json` is valid JSON
- Check WordPress error logs
- Ensure admin permissions

---

## 📊 What's in Each SCSS Folder

### abstracts/
- `_variables.scss` - All colors, fonts, spacing, breakpoints
- `_mixins.scss` - Reusable code blocks
- `_functions.scss` - Custom calculations

### layout/
- `_base.scss` - HTML reset and base styles
- `_header.scss` - Header styling
- `_footer.scss` - Footer styling
- `_grid.scss` - Grid system
- `_typography.scss` - Heading and text styles

### components/
- `_buttons.scss` - Button styles
- `_forms.scss` - Form input styles
- `_modals.scss` - Modal dialogs
- `_cards.scss` - Card components
- `_pagination.scss` - Page navigation

### theme/
- `_home.scss` - Homepage styles
- `_blog.scss` - Blog listing
- `_single.scss` - Single post page
- `_archive.scss` - Archive pages
- `_404.scss` - 404 error page

### utilities/
- `_spacing.scss` - Margin/padding classes
- `_colors.scss` - Text and background colors
- `_flexbox.scss` - Flex layout utilities
- `_display.scss` - Display utilities
- `_responsive.scss` - Mobile-responsive classes

### woocommerce/
- `_shop.scss` - Shop page styles
- `_single-product.scss` - Single product page
- `_cart.scss` - Cart page
- `_checkout.scss` - Checkout page

### elementor/
- `_widgets.scss` - Widget styling
- `_sections.scss` - Section styling

---

## 🎓 Learning SCSS

### Key Concepts

**Variables** - Store values once, use everywhere:
```scss
$primary-color: #2563eb;
button { color: $primary-color; }
```

**Nesting** - Cleaner code organization:
```scss
.card {
    border: 1px solid #ccc;
    
    &:hover {
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
}
```

**Mixins** - Reusable code blocks:
```scss
@mixin flex-center {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal { @include flex-center; }
```

**Inheritance** - Share styles:
```scss
.btn { padding: 10px 20px; }
.btn-primary { @extend .btn; background: blue; }
```

---

## 📱 Responsive Design

Use the breakpoint mixin:

```scss
.header {
    font-size: 24px;
    
    @include media-query('md') {
        font-size: 32px;
    }
    
    @include media-query('lg') {
        font-size: 40px;
    }
}
```

Available breakpoints:
- `xs` - Mobile
- `sm` - 576px+
- `md` - 768px+ (tablets)
- `lg` - 992px+ (desktops)
- `xl` - 1200px+ (large screens)
- `2xl` - 1400px+ (extra large)

---

## ✅ Checklist

- [ ] Run `npm install` in kr-theme folder
- [ ] Run `npm run dev` to watch SCSS
- [ ] Import a demo via WordPress admin
- [ ] Test SCSS changes (edit a variable, save)
- [ ] Check compiled CSS in assets/css/
- [ ] Clear browser cache and reload

---

## 🎉 You're Ready!

You now have:
- ✅ Professional SCSS compilation system
- ✅ Organized code structure  
- ✅ Demo importer for quick setups
- ✅ Responsive design utilities
- ✅ Variable management system
- ✅ Reusable mixins and functions

**Happy coding!** 🚀

---

**Quick Links:**
- 📖 Full Documentation: `SCSS-AND-DEMO-SYSTEM.md`
- 📁 SCSS Folder: `assets/scss/`
- 🎨 Demos Folder: `demos/`
- ⚙️ Build Config: `gulpfile.js`
