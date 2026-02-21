</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand Column -->
            <div class="footer-brand">
                <a href="<?php echo esc_url(
                    home_url("/"),
                ); ?>" class="site-logo">
                    <span class="logo-mark"><?php echo esc_html(
                        mb_substr(get_bloginfo("name"), 0, 1),
                    ); ?></span>
                    <span><?php bloginfo("name"); ?></span>
                </a>
                <p><?php bloginfo("description"); ?></p>
            </div>

            <!-- Footer Navigation -->
            <?php if (has_nav_menu("footer")): ?>
                <nav class="footer-nav">
                    <h4><?php esc_html_e("Links", "clean-vite-wp"); ?></h4>
                    <?php wp_nav_menu([
                        "theme_location" => "footer",
                        "container" => false,
                        "depth" => 1,
                        "fallback_cb" => false,
                    ]); ?>
                </nav>
            <?php endif; ?>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date("Y"); ?> <?php bloginfo(
     "name",
 ); ?>. <?php esc_html_e("All rights reserved.", "clean-vite-wp"); ?></p>
            <div class="footer-links">
                <?php if (get_privacy_policy_url()): ?>
                    <a href="<?php echo esc_url(
                        get_privacy_policy_url(),
                    ); ?>"><?php esc_html_e(
    "Privacy Policy",
    "clean-vite-wp",
); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
