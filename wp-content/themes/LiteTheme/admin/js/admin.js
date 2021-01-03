jQuery(document).ready(function($) {
    /* initialize mediaUploader */
    var mediaUploader;

    /* extendable mediauploader function */
    var uploader = function(target, preview, title, text, is_multiple = false) {
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: title,
            button: {
                text: text
            },
            multiple: is_multiple
        });

        mediaUploader.on('select', function() {
            attachment = mediaUploader.state().get('selection').first().toJSON();
            target.val(attachment.id);
            preview.attr('src', attachment.url);
        });

        mediaUploader.open();
    }

    /* upload & update header logo */
    $('#header_logo_upload').on('click', function(e) {
        e.preventDefault();
        uploader($('#header_logo'), $('#header_logo_preview'), 'Upload Logo Image', 'Choose Logo');

    });

    $('#header_logo_remove').on('click', function(e) {
        e.preventDefault();
        var answer = confirm('Remove logo image?');
        if (answer === true) {
            $('#header_logo').val('');
            $('.litetheme-theme-form').submit();
        }
        return;
    });

    /* upload & update hero image */
    $('#hero_image_upload').on('click', function(e) {
        e.preventDefault();
        uploader($('#hero_image'), $('#hero_image_preview'), 'Upload Hero Image', 'Choose Hero Image');

    });

    $('#hero_image_remove').on('click', function(e) {
        e.preventDefault();
        var answer = confirm('Remove hero image?');
        if (answer === true) {
            $('#hero_image').val('');
            $('#hero_image_preview').attr('src', '');
        }
        return;
    });

    /* enable color picker */
    $('.color-field').wpColorPicker();

    /* disable page_title button if default */
    let checkboxes = [
        ['#post_page_title', '#theme_post_title_default'],
        ['#page_title', '#theme_page_title_default'],
    ];

    disableWhenDefault(checkboxes);
});

function disableWhenDefault(checkboxes) {
    jQuery.each(checkboxes, function(index, value) {
        let checkbox = jQuery( value['0'] ),
            checkbox_default = jQuery( value[1] );

        if (checkbox_default.length) {
            if(checkbox_default.is(':checked')) {
                checkbox.prop('disabled', true);
            }
            else {
                checkbox.prop('disabled', false);
            }

            checkbox_default.on('change', function() {
                if( jQuery(this).is(':checked') ) {
                    checkbox.prop('disabled', true);
                }
                else {
                    checkbox.prop('disabled', false);
                }
            });
        }
    });
}
