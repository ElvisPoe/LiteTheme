<?php

/**
 * Shortcodes
 */

/* Get Main Site URL Everywhere */
add_shortcode('site_url', 'fm_site_url');
function fm_site_url($atts) {
    $atts = shortcode_atts( array(
        'uri' => '',
    ), $atts);
    return site_url( $atts['uri'] );
}