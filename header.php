<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="dark light">
    <script>
        (function(){var t=localStorage.getItem('cvw-theme');if(t==='light'||t==='dark'){document.documentElement.dataset.theme=t;document.querySelector('meta[name="color-scheme"]').content=t;}})();
    </script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="top-accent-bar"></div>

<header class="site-header">
    <div class="container">
        <div class="header-inner">
            <!-- Logo -->
            <?php if (has_custom_logo()):
                $logo_id  = get_theme_mod('custom_logo');
                $logo_url = wp_get_attachment_image_url($logo_id, 'full');
            ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                    <img src="<?php echo esc_url($logo_url); ?>"
                         alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                         class="site-logo-img">
                </a>
            <?php elseif (file_exists(get_template_directory() . '/images/logo.png')): ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/images/logo.png'); ?>"
                         alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                         class="site-logo-img">
                </a>
            <?php else: ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                    <span class="site-logo-text"><?php bloginfo('name'); ?></span>
                </a>
            <?php endif; ?>

            <!-- Header Search (full width) -->
            <form role="search" method="get" class="header-search" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" class="search-input" name="s"
                       placeholder="<?php esc_attr_e('Search posts...', 'clean-vite-wp'); ?>"
                       value="<?php echo get_search_query(); ?>" autocomplete="off">
                <input type="hidden" name="post_type" value="fb_post">
                <button type="submit" class="search-submit" aria-label="<?php esc_attr_e('Search', 'clean-vite-wp'); ?>">
                    <?php echo cvw_icon('search', 18); ?>
                </button>
            </form>

            <!-- Theme Toggle -->
            <button class="theme-toggle" aria-label="<?php esc_attr_e('Toggle theme', 'clean-vite-wp'); ?>">
                <span class="icon-sun"><?php echo cvw_icon('sun', 20); ?></span>
                <span class="icon-moon"><?php echo cvw_icon('moon', 20); ?></span>
            </button>

            <!-- Mobile Menu Toggle -->
            <button class="menu-toggle" aria-expanded="false" aria-label="<?php esc_attr_e(
                "Toggle menu",
                "clean-vite-wp",
            ); ?>">
                <span class="icon-menu"><?php echo cvw_icon(
                    "menu",
                    24,
                ); ?></span>
                <span class="icon-close"><?php echo cvw_icon(
                    "close",
                    24,
                ); ?></span>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <?php
    $nav_categories = get_terms([
        'taxonomy'   => 'post_category_type',
        'hide_empty' => true,
        'exclude'    => avscanner_get_ad_term_id(),
    ]);
    ?>
    <nav class="nav-mobile" aria-hidden="true">
        <?php wp_nav_menu([
            "theme_location" => "primary",
            "container" => false,
            "menu_class" => "nav-mobile-menu",
            "fallback_cb" => false,
            "depth" => 1,
            "link_class" => "nav-link",
        ]); ?>

        <?php if (!is_wp_error($nav_categories) && !empty($nav_categories)): ?>
            <div class="nav-mobile-categories">
                <span class="nav-mobile-label"><?php esc_html_e('Categories', 'clean-vite-wp'); ?></span>
                <?php foreach ($nav_categories as $cat): ?>
                    <a href="<?php echo esc_url(get_term_link($cat)); ?>"
                       class="badge badge-<?php echo esc_attr($cat->slug); ?>">
                        <?php echo esc_html($cat->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </nav>
</header>

<?php if (!is_wp_error($nav_categories) && !empty($nav_categories)):
    $all_url    = home_url('/');
    $all_active = is_front_page() || (is_post_type_archive('fb_post') && !is_tax());
?>
<nav class="category-nav" aria-label="<?php esc_attr_e('Categories', 'clean-vite-wp'); ?>">
    <div class="container">
        <div class="category-nav-scroll">
            <a href="<?php echo esc_url($all_url); ?>"
               class="cat-link <?php echo $all_active ? 'is-active' : ''; ?>">
                <?php esc_html_e('All', 'clean-vite-wp'); ?>
            </a>
            <?php foreach ($nav_categories as $cat):
                $is_active = is_tax('post_category_type', $cat->slug);
            ?>
                <a href="<?php echo esc_url(get_term_link($cat)); ?>"
                   class="cat-link cat-<?php echo esc_attr($cat->slug); ?> <?php echo $is_active ? 'is-active' : ''; ?>">
                    <?php echo esc_html($cat->name); ?>
                    <span class="cat-count"><?php echo esc_html($cat->count); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</nav>
<?php endif; ?>

<main class="main-content">
