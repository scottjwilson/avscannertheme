<?php
/**
 * AVScannerTheme - Theme Setup
 *
 * Core theme configuration, menus, and theme supports.
 *
 * @package AVScannerTheme
 */

defined("ABSPATH") || exit();

define("CVW_VERSION", "1.0.0");
define("CVW_DIR", get_template_directory());
define("CVW_URI", get_template_directory_uri());

/**
 * Register theme supports and navigation menus
 */
function avs_setup(): void
{
    add_theme_support("automatic-feed-links");
    add_theme_support("title-tag");
    add_theme_support("post-thumbnails");
    add_theme_support("custom-logo", [
        "height" => 40,
        "width" => 160,
        "flex-width" => true,
        "flex-height" => true,
    ]);
    add_theme_support("align-wide");
    add_theme_support("responsive-embeds");
    add_theme_support("html5", [
        "search-form",
        "comment-form",
        "comment-list",
        "gallery",
        "caption",
    ]);

    add_image_size("cvw-card", 600, 400, true);
    add_image_size('cvw-card-2x', 900, 600, true);
    add_image_size('cvw-hero', 800, 0, false);
    add_image_size('cvw-hero-2x', 1200, 0, false);

    register_nav_menus([
        "primary" => __("Primary Menu", "avscannertheme"),
        "footer" => __("Footer Menu", "avscannertheme"),
    ]);
}
add_action("after_setup_theme", "avs_setup");

/**
 * Generate WebP sub-sizes for JPEG/PNG uploads (WP 5.8+).
 * The original full-size upload stays as-is; only thumbnails convert.
 * Falls back silently if the server lacks WebP support in GD/Imagick.
 */
function avs_webp_output_format(array $formats): array {
    $formats['image/jpeg'] = 'image/webp';
    $formats['image/png']  = 'image/webp';
    return $formats;
}
add_filter('image_editor_output_format', 'avs_webp_output_format');

/**
 * Add decoding="async" to any <img> tag that doesn't already have it.
 */
function avs_add_decoding_async(string $content): string {
    if (empty($content)) return $content;
    return preg_replace(
        '/<img(?![^>]*\bdecoding\b)([^>]*)>/i',
        '<img decoding="async"$1>',
        $content
    );
}
add_filter('the_content', 'avs_add_decoding_async', 999);
add_filter('post_thumbnail_html', 'avs_add_decoding_async', 999);

/**
 * Enqueue base styles and scripts
 */
function avs_enqueue_assets(): void
{
    wp_enqueue_style("cvw-style", get_stylesheet_uri(), [], CVW_VERSION);

    // Check if Vite handles assets
    if (function_exists("avs_detect_vite_server")) {
        $vite = avs_detect_vite_server();
        $has_manifest = file_exists(get_theme_file_path("dist/.vite/manifest.json"))
            || file_exists(get_theme_file_path("dist/manifest.json"));

        if ($vite["running"] || $has_manifest) {
            return;
        }
    }

    // Google Fonts
    wp_enqueue_style(
        "cvw-google-fonts",
        "https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700;800;900&family=Inter:wght@400;500;600&display=swap",
        [],
        null,
    );

    // Fallback: enqueue CSS directly if Vite is not available
    wp_enqueue_style(
        "cvw-variables",
        get_template_directory_uri() . "/css/variables.css",
        ["cvw-google-fonts"],
        CVW_VERSION,
    );
    wp_enqueue_style(
        "cvw-base",
        get_template_directory_uri() . "/css/base.css",
        ["cvw-variables"],
        CVW_VERSION,
    );
    wp_enqueue_style(
        "cvw-layout",
        get_template_directory_uri() . "/css/layout.css",
        ["cvw-base"],
        CVW_VERSION,
    );
    wp_enqueue_style(
        "cvw-header",
        get_template_directory_uri() . "/css/header.css",
        ["cvw-base", "cvw-layout"],
        CVW_VERSION,
    );
    wp_enqueue_style(
        "cvw-search",
        get_template_directory_uri() . "/css/search.css",
        ["cvw-header"],
        CVW_VERSION,
    );
    wp_enqueue_style(
        "cvw-category-nav",
        get_template_directory_uri() . "/css/category-nav.css",
        ["cvw-header"],
        CVW_VERSION,
    );
    wp_enqueue_style(
        "cvw-footer",
        get_template_directory_uri() . "/css/footer.css",
        ["cvw-base", "cvw-layout"],
        CVW_VERSION,
    );

    if (is_front_page()) {
        wp_enqueue_style(
            "cvw-front-page",
            get_template_directory_uri() . "/css/front-page.css",
            ["cvw-base"],
            CVW_VERSION,
        );
    }

    wp_enqueue_script(
        "cvw-main",
        get_template_directory_uri() . "/js/main.js",
        [],
        CVW_VERSION,
        true,
    );
}
add_action("wp_enqueue_scripts", "avs_enqueue_assets");

