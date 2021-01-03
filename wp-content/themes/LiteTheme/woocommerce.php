<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <?php
            require get_template_directory() . '/head.php';
        ?>
    </head>
    <body id="bd" <?php body_class(array('woocommerce', 'd-flex', 'flex-column', 'h-100')); ?>>

    <?php get_header(); ?>

    <?php if (! empty($meta)): ?>
        <?php if ( ! empty($meta['hero_image'][0]) ): ?>
            <div class="hero row">
                <div class="hero_banner col-12">
                    <?php
                    if (wp_is_mobile())
                        $hero_img_attrs = wp_get_attachment_image_src($meta['hero_image'][0], 'large');
                    else
                        $hero_img_attrs = wp_get_attachment_image_src($meta['hero_image'][0], 'full_hd');
                    ?>
                    <img class="hero_image" src="<?php echo $hero_img_attrs[0]; ?>" alt="hero image" width="<?php echo $hero_img_attrs[1]; ?>" height="<?php echo $hero_img_attrs[2]; ?>" />
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="main <?php echo container_width('body') ?> d-flex flex-column">

        <div class="row">

            <?php if(!is_product()): ?>
                <aside id="sitebar-1" class="col-md-3">
                    <?php dynamic_sidebar('sidebar-1'); ?>
                </aside>
            <?php endif; ?>

            <main id="content" class="<?php echo $content_class; ?> <?php if(is_product()){echo "col-md-12";} else {echo "col-md-12";}?>" role="main">
                <?php
                    echo $page_title;
                    woocommerce_content();
                ?>
            </main>
        </div>
    </div>

    <?php get_footer(); ?>

    </body>
</html>