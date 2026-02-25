<?php
/**
 * Search Results Template
 *
 * @package AVScannerTheme
 */

get_header(); ?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="text-label"><?php esc_html_e("Search Results", "avscannertheme"); ?></span>
            <h1 class="text-display">
                <?php printf(
                    /* translators: %s: search query */
                    esc_html__('Results for "%s"', "avscannertheme"),
                    get_search_query(),
                ); ?>
            </h1>
            <?php if (have_posts()): ?>
                <p class="text-muted">
                    <?php printf(
                        /* translators: %s: number of results */
                        esc_html(_n('%s post found', '%s posts found', (int) $wp_query->found_posts, 'avscannertheme')),
                        number_format_i18n($wp_query->found_posts),
                    ); ?>
                </p>
            <?php endif; ?>
        </div>

        <?php if (have_posts()): ?>
            <div class="grid grid-3 stagger-children reveal">
                <?php while (have_posts()):
                    the_post();
                    get_template_part('template-parts/card-fb-post', null, [
                        'show_time' => true,
                    ]);
                endwhile; ?>
            </div>

            <?php the_posts_pagination([
                "mid_size" => 2,
                "prev_text" => "&laquo;",
                "next_text" => "&raquo;",
            ]); ?>

        <?php else: ?>
            <div class="empty-state">
                <?php echo avs_empty_state_svg('no-results'); ?>
                <h2 class="text-display"><?php esc_html_e("No Results Found", "avscannertheme"); ?></h2>
                <p><?php esc_html_e("No scanner posts matched your search. Try a different term.", "avscannertheme"); ?></p>
                <a href="<?php echo esc_url(home_url("/")); ?>" class="btn btn-primary">
                    <?php esc_html_e("Back to Home", "avscannertheme"); ?>
                </a>
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
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
