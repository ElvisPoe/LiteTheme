<h1><?php echo __('LiteTheme Blog'); ?></h1>
<?php settings_errors(); ?>
<form action="options.php" method="post" class="litetheme-theme-form">
    <?php settings_fields('litetheme-blog-options'); ?>
    <?php do_settings_sections('theme_blog_settings'); ?>
    <?php submit_button( __('Save Changes'), 'primary', 'btn-submit' ); ?>
</form>
