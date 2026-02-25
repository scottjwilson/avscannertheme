<?php
/**
 * Taxonomy Archive: News Categories (post_category_type)
 *
 * Shows a category-specific header then reuses the shared card grid
 * from archive-fb_post.php.
 *
 * @package AVScannerTheme
 */

get_header();

$term = get_queried_object();
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="text-label"><?php esc_html_e("News Category", "avscannertheme"); ?></span>
            <h1 class="text-display"><?php echo esc_html($term->name); ?></h1>
            <?php if ($term->description): ?>
                <p class="section-description"><?php echo esc_html($term->description); ?></p>
            <?php endif; ?>
        </div>

        <?php if (have_posts()): ?>
            <div class="grid grid-3 stagger-children reveal"
                 data-infinite-scroll
                 data-per-page="12"
                 data-total-pages="<?php echo (int) $wp_query->max_num_pages; ?>"
                 data-current-page="1"
                 data-category="<?php echo esc_attr($term->slug); ?>">
                <?php
                $post_index = 0;
                while (have_posts()):
                    the_post();
                    get_template_part('template-parts/card-fb-post', null, [
                        'show_time' => true,
                        'is_first'  => $post_index === 0,
                    ]);
                    $post_index++;
                endwhile;
                ?>
            </div>

            <div class="infinite-scroll-controls">
                <div class="infinite-scroll-sentinel" aria-hidden="true"></div>
                <button class="btn btn-outline infinite-scroll-load-more" hidden>
                    Load More
                </button>
                <p class="infinite-scroll-status" hidden></p>
            </div>

            <noscript>
                <?php the_posts_pagination([
                    "mid_size" => 2,
                    "prev_text" => "&laquo;",
                    "next_text" => "&raquo;",
                ]); ?>
            </noscript>

        <?php else: ?>
            <div class="empty-state">
                <?php echo avs_empty_state_svg('no-posts'); ?>
                <h2 class="text-display"><?php esc_html_e("No Posts Found", "avscannertheme"); ?></h2>
                <p><?php printf(
                    esc_html__('No posts found in the "%s" category yet.', 'avscannertheme'),
                    esc_html($term->name)
                ); ?></p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                    <?php esc_html_e("View All Posts", "avscannertheme"); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