/**
 * Custom excerpt length
 */
function avs_excerpt_length(int $length): int
{
    return 20;
}
add_filter("excerpt_length", "avs_excerpt_length", 999);

/**
 * SVG Icons Library
 */
function avs_icon($name, $size = 20): string
{
    $icons = [
        "arrow-right" =>
            '<svg width="' .
            $size .
            '" height="' .
            $size .
            '" viewBox="0 0 20 20" fill="none"><path d="M4.167 10h11.666M10 4.167L15.833 10 10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        "arrow-up-right" =>
            '<svg width="' .
            $size .
            '" height="' .
            $size .
            '" viewBox="0 0 20 20" fill="none"><path d="M5.833 14.167L14.167 5.833M14.167 5.833H5.833M14.167 5.833v8.334" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        "menu" =>
            '<svg width="' .
            $size .
            '" height="' .
            $size .
            '" viewBox="0 0 24 24" fill="none"><path d="M3 12h18M3 6h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        "close" =>
            '<svg width="' .
            $size .
            '" height="' .
            $size .
            '" viewBox="0 0 24 24" fill="none"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        "check" =>
            '<svg width="' .
            $size .
            '" height="' .
            $size .
            '" viewBox="0 0 20 20" fill="none"><path d="M16.667 5L7.5 14.167 3.333 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        "plus" =>
            '<svg width="' .
            $size .
            '" height="' .
            $size .
            '" viewBox="0 0 20 20" fill="none"><path d="M10 4.167v11.666M4.167 10h11.666" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        "search" =>
            '<svg width="' .
            $size .
            '" height="' .
            $size .
            '" viewBox="0 0 20 20" fill="none"><circle cx="9.167" cy="9.167" r="5.833" stroke="currentColor" stroke-width="1.5"/><path d="M17.5 17.5l-4.167-4.167" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
        "mail" =>
            '<svg width="' .
            $size .
            '" height="' .
            $size .
            '" viewBox="0 0 20 20" fill="none"><path d="M3.333 3.333h13.334c.916 0 1.666.75 1.666 1.667v10c0 .917-.75 1.667-1.666 1.667H3.333c-.916 0-1.666-.75-1.666-1.667V5c0-.917.75-1.667 1.666-1.667z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.333 5l-8.333 5.833L1.667 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        "code" =>
            '<svg width="' .
            $size .
            '" height="' .
            $size .
            '" viewBox="0 0 20 20" fill="none"><path d="M13.333 15l5-5-5-5M6.667 5l-5 5 5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        "globe" =>
            '<svg width="' .
            $size .
            '" height="' .
            $size .
            '" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="8.333" stroke="currentColor" stroke-width="1.5"/><path d="M1.667 10h16.666M10 1.667a12.75 12.75 0 013.333 8.333 12.75 12.75 0 01-3.333 8.333 12.75 12.75 0 01-3.333-8.333A12.75 12.75 0 0110 1.667z" stroke="currentColor" stroke-width="1.5"/></svg>',
        "arrow-up" =>
            '<svg width="' .
            $size .
            '" height="' .
            $size .
            '" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m-7 7 7-7 7 7"/></svg>',
        "sun" =>
            '<svg width="' .
            $size .
            '" height="' .
            $size .
            '" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="2"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
        "moon" =>
            '<svg width="' .
            $size .
            '" height="' .
            $size .
            '" viewBox="0 0 24 24" fill="none"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    ];

    return $icons[$name] ?? "";
}

/**
 * Include fb_post in taxonomy archive queries.
 *
 * WordPress defaults taxonomy archives to the "post" type even when the
 * taxonomy is registered against a custom post type.
 */
function avs_taxonomy_query_fb_posts($query): void
{
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->is_tax("post_category_type")) {
        $query->set("post_type", "fb_post");
        $query->set("posts_per_page", 12);
    }

    if ($query->is_post_type_archive("fb_post")) {
        $query->set("posts_per_page", 12);
    }
}
add_action("pre_get_posts", "avs_taxonomy_query_fb_posts");

