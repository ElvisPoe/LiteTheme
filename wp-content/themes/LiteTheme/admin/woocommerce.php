<?php

/*
** WooCommerce functionalities
*/

if ( get_option('enable_advanced') == 1 && class_exists('WooCommerce') ) {
    if ( get_option('woo_enable_catalog_mode') == 1 ) {
        add_action( 'init', 'custom_enable_catalog_mode', 10 );
    }
}