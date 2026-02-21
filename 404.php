<?php
/**
 * 404 Error Page
 *
 * @package Clean_Vite_WP
 */

get_header(); ?>

<section class="hero" style="min-height: 70vh; display: flex; align-items: center;">
    <div class="container">
        <div class="hero-content">
            <p style="font-family: var(--font-display); font-size: 8rem; font-weight: 700; color: var(--color-neutral-200); line-height: 1; margin-bottom: 1rem;">404</p>
            <h1 class="text-display"><?php esc_html_e(
                "Page Not Found",
                "clean-vite-wp",
            ); ?></h1>
            <p class="hero-subtitle"><?php esc_html_e(
                "The page you're looking for doesn't exist or has been moved.",
                "clean-vite-wp",
            ); ?></p>
            <div class="hero-actions">
                <a href="<?php echo esc_url(
                    home_url("/"),
                ); ?>" class="btn btn-primary btn-lg">
                    <?php esc_html_e(
                        "Back to Home",
                        "clean-vite-wp",
                    ); ?> <?php echo cvw_icon("arrow-right"); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
