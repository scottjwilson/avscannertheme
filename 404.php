<?php
/**
 * 404 Error Page
 *
 * @package AVScannerTheme
 */

get_header(); ?>

<section class="error-404 section">
    <div class="container">
        <div class="empty-state">
            <?php echo avs_empty_state_svg('not-found'); ?>
            <p class="error-404-code">404</p>
            <h1 class="text-display"><?php esc_html_e('Page Not Found', 'avscannertheme'); ?></h1>
            <p><?php esc_html_e("The page you're looking for doesn't exist or has been moved.", 'avscannertheme'); ?></p>
            <div class="empty-state-actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary btn-lg">
                    <?php esc_html_e('Back to Home', 'avscannertheme'); ?> <?php echo avs_icon('arrow-right'); ?>
                </a>
            </div>

            <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>" style="margin-top: var(--space-6); max-width: 480px; margin-left: auto; margin-right: auto;">
                <label class="sr-only" for="error-search-input"><?php esc_html_e('Search for:', 'avscannertheme'); ?></label>
                <div class="header-search-wrap">
                    <input type="search" id="error-search-input" class="search-input" name="s" placeholder="<?php esc_attr_e('Search posts…', 'avscannertheme'); ?>" />
                    <input type="hidden" name="post_type" value="fb_post" />
                    <button type="submit" class="btn btn-primary"><?php echo avs_icon('search', 18); ?></button>
                </div>
            </form>
        </div>

        <?php
        $browse_cats = get_terms([
            'taxonomy'   => 'post_category_type',
            'hide_empty' => true,
            'exclude'    => avscanner_get_ad_term_id(),
        ]);
        if ($browse_cats && ! is_wp_error($browse_cats)) : ?>
            <div class="empty-state-section">
                <h3 class="text-label"><?php esc_html_e('Browse by Category', 'avscannertheme'); ?></h3>
                <div class="card-badges" style="justify-content: center; flex-wrap: wrap; gap: var(--space-2);">
                    <?php foreach ($browse_cats as $cat) : ?>
                        <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="badge badge-<?php echo esc_attr($cat->slug); ?>">
                            <?php echo esc_html($cat->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php
        $recent_posts = new WP_Query([
            'post_type'      => 'fb_post',
            'posts_per_page' => 3,
            'no_found_rows'  => true,
        ]);
        if ($recent_posts->have_posts()) : ?>
            <div class="empty-state-section">
                <h3 class="text-label"><?php esc_html_e('Latest Posts', 'avscannertheme'); ?></h3>
                <div class="grid grid-3 stagger-children reveal">
                    <?php while ($recent_posts->have_posts()) : $recent_posts->the_post();
                        get_template_part('template-parts/card-fb-post');
                    endwhile; ?>
                </div>
            </div>
        <?php endif;
        wp_reset_postdata();
        ?>
    </div>
</section>

<?php get_footer(); ?>
