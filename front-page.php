<?php
/**
 * Front Page Template — displays all scanner posts.
 *
 * @package AVScannerTheme
 */

get_header();

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$posts_query = new WP_Query([
    'post_type'      => 'fb_post',
    'post_status'    => 'publish',
    'posts_per_page' => 15,
    'paged'          => $paged,
]);
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="text-label"><?php esc_html_e("Scanner Posts", "avscannertheme"); ?></span>
            <h1 class="text-display"><?php bloginfo('name'); ?></h1>
        </div>

        <?php if ($posts_query->have_posts()): ?>
            <div class="grid grid-3 stagger-children reveal"
                 data-infinite-scroll
                 data-per-page="15"
                 data-total-pages="<?php echo (int) $posts_query->max_num_pages; ?>"
                 data-current-page="1">
                <?php
                $post_index = 0;
                while ($posts_query->have_posts()):
                    $posts_query->the_post();
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
                <p class="infinite-scroll-status" aria-live="polite" hidden></p>
            </div>

            <noscript>
                <?php
                $total_pages = $posts_query->max_num_pages;
                if ($total_pages > 1):
                    echo '<nav class="pagination">';
                    echo paginate_links([
                        'total'     => $total_pages,
                        'current'   => $paged,
                        'mid_size'  => 2,
                        'prev_text' => '&laquo;',
                        'next_text' => '&raquo;',
                    ]);
                    echo '</nav>';
                endif;
                ?>
            </noscript>

            <?php wp_reset_postdata(); ?>

        <?php else: ?>
            <div class="empty-state">
                <?php echo avs_empty_state_svg('no-posts'); ?>
                <h2 class="text-display"><?php esc_html_e("No Posts Found", "avscannertheme"); ?></h2>
                <p><?php esc_html_e("There are no scanner posts to display yet.", "avscannertheme"); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
