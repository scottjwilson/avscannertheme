<?php
/**
 * Template Part: Scanner Post Card
 *
 * Args (via get_template_part $args):
 *   show_time (bool)  — append time to date display (default false)
 *
 * @package AVScannerTheme
 */

$show_time = !empty($args["show_time"]);
$thumb_id = get_post_thumbnail_id();
$fb_image = $thumb_id
    ? wp_get_attachment_url($thumb_id)
    : get_post_meta(get_the_ID(), "_fb_full_picture", true);
$fb_video = get_post_meta(get_the_ID(), "_fb_video_url", true);
$post_cats = get_the_terms(get_the_ID(), "post_category_type");
$is_ad = false;
if ($post_cats && !is_wp_error($post_cats)) {
    $is_ad = in_array("advertisement", wp_list_pluck($post_cats, "slug"), true);
}
$card_class = "card card-hover" . ($is_ad ? " card-sponsored" : "");
?>

<article class="<?php echo esc_attr($card_class); ?>">
    <?php $sizes = '(min-width: 1024px) 400px, (min-width: 640px) 50vw, 100vw'; ?>
    <?php if ($thumb_id) : ?>
        <a href="<?php the_permalink(); ?>" class="card-image-link<?php echo $fb_video ? ' has-video' : ''; ?>">
            <div class="card-image">
                <?php echo wp_get_attachment_image($thumb_id, 'cvw-card', false, [
                    'sizes'   => $sizes,
                    'loading' => 'lazy',
                    'alt'     => get_the_title(),
                ]); ?>
                <?php if ($fb_video): ?>
                    <span class="card-play-icon" aria-hidden="true">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                            <circle cx="24" cy="24" r="24" fill="rgba(0,0,0,0.6)"/>
                            <path d="M19 15l14 9-14 9V15z" fill="white"/>
                        </svg>
                    </span>
                <?php endif; ?>
            </div>
        </a>
    <?php elseif ($fb_image) : ?>
        <a href="<?php the_permalink(); ?>" class="card-image-link<?php echo $fb_video ? ' has-video' : ''; ?>">
            <div class="card-image">
                <img src="<?php echo esc_url($fb_image); ?>"
                     alt="<?php the_title_attribute(); ?>"
                     loading="lazy">
                <?php if ($fb_video): ?>
                    <span class="card-play-icon" aria-hidden="true">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                            <circle cx="24" cy="24" r="24" fill="rgba(0,0,0,0.6)"/>
                            <path d="M19 15l14 9-14 9V15z" fill="white"/>
                        </svg>
                    </span>
                <?php endif; ?>
            </div>
        </a>
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

    <?php $shared_url = get_post_meta(get_the_ID(), '_fb_shared_url', true); ?>
    <?php if ($shared_url): ?>
        <span class="card-source">
            via <?php echo esc_html(wp_parse_url($shared_url, PHP_URL_HOST)); ?>
        </span>
    <?php endif; ?>

    <h3 class="card-title">
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </h3>

    <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>

    <a href="<?php the_permalink(); ?>" class="card-link">
        <?php esc_html_e("Read more", "avscannertheme"); ?> <?php echo avs_icon(
     "arrow-right",
     16,
 ); ?>
    </a>
</article>
