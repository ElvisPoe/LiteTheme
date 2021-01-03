<?php

/*
** Theme Support
*/

if (get_option('enable_advanced') == 1) {
    # Enable post formats
    $options = get_option( 'post_formats' );
    $formats = array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' );
    $enable = array();
    foreach ($formats as $format) {
        if ( isset($options[$format]) && $options[$format] == 1 ) {
            $enable[] = $format;
        }
    }
    if ( isset($options) ) {
        add_theme_support('post-formats', $enable);
    }

    # Enable custom header
    $header = get_option( 'custom_header' );
    if ( isset($header) ) {
        add_theme_support('custom-header');
    }

    # Enable custom background
    $background = get_option( 'custom_background' );
    if ( isset($background) ) {
        add_theme_support('custom-background');
    }
}
?>