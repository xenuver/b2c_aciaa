# 🎨 ACIAA — Frontend Redesign Master Plan

> **Project:** Aciaa Fashion Store (Laravel Blade + Bootstrap + Alpine.js)
> **Objective:** Redesign seluruh halaman frontend agar premium, modern, dan kohesif
> **Tool:** ui-ux-pro-max skill  
> **Generated:** 2026-07-04  
> **Status:** 📋 Planning

---

## 📐 DESIGN SYSTEM

### Identitas Brand

| Aspek | Nilai |
|-------|-------|
| **Brand** | ACIAA — Women's Fashion & Beauty Store |
| **Tone** | Elegant, Modern, Premium, Feminine |
| **Target Audience** | Wanita modern usia 20-35 tahun |
| **Core Style** | Liquid Glass + Exaggerated Minimalism |
| **Vibe** | High-end boutique, editorial fashion, soft luxury |

---

### 🎨 Color Palette

#### Primary Palette

| Role | Hex | Preview | CSS Variable | Penggunaan |
|------|-----|---------|--------------|------------|
| **Primary** | `#C2185B` | 🟥 Deep Rose | `--color-primary` | CTA buttons, links aktif, aksen utama |
| **Primary Light** | `#E91E8C` | 🩷 Light Rose | `--color-primary-light` | Hover states, focus rings |
| **Primary Soft** | `#FCE4EC` | 🩷 Blush | `--color-primary-soft` | Tags, badges background, subtle fills |
| **Secondary** | `#F48FB1` | 🌸 Soft Pink | `--color-secondary` | Secondary buttons, decorative elements |
| **Gold** | `#CA8A04` | 🟡 Elegant Gold | `--color-gold` | Premium CTA, harga spesial, flash sale |
| **Gold Light** | `#FEF3C7` | 🟨 Soft Gold | `--color-gold-light` | Gold badge backgrounds |

#### Neutral Palette

| Role | Hex | CSS Variable | Penggunaan |
|------|-----|--------------|------------|
| **Text Primary** | `#1A1A2E` | `--color-text` | Heading, body text utama |
| **Text Secondary** | `#4A5568` | `--color-text-secondary` | Deskripsi, subtitle |
| **Text Muted** | `#9CA3AF` | `--color-text-muted` | Label, meta info, placeholder |
| **Background** | `#FDF2F8` | `--color-bg` | Page background utama |
| **Surface** | `#FFFFFF` | `--color-surface` | Card, panel, form background |
| **Surface Alt** | `#FEF6F5` | `--color-surface-alt` | Alternate section background |
| **Border** | `rgba(194, 24, 91, 0.12)` | `--color-border` | Card borders, divider |
| **Border Light** | `rgba(0, 0, 0, 0.06)` | `--color-border-light` | Subtle separators |

#### Status Colors

| Role | Hex | Penggunaan |
|------|-----|------------|
| **Success** | `#16A34A` | Toast sukses, status paid |
| **Warning** | `#CA8A04` | Status pending, flash sale |
| **Danger** | `#DC2626` | Error, delete, status cancelled |
| **Info** | `#2563EB` | Status processing, info badges |

---

### 🔤 Typography

#### Font Stack

| Role | Font | Weight | Fallback | Penggunaan |
|------|------|--------|----------|------------|
| **Heading** | **Cormorant** | 400, 500, 600, 700 | Georgia, serif | h1-h4, hero title, product names |
| **Body** | **Montserrat** | 300, 400, 500, 600, 700 | system-ui, sans-serif | Body text, nav, buttons, forms |

#### CSS Import

```css
@import url('https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Montserrat:wght@300;400;500;600;700&display=swap');
```

#### Type Scale

| Element | Font | Size | Weight | Line Height | Letter Spacing |
|---------|------|------|--------|-------------|----------------|
| **Hero Title** | Cormorant | `clamp(2.5rem, 5vw, 4.5rem)` | 400 | 1.1 | `-0.02em` |
| **Section Title (h2)** | Cormorant | `clamp(1.8rem, 3vw, 2.8rem)` | 500 | 1.2 | `-0.01em` |
| **Card Title (h3)** | Cormorant | `1.15rem` | 600 | 1.3 | `0` |
| **Subtitle** | Montserrat | `1rem` | 400 | 1.6 | `0` |
| **Body** | Montserrat | `0.925rem` | 400 | 1.7 | `0` |
| **Small/Caption** | Montserrat | `0.8rem` | 500 | 1.4 | `0.02em` |
| **Tag/Label** | Montserrat | `0.75rem` | 600 | 1 | `0.1em` |
| **Button** | Montserrat | `0.88rem` | 600 | 1 | `0.02em` |
| **Nav Link** | Montserrat | `0.875rem` | 500 | 1 | `0` |
| **Price** | Montserrat | `1.05rem` | 700 | 1 | `0` |
| **Price Old** | Montserrat | `0.8rem` | 400 | 1 | `0` |

---

### 📏 Spacing & Layout

#### Spacing Scale

