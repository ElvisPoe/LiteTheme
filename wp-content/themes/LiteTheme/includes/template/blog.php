<div class="blog-post col-12 col-md-6">
    <?php if ( has_post_thumbnail() ): ?>
        <div class="post_thumbnail">
            <?php $attachment_id = get_post_thumbnail_id( get_the_ID() );
            if (wp_is_mobile())
                $post_img_attrs = wp_get_attachment_image_src($attachment_id, 'medium');
            else
                $post_img_attrs = wp_get_attachment_image_src($attachment_id, 'large');
            ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><img class="post-thumbnail" src="<?php echo $post_img_attrs[0]; ?>" alt="<?php echo esc_html( the_title('','',false) ) ?>" width="<?php echo $post_img_attrs[1]; ?>" height="<?php echo $post_img_attrs[2]; ?>" /></a>
        </div>
    <?php endif; ?>
    <h3 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_title(); ?></a></h3>
    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php _e('Read more'); ?></a>
</div>
