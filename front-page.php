<?php
/**
 * Front Page Template
 *
 * @package Clean_Vite_WP
 */

get_header(); ?>

<?php while (have_posts()):
    the_post(); ?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="text-hero"><?php the_title(); ?></h1>
            <?php if (has_excerpt()): ?>
                <p class="hero-subtitle"><?php echo get_the_excerpt(); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if (get_the_content()): ?>
<section class="section">
    <div class="container">
        <div class="prose">
            <?php the_content(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
endwhile; ?>

<?php get_footer(); ?>
