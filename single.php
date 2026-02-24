<?php
/**
 * Single Post Template
 *
 * @package AVScannerTheme
 */

get_header(); ?>

<?php while (have_posts()):
    the_post(); ?>

<article class="section">
    <div class="container" style="max-width: 800px;">
        <header class="single-header">
            <span class="single-date">
                <?php echo get_the_date(); ?>
            </span>
            <h1 class="text-display single-title"><?php the_title(); ?></h1>
            <?php if (has_excerpt()): ?>
                <p class="text-subtitle"><?php echo get_the_excerpt(); ?></p>
            <?php endif; ?>
        </header>

        <?php if (has_post_thumbnail()): ?>
            <div class="single-image">
                <?php the_post_thumbnail("large"); ?>
            </div>
        <?php endif; ?>

        <div class="prose">
            <?php the_content(); ?>
        </div>

        <nav class="single-nav">
            <?php
            $prev = get_previous_post();
            $next = get_next_post();
            ?>
            <div>
                <?php if ($prev): ?>
                    <span class="single-nav-label"><?php esc_html_e("Previous", "avscannertheme"); ?></span>
                    <a href="<?php echo get_permalink($prev); ?>" class="single-nav-link">
                        <?php echo esc_html($prev->post_title); ?>
                    </a>
                <?php endif; ?>
            </div>
            <div class="single-nav-next">
                <?php if ($next): ?>
                    <span class="single-nav-label"><?php esc_html_e("Next", "avscannertheme"); ?></span>
                    <a href="<?php echo get_permalink($next); ?>" class="single-nav-link">
                        <?php echo esc_html($next->post_title); ?>
                    </a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</article>

<?php
endwhile; ?>

<?php get_footer(); ?>
