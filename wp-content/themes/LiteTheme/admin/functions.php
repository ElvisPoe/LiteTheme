<?php

/*
** Admin Functions
*/

# Admin Styles
function admin_styles() {
    wp_register_style( 'admin_style', get_template_directory_uri() . '/admin/css/admin.css', false, '1.0', 'all' );
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_style('admin_style');
}

# Admin Scripts
function admin_scripts() {
    wp_register_script('admin_script', get_template_directory_uri() . '/admin/js/admin.js', array('jquery'), '1.0', true);

    # Enable Media Uploader
    wp_enqueue_media();

    wp_enqueue_script('wp-color-picker');

    wp_enqueue_script('admin_script');
}

# Theme Option Pages
function theme_add_admin_page() {
    // register Theme Page
    add_menu_page( 'LiteTheme Options', 'LiteTheme', 'manage_options', 'theme_settings', 'theme_settings_page', 'dashicons-schedule', 100 );

    // Register Subpages
    add_submenu_page( 'theme_settings', 'LiteTheme Theme Options', __('General'), 'manage_options', 'theme_settings', 'theme_settings_page' );
    if ( get_option('enable_advanced') == 1 ) {
        add_submenu_page( 'theme_settings', 'Blog', __('Blog'), 'manage_options', 'theme_blog', 'theme_blog_page' );
        add_submenu_page( 'theme_settings', 'Colors', __('Colors'), 'manage_options', 'theme_colors', 'theme_colors_page' );
        if (class_exists('WooCommerce')) {
            add_submenu_page( 'theme_settings', 'WooCommerce', __('WooCommerce'), 'manage_options', 'theme_woo_functions', 'woocommerce_page' );
        }
        add_submenu_page( 'theme_settings', 'Theme Support', __('Theme Support'), 'manage_options', 'theme_support', 'theme_support_page' );
        //add_submenu_page( 'theme_settings', 'Custom CSS', __('Custom CSS'), 'manage_options', 'theme_css', 'theme_css_page' );
    }

    // Activate Custom Settings
    add_action('admin_init', 'theme_custom_settings');
}

