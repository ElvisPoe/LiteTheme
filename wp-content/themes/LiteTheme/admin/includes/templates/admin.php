<h1><?php echo __('LiteTheme'); ?></h1>
<?php settings_errors(); ?>
<form action="options.php" method="post" class="litetheme-theme-form">
    <?php settings_fields('litetheme-settings-group'); ?>
    <?php do_settings_sections('theme_settings'); ?>
    <?php submit_button( __('Save Changes'), 'primary', 'btn-submit' ); ?>
</form>
