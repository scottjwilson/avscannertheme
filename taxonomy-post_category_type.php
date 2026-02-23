<?php
/**
 * Taxonomy Archive: News Categories (post_category_type)
 *
 * Shows a category-specific header then reuses the shared card grid
 * from archive-fb_post.php.
 *
 * @package Clean_Vite_WP
 */

get_header();

$term = get_queried_object();
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="text-label"><?php esc_html_e("News Category", "clean-vite-wp"); ?></span>
            <h1 class="text-display"><?php echo esc_html($term->name); ?></h1>
            <?php if ($term->description): ?>
                <p class="section-description"><?php echo esc_html($term->description); ?></p>
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
                <h2 class="text-display"><?php esc_html_e("No Posts Found", "clean-vite-wp"); ?></h2>
                <p><?php printf(
                    esc_html__('No posts found in the "%s" category yet.', 'clean-vite-wp'),
                    esc_html($term->name)
                ); ?></p>
                <a href="<?php echo esc_url(get_post_type_archive_link("fb_post")); ?>" class="btn btn-primary">
                    <?php esc_html_e("View All Posts", "clean-vite-wp"); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
