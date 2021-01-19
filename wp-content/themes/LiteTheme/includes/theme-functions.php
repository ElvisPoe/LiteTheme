<?php
if ( ! defined('THEME_VERSION') ) {
    define('THEME_VERSION', wp_get_theme()->get( 'Version' ));
}

if ( ! defined('THEME_MAX_COLS') ) {
    define('THEME_MAX_COLS', 6);
}

if ( ! defined('DS') ) {
    define('DS', DIRECTORY_SEPARATOR);
}

// Include Core Files
require get_template_directory() . '/admin/functions.php';
require get_template_directory() . '/admin/theme-support.php';
require get_template_directory() . '/admin/woocommerce.php';
require get_template_directory() . '/includes/woocommerce/functions.php';
require get_template_directory() . '/includes/widgets.php';
require get_template_directory() . '/includes/metaboxes.php';
require get_template_directory() . '/includes/shortcodes.php';


// Include Custom Post Types
require get_template_directory() . '/includes/custom-post-types/benefits.php';
require get_template_directory() . '/includes/custom-post-types/team.php';

// Include Less
require get_template_directory() . '/includes/less/theless.php';

if ( ! current_user_can('manage_options') ) {
    show_admin_bar(false);
}

# Enable title tag
add_theme_support( 'title-tag' );

# Enable custom logo
add_theme_support('custom-logo');

# Enable html5
add_theme_support('html5');

# Enable thumbnails
add_theme_support('post-thumbnails');

# Enable custom header uploads
add_theme_support('custom-header-uploads');

# Enable title tag
add_theme_support('title-tag');

# Custom image sizes
add_image_size('hd', 1280, 768, false);
add_image_size('full_hd', 1920, 1080, false);
add_image_size('blog_image_small', 800, 400, true);
add_image_size('blog_image', 1200, 600, true);

# Enable selective refresh for widgets
add_theme_support( 'customize-selective-refresh-widgets' );

# Theme enable menus
function register_theme_menus() {
    register_nav_menus(
        array(
            'main-menu' => __('Main Menu')
        )
    );
}

function menu_item_class($classes = array(), $menu_item = false) {
    $classes[] = 'nav-item';

    if ( in_array('current-menu-item', $classes) ) {
        $classes[] = 'active';
    }
    return $classes;
}

function menu_link_atts($atts, $item, $args) {
    if ($args->theme_location == 'main-menu') {
        $atts['class'] = 'nav-link';
    }
    return $atts;
}

# Styles
function theme_styles() {
    wp_register_style('bootstrap', get_template_directory_uri() . '/css/included/bootstrap.min.css', false, '4.3.1', 'all');

    wp_register_style('fontawesome', get_template_directory_uri() . '/css/included/fontawesome-all.min.css', false, '5.8.1', 'all');
    wp_register_style('theme_style', get_template_directory_uri() . '/css/included/theme.css', false, THEME_VERSION, 'all');

    wp_register_style('theme_default_style', get_template_directory_uri() . '/css/styles/style_theme.css', false, THEME_VERSION, 'all');

    $theme_style = get_option('theme_style');

    if (empty($theme_style)) {
        wp_enqueue_style('theme_default_style');
    }
    if ($theme_style) {
        $style_after_path = '/css/styles/' . $theme_style . '.css';
        $style_ver = @filemtime(get_template_directory() . $style_after_path);
        wp_register_style($theme_style, get_template_directory_uri() . $style_after_path, false, $style_ver, 'all');
    }

    wp_enqueue_style('bootstrap');
    wp_enqueue_style('bootstrap-map');
    wp_enqueue_style('fontawesome');
    wp_enqueue_style('theme_style');
    if ($theme_style) {
        wp_enqueue_style($theme_style);
    }
}

# Scripts
function theme_scripts() {
    wp_register_script('jquery', includes_url() . '/js/jquery/jquery.js', false, NULL, true);
    wp_register_script('popper', get_template_directory_uri() . '/js/popper.min.js', array('jquery'), '1.14.4', true);
    wp_register_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '4.3.1', true);
    wp_register_script('theme_script', get_template_directory_uri() . '/js/script.js', array('jquery'), THEME_VERSION, true);

    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap');
    wp_enqueue_script('theme_script');
}

# Hooks
add_action('wp_enqueue_scripts', 'theme_styles');
add_action('wp_enqueue_scripts', 'theme_scripts');
add_action('init', 'register_theme_menus');
add_action('after_switch_theme', 'apply_defaults');

