<?php

/* Add a custom Post Type - Benefits */
add_action( 'init', 'benefits_post_type' );
function benefits_post_type() {
    $labels = array(
        'name'               => __( 'Benefits', 'benefits' ),
        'singular_name'      => __( 'Benefit', 'benefit' ),
        'add_new'            => __( 'Add New', 'benefit' ),
        'add_new_item'       => __( 'Add New Benefit' ),
        'edit_item'          => __( 'Edit benefit' ),
        'new_item'           => __( 'New benefit' ),
        'all_items'          => __( 'All benefits' ),
        'view_item'          => __( 'View benefit' ),
        'search_items'       => __( 'Search benefits' ),
        'not_found'          => __( 'No benefits found' ),
        'not_found_in_trash' => __( 'No benefits found in the Trash' ),
        'menu_name'          => 'Benefits'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Benefits for Course Tabs',
        'public'        => true,
        'menu_icon'     => 'dashicons-info',
        'menu_position' => 25,
        'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', ),
        'has_archive'   => true,
        'taxonomies'    => array('category'),
    );
    register_post_type( 'benefit', $args );
}