| Token | Value | Penggunaan |
|-------|-------|------------|
| `--space-xs` | `4px` | Tight gaps, icon margins |
| `--space-sm` | `8px` | Inline spacing, badge padding |
| `--space-md` | `16px` | Standard padding, card gaps |
| `--space-lg` | `24px` | Card padding, section gaps |
| `--space-xl` | `32px` | Section spacing |
| `--space-2xl` | `48px` | Large section margins |
| `--space-3xl` | `64px` | Section vertical padding |
| `--space-4xl` | `80px` | Hero padding, major sections |

#### Border Radius

| Token | Value | Penggunaan |
|-------|-------|------------|
| `--radius-sm` | `8px` | Inputs, small buttons |
| `--radius-md` | `12px` | Cards, medium buttons |
| `--radius-lg` | `16px` | Large cards, panels |
| `--radius-xl` | `20px` | Hero sections, modals |
| `--radius-full` | `9999px` | Pill buttons, badges, avatars |

#### Container

| Breakpoint | Max Width |
|------------|-----------|
| Default | `1200px` |
| Wide | `1400px` (navbar) |
| Narrow | `800px` (checkout, profile) |

---

### ✨ Effects & Animations

#### Glass Effect (Liquid Glass)

```css
/* Glass Card */
.glass {
    background: rgba(255, 255, 255, 0.65);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px rgba(194, 24, 91, 0.06);
}

/* Glass Dark (untuk navbar transparent) */
.glass-dark {
    background: rgba(0, 0, 0, 0.15);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.15);
}

/* Navbar scrolled state */
.glass-nav-scrolled {
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
}
```

#### Shadow System

| Level | Value | Penggunaan |
|-------|-------|------------|
| `--shadow-sm` | `0 1px 3px rgba(0,0,0,0.05)` | Subtle lift, inputs |
| `--shadow-md` | `0 4px 16px rgba(0,0,0,0.08)` | Cards default |
| `--shadow-lg` | `0 8px 32px rgba(0,0,0,0.1)` | Cards hover, dropdowns |
| `--shadow-xl` | `0 16px 48px rgba(0,0,0,0.12)` | Modals, featured cards |
| `--shadow-rose` | `0 8px 24px rgba(194, 24, 91, 0.15)` | CTA buttons hover |
| `--shadow-gold` | `0 8px 24px rgba(202, 138, 4, 0.2)` | Gold CTA hover |

#### Animation Curves

| Token | Value | Penggunaan |
|-------|-------|------------|
| `--ease-fluid` | `cubic-bezier(0.25, 0.46, 0.45, 0.94)` | General transitions |
| `--ease-bounce` | `cubic-bezier(0.34, 1.56, 0.64, 1)` | Playful bouncy effects |
| `--ease-smooth` | `cubic-bezier(0.4, 0, 0.2, 1)` | Smooth linear feel |

#### Animation Durations

| Token | Value | Penggunaan |
|-------|-------|------------|
| `--duration-fast` | `150ms` | Hover color changes |
| `--duration-base` | `250ms` | Standard transitions |
| `--duration-medium` | `350ms` | Card hovers, dropdowns |
| `--duration-slow` | `500ms` | Page transitions, overlays |
| `--duration-hero` | `800ms` | Hero content entrance |

#### Standard Hover Effect (Cards)

```css
.card-hover {
    transition: transform var(--duration-medium) var(--ease-fluid),
                box-shadow var(--duration-medium) var(--ease-fluid);
    cursor: pointer;
}

.card-hover:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-lg);
}
```

#### Image Zoom on Hover

```css
.img-zoom-wrapper {
    overflow: hidden;
}

.img-zoom-wrapper img {
    transition: transform 0.6s var(--ease-fluid);
}

.img-zoom-wrapper:hover img {
    transform: scale(1.06);
}
```

---

### 🧩 Component Specs

#### Buttons

```css
/* Primary Button — Rose */
.btn-primary-aciaa {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 28px;
    background: linear-gradient(135deg, #C2185B 0%, #E91E8C 100%);
    color: #fff;
    border: none;
    border-radius: var(--radius-full);
    font-family: 'Montserrat', sans-serif;
    font-weight: 600;
    font-size: 0.88rem;
    cursor: pointer;
    transition: all var(--duration-base) var(--ease-fluid);
    box-shadow: 0 4px 16px rgba(194, 24, 91, 0.25);
}
.btn-primary-aciaa:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(194, 24, 91, 0.35);
}

/* Gold CTA Button (Premium action) */
.btn-gold {
    background: linear-gradient(135deg, #CA8A04 0%, #EAB308 100%);
    color: #fff;
    box-shadow: 0 4px 16px rgba(202, 138, 4, 0.25);
}

/* Secondary / Outline */
.btn-outline-aciaa {
    background: transparent;
    color: #C2185B;
    border: 1.5px solid rgba(194, 24, 91, 0.3);
    border-radius: var(--radius-full);
    padding: 10px 24px;
}
.btn-outline-aciaa:hover {
    background: #FCE4EC;
    border-color: #C2185B;
}

/* Ghost Button (for navs, subtle) */
.btn-ghost {
    background: transparent;
    color: var(--color-text-secondary);
    border: none;
    padding: 8px 16px;
    border-radius: var(--radius-sm);
}
.btn-ghost:hover {
    background: var(--color-surface-alt);
    color: var(--color-primary);
}
```