# Theme Custom Settings
function theme_custom_settings() {
    // General Page

    // Social Links & Data
    register_setting( 'litetheme-settings-group', 'store_address');
    register_setting( 'litetheme-settings-group', 'store_phone_1');
    register_setting( 'litetheme-settings-group', 'store_email');
    register_setting( 'litetheme-settings-group', 'facebook_id');
    register_setting( 'litetheme-settings-group', 'twitter_id');
    register_setting( 'litetheme-settings-group', 'youtube_id');
    register_setting( 'litetheme-settings-group', 'instagram_id');

    add_settings_section( 'litetheme-social-links', __('Store Info & Links'), 'theme_social_options', 'theme_settings' );

    add_settings_field( 'store-address', __('Store Address'), 'theme_store_address', 'theme_settings', 'litetheme-social-links' );
    add_settings_field( 'store-phone-1', __('Store Phone 1'), 'theme_store_phone_1', 'theme_settings', 'litetheme-social-links' );
    add_settings_field( 'store-phone-2', __('Store Phone 2'), 'theme_store_phone_2', 'theme_settings', 'litetheme-social-links' );
    add_settings_field( 'store-email', __('Store Email'), 'theme_store_email', 'theme_settings', 'litetheme-social-links' );
    add_settings_field( 'facebook-link', __('Facebook'), 'theme_facebook_id', 'theme_settings', 'litetheme-social-links' );
    add_settings_field( 'twitter-link', __('Twitter'), 'theme_twitter_id', 'theme_settings', 'litetheme-social-links' );
    add_settings_field( 'youtube-link', __('Youtube'), 'theme_youtube_id', 'theme_settings', 'litetheme-social-links' );
    add_settings_field( 'instagram-link', __('Instagram'), 'theme_instagram_id', 'theme_settings', 'litetheme-social-links' );


    // Header Options
    register_setting( 'litetheme-settings-group', 'enable_advanced' );
    add_settings_section( 'litetheme-enable-advanced', __('Advanced Options'), 'theme_advanced_options', 'theme_settings' );
    add_settings_field( 'enable-advanced', __('Simple / Advanced'), 'theme_enable_advanced', 'theme_settings', 'litetheme-enable-advanced' );

    register_setting( 'litetheme-settings-group', 'theme_style' );
    add_settings_section( 'litetheme-style-select', __('Theme Style'), null, 'theme_settings' );
    add_settings_field( 'theme-style', __('Active Style'), 'theme_style', 'theme_settings', 'litetheme-style-select' );

    register_setting( 'litetheme-settings-group', 'header_width' );
    add_settings_section( 'litetheme-header-options', __('Header Options'), 'theme_header_options', 'theme_settings' );
    add_settings_field( 'header-width', __('Header Width'), 'theme_header_width', 'theme_settings', 'litetheme-header-options' );

    register_setting( 'litetheme-settings-group', 'header_columns' );
    add_settings_field( 'header-columns', __('Header Columns'), 'theme_header_columns', 'theme_settings', 'litetheme-header-options' );

    register_setting( 'litetheme-settings-group', 'header_logo', 'sync_header_logo_to_custom_logo' );
    add_settings_field( 'header-logo', __('Logo Image'), 'theme_header_logo', 'theme_settings', 'litetheme-header-options' );

    register_setting( 'litetheme-settings-group', 'logo_position' );
    add_settings_field( 'logo-position', __('Logo Position'), 'theme_logo_position', 'theme_settings', 'litetheme-header-options' );

    register_setting( 'litetheme-settings-group', 'menu_style' );
    add_settings_field( 'menu-style', __('Menu Style'), 'theme_menu_style', 'theme_settings', 'litetheme-header-options' );

    register_setting( 'litetheme-settings-group', 'sticky_menu' );
    add_settings_field( 'sticky-menu', __('Sticky Menu'), 'theme_sticky_menu', 'theme_settings', 'litetheme-header-options' );

    // Layout Options
    register_setting( 'litetheme-settings-group', 'body_width' );
    add_settings_section( 'litetheme-layout-options', __('Layout Options'), 'theme_layout_options', 'theme_settings' );
    add_settings_field( 'body-width', __('Body Width'), 'theme_body_width', 'theme_settings', 'litetheme-layout-options' );

    register_setting( 'litetheme-settings-group', 'theme_page_title' );
    add_settings_field( 'theme-page-title', __('Page Title'), 'theme_page_title', 'theme_settings', 'litetheme-layout-options' );

    register_setting( 'litetheme-settings-group', 'theme_sidebars' );
    add_settings_field( 'theme-sidebars', __('Left / Right Sidebar'), 'theme_left_right_sidebar', 'theme_settings', 'litetheme-layout-options' );

    // Footer Options
    register_setting( 'litetheme-settings-group', 'footer_width' );
    add_settings_section( 'litetheme-footer-options', __('Footer Options'), 'theme_footer_options', 'theme_settings' );
    add_settings_field( 'footer-width', __('Footer Width'), 'theme_footer_width', 'theme_settings', 'litetheme-footer-options' );

    register_setting( 'litetheme-settings-group', 'footer_columns' );
    add_settings_field( 'footer-columns', __('Footer Columns'), 'theme_footer_columns', 'theme_settings', 'litetheme-footer-options' );

    register_setting( 'litetheme-settings-group', 'copyright_text' );
    add_settings_field( 'copyright_text', __('Copyright Text'), 'theme_copyright_text', 'theme_settings', 'litetheme-footer-options' );

    // Blog Page
    register_setting( 'litetheme-blog-options', 'theme_post_title' );
    register_setting( 'litetheme-blog-options', 'theme_post_author' );
    add_settings_section( 'litetheme-blog-layout', __('Blog Layout'), null, 'theme_blog_settings' );
    add_settings_field( 'theme-post-title', __('Post Title'), 'theme_post_title', 'theme_blog_settings', 'litetheme-blog-layout' );
    add_settings_field( 'theme-post-author', __('Post Author'), 'theme_post_author', 'theme_blog_settings', 'litetheme-blog-layout' );

    // Colors Page
    register_setting( 'litetheme-colors-options', 'header_bg_color' );
    register_setting( 'litetheme-colors-options', 'header_text_color' );
    register_setting( 'litetheme-colors-options', 'header_link_color' );
    add_settings_section( 'litetheme-header-colors', __('Header Colors'), null, 'theme_colors_settings' );
    add_settings_field( 'header-bg-color', __('Header Background Color'), 'theme_header_bg_color', 'theme_colors_settings', 'litetheme-header-colors' );
    add_settings_field( 'header-text-color', __('Header Text Color'), 'theme_header_text_color', 'theme_colors_settings', 'litetheme-header-colors' );
    add_settings_field( 'header-link-color', __('Header Link Color'), 'theme_header_link_color', 'theme_colors_settings', 'litetheme-header-colors' );

    register_setting( 'litetheme-colors-options', 'nav_bg_color' );
    register_setting( 'litetheme-colors-options', 'nav_text_color' );
    register_setting( 'litetheme-colors-options', 'nav_link_color' );
    add_settings_section( 'litetheme-nav-colors', __('Navigation Colors'), null, 'theme_colors_settings' );
    add_settings_field( 'nav-bg-color', __('Navigation Background Color'), 'theme_nav_bg_color', 'theme_colors_settings', 'litetheme-nav-colors' );
    add_settings_field( 'nav-text-color', __('Navigation Text Color'), 'theme_nav_text_color', 'theme_colors_settings', 'litetheme-nav-colors' );
    add_settings_field( 'nav-link-color', __('Navigation Link Color'), 'theme_nav_link_color', 'theme_colors_settings', 'litetheme-nav-colors' );

    register_setting( 'litetheme-colors-options', 'body_bg_color' );
    register_setting( 'litetheme-colors-options', 'body_text_color' );
    register_setting( 'litetheme-colors-options', 'body_link_color' );
    add_settings_section( 'litetheme-body-colors', __('Body Colors'), null, 'theme_colors_settings' );
    add_settings_field( 'body-bg-color', __('Body Background Color'), 'theme_body_bg_color', 'theme_colors_settings', 'litetheme-body-colors' );
    add_settings_field( 'body-text-color', __('Body Text Color'), 'theme_body_text_color', 'theme_colors_settings', 'litetheme-body-colors' );
    add_settings_field( 'body-link-color', __('Body Link Color'), 'theme_body_link_color', 'theme_colors_settings', 'litetheme-body-colors' );

    register_setting( 'litetheme-colors-options', 'footer_bg_color' );
    register_setting( 'litetheme-colors-options', 'footer_text_color' );
    register_setting( 'litetheme-colors-options', 'footer_link_color' );
    add_settings_section( 'litetheme-footer-colors', __('Footer Colors'), null, 'theme_colors_settings' );
    add_settings_field( 'footer-bg-color', __('Footer Background Color'), 'theme_footer_bg_color', 'theme_colors_settings', 'litetheme-footer-colors' );
    add_settings_field( 'footer-text-color', __('Footer Text Color'), 'theme_footer_text_color', 'theme_colors_settings', 'litetheme-footer-colors' );
    add_settings_field( 'footer-link-color', __('Footer Link Color'), 'theme_footer_link_color', 'theme_colors_settings', 'litetheme-footer-colors' );

    // WooCommerce Functions
    register_setting( 'litetheme-woo-functions-options', 'woo_enable_catalog_mode' );
    register_setting( 'litetheme-woo-functions-options', 'woo_show_catalog_qty' );
    register_setting( 'litetheme-woo-functions-options', 'woo_show_catalog_variation_options' );
    add_settings_section( 'litetheme-woo-functions', __('WooCommerce Functions'), null, 'woo_functions_settings' );
    add_settings_field( 'woo-enable-catalog-mode', __('Catalog Mode'), 'theme_woo_enable_catalog_mode', 'woo_functions_settings', 'litetheme-woo-functions' );
    add_settings_field( 'woo-show-catalog-qty', __('Catalog Quantity'), 'theme_woo_show_catalog_qty', 'woo_functions_settings', 'litetheme-woo-functions' );
    add_settings_field( 'woo-show-catalog-variation-options', __('Catalog Variation Options'), 'theme_woo_show_catalog_variation_options', 'woo_functions_settings', 'litetheme-woo-functions' );

    // Support Page
    register_setting( 'litetheme-support-options', 'post_formats' );
    register_setting( 'litetheme-support-options', 'custom_header' );
    register_setting( 'litetheme-support-options', 'custom_background' );
    add_settings_section( 'litetheme-theme-support', __('Theme Supports'), 'theme_support_options', 'theme_support_settings' );
    add_settings_field( 'post-formats', __('Post Formats'), 'theme_post_formats', 'theme_support_settings', 'litetheme-theme-support' );
    add_settings_field( 'custom-header', __('Custom Header'), 'theme_custom_header', 'theme_support_settings', 'litetheme-theme-support' );
    add_settings_field( 'custom-background', __('Custom Background'), 'theme_custom_background', 'theme_support_settings', 'litetheme-theme-support' );

    register_setting( 'litetheme-support-options', 'use_greek_to_slug' );
    add_settings_field( 'use-greek-to-slug', __('Use GreekToSlug'), 'theme_use_greek_to_slug', 'theme_support_settings', 'litetheme-theme-support' );
}

