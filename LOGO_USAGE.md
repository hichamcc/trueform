# True Form Elite Logo Usage Guide

## Logo Components Created

### 1. Full Logo (`<x-logo />`)
**File:** `resources/views/components/logo.blade.php`

Complete logo with icon and text. Best for headers, marketing pages, and primary branding.

**Usage:**
```blade
<!-- Default size (200x60) -->
<x-logo />

<!-- Custom size -->
<x-logo width="300" height="90" />

<!-- With custom classes -->
<x-logo class="opacity-80 hover:opacity-100 transition" />
```

### 2. Icon Only (`<x-logo-icon />`)
**File:** `resources/views/components/logo-icon.blade.php`

Standalone icon mark. Perfect for favicons, mobile headers, and compact spaces.

**Usage:**
```blade
<!-- Default size (48x48) -->
<x-logo-icon />

<!-- Custom size -->
<x-logo-icon size="64" />

<!-- With custom classes -->
<x-logo-icon size="32" class="mx-auto" />
```

## Logo Design Elements

### Symbol Meaning:
- **Outer Circle**: Represents the continuous 360-day transformation journey
- **Upward Triangle**: Symbolizes growth, elevation, and progress
- **Central Diamond**: Represents the core, inner strength, and balance
- **Animated Pulse**: Signifies energy, vitality, and the Mito-Age Score

### Color Palette:
- **Silver Gradient**: #f0f0f0 → #e4e4e4 → #d1d1d1 → #b4b4b4
- Matches the dashboard's premium dark theme with silver accents

### Animation:
- Subtle pulsing ring effect (3-second cycle)
- Creates sense of energy and vitality
- Can be disabled by removing the `<animate>` tags if needed

## Where to Use

### Full Logo:
- Navigation bars (desktop)
- Welcome/landing page
- Email headers
- Marketing materials
- Footer branding
- Admin panel header

### Icon Only:
- Mobile navigation
- Favicon (needs to be exported as .ico or .png)
- App icons
- Social media profile pictures
- Loading screens
- Compact headers

## Updating Existing Pages

### Navigation Bar Example:
```blade
<!-- Replace text with logo -->
<div class="flex items-center">
    <x-logo width="180" height="54" />
</div>
```

### Dashboard Sidebar Example:
```blade
<!-- Icon + Text combo -->
<div class="flex items-center gap-3">
    <x-logo-icon size="40" />
    <div>
        <h1 class="text-xl font-bold">True Form Elite</h1>
        <p class="text-xs">360-Day Journey</p>
    </div>
</div>
```

## Exporting for Other Uses

### To export as PNG (for favicon, app icons):
1. Open the SVG in a browser
2. Use browser dev tools to export as PNG
3. Or use online tools like CloudConvert or SVGOMG

### Recommended Export Sizes:
- **Favicon**: 32x32, 48x48, 64x64
- **App Icons**: 120x120, 180x180, 512x512
- **Social Media**: 400x400 (square)
- **Email**: 600x180 (full logo)

## Customization

Both components accept standard HTML/SVG attributes:
- `width` and `height` (or `size` for icon)
- `class` for Tailwind CSS classes
- Any other SVG attributes via `$attributes`

## Dark Mode Compatibility

The logo is designed for dark backgrounds but works on light backgrounds too. The silver gradient provides good contrast in both contexts.

---

**Created:** 2025-11-08
**Version:** 1.0
**Format:** SVG (Scalable Vector Graphics)