function apply_defaults() {
    $args = array(
        'post_type' => 'any',
        'posts_per_page' => '-1',
    );

    $result = new WP_Query($args);
    if ($result->have_posts()) {
        while($result->have_posts()) {
            $result->the_post();
            $meta = get_post_meta(get_the_ID());

            if (get_post_type() == 'post') {
                if (! isset($meta['post_page_title'])) {
                    update_post_meta( get_the_ID(), 'post_page_title', sanitize_text_field( wp_unslash( 'default' ) ) );
                }

                if (! isset($meta['post_page_author'])) {
                    update_post_meta( get_the_ID(), 'post_page_author', sanitize_text_field( wp_unslash( 'default' ) ) );
                }
            } elseif (get_post_type() == 'page') {
                if (! isset($meta['container_width'])) {
                    update_post_meta( get_the_ID(), 'container_width', sanitize_text_field( wp_unslash( 'default' ) ) );
                }
                if (! isset($meta['page_title'])) {
                    update_post_meta( get_the_ID(), 'page_title', sanitize_text_field( wp_unslash( 'default' ) ) );
                }
                if (! isset($meta['hero_image'])) {
                    update_post_meta( get_the_ID(), 'hero_image', sanitize_text_field( wp_unslash( '' ) ) );
                }
            }
            if (! isset($meta['sidebars'])) {
                update_post_meta( get_the_ID(), 'sidebars', sanitize_text_field( wp_unslash( 'default' ) ) );
            }
        }
    }
    wp_reset_postdata();

}

function has_active_sidebar($sidebar) {
    $queried_id = get_queried_object_id();
    $meta = get_post_meta($queried_id);

    $part = preg_split('/-|_/', $sidebar)[0];

    if ( is_active_sidebar($sidebar) && ( in_array($sidebar, get_option('theme_sidebars')) || in_array($part, $meta['sidebars']) || $meta['sidebars'][0] === 'both' ) ) {
        return true;
    }

    return false;
}

if (function_exists('greekToSlug')) {
    //add_action('add_attachment', 'renameAttachmentToLatin');
    add_filter('sanitize_file_name', 'filenameToLatin', 10, 1);
    add_filter('sanitize_title', 'greekToSlug', 5, 1);
}

add_filter('nav_menu_css_class', 'menu_item_class', 10, 2);
add_filter('nav_menu_link_attributes', 'menu_link_atts', 10, 3);

# Theme Helper Functions
function callback_exists($hook_tag, $callback, $priority) {
    global $wp_filter;
    if ( ! empty($priority) )
        return isset( $wp_filter[$hook_tag]->callbacks[$priority][$callback] );
    else {
        if ( isset($wp_filter[$hook_tag]->callbacks) ) {
            foreach($wp_filter[$hook_tag]->callbacks as $priority_key => $callbacks) {
                if ( isset($callbacks[$callback]) )
                    return true;
            }
        }
    }
    return false;
}

function container_width($section = 'body') {
    $global    = get_option($section .'_width');
    $container = get_post_meta(get_the_ID(), 'container_width', true);
    if ( $section === 'body' && ( ! empty($container) && $container !== 'default' ) ) {
        if ($container == 'grid')
            return 'container';
        elseif ($container == 'fluid')
            return 'container-fluid';
    } else {
        if ($global == 'grid')
            return 'container';
        elseif ($global == 'fluid')
            return 'container-fluid';
    }
    return '';
}

function menu_style() {
    $menu = get_option('menu_style');

    return esc_attr($menu);
}

function is_title_shown($page_id = null) {
    if ( empty($page_id) || ! is_numeric($page_id) )
        $page_id = get_queried_object_id();
    $meta = get_post_meta($page_id);
    if (! empty($meta['page_title'][0])) {
        if ( $meta['page_title'][0] == 1 || ( $meta['page_title'][0] == 'default' && !empty( get_option('theme_page_title') ) ) ) {
            return true;
        }
    }
    elseif (! empty($meta['post_page_title'][0])) {
        if ( $meta['post_page_title'][0] == 1 || ( $meta['post_page_title'][0] == 'default' && !empty( get_option('theme_post_title') ) ) ) {
            return true;
        }
    }
    return false;
}

