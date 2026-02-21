<?php
/**
 * Single Post Template
 *
 * @package Clean_Vite_WP
 */

get_header(); ?>

<?php while (have_posts()):
    the_post(); ?>

<article class="section">
    <div class="container" style="max-width: 800px;">
        <header style="margin-bottom: var(--space-8);">
            <span style="font-size: var(--text-sm); color: var(--color-neutral-500);">
                <?php echo get_the_date(); ?>
            </span>
            <h1 class="text-display" style="margin-top: var(--space-2);"><?php the_title(); ?></h1>
            <?php if (has_excerpt()): ?>
                <p class="text-subtitle" style="margin-top: var(--space-4);"><?php echo get_the_excerpt(); ?></p>
            <?php endif; ?>
        </header>

        <?php if (has_post_thumbnail()): ?>
            <div style="border-radius: var(--radius-2xl); overflow: hidden; margin-bottom: var(--space-8);">
                <?php the_post_thumbnail("large", [
                    "style" => "width: 100%; height: auto;",
                ]); ?>
            </div>
        <?php endif; ?>

        <div class="prose">
            <?php the_content(); ?>
        </div>

        <nav style="display: flex; justify-content: space-between; gap: var(--space-4); margin-top: var(--space-12); padding-top: var(--space-8); border-top: 1px solid var(--color-neutral-200);">
            <?php
            $prev = get_previous_post();
            $next = get_next_post();
            ?>
            <div>
                <?php if ($prev): ?>
                    <span style="font-size: var(--text-xs); color: var(--color-neutral-500); text-transform: uppercase; letter-spacing: var(--tracking-wider);"><?php esc_html_e("Previous", "clean-vite-wp"); ?></span>
                    <a href="<?php echo get_permalink($prev); ?>" style="display: block; font-weight: 600; margin-top: var(--space-1);">
                        <?php echo esc_html($prev->post_title); ?>
                    </a>
                <?php endif; ?>
            </div>
            <div style="text-align: right;">
                <?php if ($next): ?>
                    <span style="font-size: var(--text-xs); color: var(--color-neutral-500); text-transform: uppercase; letter-spacing: var(--tracking-wider);"><?php esc_html_e("Next", "clean-vite-wp"); ?></span>
                    <a href="<?php echo get_permalink($next); ?>" style="display: block; font-weight: 600; margin-top: var(--space-1);">
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
