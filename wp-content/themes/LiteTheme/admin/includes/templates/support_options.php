<h1><?php echo __('LiteTheme Support Options'); ?></h1>
<?php settings_errors(); ?>
<form action="options.php" method="post" class="litetheme-theme-form">
    <?php settings_fields('litetheme-support-options'); ?>
    <?php do_settings_sections('theme_support_settings'); ?>
    <?php submit_button( __('Save Changes'), 'primary', 'btn-submit' ); ?>
</form>
