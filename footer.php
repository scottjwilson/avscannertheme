</main>

<?php
$footer_categories = get_terms([
    'taxonomy'   => 'post_category_type',
    'hide_empty' => true,
    'exclude'    => avscanner_get_ad_term_id(),
]);
?>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand Column -->
            <div class="footer-brand">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo">
                    <?php if (has_custom_logo()):
                        $logo_id  = get_theme_mod('custom_logo');
                        $logo_url = wp_get_attachment_image_url($logo_id, 'full');
                    ?>
                        <img src="<?php echo esc_url($logo_url); ?>"
                             alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                             class="footer-logo-img">
                    <?php elseif (file_exists(get_template_directory() . '/images/logo.png')): ?>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/images/logo.png'); ?>"
                             alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                             class="footer-logo-img">
                    <?php else: ?>
                        <span class="footer-logo-text"><?php bloginfo('name'); ?></span>
                    <?php endif; ?>
                </a>
                <p class="footer-tagline"><?php bloginfo('description'); ?></p>
            </div>

            <!-- Categories Column -->
            <?php if (!is_wp_error($footer_categories) && !empty($footer_categories)): ?>
                <div class="footer-col">
                    <h4 class="footer-heading"><?php esc_html_e('Categories', 'avscannertheme'); ?></h4>
                    <ul class="footer-cat-list">
                        <?php foreach ($footer_categories as $cat): ?>
                            <li>
                                <a href="<?php echo esc_url(get_term_link($cat)); ?>">
                                    <span class="footer-cat-dot" style="background:var(--badge-<?php echo esc_attr($cat->slug); ?>)"></span>
                                    <?php echo esc_html($cat->name); ?>
                                    <span class="footer-cat-count"><?php echo esc_html($cat->count); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Links Column -->
            <?php if (has_nav_menu('footer')): ?>
                <div class="footer-col">
                    <h4 class="footer-heading"><?php esc_html_e('Links', 'avscannertheme'); ?></h4>
                    <?php wp_nav_menu([
                        'theme_location' => 'footer',
                        'container' => false,
                        'menu_class' => 'footer-link-list',
                        'depth' => 1,
                        'fallback_cb' => false,
                    ]); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
            <div class="footer-links">
                <?php if (get_privacy_policy_url()): ?>
                    <a href="<?php echo esc_url(get_privacy_policy_url()); ?>"><?php esc_html_e('Privacy Policy', 'avscannertheme'); ?></a>
                <?php endif; ?>
                <a href="<?php echo esc_url(home_url('/feed/')); ?>"><?php esc_html_e('RSS Feed', 'avscannertheme'); ?></a>
            </div>
        </div>
    </div>
</footer>

<template id="card-skeleton">
    <div class="card card-skeleton">
        <div class="skeleton skeleton-image"></div>
        <div class="skeleton skeleton-line" style="width:35%"></div>
        <div class="skeleton skeleton-line skeleton-line-lg" style="width:85%"></div>
        <div class="skeleton skeleton-line" style="width:100%"></div>
        <div class="skeleton skeleton-line" style="width:60%"></div>
    </div>
</template>

<button class="back-to-top" aria-label="Back to top" hidden>
    <?php echo avs_icon('arrow-up', 20); ?>
</button>

<?php wp_footer(); ?>
</body>
</html>
