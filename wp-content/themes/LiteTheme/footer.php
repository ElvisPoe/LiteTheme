<footer id="footer" class="container-fluid" role="contentinfo">
    <div class="<?php echo container_width('footer') ?>">
        <div class="footer-columns row">
            <?php
            $footer_columns = (get_option('footer_columns') < 1 || get_option('footer_columns') > 6) ? 4 : get_option('footer_columns');
            $offset = 0;
            foreach (range(1, intval($footer_columns)) as $col): ?>
                <?php if (is_active_sidebar('footer-' . $col)): ?>
                    <div class="footer-column-<?php echo $col;?> <?php echo column_spaning($footer_columns, $offset, $col)?> ">
                        <?php dynamic_sidebar('footer-' . $col); ?>
                    </div>
                    <?php $offset = 0;
                else:
                    $offset++;
                endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="container-fluid mt-auto" id="copyright">
        <div class="copyright-text"><?php echo get_option('copyright_text') ?></div>
    </div>

    <?php wp_footer(); ?>
</footer>