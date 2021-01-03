<?php

# Custom Meta Fields For Post Pages etc.
function theme_add_meta_box() {
    $screens = array('page');
    foreach ($screens as $screen) {
        add_meta_box(
            'theme_page_width',
            __('Layout'),
            'theme_page_width_layout',
            $screen,
            'side',
            'core'
        );
    }

    foreach ($screens as $screen) {
        add_meta_box(
            'theme_page_title',
            __('Layout'),
            'theme_page_title_layout',
            $screen,
            'advanced',
            'high'
        );
    }

    foreach ($screens as $screen) {
        add_meta_box(
            'theme_page_hero',
            __('Layout'),
            'theme_page_hero_layout',
            $screen,
            'advanced',
            'core'
        );
    }

    $screens = get_post_types('', 'names');
    foreach ($screens as $screen) {
        add_meta_box(
            'theme_sidebars',
            __('Layout'),
            'theme_sidebars_layout',
            $screen,
            'side',
            'core'
        );
    }

    $screens = array('post');
    foreach ($screens as $screen) {
        add_meta_box(
            'theme_post_title',
            __('Layout'),
            'theme_post_title_layout',
            $screen,
            'advanced',
            'high'
        );
    }

    foreach ($screens as $screen) {
        add_meta_box(
            'theme_post_author',
            __('Layout'),
            'theme_post_author_layout',
            $screen,
            'advanced',
            'core'
        );
    }
}

add_action('add_meta_boxes', 'theme_add_meta_box');

# Meta Callback Render Functions
function theme_page_width_layout($post) {
    wp_nonce_field( basename(__FILE__), 'theme_meta_box_nonce' );
    if ( metadata_exists( 'post', $post->ID, 'container_width' ) )
        $container_width = esc_attr( get_post_meta( $post->ID, 'container_width', true ) );
    else
        $container_width = 'default';
    ?>
    <div>
        <label for="container_width"><?php echo __('Container Width'); ?></label><br />
        <input type="radio" id="container_width_default" class="f-icon cont-default" name="container_width" value="default" <?php checked($container_width, 'default'); ?> />
        <label for="container_width_default"><?php echo __('Default'); ?></label>
        <input type="radio" id="container_width_grid" class="f-icon cont-grid" name="container_width" value="grid" <?php checked($container_width, 'grid'); ?> />
        <label for="container_width_grid"><?php echo __('Grid'); ?></label>
        <input type="radio" id="container_width_fluid" class="f-icon cont-fluid" name="container_width" value="fluid" <?php checked($container_width, 'fluid'); ?> />
        <label for="container_width_fluid"><?php echo __('Fluid'); ?></label>
    </div>
    <?php
}

function theme_page_title_layout($post) {
    wp_nonce_field( basename(__FILE__), 'theme_meta_box_nonce' );
    if ( metadata_exists( 'post', $post->ID, 'page_title' ) )
        $page_title = esc_attr( get_post_meta( $post->ID, 'page_title', true ) );
    else
        $page_title = 'default';
    ?>
    <div>
        <label for="page_title"><?php echo __('Page Title'); ?></label><br />
        <input type="checkbox" id="page_title" class="checkbox-switch" name="page_title" value="1" <?php echo ($page_title == 1) ? 'checked' : ''; ?> />
        <label for="page_title"><?php echo __('Show Page Title'); ?></label><br />
        <input type="checkbox" id="theme_page_title_default" class="" name="page_title" value="default" <?php echo ($page_title == 'default') ? 'checked' : ''; ?> />
        <label for="theme_page_title_default"><?php echo __('Use Theme Default'); ?></label>
    </div>
    <?php
}

function theme_page_hero_layout($post) {
    wp_nonce_field( basename(__FILE__), 'theme_meta_box_nonce' );
    $hero_image = esc_attr( get_post_meta( $post->ID, 'hero_image', true ) ); ?>
    <div>
        <img id="hero_image_preview" src="<?php echo ( ! empty($hero_image) ) ? wp_get_attachment_url($hero_image) : ''; ?>" alt="Hero Image Preview" style="width: 150px; max-height: 50px;" />
    </div>
    <?php
    if  (! empty($hero_image) ) : ?>
        <input type="button" id="hero_image_upload" class="button button-secondary" value="Change Hero Image" />
        <input type="button" id="hero_image_remove" class="button button-secondary" value="Remove" />
    <?php else: ?>
        <input type="button" id="hero_image_upload" class="button button-secondary" value="Upload Hero Image" />
    <?php endif; ?>
    <input type="hidden" id="hero_image" class="" name="hero_image" value="<?php echo $hero_image; ?>" />
    <p class="description">Image will be shown at the top of the page content.</p>
    <?php
}

