<?php
/**
 * Search Results Template
 *
 * @package Clean_Vite_WP
 */

get_header(); ?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="text-label"><?php esc_html_e("Search Results", "clean-vite-wp"); ?></span>
            <h1 class="text-display">
                <?php printf(
                    /* translators: %s: search query */
                    esc_html__('Results for "%s"', "clean-vite-wp"),
                    get_search_query(),
                ); ?>
            </h1>
            <?php if (have_posts()): ?>
                <p class="text-muted">
                    <?php printf(
                        /* translators: %s: number of results */
                        esc_html(_n('%s post found', '%s posts found', (int) $wp_query->found_posts, 'clean-vite-wp')),
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
                <h2 class="text-display"><?php esc_html_e("No Results Found", "clean-vite-wp"); ?></h2>
                <p><?php esc_html_e("No scanner posts matched your search. Try a different term.", "clean-vite-wp"); ?></p>
                <a href="<?php echo esc_url(home_url("/")); ?>" class="btn btn-primary">
                    <?php esc_html_e("Back to Home", "clean-vite-wp"); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
