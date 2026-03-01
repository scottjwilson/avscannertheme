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

// Stats for hero
$total_posts = wp_count_posts('fb_post');
$incident_count = (int) ($total_posts->publish ?? 0);

$latest_post = get_posts([
    'post_type'      => 'fb_post',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'fields'         => 'ids',
]);
$last_updated = $latest_post ? human_time_diff(get_post_time('U', false, $latest_post[0])) . ' ago' : '';

$nav_categories = get_terms([
    'taxonomy'   => 'post_category_type',
    'hide_empty' => true,
    'exclude'    => avscanner_get_ad_term_id(),
]);
$category_count = !is_wp_error($nav_categories) ? count($nav_categories) : 0;
?>

<section class="front-hero">
    <canvas class="front-hero-canvas" id="hero-scanner"></canvas>
    <div class="container">
        <div class="front-hero-inner">
            <div class="front-hero-text">
                <h1 class="front-hero-title"><?php bloginfo('name'); ?></h1>
                <p class="front-hero-tagline"><?php bloginfo('description'); ?></p>
            </div>
            <div class="front-hero-stats">
                <div class="front-hero-stat">
                    <span class="front-hero-stat-value"><?php echo number_format($incident_count); ?></span>
                    <span class="front-hero-stat-label">Incidents Tracked</span>
                </div>
                <div class="front-hero-stat">
                    <span class="front-hero-stat-value"><?php echo (int) $category_count; ?></span>
                    <span class="front-hero-stat-label">Categories</span>
                </div>
                <?php if ($last_updated): ?>
                    <div class="front-hero-stat">
                        <span class="front-hero-stat-value"><?php echo esc_html($last_updated); ?></span>
                        <span class="front-hero-stat-label">Last Updated</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">

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
