<h1><?php echo __('LiteTheme Colors Page'); ?></h1>
<?php settings_errors(); ?>
<form action="options.php" method="post" class="litetheme-theme-form">
    <?php settings_fields('litetheme-colors-options'); ?>
    <?php do_settings_sections('theme_colors_settings'); ?>
    <?php submit_button( __('Save Changes'), 'primary', 'btn-submit' ); ?>
</form>
