<?php

# Widget Areas
function theme_widgets_init() {
    register_sidebar( array(
        'name'          => 'Sidebar',
        'id'            => 'sidebar-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>'
    ) );

    $header_columns = (get_option('header_columns') < 1 || get_option('header_columns') > THEME_MAX_COLS) ? 4 : get_option('header_columns');
    if ( ! empty($header_columns) ) {
        foreach( range( 1, intval( $header_columns ) ) as $col) {
            register_sidebar( array(
                'name'          => 'Header ' . $col,
                'id'            => 'header-' . $col,
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '',
                'after_title'   => ''
            ) );
        }
    }

    $footer_columns = (get_option('footer_columns') < 1 || get_option('footer_columns') > THEME_MAX_COLS) ? 4 : get_option('footer_columns');
    if ( ! empty($footer_columns) ) {
        foreach( range( 1, intval( $footer_columns ) ) as $col) {
            register_sidebar( array(
                'name'          => 'Footer ' . $col,
                'id'            => 'footer-' . $col,
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h4 class="widget-title">',
                'after_title'   => '</h4>'
            ) );
        }
    }
}
add_action('widgets_init', 'theme_widgets_init');

/* Custom Widgets */
register_sidebar( array(
    'name'          => 'Call Us Product Page',
    'id'            => 'call-us-product-page',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="widget-title">',
    'after_title'   => '</h4>'
) );