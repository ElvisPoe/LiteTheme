<div class="blog-post">
    <header>
        <?php if ( has_post_thumbnail() ): ?>
            <div class="post_thumbnail">
                <?php $attachment_id = get_post_thumbnail_id( get_the_ID() );
                if (wp_is_mobile())
                    $post_img_attrs = wp_get_attachment_image_src($attachment_id, 'blog_image_small');
                else
                    $post_img_attrs = wp_get_attachment_image_src($attachment_id, 'blog_image');
                ?>
                <img class="post-thumbnail" src="<?php echo $post_img_attrs[0]; ?>" alt="<?php echo esc_html( the_title('','',false) ) ?>" width="<?php echo $post_img_attrs[1]; ?>" height="<?php echo $post_img_attrs[2]; ?>" />
            </div>
        <?php endif; ?>
    </header>
    <?php if ( is_title_shown() ):
        the_title('<header class="page-header"><h1 class="page-title">','</h1></header>');
    endif; ?>
    <?php the_content(); ?>
</div>