function is_author_shown($page_id = null) {
    if ( empty($page_id) || ! is_numeric($page_id) )
        $page_id = get_queried_object_id();
    $meta = get_post_meta($page_id);
    if (! empty($meta['post_page_author'][0])) {
        if ( $meta['post_page_author'][0] == 1 || ( $meta['post_page_author'][0] == 'default' && !empty( get_option('theme_post_author') ) ) ) {
            return true;
        }
    }
    return false;
}

function get_image_id_from_url($url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url));
    return $attachment[0];
}

function column_spaning($total_columns, $offset = 0, $index = 0) {
    $span = floor(12 / $total_columns);
    $cols = '';
    if ($total_columns != 3 && $total_columns % 2 != 0) {
        if ($index > 1) {
            $cols .= 'col-sm-6';
            $cols .= ' col-md-' . ($span + 1);
        }
        else {
            $cols .= 'col-sm-12';
            $cols .= ' col-md-' . $span;
        }
    }
    else{
        $cols .= 'col-sm-6';
        $cols .= ' col-md-' . $span;
    }
    if ($offset > 0) {
        if ($total_columns % 2 != 0 && $index > 1) {
            $cols .= ' offset-md-' . ($span * $offset - 1);
        }
        else {
            $cols .= ' offset-md-' . $span * $offset;
        }
    }
    return $cols;
}

function contentColSpaning() {
    if (has_active_sidebar('left-sidebar') && has_active_sidebar('right-sidebar')) {
        $cols = 'col-md-6';
    } elseif (has_active_sidebar('left-sidebar') || has_active_sidebar('right-sidebar')) {
        $cols = 'col-md-9';
    } else {
        $cols = 'col-md-12';
    }
    return $cols;
}

function filenameToLatin($filename) {
    $path = pathinfo($filename);
    return str_replace($path['filename'], sanitize_title($path['filename']), $filename);
}


function greekToSlug($str) {
    $greekChars = array(
        'Α','Β','Γ','Δ','Ε','Ζ','Η','Θ','Ι','Κ','Λ','Μ','Ν','Ξ','Ο','Π','Ρ','Σ','Τ','Υ','Φ','Χ','Ψ','Ω',
        'α','β','γ','δ','ε','ζ','η','θ','ι','κ','λ','μ','ν','ξ','ο','π','ρ','σ','τ','υ','φ','χ','ψ','ω','ς',
    );
    $englishChars = array(
        'a', 'b', 'g', 'd', 'e', 'z', 'i', 'th', 'i', 'k', 'l', 'm', 'n', 'x', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ps', 'o',
        'a', 'b', 'g', 'd', 'e', 'z', 'i', 'th', 'i', 'k', 'l', 'm', 'n', 'x', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ps', 'o', 's'
    );

    $urlLower = strtolower(str_replace($greekChars, $englishChars, $str));
    $noSpace = str_replace(' ', '-', $urlLower);
    $noSpace1 = str_replace('---', '-', $noSpace);
    $noSpace2 = str_replace('--', '-', $noSpace1);
    $noSpace3 = str_replace('(', '', $noSpace2);
    $noSpace4 = str_replace(')', '', $noSpace3);
    $noSpace5 = str_replace('°', '', $noSpace4);
    $noSpace6 = str_replace('+', '', $noSpace5);
    $noSpace7 = str_replace('’', '', $noSpace6);
    $noSpace8 = str_replace('.', '-', $noSpace7);
    $final = str_replace('/', '-', $noSpace8);

    return $final;
}

// REMOVE WP EMOJI STYLES AND SCRIPTS
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Add Less Compile button in admin bar
add_action( 'admin_bar_menu', 'add_link_to_admin_bar',999 );
function add_link_to_admin_bar($admin_bar) {
    $args = array(
        'id'     => 'less-compile',
        'title'  => 'Less Compile',
        'href'   => esc_url( home_url() . '/theless' ),
        'meta'   => array('target' => '_blank')
    );
    $admin_bar->add_node( $args );
}

// If there is a logo - Show it in Admin Login Page
if(has_custom_logo()){
    function custom_wplogin_logo() {
        $image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' );
        ?>
        <style type='text/css'>
            #login h1 a, .login h1 a {
                background-image: url(<?= $image[0] ?>);
                width: auto;
                background-size: contain;
                height: 150px;
                background-repeat: no-repeat;
                pointer-events: none;
            }
        </style>
    <?php }
    add_action( 'login_enqueue_scripts', 'custom_wplogin_logo' );
}