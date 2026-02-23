<?php
/**
 * Theme SEO: Meta tags, Open Graph, Twitter Cards, and Structured Data.
 *
 * Outputs automatic SEO defaults via wp_head hooks.
 * Defers to Yoast, RankMath, or All in One SEO if active.
 *
 * @package Clean_Vite_WP
 */

/**
 * Check if a known SEO plugin is active.
 */
function cvw_seo_plugin_active(): bool {
    return defined('WPSEO_VERSION')       // Yoast
        || defined('RANK_MATH_VERSION')   // RankMath
        || defined('AIOSEO_VERSION');     // All in One SEO
}

/**
 * Output meta description tag.
 */
function cvw_meta_description(): void {
    if (cvw_seo_plugin_active()) return;

    $desc = '';
    if (is_singular('fb_post')) {
        $desc = wp_trim_words(get_the_excerpt(), 25, '…');
        if (!$desc) {
            $desc = wp_trim_words(wp_strip_all_tags(get_the_content()), 25, '…');
        }
    } elseif (is_tax('post_category_type')) {
        $term = get_queried_object();
        $desc = $term->description ?: sprintf('Browse %s posts on %s', $term->name, get_bloginfo('name'));
    } elseif (is_front_page()) {
        $desc = get_bloginfo('description');
    } elseif (is_search()) {
        $desc = sprintf('Search results for "%s" on %s', get_search_query(), get_bloginfo('name'));
    } elseif (is_post_type_archive('fb_post')) {
        $desc = sprintf('Latest scanner posts on %s', get_bloginfo('name'));
    }

    if ($desc) {
        printf('<meta name="description" content="%s">' . "\n", esc_attr($desc));
    }
}
add_action('wp_head', 'cvw_meta_description', 1);

/**
 * Output canonical URL for non-singular pages.
 *
 * WordPress handles singular canonical via rel_canonical().
 */
function cvw_canonical_url(): void {
    if (cvw_seo_plugin_active()) return;
    if (is_singular()) return;

    $url = '';
    if (is_front_page()) {
        $url = home_url('/');
    } elseif (is_tax('post_category_type')) {
        $url = get_term_link(get_queried_object());
    } elseif (is_post_type_archive('fb_post')) {
        $url = get_post_type_archive_link('fb_post');
    } elseif (is_search()) {
        $url = home_url('/?s=' . urlencode(get_search_query()));
    }

    if ($url && !is_wp_error($url)) {
        printf('<link rel="canonical" href="%s">' . "\n", esc_url($url));
    }
}
add_action('wp_head', 'cvw_canonical_url', 1);

/**
 * Output Open Graph meta tags.
 */
function cvw_open_graph(): void {
    if (cvw_seo_plugin_active()) return;

    $og = [
        'og:site_name' => get_bloginfo('name'),
        'og:locale'    => get_locale(),
    ];

    if (is_singular('fb_post')) {
        $og['og:type']        = 'article';
        $og['og:title']       = get_the_title();
        $og['og:description'] = wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags(get_the_content()), 25, '…');
        $og['og:url']         = get_permalink();
        $img = get_the_post_thumbnail_url(null, 'large');
        if (!$img) $img = get_post_meta(get_the_ID(), '_fb_full_picture', true);
        if ($img) $og['og:image'] = $img;
    } elseif (is_front_page()) {
        $og['og:type']        = 'website';
        $og['og:title']       = get_bloginfo('name');
        $og['og:description'] = get_bloginfo('description');
        $og['og:url']         = home_url('/');
        $logo_id = get_theme_mod('custom_logo');
        if ($logo_id) $og['og:image'] = wp_get_attachment_image_url($logo_id, 'full');
    } elseif (is_tax('post_category_type')) {
        $term = get_queried_object();
        $og['og:type']        = 'website';
        $og['og:title']       = $term->name . ' — ' . get_bloginfo('name');
        $og['og:description'] = $term->description ?: sprintf('Browse %s posts', $term->name);
        $og['og:url']         = get_term_link($term);
    }

    foreach ($og as $prop => $content) {
        if ($content && !is_wp_error($content)) {
            printf('<meta property="%s" content="%s">' . "\n", esc_attr($prop), esc_attr($content));
        }
    }
}
add_action('wp_head', 'cvw_open_graph', 2);

/**
 * Output Twitter Card meta tags.
 */
function cvw_twitter_card(): void {
    if (cvw_seo_plugin_active()) return;

    $card = ['twitter:card' => 'summary_large_image'];

    if (is_singular('fb_post')) {
        $card['twitter:title']       = get_the_title();
        $card['twitter:description'] = wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags(get_the_content()), 25, '…');
        $img = get_the_post_thumbnail_url(null, 'large');
        if (!$img) $img = get_post_meta(get_the_ID(), '_fb_full_picture', true);
        if ($img) $card['twitter:image'] = $img;
    } elseif (is_front_page()) {
        $card['twitter:title']       = get_bloginfo('name');
        $card['twitter:description'] = get_bloginfo('description');
        $logo_id = get_theme_mod('custom_logo');
        if ($logo_id) $card['twitter:image'] = wp_get_attachment_image_url($logo_id, 'full');
    }

    foreach ($card as $name => $content) {
        if ($content) {
            printf('<meta name="%s" content="%s">' . "\n", esc_attr($name), esc_attr($content));
        }
    }
}
add_action('wp_head', 'cvw_twitter_card', 2);

/**
 * Output JSON-LD structured data.
 */
function cvw_json_ld(): void {
    if (cvw_seo_plugin_active()) return;

    $schemas = [];

    if (is_front_page()) {
        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            'name'     => get_bloginfo('name'),
            'url'      => home_url('/'),
            'potentialAction' => [
                '@type'       => 'SearchAction',
                'target'      => home_url('/?s={search_term_string}&post_type=fb_post'),
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    if (is_singular('fb_post')) {
        $img = get_the_post_thumbnail_url(null, 'large');
        if (!$img) $img = get_post_meta(get_the_ID(), '_fb_full_picture', true);

        $article = [
            '@context'         => 'https://schema.org',
            '@type'            => 'NewsArticle',
            'headline'         => get_the_title(),
            'datePublished'    => get_the_date('c'),
            'dateModified'     => get_the_modified_date('c'),
            'mainEntityOfPage' => get_permalink(),
            'author'           => ['@type' => 'Organization', 'name' => get_bloginfo('name')],
            'publisher'        => ['@type' => 'Organization', 'name' => get_bloginfo('name')],
        ];
        if ($img) $article['image'] = $img;

        $logo_id = get_theme_mod('custom_logo');
        if ($logo_id) {
            $article['publisher']['logo'] = [
                '@type' => 'ImageObject',
                'url'   => wp_get_attachment_image_url($logo_id, 'full'),
            ];
        }

        $schemas[] = $article;

        // BreadcrumbList
        $crumbs = [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => home_url('/')],
        ];
        $terms = get_the_terms(get_the_ID(), 'post_category_type');
        if ($terms && !is_wp_error($terms)) {
            $term = $terms[0];
            $crumbs[] = ['@type' => 'ListItem', 'position' => 2, 'name' => $term->name, 'item' => get_term_link($term)];
            $crumbs[] = ['@type' => 'ListItem', 'position' => 3, 'name' => get_the_title()];
        } else {
            $crumbs[] = ['@type' => 'ListItem', 'position' => 2, 'name' => get_the_title()];
        }
        $schemas[] = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $crumbs,
        ];
    }

    foreach ($schemas as $schema) {
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
add_action('wp_head', 'cvw_json_ld', 5);
