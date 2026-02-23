<?php
/**
 * Clean Vite WP - Theme Setup
 *
 * Core theme configuration, menus, and theme supports.
 *
 * @package Clean_Vite_WP
 */

defined("ABSPATH") || exit();

define("CVW_VERSION", "1.0.0");
define("CVW_DIR", get_template_directory());
define("CVW_URI", get_template_directory_uri());

/**
 * Register theme supports and navigation menus
 */
function cvw_setup(): void
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

    register_nav_menus([
        "primary" => __("Primary Menu", "clean-vite-wp"),
        "footer" => __("Footer Menu", "clean-vite-wp"),
    ]);
}
add_action("after_setup_theme", "cvw_setup");

/**
 * Enqueue base styles and scripts
 */
function cvw_enqueue_assets(): void
{
    wp_enqueue_style("cvw-style", get_stylesheet_uri(), [], CVW_VERSION);

    // Check if Vite handles assets
    if (function_exists("cvw_detect_vite_server")) {
        $vite = cvw_detect_vite_server();
        $has_manifest = file_exists(get_theme_file_path("dist/manifest.json"));

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
add_action("wp_enqueue_scripts", "cvw_enqueue_assets");

/**
 * Custom excerpt length
 */
function cvw_excerpt_length(int $length): int
{
    return 20;
}
add_filter("excerpt_length", "cvw_excerpt_length", 999);

/**
 * SVG Icons Library
 */
function cvw_icon($name, $size = 20): string
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
    ];

    return $icons[$name] ?? "";
}

/**
 * Include fb_post in taxonomy archive queries.
 *
 * WordPress defaults taxonomy archives to the "post" type even when the
 * taxonomy is registered against a custom post type.
 */
function cvw_taxonomy_query_fb_posts($query): void
{
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->is_tax("post_category_type")) {
        $query->set("post_type", "fb_post");
        $query->set("posts_per_page", 9);
    }

    if ($query->is_post_type_archive("fb_post")) {
        $query->set("posts_per_page", 9);
    }
}
add_action("pre_get_posts", "cvw_taxonomy_query_fb_posts");

/**
 * Scope search results to fb_post only.
 */
function cvw_search_query_fb_posts($query): void
{
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->is_search()) {
        $query->set("post_type", "fb_post");
        $query->set("posts_per_page", 9);
    }
}
add_action("pre_get_posts", "cvw_search_query_fb_posts");

/**
 * Body Classes
 */
function cvw_body_classes($classes): array
{
    if (is_front_page()) {
        $classes[] = "is-front-page";
    }
    return $classes;
}
add_filter("body_class", "cvw_body_classes");
