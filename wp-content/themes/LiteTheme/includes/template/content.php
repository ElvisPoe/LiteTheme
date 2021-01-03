<div class="blog-post">
    <?php if ( is_title_shown() ):
        the_title('<header class="page-header"><h1 class="page-title">','</h1></header>');
    endif; ?>
    <?php the_content(); ?>
</div>