function theme_sidebars_layout($post) {
    wp_nonce_field( basename(__FILE__), 'theme_meta_box_nonce' );
    if ( metadata_exists( 'post', $post->ID, 'sidebars' ) )
        $sidebars = esc_attr( get_post_meta( $post->ID, 'sidebars', true ) );
    else
        $sidebars = 'default';
    ?>
    <div>
        <label for="theme_sidebars"><?php echo __('Sidebars'); ?></label><br />
        <input type="radio" id="default_sidebar" class="checkbox-switch" name="sidebars" value="default" <?php checked($sidebars, 'default'); ?> />
        <label for="default_sidebar"><?php echo __('Default'); ?></label><br />
        <input type="radio" id="left_sidebar" class="checkbox-switch" name="sidebars" value="left" <?php checked($sidebars, 'left'); ?> />
        <label for="left_sidebar"><?php echo __('Left'); ?></label><br />
        <input type="radio" id="right_sidebar" class="checkbox-switch" name="sidebars" value="right" <?php checked($sidebars, 'right'); ?> />
        <label for="right_sidebar"><?php echo __('Right'); ?></label><br />
        <input type="radio" id="both_sidebars" class="checkbox-switch" name="sidebars" value="both" <?php checked($sidebars, 'both'); ?> />
        <label for="both_sidebars"><?php echo __('Both'); ?></label>
    </div>
    <?php
}

function theme_post_title_layout($post) {
    wp_nonce_field( basename(__FILE__), 'theme_meta_box_nonce' );
    if ( metadata_exists( 'post', $post->ID, 'post_page_title' ) )
        $post_page_title = esc_attr( get_post_meta( $post->ID, 'post_page_title', true ) );
    else
        $post_page_title = 'default';
    ?>
    <div>
        <label for="post_page_title"><?php echo __('Post Title'); ?></label><br />
        <input type="checkbox" id="post_page_title" class="checkbox-switch" name="post_page_title" value="1" <?php echo ($post_page_title == 1) ? 'checked' : ''; ?> />
        <label for="post_page_title"><?php echo __('Show Post Title'); ?></label><br />
        <input type="checkbox" id="theme_post_title_default" class="" name="post_page_title" value="default" <?php echo ($post_page_title == 'default') ? 'checked' : ''; ?> />
        <label for="theme_post_title_default"><?php echo __('Use Theme Default'); ?></label>
    </div>
    <?php
}

function theme_post_author_layout($post) {
    wp_nonce_field( basename(__FILE__), 'theme_meta_box_nonce' );
    if ( metadata_exists( 'post', $post->ID, 'post_page_author' ) )
        $post_page_author = esc_attr( get_post_meta( $post->ID, 'post_page_author', true ) );
    else
        $post_page_author = 'default';
    ?>
    <div>
        <label for="post_page_author"><?php echo __('Post Author'); ?></label><br />
        <input type="checkbox" id="post_page_author" class="checkbox-switch" name="post_page_author" value="1" <?php echo ($post_page_author == 1) ? 'checked' : ''; ?> />
        <label for="post_page_author"><?php echo __('Show Post Author'); ?></label><br />
        <input type="checkbox" id="theme_post_author_default" class="" name="post_page_author" value="default" <?php echo ($post_page_author == 'default') ? 'checked' : ''; ?> />
        <label for="theme_post_author_default"><?php echo __('Use Theme Default'); ?></label>
    </div>
    <?php
}

# Meta Field Save
function theme_meta_box_save($post_id) {
    if ( isset($_POST['theme_meta_box_nonce']) && ! wp_verify_nonce( $_POST['theme_meta_box_nonce'], basename(__FILE__) ) )
        return $post_id;

    if (isset($_POST['post_type']) && $_POST['post_type'] == 'page') {
        if (! current_user_can('edit_page', $post_id))
            return $post_id;
    }
    else {
        if (! current_user_can('edit_post', $post_id))
            return $post_id;
    }

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;

    if ( isset($_POST['post_type']) ) {
        // meta defaults
        if ($_POST['post_type'] == 'page') {
            $container_width = $_POST['container_width'];
            $page_title = $_POST['page_title'];
            $hero_image = $_POST['hero_image'];

            // Sanitize and save meta values
            update_post_meta( $post_id, 'container_width', sanitize_text_field( wp_unslash( $container_width ) ) );
            update_post_meta( $post_id, 'page_title', sanitize_text_field( wp_unslash( $page_title ) ) );
            update_post_meta( $post_id, 'hero_image', sanitize_text_field( wp_unslash( $hero_image ) ) );
        }
        elseif ($_POST['post_type'] == 'post') {
            $post_page_title = $_POST['post_page_title'];
            $post_page_author = $_POST['post_page_author'];

            // Sanitize and save meta values
            update_post_meta( $post_id, 'post_page_title', sanitize_text_field( wp_unslash( $post_page_title ) ) );
            update_post_meta( $post_id, 'post_page_author', sanitize_text_field( wp_unslash( $post_page_author ) ) );
        }

        $sidebars = $_POST['sidebars'];

        // Sanitize and save meta values
        update_post_meta( $post_id, 'sidebars', sanitize_text_field( wp_unslash( $sidebars ) ) );
    }
}

add_action('save_post', 'theme_meta_box_save');