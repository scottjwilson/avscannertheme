<?php
/**
 * Single Template: Scanner Post (fb_post)
 *
 * @package Clean_Vite_WP
 */

get_header(); ?>

<?php while (have_posts()):
    the_post();
    $fb_image = get_post_meta(get_the_ID(), "_fb_full_picture", true);
    $fb_link = get_post_meta(get_the_ID(), "_fb_permalink", true);
    $post_cats = get_the_terms(get_the_ID(), "post_category_type");
?>

<article class="section">
    <div class="container" style="max-width: 800px;">
        <header class="single-header">
            <?php if ($post_cats && !is_wp_error($post_cats)): ?>
                <div class="card-badges mb-4">
                    <?php foreach ($post_cats as $cat): ?>
                        <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="badge badge-<?php echo esc_attr($cat->slug); ?>">
                            <?php echo esc_html($cat->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <span class="single-date">
                <?php echo get_the_date(); ?>
            </span>
            <h1 class="text-display single-title"><?php the_title(); ?></h1>
        </header>

        <?php if ($fb_image): ?>
            <div class="single-image">
                <img src="<?php echo esc_url($fb_image); ?>"
                     alt="<?php the_title_attribute(); ?>"
                     loading="lazy">
            </div>
        <?php endif; ?>

        <div class="prose">
            <?php the_content(); ?>
        </div>

        <?php if ($fb_link): ?>
            <div class="single-fb-link">
                <a href="<?php echo esc_url($fb_link); ?>"
                   class="btn btn-outline"
                   target="_blank"
                   rel="noopener noreferrer">
                    <?php esc_html_e("View on Facebook", "clean-vite-wp"); ?> <?php echo cvw_icon("arrow-up-right", 16); ?>
                </a>
            </div>
        <?php endif; ?>

        <nav class="single-nav">
            <?php
            $prev = get_previous_post();
            $next = get_next_post();
            ?>
            <div>
                <?php if ($prev): ?>
                    <span class="single-nav-label"><?php esc_html_e("Previous", "clean-vite-wp"); ?></span>
                    <a href="<?php echo get_permalink($prev); ?>" class="single-nav-link">
                        <?php echo esc_html($prev->post_title); ?>
                    </a>
                <?php endif; ?>
            </div>
            <div class="single-nav-next">
                <?php if ($next): ?>
                    <span class="single-nav-label"><?php esc_html_e("Next", "clean-vite-wp"); ?></span>
                    <a href="<?php echo get_permalink($next); ?>" class="single-nav-link">
                        <?php echo esc_html($next->post_title); ?>
                    </a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</article>

<?php endwhile; ?>

<?php get_footer(); ?>
