# Hero Section Consistency Implementation

## Current State Analysis
- **hero-section.blade.php**: Main component with background image, diagonal split, gradient overlays
- **hero-about.blade.php**: Similar design, different default image
- **hero-wishlist.blade.php**: Similar but uses different image path (asset('storage/'))
- **hero-riwayat.blade.php**: Simple yellow background, no image
- **herosectionkamar.blade.php**: Split section with background image but different structure
- **Member/index.blade.php**: Custom hero with background image
- **contact.blade.php**: Custom hero with gradient background, no image

## Implementation Plan

### 1. Update hero-wishlist.blade.php
- Change image path from `asset('storage/' . $image)` to `'{{ $image }}'` to match hero-section
- Ensure consistency with hero-section design

### 2. Update hero-riwayat.blade.php
- Replace simple yellow background with full hero-section design
- Add background image support
- Match hero-section component structure

### 3. Update herosectionkamar.blade.php
- Restructure to match hero-section diagonal split design
- Keep background image but update layout to be consistent

### 4. Update contact.blade.php
- Replace custom gradient hero with hero-section component
- Add appropriate background image

### 5. Update Member/index.blade.php
- Replace custom hero section with hero-section component
- Ensure proper props are passed

### 6. Verify hero-about.blade.php
- Ensure it matches hero-section design exactly
- Check image path consistency

## Files Edited
- ✅ resources/views/components/hero-wishlist.blade.php - Fixed image path consistency
- ✅ resources/views/components/hero-riwayat.blade.php - Replaced simple background with full hero design
- ✅ resources/views/components/herosectionkamar.blade.php - Restructured to match diagonal split design
- ✅ resources/views/contact.blade.php - Replaced custom gradient hero with hero-section component
- ✅ resources/views/Member/index.blade.php - Replaced custom hero with hero-section component
- ✅ resources/views/components/hero-about.blade.php - Already matched hero-section design (no changes needed)

## Expected Outcome
All hero sections will have:
- Consistent design with diagonal split background
- Background images for visual appeal
- Improved UX through unified design language
- Proper responsive behavior
