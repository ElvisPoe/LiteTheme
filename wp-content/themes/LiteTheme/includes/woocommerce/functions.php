<?php
if (class_exists('WooCommerce')) {
    /**
    * Add woocommerce support (Recommended).
    */
    function theme_add_woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }

    /**
     * Override loop template and show quantities next to add to cart buttons
     */
    function quantity_inputs_for_woocommerce_loop_add_to_cart_link( $html, $product ) {
    	if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
    		$html = '<form action="' . esc_url( $product->add_to_cart_url() ) . '" class="cart" method="post" enctype="multipart/form-data">';
    		$html .= woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->get_stock_quantity(), 'input_value' => 1 ), $product, false );
    		$html .= '<button type="submit" class="button alt">' . esc_html( $product->add_to_cart_text() ) . '</button>';
    		$html .= '</form>';
    	}
    	return $html;
    }

    /**
    * Filter product quantity
    */
    function custom_woocommerce_available_variation( $args ) {
    	$args['min_qty'] = 0;
    	return $args;
    }

    /**
    * Add product variations to loop
    */
    function change_add_to_cart() {
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
        if ( ! callback_exists('init', 'custom_enable_catalog_mode', 10) ) {
            add_action( 'woocommerce_after_shop_loop_item', 'custom_template_add_to_cart' );
        }
    }

    function custom_template_add_to_cart() {
        global $product;

        if ( ! $product->is_type('variable') ) {
            woocommerce_template_loop_add_to_cart();
            return;
        }

        remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
        add_action( 'woocommerce_single_variation', 'custom_loop_variation_add_to_cart_button', 20 );

        woocommerce_template_single_add_to_cart();
    }

    function custom_loop_variation_add_to_cart_button() {
        global $product;

        if ( $product && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() && get_option('woo_show_catalog_qty') ) {
    		woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->get_stock_quantity(), 'input_value' => 1 ), $product, true );
    	} ?>

        <div class="woocommerce-variation-add-to-cart variations_button">
            <button type="submit" class="single_add_to_cart_button button alt" ><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
            <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
            <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
            <input type="hidden" name="variation_id" class="variation_id" value="0" />
        </div>
        <?php
    }

    /*
    * Catalog Mode
    */
    function custom_enable_catalog_mode() {
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
        remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
        remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );
        add_filter( 'wc_add_to_cart_message_html', '__return_null' );
        add_action( 'wordpress_init', function() {
            if ( ! WC()->cart->is_empty() ) {
                WC()->cart->empty_cart(true);
            }
        } );
        add_action( 'woocommerce_add_to_cart', function() { WC()->cart->empty_cart(true); } );
    }

    add_action( 'after_setup_theme', 'theme_add_woocommerce_support' );

    if ( get_option('woo_show_catalog_qty') && ! callback_exists('init', 'custom_enable_catalog_mode', 10) ) {
        add_filter( 'woocommerce_loop_add_to_cart_link', 'quantity_inputs_for_woocommerce_loop_add_to_cart_link', 10, 2 );
    }
    
    if (get_option('woo_show_catalog_variation_options')) {
        add_filter( 'woocommerce_available_variation', 'custom_woocommerce_available_variation' );
        add_action( 'init', 'change_add_to_cart', 10 );
    }





    /**
     * Display the custom price for students and alumni
     * @since 1.0.0
     */
    add_action( 'woocommerce_product_options_general_product_data', 'custom_prices' );
    function custom_prices() {
        woocommerce_wp_text_input($args = array(
            'id' => 'custom_price_students',
            'label' => __( 'Students Price (€)', 'woocommerce' ),
            'class' => 'custom_price_students',
            'value' => get_post_meta(get_the_id(), 'custom_price_students')[0]
        ));
        woocommerce_wp_text_input($args = array(
            'id' => 'custom_price_alumni',
            'label' => __( 'Alumni Price (€)', 'woocommerce' ),
            'class' => 'custom_price_alumni',
            'value' => get_post_meta(get_the_id(), 'custom_price_alumni')[0]
        ));
    }
    add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save');
    function woocommerce_product_custom_fields_save( $post_id ){

        $custom_price_students = isset( $_POST['custom_price_students'] ) ? $_POST['custom_price_students'] : '';
        $custom_price_alumni = isset( $_POST['custom_price_alumni'] ) ? $_POST['custom_price_alumni'] : '';

        update_post_meta( $post_id, 'custom_price_students', sanitize_text_field($custom_price_students));
        update_post_meta( $post_id, 'custom_price_alumni', sanitize_text_field($custom_price_alumni));
    }

}
