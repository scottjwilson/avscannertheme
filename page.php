<?php
/**
 * Default Page Template
 *
 * @package Clean_Vite_WP
 */

get_header(); ?>

<?php while (have_posts()):
    the_post(); ?>

<section class="hero" style="padding-bottom: 2rem;">
    <div class="container">
        <div class="hero-content">
            <h1 class="text-hero"><?php the_title(); ?></h1>
            <?php if (has_excerpt()): ?>
                <p class="hero-subtitle"><?php echo get_the_excerpt(); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section" style="padding-top: 2rem;">
    <div class="container" style="max-width: 800px;">
        <div class="prose">
            <?php the_content(); ?>
        </div>
    </div>
</section>

<?php
endwhile; ?>

<?php get_footer(); ?>
