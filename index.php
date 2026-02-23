<?php
/**
 * Main Template File
 *
 * @package Clean_Vite_WP
 */

get_header(); ?>

<section class="section">
    <div class="container">
        <?php if (have_posts()): ?>
            <div class="grid grid-3">
                <?php while (have_posts()):
                    the_post(); ?>
                    <article class="card card-hover">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="card-image">
                                <?php the_post_thumbnail("cvw-card"); ?>
                            </div>
                        <?php endif; ?>

                        <span class="card-date">
                            <?php echo get_the_date("M j, Y"); ?>
                        </span>

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
                            <?php esc_html_e(
                                "Read more",
                                "clean-vite-wp",
                            ); ?> <?php echo cvw_icon("arrow-right", 16); ?>
                        </a>
                    </article>
                <?php
                endwhile; ?>
            </div>

            <?php the_posts_pagination(); ?>

        <?php else: ?>
            <div class="empty-state">
                <?php echo cvw_empty_state_svg('not-found'); ?>
                <h2 class="text-display"><?php esc_html_e(
                    "Nothing Found",
                    "clean-vite-wp",
                ); ?></h2>
                <p><?php esc_html_e(
                    "We couldn't find what you're looking for.",
                    "clean-vite-wp",
                ); ?></p>
                <a href="<?php echo esc_url(
                    home_url("/"),
                ); ?>" class="btn btn-primary"><?php esc_html_e(
    "Back to Home",
    "clean-vite-wp",
); ?></a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
