<?php
/**
 * Single Template: Scanner Post (fb_post)
 *
 * @package AVScannerTheme
 */

get_header(); ?>

<?php while (have_posts()):
    the_post();
    $thumb_id = get_post_thumbnail_id();
    $fb_image = $thumb_id
        ? wp_get_attachment_url($thumb_id)
        : get_post_meta(get_the_ID(), "_fb_full_picture", true);
    $fb_video = get_post_meta(get_the_ID(), "_fb_video_url", true);
    $fb_link = get_post_meta(get_the_ID(), "_fb_permalink", true);
    $post_cats = get_the_terms(get_the_ID(), "post_category_type");
    $is_ad     = false;
    if ($post_cats && ! is_wp_error($post_cats)) {
        $is_ad = in_array('advertisement', wp_list_pluck($post_cats, 'slug'), true);
    }
?>

<article class="section">
    <div class="container" style="max-width: 800px;">
        <header class="single-header">
            <?php if ($post_cats && !is_wp_error($post_cats)): ?>
                <div class="card-badges mb-4">
                    <?php if ($is_ad): ?>
                        <span class="badge badge-sponsored">Sponsored</span>
                    <?php else: ?>
                        <?php foreach ($post_cats as $cat): ?>
                            <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="badge badge-<?php echo esc_attr($cat->slug); ?>">
                                <?php echo esc_html($cat->name); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <span class="single-date">
                <?php echo get_the_date("M j, Y"); ?> at <?php echo get_the_time("g:i A"); ?>
            </span>
            <h1 class="text-display single-title"><?php the_title(); ?></h1>
        </header>

        <?php if ($fb_video): ?>
            <div class="single-video" data-fb-permalink="<?php echo esc_url($fb_link); ?>">
                <video controls preload="metadata" poster="<?php echo esc_url($thumb_id ? wp_get_attachment_url($thumb_id) : $fb_image); ?>">
                    <source src="<?php echo esc_url($fb_video); ?>" type="video/mp4">
                </video>
                <div class="single-video-fallback" hidden>
                    <?php if ($fb_image): ?>
                        <img src="<?php echo esc_url($fb_image); ?>"
                             alt="<?php the_title_attribute(); ?>">
                    <?php endif; ?>
                    <a href="<?php echo esc_url($fb_link); ?>"
                       class="btn btn-primary single-video-fallback-btn"
                       target="_blank"
                       rel="noopener noreferrer">
                        <?php echo avs_icon("arrow-up-right", 16); ?> Watch on Facebook
                    </a>
                </div>
            </div>
            <script>
            document.querySelector('.single-video source').addEventListener('error', function() {
                this.closest('.single-video').querySelector('video').hidden = true;
                this.closest('.single-video').querySelector('.single-video-fallback').hidden = false;
            });
            </script>
        <?php elseif ($fb_image): ?>
            <div class="single-image">
                <?php if ($thumb_id) :
                    echo wp_get_attachment_image($thumb_id, 'large', false, [
                        'sizes' => '(min-width: 800px) 800px, 100vw',
                        'alt'   => get_the_title(),
                    ]);
                else : ?>
                    <img src="<?php echo esc_url($fb_image); ?>"
                         alt="<?php the_title_attribute(); ?>"
                         loading="lazy">
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="prose">
            <?php the_content(); ?>
        </div>

        <?php $shared_url = get_post_meta(get_the_ID(), '_fb_shared_url', true); ?>
        <?php if ($shared_url): ?>
            <div class="shared-source">
                <span class="shared-source-label">Shared from</span>
                <a href="<?php echo esc_url($shared_url); ?>"
                   class="btn btn-outline"
                   target="_blank"
                   rel="noopener noreferrer">
                    <?php echo esc_html(wp_parse_url($shared_url, PHP_URL_HOST)); ?>
                    <?php echo avs_icon('arrow-up-right', 16); ?>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($fb_link): ?>
            <div class="single-fb-link">
                <a href="<?php echo esc_url($fb_link); ?>"
                   class="btn btn-outline"
                   target="_blank"
                   rel="noopener noreferrer">
                    <?php esc_html_e("View on Facebook", "avscannertheme"); ?> <?php echo avs_icon("arrow-up-right", 16); ?>
                </a>
            </div>
        <?php endif; ?>

    </div>

    <?php
    $related_terms = get_the_terms(get_the_ID(), 'post_category_type');
    if ($related_terms && ! is_wp_error($related_terms)) :
        $related_query = new WP_Query([
            'post_type'      => 'fb_post',
            'posts_per_page' => 3,
            'post__not_in'   => [get_the_ID()],
            'tax_query'      => [[
                'taxonomy' => 'post_category_type',
                'field'    => 'term_id',
                'terms'    => $related_terms[0]->term_id,
            ]],
            'no_found_rows'  => true,
        ]);
        if ($related_query->have_posts()) : ?>
            <section class="related-posts">
                <div class="container">
                    <h2 class="related-posts-title">Related Posts</h2>
                    <div class="grid grid-3">
                        <?php while ($related_query->have_posts()) : $related_query->the_post();
                            get_template_part('template-parts/card-fb-post');
                        endwhile; ?>
                    </div>
                </div>
            </section>
        <?php endif;
        wp_reset_postdata();
    endif;
    ?>
</article>

<?php endwhile; ?>

<?php get_footer(); ?>