function theme_advanced_options() {
    echo __('Enable full customization of the theme');
}

function theme_header_options() {
    echo __('Header Settings');
}

function theme_layout_options() {
    echo __('Layout Settings');
}

function theme_footer_options() {
    echo __('Footer Settings');
}

function theme_social_options() {
    echo __('Social Settings');
}

function theme_support_options() {
    echo __('Enable Various Theme Support Options');
}


// Admin callbacks
function theme_enable_advanced() {
    $option = get_option( 'enable_advanced' );
    ?>
    <input type="checkbox" id="enable_advanced" class="checkbox-switch" name="enable_advanced" value="1" <?php echo ($option == 1) ? 'checked' : ''; ?> />
    <label for="enable_advanced"><?php echo __('Enable Advanced'); ?></label>
    <?php
}

function theme_style() {
    $option = get_option( 'theme_style' );
    $styles = glob( get_template_directory() . '/css/styles/style_*.css');
    foreach ($styles as $key => $style):
        $style = basename(esc_attr($style), '.css'); ?>
        <input type="radio" id="<?php echo $style; ?>" class="file_css" name="theme_style" value="<?php echo $style; ?>" <?php checked($option, $style); ?> />
        <label for="<?php echo $style; ?>"><?php echo $style; ?></label>
    <?php endforeach;
}

