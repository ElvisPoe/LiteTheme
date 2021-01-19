<?php

/* Add a custom Post Type - Benefits */
add_action( 'init', 'team_post_type' );
function team_post_type() {
    $labels = array(
        'name'               => __( 'Team members', 'team' ),
        'singular_name'      => __( 'Team member', 'team' ),
        'add_new'            => __( 'Add New', 'team' ),
        'add_new_item'       => __( 'Add New Team Member' ),
        'edit_item'          => __( 'Edit team member' ),
        'new_item'           => __( 'New team member' ),
        'all_items'          => __( 'All team members' ),
        'view_item'          => __( 'View team member' ),
        'search_items'       => __( 'Search team members' ),
        'not_found'          => __( 'No team member found' ),
        'not_found_in_trash' => __( 'No team member found in the Trash' ),
        'menu_name'          => 'Team'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Team members',
        'public'        => true,
        'menu_icon'     => 'dashicons-admin-users',
        'menu_position' => 25,
        'supports'      => array( 'title', 'editor', 'thumbnail'),
        'has_archive'   => true,
        'taxonomies'    => array('category'),
    );
    register_post_type( 'team-member', $args );
}


/*
 *
 * Custom Field for Team Member
 *
 * */

add_action( 'add_meta_boxes', 'team_member_add_meta_box' );
function team_member_add_meta_box() {
//this will add the metabox for the member post type
    add_meta_box(
        'team_member_data',
        __( 'Team Member Details', 'litetheme' ),
        'team_member_data_function',
        'team-member',
        'normal',
        'high'
    );
}

/**
 * Prints the box content.
 * @param WP_Post $post The object for the current post/page.
 */
add_action( 'save_post', 'member_save_meta_box_data' );
function team_member_data_function( $post ) {

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'member_save_meta_box_data', 'member_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $value_team_member_phone = get_post_meta( $post->ID, 'team_member_phone', true );
    $value_team_member_company = get_post_meta( $post->ID, 'team_member_company', true );

    echo "<label for='member_phone'>Phone Number</label>";
    echo '<input type="text" id="team_member_phone" name="team_member_phone" value="' . esc_attr( $value_team_member_phone ) . '" style="width: 100%" />';

    echo "<label for='member_company'>Company</label>";
    echo '<input type="text" id="team_member_company" name="team_member_company" value="' . esc_attr( $value_team_member_company ) . '" style="width: 100%" />';
}

/**
 * When the post is saved, saves our custom data.
 * @param int $post_id The ID of the post being saved.
 */
function member_save_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['member_meta_box_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['member_meta_box_nonce'], 'member_save_meta_box_data' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    if ( ! isset( $_POST['team_member_phone'] ) ) {
        return;
    }
    if ( ! isset( $_POST['team_member_company'] ) ) {
        return;
    }

    update_post_meta( $post_id, 'team_member_phone', sanitize_text_field( $_POST['team_member_phone'] ) );
    update_post_meta( $post_id, 'team_member_company', sanitize_text_field( $_POST['team_member_company'] ) );
}