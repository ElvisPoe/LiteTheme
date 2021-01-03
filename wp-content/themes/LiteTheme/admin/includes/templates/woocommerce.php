<h1><?php echo __('LiteTheme WooCommerce Page'); ?></h1>
<?php settings_errors(); ?>
<form action="options.php" method="post" class="litetheme-theme-form">
    <?php settings_fields('litetheme-woo-functions-options'); ?>
    <?php do_settings_sections('woo_functions_settings'); ?>
    <?php submit_button( __('Save Changes'), 'primary', 'btn-submit' ); ?>
</form>