function theme_header_width() {
    $option = get_option( 'header_width' );
    ?>
    <input type="radio" id="header_width_grid" class="f-icon cont-grid" name="header_width" value="grid" <?php checked($option, 'grid'); ?> />
    <label for="header_width_grid"><?php echo __('Grid'); ?></label>
    <input type="radio" id="header_width_fluid" class="f-icon cont-fluid" name="header_width" value="fluid" <?php checked($option, 'fluid'); ?> />
    <label for="header_width_fluid"><?php echo __('Fluid'); ?></label>
    <?php
}

function theme_header_columns() {
    $option = get_option( 'header_columns' );
    ?>
    <input type="number" id="header_columns" class="" name="header_columns" value="<?php echo esc_attr($option); ?>" min="1" max="<?php echo THEME_MAX_COLS; ?>" placeholder="min: 1, max: <?php echo THEME_MAX_COLS; ?>" />
    <p class="description"><?php echo sprintf(__("Number of columns. 1 to %s."), THEME_MAX_COLS); ?></p>
    <?php
}

function theme_header_logo() {
    $option = get_option( 'header_logo' );
    $custom_logo = get_theme_mod('custom_logo');
    $header_logo = ($option === $custom_logo) ? $option : $custom_logo;
    if  (! empty($header_logo) ) : ?>
        <input type="button" id="header_logo_upload" class="button button-secondary" value="Change Logo" />
        <input type="button" id="header_logo_remove" class="button button-secondary" value="Remove" />
    <?php else: ?>
        <input type="button" id="header_logo_upload" class="button button-secondary" value="Upload Logo" />
    <?php endif; ?>
    <input type="hidden" id="header_logo" class="" name="header_logo" value="<?php echo $header_logo; ?>" />
    <p class="description">If no image is selected, default title will be used.</p>
    <img id="header_logo_preview" src="<?php echo ( ! empty($header_logo) ) ? wp_get_attachment_url( $header_logo ) : 'https://via.placeholder.com/150'; ?>" alt="Logo Preview" height="150"/>
    <?php
}

