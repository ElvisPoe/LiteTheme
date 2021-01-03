<?php $menuclass = ''; ?>

<?php show_admin_bar(true); ?>

<header id="header" role="banner" class="<?php echo (get_option('sticky_menu') == 1) ? 'sticky-top' : ''; ?>">
    <div class="<?php echo container_width('header') ?> main-header">
        <div class="header-columns row">

            <div class="col-6 col-md-3 logo-col">
                <div id="logo">
                    <?php if ( has_custom_logo() ) :
                        the_custom_logo();
                    else :
                        echo '<h1><a href="' . get_bloginfo('wpurl') . '">' . get_bloginfo('name') . '</a></h1>';
                    endif; ?>
                </div>
            </div>

            <div class="col-6 col-md-9">
                <button type="button" class="navbar-toggler-open d-md-none menu-btn-col"
                    <?php echo (menu_style() == 'collapse') ? 'data-toggle="collapse" data-target="#navtoggle"' : ''; ?> >
                    <i class="fas fa-bars"></i>
                </button>
                <nav id="navigation" class="d-none d-md-block navigation navbar navbar-expand-md" role="navigation">
                    <?php if ( has_nav_menu('main-menu') ) {
                            wp_nav_menu( array( 'theme_location' => 'main-menu', 'container' => false, 'menu_class' => 'navbar-nav flex-wrap ' . $menuclass ) );
                        }
                    ?>
                </nav>
            </div>
        </div>
    </div>
</header>

<?php if (menu_style() == 'offcanvas'): ?>
    <?php $menuclass = 'offcanvas'; ?>
    <div id="offcanvas" class="offcanvas">
        <button type="button" class="navbar-toggler-close" <?php echo (menu_style() == 'collapse') ? 'data-toggle="collapse" data-target="#navtoggle"' : ''; ?> >
            <i class="fas fa-times"></i>
        </button>
        <nav id="offcanvas-nav" role="navigation">
            <?php if ( has_nav_menu('main-menu') ) {
                wp_nav_menu( array( 'theme_location' => 'main-menu', 'container' => false, 'menu_class' => 'navbar-nav flex-wrap offcanvas' ) );
            }
            ?>
        </nav>
    </div>
<?php endif; ?>