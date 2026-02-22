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

        <?php
        // Category filter bar — same as archive-fb_post.php
        $categories = get_terms([
            "taxonomy" => "post_category_type",
            "hide_empty" => true,
        ]);

        if (!is_wp_error($categories) && !empty($categories)): ?>
            <div class="filter-bar">
                <a href="<?php echo esc_url(get_post_type_archive_link("fb_post")); ?>"
                   class="btn btn-sm btn-outline">
                    <?php esc_html_e("All", "clean-vite-wp"); ?>
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="<?php echo esc_url(get_term_link($cat)); ?>"
                       class="btn btn-sm <?php echo ($cat->slug === $term->slug) ? "btn-primary" : "btn-outline"; ?>">
                        <?php echo esc_html($cat->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (have_posts()): ?>
            <div class="grid grid-3 stagger-children reveal">
                <?php while (have_posts()):
                    the_post();
                    $fb_image = get_post_meta(get_the_ID(), "_fb_full_picture", true);
                    $post_cats = get_the_terms(get_the_ID(), "post_category_type");
                ?>
                    <article class="card card-hover">
                        <?php if ($fb_image): ?>
                            <div class="card-image">
                                <img src="<?php echo esc_url($fb_image); ?>"
                                     alt="<?php the_title_attribute(); ?>"
                                     loading="lazy">
                            </div>
                        <?php endif; ?>

                        <span class="card-date">
                            <?php echo get_the_date("M j, Y"); ?> at <?php echo get_the_time("g:i A"); ?>
                        </span>

                        <?php if ($post_cats && !is_wp_error($post_cats)): ?>
                            <div class="card-badges">
                                <?php foreach ($post_cats as $cat): ?>
                                    <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="badge badge-<?php echo esc_attr($cat->slug); ?>">
                                        <?php echo esc_html($cat->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <h3 class="card-title">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>

                        <p class="card-text"><?php echo wp_trim_words(
                            get_the_excerpt(),
                            15,
                        ); ?></p>

                        <a href="<?php the_permalink(); ?>" class="card-link">
                            <?php esc_html_e("Read more", "clean-vite-wp"); ?> <?php echo cvw_icon("arrow-right", 16); ?>
                        </a>
                    </article>
                <?php endwhile; ?>
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