function theme_logo_position() {
    $option = get_option( 'logo_position' );
    ?>
    <input type="number" id="logo_position" class="" name="logo_position" value="<?php echo esc_attr($option); ?>" min="1" max="<?php echo THEME_MAX_COLS; ?>" placeholder="min: 1, max: <?php echo THEME_MAX_COLS; ?>" />
    <p class="description"><?php echo __("Represents the column to put the logo."); ?></p>
    <?php
}

function theme_menu_style() {
    $option = get_option( 'menu_style' );
    ?>
    <input type="radio" id="header_menu_offcanvas" class="f-icon nav-offcanvas" name="menu_style" value="offcanvas" <?php checked($option, 'offcanvas'); ?> />
    <label for="header_menu_offcanvas"><?php echo __('Offcanvas'); ?></label>

    <?php
}

function theme_sticky_menu() {
    $option = get_option( 'sticky_menu' );
    ?>
    <input type="checkbox" id="sticky_menu" class="checkbox-switch" name="sticky_menu" value="1" <?php echo ($option == 1) ? 'checked' : ''; ?> />
    <label for="sticky_menu"><?php echo __('Sticky on scroll'); ?></label>
    <?php
}

function theme_body_width() {
    $option = get_option( 'body_width' );
    ?>
    <input type="radio" id="body_width_grid" class="f-icon cont-grid" name="body_width" value="grid" <?php checked($option, 'grid'); ?> />
    <label for="body_width_grid"><?php echo __('Grid'); ?></label>
    <input type="radio" id="body_width_fluid" class="f-icon cont-fluid" name="body_width" value="fluid" <?php checked($option, 'fluid'); ?> />
    <label for="body_width_fluid"><?php echo __('Fluid'); ?></label>
    <?php
}

function theme_page_title() {
    $option = get_option( 'theme_page_title' );
    ?>
    <input type="checkbox" id="theme_page_title" class="checkbox-switch" name="theme_page_title" value="1" <?php echo ($option == 1) ? 'checked' : ''; ?> />
    <label for="theme_page_title"><?php echo __('Show Page Title'); ?></label>
    <?php
}

function theme_left_right_sidebar() {
    $options = get_option( 'theme_sidebars' );
    $sidebars = array('left', 'right');
    foreach ($sidebars as $sidebar): ?>
        <input type="checkbox" id="<?php echo $sidebar ?>_sidebar" class="checkbox-switch" name="theme_sidebars[<?php echo $sidebar; ?>]" value="1" <?php echo (isset($options[$sidebar]) && $options[$sidebar] == 1) ? 'checked' : ''; ?> />
        <label for="<?php echo $sidebar ?>_sidebar"><?php echo mb_convert_case($sidebar, MB_CASE_TITLE, "UTF-8"); ?> sidebar</label>
        <?php if ($sidebar !== end($sidebars)) echo '<br />'; ?>
    <?php endforeach;
}

function theme_footer_width() {
    $option = get_option( 'footer_width' );
    ?>
    <input type="radio" id="footer_width_grid" class="f-icon cont-grid" name="footer_width" value="grid" <?php checked($option, 'grid'); ?> />
    <label for="footer_width_grid"><?php echo __('Grid'); ?></label>
    <input type="radio" id="footer_width_fluid" class="f-icon cont-fluid" name="footer_width" value="fluid" <?php checked($option, 'fluid'); ?> />
    <label for="footer_width_fluid"><?php echo __('Fluid'); ?></label>
    <?php
}