/**
 * Explicitly declare thumbnail support for fb_post CPT
 */
function avs_post_type_supports(): void {
    add_post_type_support('fb_post', 'thumbnail');
}
add_action('init', 'avs_post_type_supports');

/**
 * Scope search results to fb_post only.
 */
function avs_search_query_fb_posts($query): void
{
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->is_search()) {
        $query->set("post_type", "fb_post");
        $query->set("posts_per_page", 9);
    }
}
add_action("pre_get_posts", "avs_search_query_fb_posts");

/**
 * Body Classes
 */
function avs_body_classes($classes): array
{
    if (is_front_page()) {
        $classes[] = "is-front-page";
    }
    return $classes;
}
add_filter("body_class", "avs_body_classes");

/**
 * Empty State SVG Illustrations
 *
 * Returns context-specific inline SVGs using currentColor for theming.
 */
function avs_empty_state_svg(string $type = 'no-posts'): string
{
    switch ($type) {
        case 'no-posts':
            // Empty inbox/folder with scanner motif
            return '<svg class="empty-state-illustration" width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="25" y="35" width="70" height="55" rx="6" stroke="currentColor" stroke-width="2" opacity="0.3"/>
                <path d="M25 50h70" stroke="currentColor" stroke-width="2" opacity="0.2"/>
                <rect x="35" y="58" width="30" height="3" rx="1.5" fill="currentColor" opacity="0.15"/>
                <rect x="35" y="66" width="50" height="3" rx="1.5" fill="currentColor" opacity="0.1"/>
                <rect x="35" y="74" width="40" height="3" rx="1.5" fill="currentColor" opacity="0.1"/>
                <circle cx="60" cy="28" r="12" stroke="currentColor" stroke-width="2" opacity="0.25"/>
                <path d="M55 28l3 3 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" opacity="0.3"/>
                <path d="M85 20l5-5M85 25h7M90 15v7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.15"/>
            </svg>';

        case 'no-results':
            // Magnifying glass with question mark
            return '<svg class="empty-state-illustration" width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="52" cy="52" r="28" stroke="currentColor" stroke-width="2.5" opacity="0.3"/>
                <path d="M73 73l20 20" stroke="currentColor" stroke-width="3" stroke-linecap="round" opacity="0.3"/>
                <path d="M46 42a8 8 0 0116 2c0 4-6 5-6 9" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" opacity="0.25"/>
                <circle cx="56" cy="62" r="1.5" fill="currentColor" opacity="0.25"/>
                <path d="M20 30l-4-4M22 26h-6M18 20v6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.12"/>
                <path d="M95 40l3-3M97 40h-5M95 35v5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.12"/>
            </svg>';

        case 'not-found':
            // Broken signal / radar dish
            return '<svg class="empty-state-illustration" width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="60" cy="65" r="30" stroke="currentColor" stroke-width="2" opacity="0.15"/>
                <circle cx="60" cy="65" r="20" stroke="currentColor" stroke-width="2" opacity="0.2"/>
                <circle cx="60" cy="65" r="10" stroke="currentColor" stroke-width="2" opacity="0.25"/>
                <circle cx="60" cy="65" r="3" fill="currentColor" opacity="0.3"/>
                <path d="M60 65l18-25" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" opacity="0.3"/>
                <path d="M72 35l8 3M75 43l5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.2"/>
                <path d="M38 30l-2-6M32 28l8-2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.12"/>
                <path d="M88 55l4-2M90 58l2-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" opacity="0.12"/>
                <path d="M40 100h40" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.2"/>
                <path d="M50 100l10-5 10 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" opacity="0.2"/>
            </svg>';

        default:
            return '';
    }
}
