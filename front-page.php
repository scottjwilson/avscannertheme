<?php
/**
 * Front Page Template — displays all scanner posts.
 *
 * @package Clean_Vite_WP
 */

get_header();

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$posts_query = new WP_Query([
    'post_type'      => 'fb_post',
    'post_status'    => 'publish',
    'posts_per_page' => 12,
    'paged'          => $paged,
]);
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="text-label"><?php esc_html_e("Scanner Posts", "clean-vite-wp"); ?></span>
            <h1 class="text-display"><?php bloginfo('name'); ?></h1>
        </div>

        <?php if ($posts_query->have_posts()): ?>
            <div class="grid grid-3 stagger-children reveal">
                <?php
                while ($posts_query->have_posts()):
                    $posts_query->the_post();
                    get_template_part('template-parts/card-fb-post', null, [
                        'show_time' => true,
                    ]);
                endwhile;
                ?>
            </div>

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

            <?php wp_reset_postdata(); ?>

        <?php else: ?>
            <div class="empty-state">
                <?php echo cvw_empty_state_svg('no-posts'); ?>
                <h2 class="text-display"><?php esc_html_e("No Posts Found", "clean-vite-wp"); ?></h2>
                <p><?php esc_html_e("There are no scanner posts to display yet.", "clean-vite-wp"); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