function theme_footer_columns() {
    $option = get_option( 'footer_columns' );
    ?>
    <input type="number" id="footer_columns" class="" name="footer_columns" value="<?php echo esc_attr($option); ?>" min="1" max="<?php echo THEME_MAX_COLS; ?>" placeholder="min: 1, max: <?php echo THEME_MAX_COLS; ?>" />
    <p class="description"><?php echo sprintf(__("Number of columns. 1 to %s."), THEME_MAX_COLS); ?></p>
    <?php
}

function theme_store_address() {
    $store_address = get_option( 'store_address' );
    ?>
    <input type="text" id="store_address" class="" name="store_address" value="<?php echo esc_attr($store_address); ?>" placeholder="Store Address" />
    <p class="description">get_option('store_address')</p>
    <?php
}
function theme_store_email() {
    $store_email = get_option( 'store_email' );
    ?>
    <input type="email" id="store_email" class="" name="store_email" value="<?php echo esc_attr($store_email); ?>" placeholder="Store Email" />
    <p class="description">get_option('store_address')</p>
    <?php
}
function theme_store_phone_1() {
    $store_phone_1   = get_option( 'store_phone_1' );
    ?>
    <input type="text" id="store_phone_1" class="" name="store_phone_1" value="<?php echo esc_attr($store_phone_1); ?>" placeholder="Store Phone 1" />
    <p class="description">get_option('store_phone_1')</p>
    <?php
}
function theme_store_phone_2() {
    $store_phone_2   = get_option( 'store_phone_2' );
    ?>
    <input type="text" id="store_phone_2" class="" name="store_phone_2" value="<?php echo esc_attr($store_phone_2); ?>" placeholder="Store Phone 2" />
    <p class="description">get_option('store_phone_2')</p>
    <?php
}
function theme_facebook_id() {
    $facebook   = get_option( 'facebook_id' );
    ?>
    <input type="url" id="facebook_id" class="" name="facebook_id" value="<?php echo esc_attr($facebook); ?>" placeholder="Facebook" />
    <p class="description">get_option('facebook_id')</p>
    <?php
}
function theme_twitter_id() {
    $twitter    = get_option( 'twitter_id' );
    ?>
    <input type="url" id="twitter_id" class="" name="twitter_id" value="<?php echo esc_attr($twitter); ?>" placeholder="Twitter" />
    <p class="description">get_option('twitter_id')</p>
    <?php
}
function theme_googleplus_id() {
    $googleplus = get_option( 'twitter_id' );
    ?>
    <input type="url" id="googleplus_id" class="" name="googleplus_id" value="<?php echo esc_attr($googleplus); ?>" placeholder="Google+" />
    <p class="description">get_option('googleplus_id')</p>
    <?php
}
function theme_youtube_id() {
    $youtube    = get_option( 'youtube_id' );
    ?>
    <input type="url" id="youtube_id" class="" name="youtube_id" value="<?php echo esc_attr($youtube); ?>" placeholder="Youtube Channel" />
    <p class="description">get_option('youtube_id')</p>
    <?php
}
function theme_instagram_id() {
    $instagram  = get_option( 'instagram_id' );
    ?>
    <input type="url" id="instagram_id" class="" name="instagram_id" value="<?php echo esc_attr($instagram); ?>" placeholder="Instagram" />
    <p class="description">get_option('instagram_id')</p>
    <?php
}

// Blog callbacks
function theme_post_title() {
    $option = get_option( 'theme_post_title' );
    ?>
    <input type="checkbox" id="theme_post_title" class="checkbox-switch" name="theme_post_title" value="1" <?php echo ($option == 1) ? 'checked' : ''; ?> />
    <label for="theme_post_title"><?php echo __('Show Post Title'); ?></label>
    <?php
}
function theme_post_author() {
    $option = get_option( 'theme_post_author' );
    ?>
    <input type="checkbox" id="theme_post_author" class="checkbox-switch" name="theme_post_author" value="1" <?php echo ($option == 1) ? 'checked' : ''; ?> />
    <label for="theme_post_author"><?php echo __('Show Post Author'); ?></label>
    <?php
}

