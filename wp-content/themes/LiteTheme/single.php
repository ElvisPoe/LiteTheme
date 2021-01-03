<?php
$queried_id = get_queried_object_id();
$meta = get_post_meta($queried_id);
 ?>
<?php get_header(); ?>

    <div class="main <?php echo container_width('body') ?> d-flex flex-column">
        <div class="row">
            <?php if (is_active_sidebar('left-sidebar')): ?>
                <div id="left_sidebar" class="col-md-3">
                    <?php dynamic_sidebar('left-sidebar'); ?>
                </div>
            <?php endif; ?>
            <main id="content" class="<?php echo ( is_front_page() ) ? 'default-page' : ''; ?> <?php echo contentColSpaning(); ?>" role="main">
                <?php
                if ( have_posts() ) :
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'includes/template/single', get_post_format() );
                        ?>
                        <?php if (is_author_shown()): ?>
                            <div class="post-meta">
                                <?php echo '<span class="author" rel="author">' . esc_html( get_the_author() ) . '</span>'; ?>
                                <?php echo '<span class="post-date">' . get_the_date() . '</span>'; ?>
                            </div>
                        <?php endif; ?>
                        <?php
                        the_post_navigation(
                            array(
                                'prev_text' => '<i class="fas fa-angle-left fa-2x" aria-hidden="true"></i><span class="meta-nav" aria-hidden="true">' . __('Previous') . '</span><span class="post-title">%title</span>',
                                'next_text' => '<i class="fas fa-angle-right fa-2x" aria-hidden="true"></i><span class="meta-nav" aria-hidden="true">' . __('Next') . '</span><span class="post-title">%title</span>',
                                'in_same_term' => true
                            )
                        );
                        if ( comments_open() || get_comments_number() )
                            comments_template();
                    endwhile;
                endif;
                ?>
            </main>
            <?php if (is_active_sidebar('right-sidebar')): ?>
                <div id="right_sidebar" class="col-md-3">
                    <?php dynamic_sidebar('right-sidebar'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php get_footer(); ?>
