<?php
/**
 * Template Part: Scanner Post Card
 *
 * Args (via get_template_part $args):
 *   show_time (bool)  — append time to date display (default false)
 *   is_hero   (bool)  — render as hero card (default false)
 *
 * @package Clean_Vite_WP
 */

$show_time = !empty($args["show_time"]);
$is_hero = !empty($args["is_hero"]);
$fb_image = get_post_meta(get_the_ID(), "_fb_full_picture", true);
$post_cats = get_the_terms(get_the_ID(), "post_category_type");
$is_ad = false;
if ($post_cats && !is_wp_error($post_cats)) {
    $is_ad = in_array("advertisement", wp_list_pluck($post_cats, "slug"), true);
}
$card_class =
    "card card-hover" .
    ($is_hero && !$is_ad ? " card-hero" : "") .
    ($is_ad ? " card-sponsored" : "");
?>

<article class="<?php echo esc_attr($card_class); ?>">
    <?php if ($fb_image): ?>
        <div class="card-image">
            <img src="<?php echo esc_url($fb_image); ?>"
                 alt="<?php the_title_attribute(); ?>"
                 loading="lazy">
        </div>
    <?php endif; ?>

    <span class="card-date">
        <?php
        echo get_the_date("M j, Y");
        if ($show_time): ?> at <?php echo get_the_time("g:i A");endif;
        ?>
    </span>

    <?php if ($post_cats && !is_wp_error($post_cats)): ?>
        <div class="card-badges">
            <?php if ($is_ad): ?>
                <span class="badge badge-sponsored">Sponsored</span>
            <?php else: ?>
                <?php foreach ($post_cats as $cat): ?>
                    <a href="<?php echo esc_url(
                        get_term_link($cat),
                    ); ?>" class="badge badge-<?php echo esc_attr(
    $cat->slug,
); ?>">
                        <?php echo esc_html($cat->name); ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <h3 class="card-title">
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </h3>

    <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>

    <a href="<?php the_permalink(); ?>" class="card-link">
        <?php esc_html_e("Read more", "clean-vite-wp"); ?> <?php echo cvw_icon(
     "arrow-right",
     16,
 ); ?>
    </a>
</article>