// Color callbacks
function theme_header_bg_color() {
    $option = get_option( 'header_bg_color' );
    ?>
    <input type="text" id="header_bg_color" class="color-field" name="header_bg_color" value="<?php echo $option; ?>" />
    <?php
}

function theme_header_text_color() {
    $option = get_option( 'header_text_color' );
    ?>
    <input type="text" id="header_text_color" class="color-field" name="header_text_color" value="<?php echo $option; ?>" />
    <?php
}

function theme_header_link_color() {
    $option = get_option( 'header_link_color' );
    ?>
    <input type="text" id="header_link_color" class="color-field" name="header_link_color" value="<?php echo $option; ?>" />
    <?php
}

function theme_nav_bg_color() {
    $option = get_option( 'nav_bg_color' );
    ?>
    <input type="text" id="nav_bg_color" class="color-field" name="nav_bg_color" value="<?php echo $option; ?>" />
    <?php
}

function theme_nav_text_color() {
    $option = get_option( 'nav_text_color' );
    ?>
    <input type="text" id="nav_text_color" class="color-field" name="nav_text_color" value="<?php echo $option; ?>" />
    <?php
}

function theme_nav_link_color() {
    $option = get_option( 'nav_link_color' );
    ?>
    <input type="text" id="nav_link_color" class="color-field" name="nav_link_color" value="<?php echo $option; ?>" />
    <?php
}

function theme_body_bg_color() {
    $option = get_option( 'body_bg_color' );
    ?>
    <input type="text" id="body_bg_color" class="color-field" name="body_bg_color" value="<?php echo $option; ?>" />
    <?php
}

function theme_body_text_color() {
    $option = get_option( 'body_text_color' );
    ?>
    <input type="text" id="body_text_color" class="color-field" name="body_text_color" value="<?php echo $option; ?>" />
    <?php
}

function theme_body_link_color() {
    $option = get_option( 'body_link_color' );
    ?>
    <input type="text" id="body_link_color" class="color-field" name="body_link_color" value="<?php echo $option; ?>" />
    <?php
}

function theme_footer_bg_color() {
    $option = get_option( 'footer_bg_color' );
    ?>
    <input type="text" id="footer_bg_color" class="color-field" name="footer_bg_color" value="<?php echo $option; ?>" />
    <?php
}

function theme_footer_text_color() {
    $option = get_option( 'footer_text_color' );
    ?>
    <input type="text" id="footer_text_color" class="color-field" name="footer_text_color" value="<?php echo $option; ?>" />
    <?php
}

function theme_footer_link_color() {
    $option = get_option( 'footer_link_color' );
    ?>
    <input type="text" id="footer_link_color" class="color-field" name="footer_link_color" value="<?php echo $option; ?>" />
    <?php
}
function theme_copyright_text() {
    $copyright_text  = get_option( 'copyright_text' );
    ?>
    <textarea type="text" id="copyright_text" cols="100" rows="5" class="" name="copyright_text" value="<?php echo esc_attr($copyright_text); ?>"
              placeholder="Copyright Text" /><?php echo esc_attr($copyright_text); ?></textarea>
    <p class="description">[get_data data="copyright_text"]</p>
    <?php
}

// WooCommerce callbacks
function theme_woo_enable_catalog_mode() {
    $option = get_option( 'woo_enable_catalog_mode' );
    ?>
    <input type="checkbox" id="woo_enable_catalog_mode" class="checkbox-switch" name="woo_enable_catalog_mode" value="1" <?php echo ($option == 1) ? 'checked' : ''; ?> />
    <label for="woo_enable_catalog_mode"><?php echo __('Enable Catalog Mode'); ?></label>
    <?php
}

