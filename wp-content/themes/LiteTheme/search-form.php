<form role="search" method="get" class="search-form" action="<?php echo get_permalink(woocommerce_get_page_id('shop')); ?>">
    <input type="search" class="search-field" placeholder="<?php echo __('Search', 'woocommerce') ?>" value=""
           name="s" title="<?php echo __('Search', 'woocommerce') ?>" />
    <input type="submit" class="submit" value="<?php echo __('Search', 'woocommerce') ?>">
</form>