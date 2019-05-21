jQuery(document).ready(function($){

    /** global: wp */
       
	var custom_uploader;

    jQuery('.wp_slide_image_upload').click(function(e) {

    var attachment_ids = null;
    e.preventDefault();

    //Extend the wp.media object
    custom_uploader = wp.media.frames.file_frame = wp.media({
        title: 'Choose Image',
        button: {
            text: 'Choose Image'
        },
        multiple: true
    }).open();
        
    custom_uploader.on('select', function() {
    
            var selection = custom_uploader.state().get('selection');

            selection.map( function( attachment ) {

                   attachment = attachment.toJSON();

                    if ( attachment.id ) {
                        attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

                        var gallery = jQuery('#gallery');

                        if (gallery.find('p.no-images-message') && gallery.find('p.no-images-message').css('display') === 'block'){
                            gallery.find('p.no-images-message').css('display', 'none');
                        }

                        if (gallery.find('ul.gallery_images').length < 1){
                            gallery.append(
                                '<ul id="sortable1" class="gallery_images connectedSortable">'+
                                '<div class="dx-eig-images sortable ui-sortable"></div>'+
                                '<div class="dx-eig-clear"></div>'+
                                '</ul>'
                            );

                        }

                        gallery.find('ul .dx-eig-images').append('<li class="image attachment details ui-state-highlight" data-attachment_id="' + attachment.id + '"><div class="attachment-preview">'+
                            '<div class="thumbnail"><img src="' + attachment.sizes.thumbnail.url + '" /></div><a href="#" class="delete_dx_image check" title="Remove Image"><div class="media-modal-icon"></div></a></div></li>');
                    }

                } );

                var attachments_selector = jQuery('#attachment_ids');
                var current_image_ids = attachments_selector.attr('value');
                
                current_image_ids = current_image_ids + ',';
                
                attachments_selector.attr('value',current_image_ids + attachment_ids);
           
});
    

    });
    
    jQuery(".sortable").sortable();

    $('#uploader .save_btn').click(function(e){

        e.preventDefault();
        var listItems = $("#sortable1 li");
        var ids = [];
        listItems.each(function(idx, li) {
            var id = $(li).data('attachment_id');
            ids.push(id);
            
        });

        $.ajax({
                url: uploader_obj.ajax_url,
                method: 'POST',
                data: {
                    action:'saveimages',
                    ids: ids
                },
                success: function(response){
                    alert(response);
                    window.location.reload();
                }
            });
        
        
    });


    jQuery(document).on( 'click', '.delete_dx_image', function() {
            //Get info
            var info = jQuery(this).parent().parent();
            info.remove();
        });
    
});