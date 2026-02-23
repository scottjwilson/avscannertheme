<?php
/**
 * Archive Template: Scanner Posts (fb_post)
 *
 * @package Clean_Vite_WP
 */

get_header(); ?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="text-label"><?php esc_html_e("Scanner Posts", "clean-vite-wp"); ?></span>
            <h1 class="text-display"><?php post_type_archive_title(); ?></h1>
        </div>

        <?php if (have_posts()): ?>
            <div class="grid grid-3 stagger-children reveal">
                <?php
                $post_index = 0;
                while (have_posts()):
                    the_post();
                    get_template_part('template-parts/card-fb-post', null, [
                        'show_time' => true,
                        'is_hero'   => $post_index === 0,
                    ]);
                    $post_index++;
                endwhile;
                ?>
            </div>

            <?php the_posts_pagination([
                "mid_size" => 2,
                "prev_text" => "&laquo;",
                "next_text" => "&raquo;",
            ]); ?>

        <?php else: ?>
            <div class="empty-state">
                <?php echo cvw_empty_state_svg('no-posts'); ?>
                <h2 class="text-display"><?php esc_html_e("No Posts Found", "clean-vite-wp"); ?></h2>
                <p><?php esc_html_e("There are no scanner posts to display yet.", "clean-vite-wp"); ?></p>
                <a href="<?php echo esc_url(home_url("/")); ?>" class="btn btn-primary">
                    <?php esc_html_e("Back to Home", "clean-vite-wp"); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
