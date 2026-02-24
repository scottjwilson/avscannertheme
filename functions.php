<?php
/**
 * AVScannerTheme - Theme Functions
 *
 * @package AVScannerTheme
 */

// Theme setup: menus, supports, and base assets
require_once get_template_directory() . "/inc/theme-setup.php";

// Vite integration: dev server detection and production asset loading
require_once get_template_directory() . "/inc/vite.php";

// SEO: meta description, canonical, Open Graph, Twitter Cards, JSON-LD
require_once get_template_directory() . "/inc/seo.php";

