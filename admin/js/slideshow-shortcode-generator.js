var editor_object;
(function() {
    tinymce.create("tinymce.plugins.slideshow_mce_button", {
        init : function(ed, url) {
            //add new button
            ed.addButton("slideshow_mce_button", {
                text: 'myslideshow',
                icon: false,
                // title : wdm_button_title,
                cmd : "generate_shortcode",
                // image : wdm_button_icon
            });
            //button functionality.
            ed.addCommand("generate_shortcode", function() {
                editor_object = ed;
                jQuery('#postdivrich #wp-content-wrap').css('z-index','1');
                if(!jQuery('#slideshow_list').length) {
                  //alert('hey');
                    jQuery('body').prepend(slideshow_list);
                }
                jQuery('.open_modal').trigger('click');
                //console.log('hello'+tp);
            });
        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : "Slideshow Shortcode Generator",
                author : "Sonali",
                version : "1"
            };
        }
    });
    tinymce.PluginManager.add("slideshow_mce_button", tinymce.plugins.slideshow_mce_button);
})();

jQuery(document).on('click', '.wdm_insert_slideshow', function(){
    jQuery('#postdivrich #wp-content-wrap').removeAttr('style');
    editor_text = '[myslideshow id=\''+jQuery('.select_slideshow').val()+'\']';
    //console.log('hello'+editor_text);
    editor_object.execCommand("mceInsertContent", 0, editor_text);
    jQuery('.close-modal').trigger('click');
});