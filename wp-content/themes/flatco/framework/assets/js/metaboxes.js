function showHidePostFormatField(){    
    jQuery('#normal-sortables>[id*="tw-format-"]').each(function(){
       if(jQuery(this).attr('id').replace("tw","post")===jQuery('#post-formats-select input:radio:checked').attr('id').replace('image', '0')){
           jQuery(this).css('display', 'block');
       } else {
           jQuery(this).css('display', 'none');
       }
    });    
}

jQuery(function(){
		
    /* Color Picker */
    jQuery(".color_picker").ColorPicker({
        onShow: function (colpkr) {
            jQuery(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            jQuery(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb, el) {
            jQuery(el).parent().find('.color_picker_inner').css('backgroundColor', '#' + hex);
            jQuery(el).parent().find('.color_picker_value').val('#' + hex);
        }
    });

    
    /* Check show hide */
    jQuery('.check-show-hide').change(function() {
        var datashow = jQuery(this).attr('data-show');
        var datahide = jQuery(this).attr('data-hide');
        if(jQuery(this).is(':checked')) {
            jQuery(datashow).fadeIn();
            jQuery(datahide).fadeOut();
        } else {
            jQuery(datashow).fadeOut();
            jQuery(datahide).fadeIn();
        }
    });
    jQuery('.check-show-hide').each(function() {
        jQuery(this).change();
    }); 
    
    
    
    /* Page template */
    var selector = "#page_template";
    var defaultpage = "#page_meta_settings";
    var comingsoon = "#comingsoon_meta_settings";
    jQuery(selector).bind('change', function(){
        var template = jQuery(this).val();
        if(template=='template-coming_soon.php'){
            jQuery(defaultpage).fadeOut();
            jQuery(comingsoon).fadeIn();                   
        } else {
            jQuery(defaultpage).fadeIn();
            jQuery(comingsoon).fadeOut(); 
        }
    });    
    jQuery(selector).change();
            
    /* Select options */            
    jQuery(".tw-metaboxes select").each(function(){
        $this = jQuery(this);
        if( $this.attr("data-value") != "" ){
            $this.val($this.attr("data-value"));
        }
    });
    

    jQuery("#header_type select").change(function(){
        $this = jQuery(this);
        if( $this.val() == "subtitle" ){
            jQuery(".tw-metaboxes #subtitle").fadeIn();
            jQuery(".tw-metaboxes #bg_image").fadeIn();
            jQuery(".tw-metaboxes #slider_id").fadeOut();
            jQuery(".tw-metaboxes #googlemap").fadeOut();
        } else if($this.val() == "slider") {
            jQuery(".tw-metaboxes #slider_id").fadeIn();
            jQuery(".tw-metaboxes #subtitle").fadeOut();
            jQuery(".tw-metaboxes #bg_image").fadeOut();
            jQuery(".tw-metaboxes #googlemap").fadeOut();
        } else if($this.val() == "map") {
            jQuery(".tw-metaboxes #googlemap").fadeIn();
            jQuery(".tw-metaboxes #slider_id").fadeOut();
            jQuery(".tw-metaboxes #subtitle").fadeOut();
            jQuery(".tw-metaboxes #bg_image").fadeOut();
        } else {
            jQuery(".tw-metaboxes #googlemap").fadeOut();
            jQuery(".tw-metaboxes #slider_id").fadeOut();
            jQuery(".tw-metaboxes #subtitle").fadeOut();
            jQuery(".tw-metaboxes #bg_image").fadeOut();
        }
    });
    jQuery("#header_type select").change();
    
    
    /* Page layout options */
    jQuery(".tw-metaboxes .type_layout a").each(function(){
        $val = jQuery(".tw-metaboxes .type_layout input").val();
        $this = jQuery(this);
        if( $this.data("value") == $val ){
            $this.addClass("active");
        }
    });
    jQuery(".tw-metaboxes .type_layout a").click(function(){
        jQuery(".tw-metaboxes .type_layout a").removeClass("active");
        $val = jQuery(this).data('value');
        jQuery(".tw-metaboxes .type_layout input").val($val);
        jQuery(this).addClass("active");
    })
    
    
    
    /* Post format */
    showHidePostFormatField();
    jQuery('#post-formats-select input').change(showHidePostFormatField);
    
    
    /* Gallery */
    
    var frame;
    var images = script_data.image_ids;
    var selection = loadImages(images);

    jQuery('#gallery_images_upload').on('click', function(e) {
            e.preventDefault();

            // Set options for 1st frame render
            var options = {
                    title: script_data.label_create,
                    state: 'gallery-edit',
                    frame: 'post',
                    selection: selection
            };

            // Check if frame or gallery already exist
            if( frame || selection ) {
                    options['title'] = script_data.label_edit;
            }

            frame = wp.media(options).open();

            // Tweak views
            frame.menu.get('view').unset('cancel');
            frame.menu.get('view').unset('separateCancel');
            frame.menu.get('view').get('gallery-edit').el.innerHTML = script_data.label_edit;
            frame.content.get('view').sidebar.unset('gallery'); // Hide Gallery Settings in sidebar

            // When we are editing a gallery
            overrideGalleryInsert();
            frame.on( 'toolbar:render:gallery-edit', function() {
            overrideGalleryInsert();
            });

            frame.on( 'content:render:browse', function( browser ) {
                if ( !browser ) return;
                // Hide Gallery Setting in sidebar
                browser.sidebar.on('ready', function(){
                    browser.sidebar.unset('gallery');
                });
                // Hide filter/search as they don't work 
                    browser.toolbar.on('ready', function(){ 
                            if(browser.toolbar.controller._state == 'gallery-library'){ 
                                    browser.toolbar.$el.hide(); 
                            } 
                    }); 
            });

            // All images removed
            frame.state().get('library').on( 'remove', function() {
                var models = frame.state().get('library');
                    if(models.length == 0){
                        selection = false;
                        jQuery.post(ajaxurl, { 
                            ids: '',
                            action: 'themewaves_save_images',
                            post_id: script_data.post_id,
                            nonce: script_data.nonce 
                        });
                    }
            });

            // Override insert button
            function overrideGalleryInsert() {
                    frame.toolbar.get('view').set({
                            insert: {
                                    style: 'primary',
                                    text: script_data.label_save,

                                    click: function() {                                            
                                            var models = frame.state().get('library'),
                                                ids = '';

                                            models.each( function( attachment ) {
                                                ids += attachment.id + ','
                                            });

                                            this.el.innerHTML = script_data.label_saving;
                                            
                                            jQuery.ajax({
                                                    type: 'POST',
                                                    url: ajaxurl,
                                                    data: { 
                                                        ids: ids, 
                                                        action: 'themewaves_save_images', 
                                                        post_id: script_data.post_id, 
                                                        nonce: script_data.nonce 
                                                    },
                                                    success: function(){
                                                        selection = loadImages(ids);
                                                        jQuery('#gallery_image_ids').val( ids );
                                                        frame.close();
                                                    },
                                                    dataType: 'html'
                                            }).done( function( data ) {
                                                    jQuery('.gallery-thumbs').html( data );
                                            }); 
                                    }
                            }
                    });
            }
        });
					
        // Load images
        function loadImages(images) {
                if( images ){
                    var shortcode = new wp.shortcode({
                        tag:    'gallery',
                        attrs:   { ids: images },
                        type:   'single'
                    });

                    var attachments = wp.media.gallery.attachments( shortcode );

                    var selection = new wp.media.model.Selection( attachments.models, {
                            props:    attachments.props.toJSON(),
                            multiple: true
                    });

                    selection.gallery = attachments.gallery;

                    // Fetch the query's attachments, and then break ties from the
                    // query to allow for sorting.
                    selection.more().done( function() {
                            // Break ties with the query.
                            selection.props.set({ query: false });
                            selection.unmirror();
                            selection.props.unset('orderby');
                    });

                    return selection;
                }
                return false;
        }
});

function browseimage(id){
    var elementId = id;
    window.original_send_to_editor = window.send_to_editor;
    window.custom_editor = true;    
    window.send_to_editor = function(html){
        if (elementId != undefined) {
            jQuery(html).find('img').each(function(){
                    var imgurl = jQuery(this).attr('src');
                    jQuery('input[name="'+elementId+'"]').val(imgurl);
                    return;
            });
        } else {
            window.original_send_to_editor(html);
        }
        elementId = undefined;
    };
    wp.media.editor.open();
}

window.original_send_to_editor = window.send_to_editor;
window.custom_editor = true;