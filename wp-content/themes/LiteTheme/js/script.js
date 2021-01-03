jQuery(document).ready(function($) {
    if ($('body').hasClass('admin-bar')) {
        adminBarFix();

        $(window).resize(function(){
            adminBarFix();
        });
    }

    $('.navbar-toggler-open').on('click', function() {
        $('#offcanvas').toggleClass('open');
        $('#bd').css('position', 'fixed');
    });

    $('.navbar-toggler-close').on('click', function() {
        $('#offcanvas.open').removeClass('open');
        $('#bd').css('position', '');
    });

    function adminBarFix() {
        let adminbar_width = 0;
        if ($(window).width() >= 767) {
            adminbar_width = 32;
        }
        else {
            adminbar_width = 46;
        }
        $('html').css('min-height', '100vh').css('min-height', '-=' + adminbar_width + 'px');
        $('body').css('min-height', '100vh').css('min-height', '-=' + adminbar_width + 'px');
        $('#wrap-body').css('min-height', '100vh').css('min-height', '-=' + adminbar_width + 'px');
    }

    $(document.body).trigger( 'wc_force_reload_fragments' );


    /* Mobile Menu */
    if ($(window).width() < 768) { // Only on mobile
        $(".menu-item-has-children > a").append("<i class='show-more-menu'></i>"); // Add the icon in the menu item with child
    }
    $("#offcanvas-nav li.menu-item-has-children a i").click(function (e) { // On that icon click run
        e.preventDefault(); // Dont go to the menu link.
        let subMenu = $(this).closest('li.menu-item-has-children').children('.sub-menu');
        if (subMenu.is(':visible')) { // Check if menu is display: none and Show It;
            subMenu.slideUp('fast');
            $(this).addClass('show-more-menu').removeClass('show-less-menu'); // Rotate the icon
        } else { // Else (if is display block) Show it.
            subMenu.slideDown('fast');
            $(this).addClass('show-less-menu').removeClass('show-more-menu');
        }
    });



});