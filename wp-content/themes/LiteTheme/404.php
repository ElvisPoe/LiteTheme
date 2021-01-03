<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <?php
            require get_template_directory() . '/head.php';
        ?>
    </head>
    <body id="bd" <?php body_class(array('woocommerce', 'd-flex', 'flex-column', 'h-100')); ?>>

    <?php get_header(); ?>

        <div class="main <?php echo container_width('body') ?> d-flex flex-column">
            <div class="row">
                <main id="content" class="<?php echo ( is_front_page() ) ? 'default-page' : ''; ?> <?php echo contentColSpaning(); ?>" role="main">
                    <div class="error-404 not-found">
                        <header class="page-header">
                            <h1 class="page-title"><?php _e('Page not found'); ?></h1>
                        </header>
                        <a href="<?php echo get_bloginfo('wpurl') ?>"><?php _e('Return to homepage') ?></a>
                    </div>
                </main>
            </div>
        </div>

    <?php get_footer(); ?>

    </body>
</html>