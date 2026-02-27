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

            <!-- Contact Column -->
            <div class="footer-col">
                <h4 class="footer-heading"><?php esc_html_e('Contact', 'avscannertheme'); ?></h4>
                <ul class="footer-contact-list">
                    <li>
                        <span class="footer-contact-label"><?php echo avs_icon('mail', 14); ?> Email</span>
                        <a href="mailto:admin@avscannernews.com">admin@avscannernews.com</a>
                    </li>
                    <li>
                        <span class="footer-contact-label"><?php echo avs_icon('phone', 14); ?> City of Palmdale</span>
                        <a href="tel:+16612675100">(661) 267-5100</a>
                    </li>
                    <li>
                        <span class="footer-contact-label"><?php echo avs_icon('phone', 14); ?> City of Lancaster</span>
                        <a href="tel:+16617236000">(661) 723-6000</a>
                    </li>
                    <li>
                        <span class="footer-contact-label"><?php echo avs_icon('phone', 14); ?> Palmdale Sheriff</span>
                        <a href="tel:+16612722400">(661) 272-2400</a>
                    </li>
                    <li>
                        <span class="footer-contact-label"><?php echo avs_icon('phone', 14); ?> Lancaster Sheriff</span>
                        <a href="tel:+16619488466">(661) 948-8466</a>
                    </li>
                    <li>
                        <span class="footer-contact-label"><?php echo avs_icon('phone', 14); ?> CHP AV</span>
                        <a href="tel:+16619488541">(661) 948-8541</a>
                    </li>
                    <li>
                        <span class="footer-contact-label"><?php echo avs_icon('phone', 14); ?> CHP After Hours</span>
                        <a href="tel:+13232593200">(323) 259-3200</a>
                    </li>
                </ul>
            </div>

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
            <div class="footer-social">
                <a href="https://facebook.com/avscannernews" class="footer-social-link" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
                    <?php echo avs_icon('facebook', 18); ?>
                </a>
                <a href="https://x.com/avscannernews" class="footer-social-link" aria-label="X (Twitter)" target="_blank" rel="noopener noreferrer">
                    <?php echo avs_icon('x-twitter', 18); ?>
                </a>
                <a href="https://instagram.com/avscannernews" class="footer-social-link" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
                    <?php echo avs_icon('instagram', 18); ?>
                </a>
            </div>
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