#### Input Fields

```css
.input-aciaa {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid rgba(0, 0, 0, 0.1);
    border-radius: var(--radius-sm);
    font-family: 'Montserrat', sans-serif;
    font-size: 0.9rem;
    background: #FAFAFA;
    transition: border-color var(--duration-fast) ease,
                box-shadow var(--duration-fast) ease;
}
.input-aciaa:focus {
    border-color: #C2185B;
    box-shadow: 0 0 0 3px rgba(194, 24, 91, 0.1);
    outline: none;
    background: #fff;
}
.input-aciaa::placeholder {
    color: #9CA3AF;
}
```

#### Product Card

```css
.product-card-aciaa {
    background: #fff;
    border-radius: var(--radius-lg);
    overflow: hidden;
    border: 1px solid var(--color-border);
    transition: all var(--duration-medium) var(--ease-fluid);
    cursor: pointer;
}
.product-card-aciaa:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-lg);
    border-color: rgba(194, 24, 91, 0.2);
}

/* Image wrapper — 4:5 aspect ratio */
.product-card-img {
    position: relative;
    padding-top: 125%;
    overflow: hidden;
    background: #F9F5F4;
}

/* Hover overlay */
.product-card-overlay {
    position: absolute;
    inset: 0;
    background: rgba(26, 26, 46, 0.2);
    opacity: 0;
    transition: opacity var(--duration-medium) var(--ease-fluid);
    display: flex;
    align-items: center;
    justify-content: center;
}
.product-card-aciaa:hover .product-card-overlay {
    opacity: 1;
}

/* Price display */
.price-current {
    font-weight: 700;
    font-size: 1.05rem;
    color: #C2185B;
}
.price-original {
    font-size: 0.8rem;
    color: #9CA3AF;
    text-decoration: line-through;
}
.price-sale {
    font-weight: 700;
    font-size: 1.05rem;
    color: #CA8A04;
}
```

#### Badges

```css
/* Discount Badge */
.badge-discount {
    position: absolute;
    top: 12px;
    left: 12px;
    background: linear-gradient(135deg, #DC2626, #EF4444);
    color: #fff;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: var(--radius-full);
    z-index: 3;
}

/* New Badge */
.badge-new {
    background: linear-gradient(135deg, #C2185B, #E91E8C);
    color: #fff;
}

/* Status Badges */
.badge-status-success { background: #DCFCE7; color: #166534; }
.badge-status-warning { background: #FEF3C7; color: #92400E; }
.badge-status-danger  { background: #FEE2E2; color: #991B1B; }
.badge-status-info    { background: #DBEAFE; color: #1E40AF; }
```

#### Hero/Page Header

```css
.page-hero {
    background: linear-gradient(135deg, #1A1A2E 0%, #16213E 50%, #0F3460 100%);
    padding: 2.5rem 0 3rem;
    position: relative;
    overflow: hidden;
}
.page-hero::before {
    content: '';
    position: absolute;
    top: -60%;
    right: -20%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(194, 24, 91, 0.12) 0%, transparent 70%);
    border-radius: 50%;
}
.page-hero h1 {
    font-family: 'Cormorant', serif;
    font-size: clamp(1.5rem, 3vw, 2rem);
    font-weight: 600;
    color: #fff;
}
.page-hero .breadcrumb-text {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.55);
    margin-top: 6px;
}
.page-hero .breadcrumb-text a {
    color: #F48FB1;
    text-decoration: none;
}
```

---

### 🚫 Anti-Patterns (JANGAN Gunakan)

| ❌ Jangan | ✅ Gunakan |
|-----------|-----------|
| Emoji sebagai icon (🛍️ 🛒 ❤️ 🔔) | SVG icons dari Lucide/Font Awesome |
| `scale()` pada hover yang geser layout | `translateY(-6px)` untuk lift effect |
| Warna teks contrast rendah (gray-400) | Minimum `#4A5568` untuk body text |
| Animasi tanpa `transition` | Selalu gunakan `transition 200-350ms` |
| Infinite animation dekoratif | Hanya untuk loading indicators |
| Cursor default pada elemen clickable | Selalu `cursor: pointer` |
| `!important` berlebihan | Gunakan specificity CSS yang tepat |
| Font mixing berlebihan | Hanya 2 font: Cormorant + Montserrat |

---

### ♿ Accessibility Checklist

- [ ] Semua image punya `alt` text
- [ ] Semua form input punya `<label>` 
- [ ] Contrast ratio minimal 4.5:1 untuk text
- [ ] Focus states visible untuk keyboard nav
- [ ] `prefers-reduced-motion` di-respect
- [ ] Warna bukan satu-satunya indikator (tambah icon/text)
- [ ] `aria-label` pada icon-only buttons
- [ ] Responsive di 375px, 768px, 1024px, 1440px
- [ ] Tidak ada horizontal scroll di mobile

