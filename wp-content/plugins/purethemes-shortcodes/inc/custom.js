jQuery(document).ready(function ($) {

    $(document.body).on('click', '.ptsc-duplicate', function () {
        $('#purethemes-popup tbody.multi:last').clone().insertAfter('#purethemes-popup tbody.multi:last');
    });

    $(document.body).on('change', '#shortcode-type', function () {
        var type = $(this).val();
        var data = {
            action: 'form_generate',
            shortcode: type
        };
        $('#purethemes-spinner').fadeIn();

        $.post(ajaxurl, data, function (response) {
            $('#form-container-ajax .form-table').fadeOut('500', function () {
                $('#form-container-ajax .form-table').after().html(response).fadeIn('400', function () {
                    ptshotcodes.resizeTB();
                    $('#purethemes-spinner').fadeOut();
                    $('#form-container-ajax .wp-color-picker-field').wpColorPicker();
                });
            })
        });
        if( $('#shortcode-type').hasClass('notloaded')) {
            ptshotcodes.load();
            $('#shortcode-type').removeClass('notloaded');
        }
        ptshotcodes.resizeTB();
    });

    var ptshotcodes = {
        gensc: function () { // function to build shortcode based on fields
            var tag = $('#shortcode-type').val();
            var output;
            if ($('tbody.multi').length > 0) {
                var wrapper = $('#wrapper_tag').val();
                output = "[" + wrapper + "]";

                $('tbody.multi').each(function() {
                    var row = $(this);
                    var content = $('.ptsc-content',this).val();
                    output += "[" + tag + "";
                    $('.ptsc', this).each(function () {
                        var name = $(this).attr('name'),
                        val = $(this).val();
                        output += " " + name + '="' + val + "\" ";
                    });
                    if ($('#content_flag').length > 0) {
                        output += "]" + content + "[/" + tag + "]";
                    } else {
                        output += "]";
                    }
                });
                output += "[/" + wrapper + "]";
            } else {
                output = "[" + tag + "";
                $('.ptsc').each(function () {
                    var name = $(this).attr('name'),
                    val = $(this).val();
                    output += " " + name + '="' + val + "\" ";
                });
                var content = $('.ptsc-content').val();
                if ($('#content_flag').length > 0) {
                    output += "]" + content + "[/" + tag + "]";
                } else {
                    output += "]";
                }
            }
            return output;
        },
/*onsubmit: function( e ) {
    // Insert content when the window form is submitted
    editor.insertContent( 'Title: ' + e.data.title );
}*/
        load: function () {
            popup = $('#purethemes-popup'),
            form = $('#form-container-ajax', popup),
            $('.ptsc-insert', form).click(function () {
                if (tinyMCE) {
                    var out = "";
                    var out = ptshotcodes.gensc();
                    tinymce.activeEditor.insertContent(out);
                    var out = "";
                    tb_remove();

                }
            });

            // resize TB
            ptshotcodes.resizeTB();
            $(window).resize(function () {
                ptshotcodes.resizeTB();
            });

        },
        resizeTB: function () {

            var tbAjax = $('#TB_ajaxContent'),
            tbWindow = $('#TB_window'),
            ptsc_popup = $('#purethemes-popup');

            ptsc_popup.css({
                maxHeight: $(window).height()*0.8
            })

            tbWindow.css({
                height: ptsc_popup.outerHeight() + 50,
                width: ptsc_popup.outerWidth()+15,
                marginLeft: -(ptsc_popup.outerWidth() / 2)
            });

            tbAjax.css({
                paddingTop: 0,
                paddingLeft: 0,
                paddingRight: 0,
                height: (tbWindow.outerHeight() - 47),
                overflow: 'auto', // IMPORTANT
                width: 600
            });
        }
    }

});

        //TODO BIND CHANGE LIVE