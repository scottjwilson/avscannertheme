<?php
/**
 * 404 Error Page
 *
 * @package Clean_Vite_WP
 */

get_header(); ?>

<section class="error-404 section">
    <div class="container">
        <div class="empty-state">
            <?php echo cvw_empty_state_svg('not-found'); ?>
            <p class="error-404-code">404</p>
            <h1 class="text-display"><?php esc_html_e('Page Not Found', 'clean-vite-wp'); ?></h1>
            <p><?php esc_html_e("The page you're looking for doesn't exist or has been moved.", 'clean-vite-wp'); ?></p>
            <div class="empty-state-actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary btn-lg">
                    <?php esc_html_e('Back to Home', 'clean-vite-wp'); ?> <?php echo cvw_icon('arrow-right'); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