---

## 📋 TASK BREAKDOWN PER-FILE

### Legend

- `[ ]` Belum dikerjakan
- `[/]` Sedang dikerjakan
- `[x]` Selesai
- 🔥 Priority: Critical | ⬆️ High | 🔶 Medium | 🔷 Normal

---

### PHASE 1 — Design Foundation & Global Layout 🔥

> Goal: Setup design tokens, update font imports, redesign navbar & footer yang shared di semua halaman.

#### 1.1 `layouts/app.blade.php` 🔥
- [x] Ganti font import dari `Poppins` → `Cormorant + Montserrat`
- [x] Tambah CSS custom properties (design tokens) di `:root`
- [x] Update `body` font-family ke `'Montserrat', system-ui, sans-serif`
- [x] Pastikan semua `@stack('styles')` dan `@stack('scripts')` tetap ada
- [x] Verifikasi Lucide, Alpine.js, Bootstrap, Font Awesome tetap loaded

#### 1.2 `layouts/landing.blade.php` 🔥
- [x] Sinkronkan font imports sama seperti `app.blade.php`
- [x] Tambah CSS tokens yang sama
- [x] Update body font-family

#### 1.3 `layouts/guest.blade.php` (Auth pages) ⬆️
- [x] Update font dari `Poppins` → `Cormorant + Montserrat`
- [x] Update CSS variables ke palet baru (`--pink` → `--color-primary`)
- [x] Update `.auth-shell` background ke `--color-bg` (#FDF2F8)
- [x] Update gradient circles ke warna baru (rose tones)
- [x] Update `.brand-logo` gradient ke `#C2185B → #E91E8C`
- [x] Update input focus states: border `#C2185B`, ring `rgba(194,24,91,0.15)`
- [x] Update submit button gradient ke `#C2185B → #E91E8C`
- [x] Heading "Selamat Datang" pakai font Cormorant

#### 1.4 `layouts/navigation.blade.php` 🔥
- [x] **Logo**: Update gradient text ke `#C2185B → #E91E8C`
- [x] **Nav links**: Update `.active` dan `:hover` colors ke `#C2185B`
- [x] **Active background**: Dari `#fef6f5` ke `#FCE4EC`
- [x] **User avatar**: Update gradient ke `#C2185B → #E91E8C`
- [x] **Search bar**: Update focus border ke `#C2185B`, ring color
- [x] **Dropdown panel**: Tambah subtle glass effect, rounded corners
- [x] **Mobile menu emojis**: Ganti semua emoji (🏠🛍️🛒❤️🕐↩️🔔👤🚪🔐📝📊) → Lucide SVG icons
- [x] **Mobile menu**: Tambah backdrop blur overlay
- [x] **Badges**: Pastikan `nav-badge` color konsisten
- [x] **Transparent navbar** (home): Update scroll state colors
- [x] Verifikasi: Alpine.js dropdowns masih bekerja
- [x] Verifikasi: Live search masih bekerja
- [x] Verifikasi: Notification dropdown masih bekerja

#### 1.5 `partials/footer.blade.php` ⬆️
- [x] Update font-family ke `Montserrat`
- [x] Update `.footer-logo-icon` gradient ke `#C2185B → #E91E8C`
- [x] Update semua `#d4a5a5` accent colors → `#C2185B`
- [x] Update `.footer-social-link:hover` background ke `#C2185B`
- [x] Update `.footer-col-title::after` underline ke `#C2185B`
- [x] Update link hover colors ke `#C2185B`
- [x] Update copyright strong color ke `#C2185B`
- [x] Heading titles pakai Cormorant

#### 1.6 `components/product-card.blade.php` ⬆️
- [x] Update card styling sesuai `.product-card-aciaa` specs
- [x] Update hover effects: `translateY(-6px)`, shadow `--shadow-lg`
- [x] Update price colors: current `#C2185B`, sale `#CA8A04`
- [x] Update discount badge ke gradient `#DC2626 → #EF4444`
- [x] Update wishlist heart button colors
- [x] Pastikan `cursor: pointer` pada card

#### 1.7 `components/toast.blade.php` 🔷
- [x] Review dan update warna success/error sesuai status colors
- [x] Update font ke Montserrat

#### 1.8 `components/whatsapp-button.blade.php` 🔷
- [x] Review floating button positioning
- [x] Pastikan tidak overlap dengan redesigned elements

---

### PHASE 2 — Landing Page & Home (High Impact) 🔥

> Goal: Redesign kedua halaman utama yang pertama kali dilihat user.

#### 2.1 `frontend/landing.blade.php` 🔥
- [x] **Hero Carousel**:
  - [x] Update font carousel title ke Cormorant, weight 400
  - [x] Update subtitle badge: background `rgba(194,24,91,0.25)`, border rose
  - [x] Update CTA `.btn-primary-custom`: gradient `#C2185B → #E91E8C`, shadow rose
  - [x] Update `.btn-secondary-custom`: border `rgba(255,255,255,0.35)` 
  - [x] Update carousel dots active color
  - [x] Update carousel controls: glass effect tetap, hover color update
  - [x] Ken Burns effect tetap (`transform: scale(1.08)` → `scale(1)`)
  - [x] Content entrance animation tetap (translateY 30px)
- [x] **Brand Manifesto**:
  - [x] Background dari `#fef6f5` → `var(--color-surface-alt)`
  - [x] `.manifesto-tag` color → `#C2185B`
  - [x] `.manifesto-title` font → Cormorant, weight 400
  - [x] `.manifesto-divider` background → `#C2185B`
  - [x] Image wrapper shadow update
- [x] **Shop by Category**:
  - [x] `.category-minimal-card` border color → `rgba(194,24,91,0.15)`
  - [x] `.cat-num` color → `#C2185B`
  - [x] Hover effect `.cat-name` color → `#C2185B`
  - [x] Hover effect `.cat-arrow` color → `#C2185B`
  - [x] Section title font → Cormorant
- [x] **Featured Products**:
  - [x] Product cards: border `var(--color-border)`
  - [x] Hover: border `rgba(194,24,91,0.2)`, shadow `--shadow-lg`
  - [x] `.btn-product-detail:hover` background → `#C2185B`
  - [x] Discount badge → gradient red
  - [x] Price colors update
  - [x] "Explore Full Shop" button → rose gradient
- [x] **Testimonials**:
  - [x] Quote icon color → `#C2185B`
  - [x] `.testimonial-quote` font → Cormorant italic
  - [x] Author name styling update
  - [x] Carousel indicators → rose colors
- [x] **Lookbook Grid**:
  - [x] `.lookbook-tag` styling update
  - [x] `.lookbook-title` font → Cormorant
  - [x] `.lookbook-link` color → `#C2185B`
  - [x] Overlay gradient subtle update
- [x] **Value Props**:
  - [x] Icon color → `#C2185B`
  - [x] Subtle background update
- [x] **Newsletter**:
  - [x] `.newsletter-tag` color → `#C2185B`
  - [x] `.newsletter-title` font → Cormorant
  - [x] Input focus state → rose border
  - [x] Submit button → rose gradient
- [x] Verifikasi: Carousel JS masih berfungsi
- [x] Responsive check: 375px, 768px, 1024px, 1440px

#### 2.2 `frontend/home.blade.php` 🔥
- [x] **Hero Carousel**: 
  - [x] Sama seperti landing carousel — update colors & fonts
  - [x] Hero search bar: focus border `#C2185B`, ring rose
  - [x] `.hero-btn` hover color → `#C2185B`
  - [x] `.hero-search-btn` focus state → dark/rose
- [x] **Featured Banner** (value props):
  - [x] Update icon colors
  - [x] Subtle background gradient update
- [x] **Category Grid**:
  - [x] `.section-tag` color → `#C2185B`
  - [x] `.section-title` font → Cormorant
  - [x] `.section-divider` background → `#C2185B`
  - [x] Category card icon colors
  - [x] Hover states update
- [x] **Flash Sale / Promo Banner**:
  - [x] `.promo-banner-tag` background → `#C2185B`
  - [x] Ganti emoji ✨🔥 → SVG icons
  - [x] Countdown timer styling → rose/gold accents
  - [x] Slider cards: price sale color → `#CA8A04`
  - [x] "Beli Sekarang" button → gold gradient
  - [x] Update slider dots dan controls
- [x] **New Collection Products**:
  - [x] Product cards sesuai design system specs
  - [x] Badge "New" → rose gradient
  - [x] Wishlist heart button colors
  - [x] Price colors update
- [x] **Recommendations Section**:
  - [x] Same product card treatment
  - [x] "Untuk Anda" badge → rose style
  - [x] Divider colors
- [x] **Newsletter Section**:
  - [x] Same treatment as landing newsletter
- [x] Verifikasi: Carousel, slider, countdown, wishlist toggle semua bekerja
- [x] Verifikasi: Quick view modal masih bekerja
- [x] Responsive check

---

### PHASE 3 — Product Pages ⬆️

> Goal: Redesign halaman katalog produk dan detail produk.

#### 3.1 `frontend/products/index.blade.php` ⬆️
- [x] Page hero/header → dark gradient + rose accents
- [x] Breadcrumb styling update
- [x] **Filter sidebar**:
  - [x] Category filter → pill-style checkboxes
  - [x] Price range → rose accent slider
  - [x] Sort dropdown → styled select
  - [x] Filter tags/badges → `#FCE4EC` background, `#C2185B` text
- [x] **`frontend/products/index.blade.php`**
  - [x] **Breadcrumb update**: Use Liquid Glass link styles.
  - [x] **Category filter**: Convert default links to pill-style toggle buttons.
  - [x] **Filter tags**: Display active filters as small chips with `#FCE4EC` background and `#C2185B` text.
  - [x] **Empty state**: Ensure empty search results use brand colors instead of default gray icons.

#### 3.2 `frontend/products/show.blade.php` ⬆️
- [x] **Tabs (Description/Reviews)**: Rose active tab
- [x] **Review cards**: Star colors `#CA8A04`, card styling
- [x] **Related products**: Same card treatment
- [x] Breadcrumb update
- [x] Verifikasi: Add to cart, buy now, wishlist, review form semua bekerja
- [x] Responsive check

---

### PHASE 4 — Cart & Checkout Flow ⬆️

> Goal: Redesign alur checkout yang kritis untuk conversion.

#### 4.1 `frontend/cart/index.blade.php` ⬆️
- [x] **Hero banner**: Update gradient circles → rose
- [x] **Hero h1**: Font → Cormorant, icon color → `#C2185B`
- [x] **Breadcrumb**: Link color → `#F48FB1`
- [x] **Cart card**: Border, hover shadow update
- [x] **Item price**: Color → `#C2185B`
- [x] **Qty stepper**: Hover bg → `#FCE4EC`
- [x] **Summary card**: Subtle glass effect
- [x] **Summary total**: Value color → `#C2185B`
- [x] **Checkout button**: Gradient `#C2185B → #E91E8C`
- [x] **Continue shopping**: Outline style
- [x] **Remove button**: Keep red accent
- [x] **Empty state**: Icon gradient → rose, CTA button → rose
- [x] Verifikasi: updateQty, removeItem, semua AJAX bekerja
- [x] Responsive check

#### 4.2 `frontend/checkout/index.blade.php` ⬆️
- [x] Hero banner → sama seperti cart
- [x] **Form inputs**: Sesuai `.input-aciaa` specs
- [x] **Address card selection**: Border active → `#C2185B`, background → `#FCE4EC`
- [x] **Shipping method radio**: Custom styled, active rose
- [x] **Payment method**: Custom radio groups, active rose
- [x] **Order summary sidebar**: Glass effect, sticky
- [x] **Submit order button**: Gold gradient (premium action)
- [x] **Voucher input**: Focus state rose
- [x] Verifikasi: Form submit, address selection, payment, voucher semua bekerja
- [x] Responsive check

#### 4.3 `frontend/checkout/direct.blade.php` ⬆️
- [x] Same styling sebagai checkout/index (share CSS patterns)
- [x] Verifikasi: Direct buy flow bekerja

#### 4.4 `frontend/checkout/success.blade.php` 🔶
- [x] Success icon: Animated checkmark, rose/green colors
- [x] Thank you card: Cormorant heading
- [x] Order summary: Clean layout
- [x] CTA buttons: "Lihat Pesanan" → rose, "Lanjut Belanja" → outline
- [x] Subtle celebratory animation (optional confetti)

---

### PHASE 5 — User Account Pages ⬆️

> Goal: Redesign halaman akun user untuk konsistensi.

#### 5.1 `frontend/transactions/index.blade.php` 🔶
- [x] Hero banner → dark gradient + rose
- [x] **Tab filters**: Pill-style, active → rose background
- [x] **Transaction cards**: Timeline-style layout
- [x] **Status badges**: Sesuai status colors (success/warning/danger/info)
- [x] **Price display**: Rose color
- [x] Pagination → rose active
- [x] Verifikasi: Tab filter, pagination bekerja

#### 5.2 `frontend/transactions/show.blade.php` 🔶
- [x] Hero banner
- [x] **Order progress tracker**: Step indicators, rose active
- [x] **Item list**: Clean product rows
- [x] **Order details card**: Glass effect
- [x] **Action buttons**: Rose/outline styling
- [x] Verifikasi: Semua action buttons (bayar, konfirmasi, dll) bekerja

#### 5.3 `frontend/transactions/partials/list.blade.php` 🔶
- [x] Konsistenkan dengan transactions/index styling
- [x] Status badge colors update
- [x] Action link colors

#### 5.4 `frontend/profile/edit.blade.php` 🔶
- [x] Hero banner
- [x] **Profile header**: Avatar with rose gradient ring
- [x] **Tab navigation**: Rose active tab
- [x] **Form sections**: Card-based, consistent inputs
- [x] **Input styling**: Sesuai `.input-aciaa` specs
- [x] **Save button**: Rose gradient
- [x] **Password section**: Same input treatment
- [x] **Address management**: Card-based, rose accents
- [x] Verifikasi: Form submit, password update, address CRUD bekerja

#### 5.5 `frontend/wishlist/index.blade.php` 🔶
- [x] Hero banner → rose accent (bukan `#cf7e7e`)
- [x] **Product grid**: Sama seperti home/products cards
- [x] **Remove button**: Keep red accent
- [x] **Personalization banner**: Update gradient → rose
- [x] **Empty state**: Rose themed
- [x] **Pagination**: Rose active
- [x] Verifikasi: Remove wishlist AJAX bekerja
- [x] Verifikasi: Quick view bekerja

---

### PHASE 6 — Secondary Pages 🔷

> Goal: Update halaman sekunder untuk konsistensi penuh.

#### 6.1 `frontend/returs/index.blade.php` 🔷
- [x] Hero banner
- [x] Retur list cards → consistent styling
- [x] Status badges → status colors
- [x] Action buttons → rose/outline
- [x] Empty state → branded

#### 6.2 `frontend/returs/create.blade.php` 🔷
- [x] Hero banner
- [x] Form inputs → `.input-aciaa` specs
- [x] Product selection card styling
- [x] Submit button → rose gradient
- [x] File upload area → rose accent border

#### 6.3 `frontend/returs/show.blade.php` 🔷
- [x] Hero banner
- [x] Detail card → glass effect
- [x] Status tracking → rose progress
- [x] Image gallery → consistent
- [x] Admin response card styling

#### 6.4 `frontend/notifications/index.blade.php` 🔷
- [x] Hero banner
- [x] Notification cards → consistent styling
- [x] Unread indicator → rose dot
- [x] "Mark all read" button → rose text
- [x] Empty state → branded
- [x] Pagination → rose

#### 6.5 `frontend/vouchers/index.blade.php` 🔷
- [x] Hero banner
- [x] Voucher cards → coupon/ticket style
- [x] Discount amount → gold accent `#CA8A04`
- [x] "Claim" / "Use" button → gold gradient
- [x] Expiry date → muted text
- [x] Active vs expired visual distinction
- [x] Empty state → branded

#### 6.6 `frontend/ratings/index.blade.php` 🔷
- [x] Hero banner
- [x] Review cards → consistent styling
- [x] Star rating → gold `#CA8A04`
- [x] Action buttons (edit/delete) → rose/red

#### 6.7 `frontend/ratings/create.blade.php` 🔷
- [x] Hero banner
- [x] Star rating input → interactive, gold
- [x] Text area → `.input-aciaa` specs
- [x] Image upload → rose accent
- [x] Submit button → rose gradient

#### 6.8 `frontend/ratings/edit.blade.php` 🔷
- [x] Same as ratings/create styling
- [x] Pre-filled form styling

---

### PHASE 7 — Auth Pages 🔷

> Goal: Update login, register, dan halaman auth lainnya.

#### 7.1 `auth/login.blade.php` 🔷
- [x] Inherits guest.blade.php updates
- [x] Review form layout consistency
- [x] Social login buttons (if any) → consistent

#### 7.2 `auth/register.blade.php` 🔷
- [x] Same as login treatment
- [x] Form validation error colors → red accent

#### 7.3 `auth/forgot-password.blade.php` 🔷
- [x] Consistent with auth redesign

#### 7.4 `auth/reset-password.blade.php` 🔷
- [x] Consistent with auth redesign

#### 7.5 `auth/verify-email.blade.php` 🔷
- [x] Consistent with auth redesign

#### 7.6 `auth/confirm-password.blade.php` 🔷
- [x] Consistent with auth redesign

---

## 📊 FILE INVENTORY & EFFORT MATRIX

| # | File | Phase | Priority | Size | Effort | Dependencies |
|---|------|-------|----------|------|--------|-------------|
| 1 | `layouts/app.blade.php` | 1 | 🔥 | 139 lines | Small | None — START HERE |
| 2 | `layouts/landing.blade.php` | 1 | 🔥 | ~400 lines | Small | After #1 |
| 3 | `layouts/guest.blade.php` | 1 | ⬆️ | 300 lines | Medium | After #1 |
| 4 | `layouts/navigation.blade.php` | 1 | 🔥 | 1488 lines | Large | After #1 |
| 5 | `partials/footer.blade.php` | 1 | ⬆️ | 298 lines | Small | After #1 |
| 6 | `components/product-card.blade.php` | 1 | ⬆️ | ~200 lines | Medium | After #1 |
| 7 | `components/toast.blade.php` | 1 | 🔷 | ~150 lines | Small | After #1 |
| 8 | `frontend/landing.blade.php` | 2 | 🔥 | 1201 lines | Large | After Phase 1 |
| 9 | `frontend/home.blade.php` | 2 | 🔥 | 2172 lines | XL | After Phase 1 |
| 10 | `frontend/products/index.blade.php` | 3 | ⬆️ | ~2000 lines | Large | After Phase 1 |
| 11 | `frontend/products/show.blade.php` | 3 | ⬆️ | ~1700 lines | Large | After Phase 1 |
| 12 | `frontend/cart/index.blade.php` | 4 | ⬆️ | 492 lines | Medium | After Phase 1 |
| 13 | `frontend/checkout/index.blade.php` | 4 | ⬆️ | ~2100 lines | XL | After Phase 1 |
| 14 | `frontend/checkout/direct.blade.php` | 4 | ⬆️ | ~2100 lines | XL | After #13 |
| 15 | `frontend/checkout/success.blade.php` | 4 | 🔶 | ~220 lines | Small | After Phase 1 |
| 16 | `frontend/transactions/index.blade.php` | 5 | 🔶 | ~200 lines | Small | After Phase 1 |
| 17 | `frontend/transactions/show.blade.php` | 5 | 🔶 | ~800 lines | Medium | After Phase 1 |
| 18 | `frontend/transactions/partials/list.blade.php` | 5 | 🔶 | ~180 lines | Small | After #16 |
| 19 | `frontend/profile/edit.blade.php` | 5 | 🔶 | ~1500 lines | Large | After Phase 1 |
| 20 | `frontend/wishlist/index.blade.php` | 5 | 🔶 | 599 lines | Medium | After Phase 1 |
| 21 | `frontend/returs/index.blade.php` | 6 | 🔷 | ~350 lines | Medium | After Phase 1 |
| 22 | `frontend/returs/create.blade.php` | 6 | 🔷 | ~600 lines | Medium | After Phase 1 |
| 23 | `frontend/returs/show.blade.php` | 6 | 🔷 | ~400 lines | Medium | After Phase 1 |
| 24 | `frontend/notifications/index.blade.php` | 6 | 🔷 | ~400 lines | Medium | After Phase 1 |
| 25 | `frontend/vouchers/index.blade.php` | 6 | 🔷 | ~450 lines | Medium | After Phase 1 |
| 26 | `frontend/ratings/index.blade.php` | 6 | 🔷 | ~300 lines | Small | After Phase 1 |
| 27 | `frontend/ratings/create.blade.php` | 6 | 🔷 | ~450 lines | Medium | After Phase 1 |
| 28 | `frontend/ratings/edit.blade.php` | 6 | 🔷 | ~500 lines | Medium | After Phase 1 |
| 29 | `auth/login.blade.php` | 7 | 🔷 | ~120 lines | Small | After #3 |
| 30 | `auth/register.blade.php` | 7 | 🔷 | ~150 lines | Small | After #3 |
| 31 | `auth/forgot-password.blade.php` | 7 | 🔷 | ~30 lines | Tiny | After #3 |
| 32 | `auth/reset-password.blade.php` | 7 | 🔷 | ~50 lines | Tiny | After #3 |
| 33 | `auth/verify-email.blade.php` | 7 | 🔷 | ~40 lines | Tiny | After #3 |
| 34 | `auth/confirm-password.blade.php` | 7 | 🔷 | ~30 lines | Tiny | After #3 |

**Total: 34 files across 7 phases**

---

## 🔄 EXECUTION RULES

### Aturan Umum

1. **Hanya ubah CSS/HTML visual** — JANGAN ubah logika PHP, Blade directives, Alpine.js, Axios, routes
2. **Inline `<style>` blocks** — Sebagian besar CSS ada di inline `<style>` tag dalam blade files, ubah di situ
3. **Test setelah setiap file** — Pastikan halaman masih bisa di-load dan interaktif
4. **Commit per-phase** — Setiap phase bisa di-commit terpisah
5. **Responsive first** — Selalu test di 375px (mobile) setelah modifikasi

### Pola Perubahan Utama

Perubahan yang paling sering dilakukan (search & replace patterns):

| Find | Replace | Context |
|------|---------|---------|
| `#d4a5a5` | `#C2185B` | Primary accent color |
| `#b5838d` | `#E91E8C` | Secondary accent / gradient end |
| `#cf7e7e` | `#C2185B` | Cart/wishlist accent color |
| `#b76e79` | `#E91E8C` | Gradient end color |
| `#fef6f5` | `#FCE4EC` | Light pink background |
| `font-family: 'Poppins'` | `font-family: 'Montserrat'` | Body font |
| `font-family: 'Inter'` | `font-family: 'Montserrat'` | Body font |
| `rgba(212, 165, 165,` | `rgba(194, 24, 91,` | Accent rgba values |
| `rgba(207,126,126,` | `rgba(194,24,91,` | Cart/wish accent rgba |

### Untuk Section Titles (h2, h3 headings)

Tambahkan `font-family: 'Cormorant', Georgia, serif;` pada:
- `.section-title`
- `.manifesto-title`
- `.carousel-title-custom`
- `.newsletter-title`
- `.promo-banner-title`
- Page hero `h1`
- Product name di detail page

---

## ✅ VERIFICATION PLAN

### Per-Phase Verification

| Check | Method |
|-------|--------|
| Pages load tanpa error | `php artisan serve` + browse |
| Carousel/slider berfungsi | Click prev/next, autoplay |
| Search bar berfungsi | Type query, verify results |
| Add to cart berfungsi | Click add, verify toast + badge |
| Wishlist toggle berfungsi | Click heart, verify state |
| Checkout form submit | Fill form, submit |
| Login/logout berfungsi | Login, verify redirect |
| Toast notifications | Trigger action, verify toast |
| Alpine.js dropdowns | Click user menu, notifications |
| Mobile responsive | Chrome DevTools 375px, 768px |
| No horizontal scroll | Check mobile views |
| No content behind navbar | Scroll content pages |

### Final Quality Checklist

- [x] Semua 34 files telah di-update
- [x] Warna konsisten di seluruh halaman (no old `#d4a5a5`)
- [x] Font konsisten (no old `Poppins/Inter` as primary)
- [x] Semua interaksi Alpine.js berfungsi
- [x] Semua AJAX calls (cart, wishlist, search) berfungsi
- [x] Semua forms bisa di-submit
- [x] Responsive di semua breakpoint
- [x] No JavaScript console errors
- [x] Lighthouse accessibility score ≥ 85
- [x] Page load time acceptable
