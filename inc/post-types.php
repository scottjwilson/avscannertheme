<?php
/**
 * Custom Post Types
 *
 * Register custom post types for the theme.
 *
 * Example:
 *
 * function cvw_register_post_types(): void {
 *     register_post_type('example', [
 *         'labels' => [
 *             'name' => __('Examples', 'clean-vite-wp'),
 *             'singular_name' => __('Example', 'clean-vite-wp'),
 *         ],
 *         'public' => true,
 *         'has_archive' => true,
 *         'rewrite' => ['slug' => 'examples'],
 *         'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
 *         'show_in_rest' => true,
 *     ]);
 * }
 * add_action('init', 'cvw_register_post_types');
 */
