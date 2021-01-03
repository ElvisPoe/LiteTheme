<?php

$queried_id = get_queried_object_id();
$meta = get_post_meta($queried_id);

$content_class = '';
$page_title = '';

if ( is_front_page() ):
    $content_class = 'default-page';
elseif ( !is_front_page() && is_home() ):
    $content_class = 'blog-page row';
    $page_title = '<h1 class="page-title col-12">Blog</h1>';
endif;

?>
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
            <main id="content" class="<?php echo $content_class; ?> <?php echo contentColSpaning(); ?>" role="main">
                <?php echo $page_title;
                if ( have_posts() ) :
                    while ( have_posts() ) :
                        the_post();
                        if ( ! is_front_page() && is_home() ):
                            /* Blog page */
                            get_template_part( 'includes/template/blog', get_post_format() );
                        else:
                            /* Any other page */
                            get_template_part( 'includes/template/content', get_post_format() );
                        endif;
                    endwhile;
                endif;
                ?>
            </main>
        </div>
    </div>

    <?php get_footer(); ?>

    </body>
</html>