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

$categories = get_terms([
    'taxonomy'   => 'post_category_type',
    'hide_empty' => true,
]);
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="text-label"><?php esc_html_e("Scanner Posts", "clean-vite-wp"); ?></span>
            <h1 class="text-display"><?php bloginfo('name'); ?></h1>
        </div>

        <?php if (!is_wp_error($categories) && !empty($categories)): ?>
            <div class="filter-bar">
                <a href="<?php echo esc_url(home_url('/')); ?>"
                   class="btn btn-sm btn-primary">
                    <?php esc_html_e("All", "clean-vite-wp"); ?>
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="<?php echo esc_url(get_term_link($cat)); ?>"
                       class="btn btn-sm btn-outline">
                        <?php echo esc_html($cat->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($posts_query->have_posts()): ?>
            <div class="grid grid-3 stagger-children reveal">
                <?php while ($posts_query->have_posts()):
                    $posts_query->the_post();
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
                            <?php echo get_the_date("M j, Y"); ?>
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
                <h2 class="text-display"><?php esc_html_e("No Posts Found", "clean-vite-wp"); ?></h2>
                <p><?php esc_html_e("There are no scanner posts to display yet.", "clean-vite-wp"); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
