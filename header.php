<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container">
        <div class="header-inner">
            <!-- Logo -->
            <a href="<?php echo esc_url(home_url("/")); ?>" class="site-logo">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <span class="logo-mark"><?php echo esc_html(
                        mb_substr(get_bloginfo("name"), 0, 1),
                    ); ?></span>
                    <span><?php bloginfo("name"); ?></span>
                <?php endif; ?>
            </a>

            <!-- Desktop Navigation -->
            <nav class="nav-desktop">
                <?php wp_nav_menu([
                    "theme_location" => "primary",
                    "container" => false,
                    "menu_class" => "nav-menu",
                    "fallback_cb" => false,
                    "depth" => 1,
                    "link_class" => "nav-link",
                ]); ?>
            </nav>

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
    <nav class="nav-mobile" aria-hidden="true">
        <?php wp_nav_menu([
            "theme_location" => "primary",
            "container" => false,
            "menu_class" => "nav-mobile-menu",
            "fallback_cb" => false,
            "depth" => 1,
            "link_class" => "nav-link",
        ]); ?>
    </nav>
</header>

<main class="main-content">
