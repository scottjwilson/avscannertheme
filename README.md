# Clean Vite WP

A minimal WordPress theme starter with Vite for modern frontend development.

## Features

- Vite integration with Hot Module Replacement (HMR)
- Automatic dev server detection
- Production builds with manifest-based asset loading
- PostCSS with Autoprefixer
- Modular CSS architecture
- Clean, minimal PHP structure

## Requirements

- WordPress 6.0+
- PHP 8.0+
- Node.js 18+

## Installation

1. Clone or copy this theme to `wp-content/themes/`
2. Install dependencies:
   ```bash
   npm install
   ```

## Development

Start the Vite dev server for HMR:

```bash
npm run dev
```

The theme automatically detects when the Vite dev server is running on `localhost:3000` and serves assets with hot reloading.

## Production Build

Build optimized assets:

```bash
npm run build
```

This generates a `dist/` directory with:
- Bundled and minified CSS
- Bundled and minified JavaScript
- Asset manifest for cache-busting

## Project Structure

```
clean-vite-wp/
├── css/
│   ├── variables.css      # CSS custom properties
│   ├── base.css           # Base/reset styles
│   ├── layout.css         # Layout utilities
│   ├── header.css         # Header styles
│   ├── footer.css         # Footer styles
│   └── front-page.css     # Front page styles
├── js/
│   └── main.js            # Main entry point (imports CSS)
├── inc/
│   ├── theme-setup.php    # Theme configuration
│   ├── vite.php           # Vite integration
│   └── post-types.php     # Custom post type scaffold
├── dist/                  # Production build output
├── functions.php          # Theme bootstrap
├── style.css              # Theme metadata
├── vite.config.js         # Vite configuration
└── package.json
```

## How It Works

### Development Mode

When `npm run dev` is running:
1. The theme detects the Vite dev server at `localhost:3000`
2. Scripts are loaded directly from Vite with HMR enabled
3. CSS changes reflect instantly without page reload

### Production Mode

When built with `npm run build`:
1. Assets are bundled into `dist/`
2. A `manifest.json` maps source files to hashed outputs
3. The theme reads the manifest and enqueues versioned assets

## Customization

### Adding CSS Files

1. Create your CSS file in `css/`
2. Import it in `js/main.js`:
   ```js
   import "../css/your-file.css";
   ```

### Adding JavaScript

Add your code to `js/main.js` or create modules and import them.

### Custom Post Types

Add your post type registrations in `inc/post-types.php`. An example scaffold is provided in the file.

### Changing the Dev Server Port

Update both:
- `vite.config.js` — `server.port`
- `inc/vite.php` — `$vite_server` variable

## License

GPL-2.0-or-later