function theme_woo_show_catalog_qty() {
    $option = get_option( 'woo_show_catalog_qty' );
    ?>
    <input type="checkbox" id="woo_show_catalog_qty" class="checkbox-switch" name="woo_show_catalog_qty" value="1" <?php echo ($option == 1) ? 'checked' : ''; ?> />
    <label for="woo_show_catalog_qty"><?php echo __('Show Catalog Quantity Box'); ?></label>
    <?php
}

function theme_woo_show_catalog_variation_options() {
    $option = get_option( 'woo_show_catalog_variation_options' );
    ?>
    <input type="checkbox" id="woo_show_catalog_variation_options" class="checkbox-switch" name="woo_show_catalog_variation_options" value="1" <?php echo ($option == 1) ? 'checked' : ''; ?> />
    <label for="woo_show_catalog_variation_options"><?php echo __('Show Catalog Variation Options'); ?></label>
    <p class="description"><?php _e('Currently not supporting AJAX add to cart.', 'litetheme'); ?></p>
    <?php
}

// Support callbacks
function theme_post_formats() {
    $options = get_option( 'post_formats' );
    $formats = array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' );
    foreach ($formats as $format): ?>
        <input type="checkbox" id="<?php echo $format; ?>" class="checkbox-switch" name="post_formats[<?php echo $format; ?>]" value="1" <?php echo (isset($options[$format]) && $options[$format] == 1 ? 'checked' : ''); ?> />
        <label for="<?php echo $format; ?>" ><?php echo $format; ?></label>
        <?php if ($format !== end($formats)) echo '<br />'; ?>
    <?php endforeach;
}

function theme_custom_header() {
    $option = get_option( 'custom_header' ); ?>
    <input type="checkbox" id="custom_header" class="checkbox-switch" name="custom_header" value="1" <?php echo ($option == 1) ? 'checked' : ''; ?> /><label for="custom_header" ><?php _e('Enable Custom Header', 'litetheme'); ?></label>
    <?php
}

function theme_custom_background() {
    $option = get_option( 'custom_background' ); ?>
    <input type="checkbox" id="custom_background" class="checkbox-switch" name="custom_background" value="1" <?php echo ($option == 1) ? 'checked' : ''; ?> /><label for="custom_background" ><?php _e('Enable Custom Background', 'litetheme'); ?></label>
    <?php
}

function theme_use_greek_to_slug() {
    $option = get_option( 'use_greek_to_slug' );
    ?>
    <input type="checkbox" id="use_greek_to_slug" class="checkbox-switch" name="use_greek_to_slug" value="1" <?php echo ($option == 1) ? 'checked' : ''; ?> />
    <label for="use_greek_to_slug"><?php echo __('Use GreekToSlug'); ?></label>
    <p class="description"><?php _e('Recommended. Changes post slugs and filenames to greeklish, preventing missing non latin file links and and non latin urls', 'litetheme'); ?></p>
    <?php
}

function sync_header_logo_to_custom_logo($input) {
    $header_logo = $input;
    $custom_logo = get_theme_mod('custom_logo');
    if ($header_logo !== $custom_logo) {
        $logo_id = $header_logo;
        set_theme_mod('custom_logo', $logo_id);
    }
    return $input;
}

# Page Functions
function theme_settings_page() {
    require_once( get_template_directory() . '/admin/includes/templates/admin.php' );
}

function theme_blog_page() {
    require_once( get_template_directory() . '/admin/includes/templates/blog.php' );
}

function theme_colors_page() {
    require_once( get_template_directory() . '/admin/includes/templates/colors.php' );
}

function woocommerce_page() {
    require_once( get_template_directory() . '/admin/includes/templates/woocommerce.php' );
}

function theme_support_page() {
    require_once( get_template_directory() . '/admin/includes/templates/support_options.php' );
}

function theme_css_page() {
    require_once( get_template_directory() . '/admin/includes/templates/custom_css.php' );
}

# Hooks
add_action('admin_enqueue_scripts', 'admin_styles', 15);
add_action('admin_enqueue_scripts', 'admin_scripts');
add_action('admin_menu', 'theme_add_admin_page');