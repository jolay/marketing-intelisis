var $twInsertShortcodeWaiting=false;
(function() {
    tinymce.PluginManager.requireLangPack('twshortcodegenerator');
    tinymce.create('tinymce.plugins.twshortcodegenerator', {
        init : function(ed, url) {
            ed.addCommand('twshortcodegenerator', function() {
                jQuery( '<div id="shortcode_container_dialog" data-current="none" />').append(jQuery('#tw-shortcode-template').html()).dialog({
                    title: 'Select the Shortcode',
                    resizable: true,
                    width: 800,
                    open: function(){
                        jQuery(this).closest('.ui-dialog-content').removeClass('ui-dialog-content').addClass('waves-ui-dialog-content');
                        jQuery(this).closest('.ui-dialog').addClass('tw-pb-main-container');
                        jQuery(this).closest('.ui-dialog').focus();
                        pbModalInitActions(jQuery(this));
                        twDlgOpen();
                    },
                    close: function(){
                        twDlgClose();
                        jQuery('#shortcode_container_dialog').closest('.ui-dialog').remove();
                        jQuery('body>#shortcode_container_dialog').remove();
                    },
                    buttons: {
                        "Done": function() {
                            var $curr=jQuery(this);
                            $twInsertShortcodeWaiting=true;
                            twInsertShortcode();
                            jQuery('#shortcode_container_dialog').addClass('loading-shortcode');
                            jQuery('#shortcode_container_dialog').siblings('.ui-dialog-titlebar').find('.ui-dialog-titlebar-close').hide();
                            jQuery('#shortcode_container_dialog').siblings('.ui-dialog-buttonpane').find('.ui-dialog-buttonset').hide();
                            $twInsertShortcodeWaitingInt=setInterval(function(){
                                if($twInsertShortcodeWaiting===false){
                                    clearInterval($twInsertShortcodeWaitingInt);
                                    $curr.dialog("close");
                                }
                            },100);
                        },
                        "Cancel": function() {
                            jQuery(this).dialog("close");
                        }
                    }
                });
            });
            ed.addButton('twshortcodegenerator', {title : 'ThemeWaves Shortcode Generator',cmd : 'twshortcodegenerator',image : url + '/../images/iconsmall.png'})
        },
        createControl : function(n, cm) {return null;},
        getInfo : function() {return {longname : "Shortcode",author : '',authorurl : '',infourl : '',version : "1.0"};}
    });
    tinymce.PluginManager.add('twshortcodegenerator', tinymce.plugins.twshortcodegenerator);
})();
// Functions
function twGetShortcode($itemSlug){
    jQuery('#shortcode_container_dialog').addClass('loading-shortcode');
    jQuery('#shortcode_container_dialog>.custom-field-container').html('');
    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        data: {
            'action':'get_modal_shortcode',
            'shortcode_name':$itemSlug
        },
        success: function(response){
            jQuery('#shortcode_container_dialog>.custom-field-container').html(jQuery(response).find('.data>.custom-field-container').first().html());
            jQuery("#shortcode_container_dialog").attr('data-current',$itemSlug).removeClass('loading-shortcode');
            pbModalInitActions(jQuery("#shortcode_container_dialog"));
        }
    });
}
function twInsertShortcode(){
    var $shortcodeContainer = jQuery("#shortcode_container_dialog");
    var $itemSlug = $shortcodeContainer.attr('data-current');
    if($itemSlug!=='none'){
        var item = '';
        $shortcodeContainer.each(function(){
            var $currentItem=jQuery(this);
            item += '{"slug":"'+$itemSlug+'","size":"shortcode-size",';
            item += '"settings":{';
            jQuery('.custom-field-container>.field-item>.field-data>.field',$currentItem).each(function(index){
                var $currentField=jQuery(this);
                if(index){item += ',';}
                if($currentField.attr('data-type')==='container'){
                    item += '"'+$currentField.attr('data-name')+'":{';
                        $currentField.children('.container-item').each(function(itemIndex){
                            var $currentContainerItem=jQuery(this);
                            if(itemIndex){item += ',';}
                            item += '"'+itemIndex+'":{';
                                jQuery('.content>.field-item>.field-data>.field',$currentContainerItem).each(function(fieldIndex){
                                    var $currentContainerItemField = jQuery(this);
                                    if(fieldIndex){item += ',';}
                                    item += '"'+$currentContainerItemField.attr('data-name')+'":"'+encodeURIComponent($currentContainerItemField.val())+'"';
                                });
                            item += '}';
                        });
                    item += '}';
                }else{
                    item += '"'+$currentField.attr('data-name')+'":"'+encodeURIComponent($currentField.val())+'"';
                }
            }).promise().done(function(){
                item +='}}';
            });
        }).promise().done(function(){
            jQuery.ajax({
                type: "POST",
                url : ajaxurl,
                data: {
                    'action':'get_printed_item',
                    'data':encodeURIComponent(item)
                },
                success: function(response){
                    window.tinymce.get($currentContentEditor).insertContent(response);
                    $twInsertShortcodeWaiting=false;
                }
            });
        });
    }else{
        $twInsertShortcodeWaiting=false;
    }
}