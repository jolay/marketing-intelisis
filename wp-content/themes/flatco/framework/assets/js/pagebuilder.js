var $currentContentEditor='content';
var $currentContentEditorInterval=0;
var $pbSavingDone=true;
var $pbSavingLast=0;
var $twBuilderScorollTop=0;
// Reset Content width 
jQuery(function(){
    $homeURI+='/';
    if($homeURI[$homeURI.length-1]==='/'){$homeURI=$homeURI.substring(0,$homeURI.length-1);}
    twInitSortDragg(jQuery('#pagebuilder-area'),jQuery('#pagebuilder-area'));
    // Click to Add Item
    jQuery('.pb-add-layout').click(function(e){e.preventDefault();
        var $curr=jQuery(this);
        var $data=$curr.siblings('.data').html();
        jQuery('.pb-add-layout-conteiner').addClass('loading');
        setTimeout(function(){
            if($curr.attr('data-possition')==='top'){
                jQuery('#pagebuilder-area').prepend($data);
            }else{
                jQuery('#pagebuilder-area').append($data);
            }
            // Sortable Draggable
            twInitSortDragg(jQuery('#pagebuilder-area'),jQuery('#pagebuilder-area'));
            pbSaveData();
            pbInitEvents();
        },100);
    });
    // Check Default Layouts
    jQuery('#pagebuilder-area>.action-container.builder-area>.data>.custom-field-container [data-name="default_layout"]').each(function(){
        jQuery(this).closest('.action-container.builder-area').addClass((jQuery(this).val()==='true'?'default':'additional')+'-layout');
    });
    pbInitEvents();
    pbInitTemplateEvents();
    pbSaveData();
    // Active current Layout
    jQuery('#pagebuilder-area>.row-container>.list>.change-layout>a.active').each(function(){
        var $curr=jQuery(this);
        $curr.closest('.row-container').children('.builder-area').eq(1).addClass($curr.attr('data-input')+'-sidebar');
    });
});
function pbInitTemplateEvents(){
    // Template Action
    jQuery('.template-add').unbind('click').bind('click',function(e){e.preventDefault();
        var $currentTemplateName   = prompt('Template Name?');
//        var $currentTemplateLayout = jQuery('input[name="pb-page-layout"]')       .val();
        var $currentTemplateContent=encodeURIComponent(jQuery('#pagebuilder-area').html());        
        if($currentTemplateName==null){
            return false;
//        }else if($currentTemplateName!='' && $currentTemplateLayout!=''){
        }else if($currentTemplateName!=''){
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    'action':'template_add',
                    'template_name':$currentTemplateName,
//                    'template_layout':$currentTemplateLayout,
                    'template_content':$currentTemplateContent
                },
                success: function(response){
                    if(jQuery('.succes',response).text()!=''){
                        jQuery('ul.template-container').append('<li class="template-item"><a class="template-name">'+$currentTemplateName+'</a><span class="template-delete">X</span></li>');
                        pbInitTemplateEvents();
//                        alert(jQuery('.succes',response).text());
                    }else if(jQuery('.error',response).text()!=''){
                        alert(jQuery('.error',response).text());
                    }
                }
            });
        }else{
            alert('Template name is empty!!! Try again.');
        }
        jQuery('#template-save').removeClass('active').children('.template-container').slideUp();
    });
    jQuery('.template-name').unbind('click').bind('click',function(e){e.preventDefault();
        var $currentTemplateName = jQuery(this).text();
        var $currentResponse = 'waitingajax';
        if($currentTemplateName){
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    'action':'template_get',
                    'template_name':$currentTemplateName
                },
                success: function(response){
                    $currentResponse=response;
                }
            });
            if(confirm("Your old contents are will delete ?")){
                var templateAjaxInt=setInterval(function(){
                    if($currentResponse!=='waitingajax'){
                        clearInterval(templateAjaxInt);
                        if(jQuery('.data',$currentResponse).html()!=''){
//                            jQuery('#pagebuilder-select-layout>[data-input="'+jQuery('.data>.layout',$currentResponse).text()+'"]').click();
                            twInitSortDragg(jQuery('>.data>.content',$currentResponse),jQuery('#pagebuilder-area'));
                            pbSaveData();
                            pbInitEvents();
                        }else if(jQuery('.error',$currentResponse).text()!=''){
                            alert(jQuery('.error',$currentResponse).text());
                        }
                    }
                },100);
            }
        }
        jQuery('#template-save').removeClass('active').children('.template-container').slideUp();
    });
    jQuery('.template-delete').unbind('click').bind('click',function(e){e.preventDefault();
        var $this = jQuery(this);
        var $currentTemplateName = $this.closest('.template-item').find('.template-name').text();
        if($currentTemplateName && confirm("Are you delete this template ?")){
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    'action':'template_remove',
                    'template_name':$currentTemplateName
                },
                success: function(response){
                    $this.closest('.template-item').remove();
                    if(jQuery('.error',response).text()!=''){    
                        alert(jQuery('.error',response).text());
                    }
                }
            });
        }
        jQuery('#template-save').removeClass('active').children('.template-container').slideUp();
    });
    // Template Style
    jQuery('#template-save>.template').unbind('click').bind('click',function(e){e.preventDefault();e.stopPropagation();
        if(jQuery('#template-save').hasClass('active')){
            jQuery('#template-save').removeClass('active').children('.template-container').slideUp();
        }else{
            jQuery('#template-save').addClass('active').children('.template-container').slideDown();
        }
    });
}

function pbInitEvents(){
    // START - Builder Item Actions
    // Row Tools Actions
    jQuery('#pagebuilder-area>.row-container').each(function(){
        var $currRowCont=jQuery(this);
        // Layout Change
        jQuery('>.list>.change-layout>a',$currRowCont).unbind('click').bind('click',function(e){e.preventDefault();
            var $currentLayout = jQuery(this);
            var $currentValueArray = $currentLayout.attr('data-value').split(',');
            var $currentLayoutInput=jQuery('>.data>.custom-field-container [data-name="row_layout"]',$currRowCont);
            $currentLayout.addClass('active').siblings('a').removeClass('active');
            $currentLayoutInput.attr("value",$currentLayout.attr('data-input'));
            if($currentValueArray[0]!==''){
                var $currentBuilderArea='';
                var $currentBuilderAreaClasses='';
                for(var i = 0, length=$currentValueArray.length ; i<length; i++){
                    $currentBuilderArea=jQuery('>.builder-area',$currRowCont).eq(i);
                    $currentBuilderAreaClasses=$currentBuilderArea.attr('class').split(' ');
                    for(var ind=0,len=$currentBuilderAreaClasses.length;ind<len;ind++){
                        if($currentBuilderAreaClasses[ind].search('size-')!==-1){
                            $currentBuilderArea.removeClass($currentBuilderAreaClasses[ind]).addClass('size-'+$currentValueArray[i]);break;
                        }
                    }
                }
                //START - Sidebar elements moving
                var $oldSidebar=false;
                var $newSidebar=false;
                if($currentLayoutInput.val()=='left'){
                    jQuery('>.builder-area',$currRowCont).eq(1).removeClass('right-sidebar').removeClass('no-sidebar').addClass('left-sidebar');
                    $oldSidebar=jQuery('>.builder-area',$currRowCont).eq(-1);
                    $newSidebar=jQuery('>.builder-area',$currRowCont).eq(0);
                }else if($currentLayoutInput.val()=='right'){
                    jQuery('>.builder-area',$currRowCont).eq(1).removeClass('left-sidebar').removeClass('no-sidebar').addClass('right-sidebar');
                    $oldSidebar=jQuery('>.builder-area',$currRowCont).eq(0);
                    $newSidebar=jQuery('>.builder-area',$currRowCont).eq(-1);
                }else{
                    jQuery('>.builder-area',$currRowCont).eq(1).removeClass('left-sidebar').removeClass('right-sidebar').addClass('no-sidebar');
                }
                if($oldSidebar&&$newSidebar){
                    if($newSidebar.children().length===0){
                        $newSidebar.html($oldSidebar.html());
                        $oldSidebar.html('');
                    }
                }
                //END   - Sidebar elements moving
                pbSaveData();
                pbInitEvents();
            }
        });
        // Click to Add Item
        jQuery('>.list>.add-element>a.elements-dropdown',$currRowCont).unbind('click').bind('click',function(e){e.preventDefault();e.stopPropagation();
            var $curr=jQuery(this).parent();
            if($curr.hasClass('active')){
                $curr.removeClass('active');
            }else{
                if($curr.closest('.row-container.action-container').hasClass('closed')){jQuery('>a.action-expand',$curr.siblings('.actions')).click();}
                $currRowCont.siblings('.row-container').find('>.list>.add-element').removeClass('active');
                $curr.addClass('active');
            }
        });
        jQuery('>.list>.add-element>.pagebuilder-elements-container>.item',$currRowCont).unbind('click').bind('click',function(e){e.preventDefault();
            var $currSlug   = jQuery(this).attr('data-slug');
            var $newElement = jQuery('#items-list>[data-slug="'+$currSlug+'"]').clone();
            jQuery('>.builder-area',$currRowCont).eq(1).append($newElement);
            jQuery(this).closest('.add-element').removeClass('active');
            pbSaveData();
            pbInitEvents();
        });
        jQuery('html').unbind('click').bind("click", function(e){
            jQuery('>.list>.add-element',$currRowCont).removeClass('active');
            jQuery('#template-save').removeClass('active').children('.template-container').slideUp();
        });
    });    
    //resize
    jQuery(".builder-area>.item>.list>.size-sizer-container>.sizer>a.down").unbind("click").bind("click",function(e){e.preventDefault();        
        var $this = jQuery(this);
        var $sizeList=jQuery('#size-list').clone();
        var $currentItem     = $this.closest('.action-container');
        var $currentSizeText = jQuery('>.list>.size-sizer-container>.size',$currentItem).text();
        var $currentSizeList = jQuery('li[data-text="'+$currentSizeText+'"]',$sizeList);
        $currentItem.removeClass($currentSizeList.attr('data-class'));
        if($currentItem.attr('data-min')){$sizeList.find('[data-class="'+$currentItem.attr('data-min')+'"]').addClass('min').siblings('.min').removeClass('min');}
        if($currentSizeList.hasClass('min')){
//            $currentSizeList=$currentSizeList.siblings('.max');
        }else{
            $currentSizeList=$currentSizeList.prev();
        }
        $currentItem.addClass($currentSizeList.attr('data-class'));
        jQuery('>.list>.size-sizer-container>.size',$currentItem).text($currentSizeList.attr('data-text'));
        pbSaveData();
    });
    
    jQuery(".builder-area>.item>.list>.size-sizer-container>.sizer>a.up").unbind("click").bind("click",function(e){e.preventDefault();
        var $this = jQuery(this);
        var $sizeList=jQuery('#size-list').clone();
        var $currentItem     = $this.closest('.action-container');
        var $currentSizeText = jQuery('>.list>.size-sizer-container>.size',$currentItem).text();
        var $currentSizeList = jQuery('li[data-text="'+$currentSizeText+'"]',$sizeList);
        $currentItem.removeClass($currentSizeList.attr('data-class'));
        if($currentItem.attr('data-min')){$sizeList.find('[data-class="'+$currentItem.attr('data-min')+'"]').addClass('min').siblings('.min').removeClass('min');}
        if($currentSizeList.hasClass('max')){
//            $currentSizeList=$currentSizeList.siblings('.min');
        }else{
            $currentSizeList=$currentSizeList.next();
        }
        $currentItem.addClass($currentSizeList.attr('data-class'));
        jQuery('>.list>.size-sizer-container>.size',$currentItem).text($currentSizeList.attr('data-text'));
        pbSaveData();
    });
		
    //duplicate
    jQuery(".builder-area>.item>.list>.actions>a.action-duplicate,.row-container>.list>.actions>a.action-duplicate").unbind("click").bind("click",function(e){
        twPublishEnable('disable');
        var $parent = jQuery(this).closest('.action-container');
        if($parent.css('position')==='relative'){
            e.preventDefault();
            var $newItem = $parent.clone().addClass('hidded').css('display','none');
            $parent.after($newItem).promise().done(function(){
                $newItem.removeClass('hidded').fadeIn('slow').promise().done(function(){
                    $parent.siblings('.action-container').css('opacity','');
                    // Sortable Draggable
                    twInitSortDragg(jQuery('#pagebuilder-area'),jQuery('#pagebuilder-area'));
                    pbSaveData();
                    pbInitEvents();
                });
            });
        }
    });
    //edit
    jQuery(".builder-area>.item>.list>.actions>a.action-edit,.row-container>.list>.actions>a.action-edit").unbind("click").bind("click",function(e){
        var $parent = jQuery(this).closest('.action-container');
        if($parent.css('position')==='relative'){
            e.preventDefault();
            jQuery('.action-container.item-modalled').removeClass('item-modalled');
            $parent.addClass('item-modalled');
            var html = $parent.children('.data').html();
            //pbInitModalSave
            jQuery( '<div id="pb-modal-container" class="'+$parent.attr('data-slug')+'" />' ).append(html).dialog({
                closeOnEscape: true,
                title: $parent.children('.list').children('.name').text(),
                resizable: false,
                width: 800,
                open: function(event, ui){
                    jQuery(this).closest('.ui-dialog-content').removeClass('ui-dialog-content').addClass('waves-ui-dialog-content');
                    jQuery(this).closest('.ui-dialog').addClass('tw-pb-main-container');
                    jQuery(this).closest('.ui-dialog').focus();
                    if($parent.attr('data-help')){jQuery(this).closest('.ui-dialog').find('.ui-dialog-buttonpane').prepend('<a href="'+$parent.attr('data-help')+'" target="_blank" class="watch-tutorial">LINK</a>');}
                    pbModalInitActions(jQuery(this));
                    $twBuilderScorollTop=jQuery(window).scrollTop();
                    twDlgOpen();
                },
                close: function(){
                    twDlgClose();
                    window.wpActiveEditor=$currentContentEditor='content';
                    jQuery('#pb-modal-container').closest('.ui-dialog').remove();
                    jQuery('body>#pb-modal-container').remove();
                    jQuery(window).scrollTop($twBuilderScorollTop);
                },
                buttons: {
                    "Save": function() {
                        if($parent.hasClass('row-container')&&jQuery('>.custom-field-container>.field-item [data-name="admin_row_name"]',jQuery(this)).attr('data-name')==='admin_row_name'&&jQuery('>.list>.row-name>.waves-row-title',$parent).hasClass('waves-row-title')){
                            jQuery('>.list>.row-name>.waves-row-title',$parent).text('Container: '+jQuery('>.custom-field-container>.field-item [data-name="admin_row_name"]',jQuery(this)).val());
                        }
                        pbModalSave(jQuery(this));
                        jQuery(this).dialog("close");
                        pbSaveData();
                    },
                    "Cancel": function() {
                        jQuery(this).dialog("close");
                    }
                }
            });
        }
    });
    //remove item
    jQuery(".builder-area>.item>.list>.actions>a.action-delete,.row-container>.list>.actions>a.action-delete").unbind("click").bind("click",function(e){
        var $currentDeleteModal = jQuery(this).closest('.action-container');
        if($currentDeleteModal.css('position')==='relative'){
            e.preventDefault();
            //pbInitModalSave
            jQuery( '<div id="pb-delete-modal-container" />' ).append('Are you sure to delete this?').dialog({
                closeOnEscape: true,
                title: 'Confirm',
                resizable: false,
                width: 800,
                open: function(event, ui){
                    jQuery(this).closest('.ui-dialog-content').removeClass('ui-dialog-content').addClass('waves-ui-dialog-content');
                    jQuery(this).closest('.ui-dialog').addClass('tw-pb-main-container');
                    jQuery(this).closest('.ui-dialog').find('.ui-dialog-buttonset>.ui-button').first().focus();
                    $twBuilderScorollTop=jQuery(window).scrollTop();
                    twDlgOpen();
                },
                close: function(){
                    twDlgClose();
                    $currentDeleteModal=false;
                    jQuery('#pb-delete-modal-container').closest('.ui-dialog').remove();
                    jQuery('body>#pb-delete-modal-container').remove();
                    jQuery(window).scrollTop($twBuilderScorollTop);
                },
                buttons: {
                    "Yes": function() {
                        $currentDeleteModal.remove();
                        $currentDeleteModal=false;
                        pbSaveData();
                        jQuery(this).dialog("close");
                    },
                    "No": function() {
                        jQuery(this).dialog("close");
                    }
                }
            });
        }
    });
    //expand item
    jQuery(".row-container>.list>.actions>a.action-expand").unbind("click").bind("click",function(e){e.preventDefault();
        var $currBtn = jQuery(this);
        var $curr    = $currBtn.closest('.action-container');
        $curr.children('.builder-area').each(function(){
            jQuery(this).css('height',jQuery(this).height()+'px');
        }).promise().done(function(){
            if($curr.hasClass('closed')){
                jQuery('>.data>.custom-field-container [data-name="admin_row_closed"]',$curr).attr("value",'false');
                $curr.children('.builder-area').each(function(){
                    var $currBR=jQuery(this);
                    if(!$currBR.hasClass('col-md-0')){
                        $currBR.css('display','block');
                        var $newH=$currBR.height();
                        if($newH<150){$newH=150;}
                        $currBR.css('min-height','0').css('height','0').animate({'height':$newH+'px'},"normal", function(){
                            $curr.removeClass('closed');
                            $currBtn.find('span').text('Close');
                            $currBR.css('min-height','').css('height','').css('display','');
                        });
                    }
                });
            }else{
                jQuery('>.data>.custom-field-container [data-name="admin_row_closed"]',$curr).attr("value",'true');
                $curr.children('.builder-area').animate({'min-height':'0','height':'0'},"normal", function(){
                    $curr.addClass('closed');
                    $currBtn.find('span').text('Expand');
                });
            }
            pbSaveData();
        });
        
    });
    // END   - Builder Item Actions
}
	
function pbSaveData(){
    var $currSaving=++$pbSavingLast;
    // Saving Datas
    twPublishEnable('disable');
    var savingInt=setInterval(function(){
        twPublishEnable('disable');
        if($pbSavingDone){
            $pbSavingDone=false;
            clearInterval(savingInt);
            var item = '';
            jQuery('#pagebuilder-area>.row-container').each(function(iRow){
                var $currentRow=jQuery(this);
                if(iRow){item += ',';}
                item += '"'+iRow+'":{';
                jQuery('>.data>.custom-field-container>.field-item>.field-data>.field',$currentRow).each(function(){
                    var $currentContainerField=jQuery(this);
                    item += '"'+$currentContainerField.attr('data-name')+'":"'+$currentContainerField.val()+'",';
                }).promise().done(function(){
                    item += '"layouts":{';
                    jQuery('>.builder-area',$currentRow).each(function(iCont){
                        var $currentContainer=jQuery(this);
                        var $size='';
                        var $classes=$currentContainer.attr('class').split(' ');
                        for(var i=0,len=$classes.length;i<len;i++){
                            if($classes[i].search('size-')!==-1){
                                $size=$classes[i];
                                break;
                            }
                        }
                        if(iCont){item += ',';}
                        item += '"'+iCont+'":{"size":"'+$size+'",';
                        item += '"items":{';
                        $currentContainer.children('.item').each(function(i){
                            var $currentItem=jQuery(this);
                            var $currentFieldVal='';
                            if(i){item += ',';}
                            item += '"'+i+'":{"slug":"'+$currentItem.attr('data-slug')+'","size":"' + jQuery('.list>.size-sizer-container>.size',$currentItem).text() + '",';
                            jQuery('.data .general-field-container>.field-item>.field-data>.field',$currentItem).each(function(){
                                var $currentField=jQuery(this);
                                item += '"'+$currentField.attr('data-name')+'":"'+encodeURIComponent($currentField.val())+'",';
                            }).promise().done(function(){
                                item += '"settings":{';
                                jQuery('.data .custom-field-container>.field-item>.field-data>.field',$currentItem).each(function(index){
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
                                                        $currentFieldVal='';
                                                        if($currentContainerItemField.attr('data-type')==="textArea"){
                                                            $currentFieldVal=$currentContainerItemField.html().replace(/&lt;/gi,'<').replace(/&gt;/gi, '>');
                                                        }else{
                                                            $currentFieldVal=$currentContainerItemField.val();
                                                        }
                                                        item += '"'+$currentContainerItemField.attr('data-name')+'":"'+encodeURIComponent($currentFieldVal)+'"';
                                                    });
                                                item += '}';
                                            });
                                        item += '}';
                                    }else{
                                        $currentFieldVal='';
                                        if($currentField.attr('data-type')==="textArea"){
                                            $currentFieldVal=$currentField.html().replace(/&lt;/gi,'<').replace(/&gt;/gi, '>');
                                        }else{
                                            $currentFieldVal=$currentField.val();
                                        }
                                        item += '"'+$currentField.attr('data-name')+'":"'+encodeURIComponent($currentFieldVal)+'"';
                                    }
                                }).promise().done(function(){
                                    item += '}}';
                                });
                            });
                        }).promise().done(function(){
                            item += '}}';
                        });
                    }).promise().done(function(){
                        item += '}}';
                    });
                });
            }).promise().done(function(){
    //            jQuery('textarea#pb_content').val('{'+item+'}');
                jQuery('textarea#pb_content').val(encodeURIComponent('{'+item+'}'));
                if($currSaving===$pbSavingLast){
                    twPublishEnable('enable');
                    $pbSavingDone=true;
                }else{
                    $pbSavingDone=true;
                }
            });
        }
    },500);
}
function pbModalInitActions($currentModal){
    //Font Awesome Actions
    jQuery('#shortcode_container_dialog [data-name="fa_type"]').closest('.field-item').hide();
    jQuery('#shortcode_container_dialog [data-name="cc_type"],#pb-modal-container [data-name="cc_type"]').closest('.field-item').hide();
    jQuery('[data-name="fa_icon"]',$currentModal).each(function(){
        var $currIconField = jQuery(this).closest('.field-item');
        var $currFa = $currIconField.siblings('.field-item.type-fa').hasClass('type-fa')?$currIconField.siblings('.field-item.type-fa'):$currentModal;
        var $currFaFields = $currIconField.parent().children('.field-item');
        //Font Awesome Viewer
        jQuery('[data-name="fa_icon"]',$currFaFields).unbind('input').bind('input',function(){
            var $style='display:inline-block; text-align:center; margin: 0 auto;';
            $style +='font-size:'       +jQuery('[data-name="fa_size"]',    $currFaFields).val()+'px;';
            $style +='width:'           +jQuery('[data-name="fa_size"]',    $currFaFields).val()+'px;';
            $style +='line-height:'     +jQuery('[data-name="fa_size"]',    $currFaFields).val()+'px;';
            $style +='padding:'         +jQuery('[data-name="fa_padding"]', $currFaFields).val()+'px;';
            $style +='color:'           +jQuery('[data-name="fa_color"]',   $currFaFields).val()+';';
            $style +='background-color:'+jQuery('[data-name="fa_bg_color"]',    $currFaFields).val()+';';
            $style +='border-color:'    +jQuery('[data-name="fa_border_color"]',$currFaFields).val()+';';
            $style +='border-width:'    +jQuery('[data-name="fa_rounded"]',     $currFaFields).val()+'px;';
            jQuery('.fa-viewer',$currFa).html('<i class="fa '+jQuery('[data-name="fa_icon"]', $currFaFields).val()+' '+jQuery('[data-name="fa_type"]', $currFaFields).val()+'" style="border-style: solid; '+$style+'"></i>');
        });
        jQuery('[data-name="fa_icon"]',$currFaFields).trigger('input');
        //Font Awesome Modal
        jQuery('.show-fa-modal',$currFa).unbind('click').bind('click',function(e){e.preventDefault();
            var $currentButton=jQuery(this);
            if($currentButton.not('.loading')){
                $currentButton.addClass('loading');
                jQuery.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: {
                        'action':'get_fontawesome'
                    },
                    success: function(response){
                        if(jQuery(response).hasClass('fontawesome-ajax-data')){
                            jQuery( '<div id="fontawesome_container_dialog" data-current="none" />').append(jQuery(response).html()).dialog({
                                title: 'Font Awesome',
                                resizable: true,
                                width: 800,
                                open: function(){
                                    jQuery(this).closest('.ui-dialog-content').removeClass('ui-dialog-content').addClass('waves-ui-dialog-content');
                                    jQuery(this).closest('.ui-dialog').addClass('tw-pb-main-container');
                                    jQuery(this).closest('.ui-dialog').focus();
                                    pbModalSaveField($currFaFields,jQuery(this).find('.general-field-container').children('.field-item'));
                                    pbModalInitActions(jQuery(this));
                                    pbFaModalInitActions(jQuery(this));
                                    twDlgOpen();
                                },
                                close: function(){
                                    twDlgClose();
                                    jQuery('#fontawesome_container_dialog').closest('.ui-dialog').remove();
                                    jQuery('body>#fontawesome_container_dialog').remove();
                                },
                                buttons: {
                                    "Insert": function() {
                                        pbModalSaveField(jQuery(this).find('.general-field-container').children('.field-item'),$currentButton.closest('.field-item').parent().children('.field-item'));
                                        $currentButton.closest('.field-item').parent().find('[data-name="fa_icon"]').trigger('input');
                                        jQuery(this).dialog("close");
                                    },
                                    "Cancel": function() {
                                        jQuery(this).dialog("close");
                                    }
                                }
                            });
                        }
                        $currentButton.removeClass('loading');
                    }
                });
            }
        });
    });
    //Circle Chart Actions
    jQuery('[data-name="cc_icon"]',$currentModal).each(function(){
        var $currIconField = jQuery(this).closest('.field-item');
        var $currCc = $currIconField.siblings('.field-item.type-cc').hasClass('type-cc')?$currIconField.siblings('.field-item.type-cc'):$currentModal;
        var $currCcFields = $currIconField.parent().children('.field-item');
        //Circle Chart Viewer
        jQuery('[data-name="cc_icon"]',$currCcFields).unbind('input').bind('input',function(){
            var $html='';
            var $style='display:block; text-align:center; margin: 0 auto;';
            $style +='width:'      +jQuery('[data-name="cc_size"]',      $currCcFields).val()+'px;';
            $style +='line-height:'+jQuery('[data-name="cc_size"]',      $currCcFields).val()+'px;';
            var $cStyle='';
            $cStyle +='color:'+jQuery('[data-name="cc_font_color"]',$currCcFields).val()+';';
            $cStyle +='font-size:'  +jQuery('[data-name="cc_font_size"]', $currCcFields).val()+'px;';
            $html +='<div class="tw-circle-chart" data-percent="'+jQuery('[data-name="cc_percent"]',$currCcFields).val()+'">';
                $html +='<span style="'+$cStyle+'">';
                    if(jQuery('[data-name="cc_type"]', $currCcFields).val()==='fa'){
                        $html +='<i class="fa '+jQuery('[data-name="cc_icon"]', $currCcFields).val()+'" style="'+$style+'"></i>';
                    }else{
                        $html +=jQuery('[data-name="cc_text"]',$currCcFields).val();
                    }
                $html +='</span>';                
            $html +='</div>';
            jQuery('.cc-viewer',$currCc).html($html);
            jQuery('.tw-circle-chart',$currCc).easyPieChart({                
                lineWidth  : jQuery('[data-name="cc_line_width"]' ,$currCcFields).val(),
                size       : jQuery('[data-name="cc_size"]'       ,$currCcFields).val(),
                barColor   : jQuery('[data-name="cc_color"]'      ,$currCcFields).val(),
                trackColor : jQuery('[data-name="cc_track_color"]',$currCcFields).val(),
                scaleColor : false,
                lineCap    : 'butt'
            });
            
        });
        jQuery('[data-name="cc_icon"]',$currCcFields).trigger('input');
        //Circle Chart Modal
        jQuery('.show-cc-modal',$currCc).unbind('click').bind('click',function(e){e.preventDefault();
            var $currentButton=jQuery(this);
            if($currentButton.not('.loading')){
                $currentButton.addClass('loading');
                jQuery.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: {
                        'action':'get_circlechart'
                    },
                    success: function(response){
                        if(jQuery(response).hasClass('fontawesome-ajax-data')){
                            jQuery( '<div id="circlechart_container_dialog" data-current="none" />').append(jQuery(response).html()).dialog({
                                title: 'Circle Chart',
                                resizable: true,
                                width: 800,
                                open: function(){
                                    jQuery(this).closest('.ui-dialog-content').removeClass('ui-dialog-content').addClass('waves-ui-dialog-content');
                                    jQuery(this).closest('.ui-dialog').addClass('tw-pb-main-container');
                                    jQuery(this).closest('.ui-dialog').focus();
                                    pbModalSaveField($currCcFields,jQuery(this).find('.general-field-container').children('.field-item'));
                                    pbModalInitActions(jQuery(this));
                                    pbCcModalInitActions(jQuery(this));
                                    twDlgOpen();
                                },
                                close: function(){
                                    twDlgClose();
                                    jQuery('#circlechart_container_dialog').closest('.ui-dialog').remove();
                                    jQuery('body>#circlechart_container_dialog').remove();
                                },
                                buttons: {
                                    "Insert": function() {
                                        pbModalSaveField(jQuery(this).find('.general-field-container').children('.field-item'),$currentButton.closest('.field-item').parent().children('.field-item'));
                                        $currentButton.closest('.field-item').parent().find('[data-name="cc_icon"]').trigger('input');
                                        jQuery(this).dialog("close");
                                    },
                                    "Cancel": function() {
                                        jQuery(this).dialog("close");
                                    }
                                }
                            });
                        }
                        $currentButton.removeClass('loading');
                    }
                });
            }
        });
    });
    //Upload Button Item
    jQuery('.field-item>.field-data>[data-type="button"]',$currentModal).each(function(){
        var $currentButton=jQuery(this);
        var $currentButtonSaveTo=$currentButton.attr('data-save-to');
        if($currentButtonSaveTo!==''){
            $currentButton.unbind('click').bind('click',function(){
                var $currentSaveField = $currentButton.closest('.field-item').siblings('.field-item').find('>.field-data>[data-name="'+$currentButtonSaveTo+'"]',$currentModal);
                window.original_send_to_editor = window.send_to_editor;
                window.custom_editor = true;
                window.send_to_editor = function(html){
                    html = jQuery("<div />").html(html);
                    $currentSaveField.val(jQuery(html).find('img').attr('src'));
                    tb_remove();
                };
                tb_show('Upload', $homeURI+'/wp-admin/media-upload.php?post_ID=' + pID + '&type=image&TB_iframe=true',false);
                jQuery('#TB_overlay').css('z-index','9998');
                jQuery('#TB_window').css('z-index','9999');
            });
        }
    });
    //TextEditor Item
    jQuery('.field-item>.field-data>[data-tinymce="true"]',$currentModal).each(function(){
        var $currentEditor=jQuery(this);
        var $currentEditorName=$currentEditor.attr('data-name')+'-'+$currentContentEditorInterval++;
        pbModalContentEditor($currentEditorName,$currentEditor);
        window.wpActiveEditor=$currentContentEditor=$currentEditorName;
    });
    //CheckBox Item
    jQuery('.field-item>.field-data>[data-type="checkbox"]',$currentModal).each(function(){
        var $currentCheck=jQuery(this);
        var $currentCheckText=$currentCheck.next('.checkbox-text');
        $currentCheckText.unbind('click').bind('click',function(){
            $currentCheck.attr("value",!$currentCheck.is(':checked')).attr("checked",!$currentCheck.is(':checked')).change();
        });
        $currentCheck.unbind('change').bind('change',function(){
            var $marginLeft='-39px';
            var $bgColor   ='#aeaeae';
            if($currentCheck.is(':checked')){
                $marginLeft='0px';
                $bgColor='#2dcb73';
                if($currentCheck.closest('.waves-ui-dialog-content.ui-widget-content').hasClass('accordion')){
                    $currentCheck.closest('.container-item').siblings('.container-item').find('.field-item>.field-data>[data-name="'+$currentCheck.attr('data-name')+'"]').attr("value","false").attr("checked",false).change();
                }
            }
            $currentCheckText.animate({
                marginLeft: $marginLeft,
                backgroundColor: $bgColor
            },300);
        });
        $currentCheck.change();
    });
    //Select Item
    jQuery('.field-item>.field-data>select',$currentModal).each(function(){
        var $currentSelect=jQuery(this);
        var $currentSelectText=$currentSelect.next('.select-text');
        $currentSelectText.width(pbItemRL($currentSelect)+$currentSelect.width()-pbItemRL($currentSelectText)); 
    });
    jQuery('.field-item>.field-data>select',$currentModal).unbind('change').bind('change',function(){
        var $currentSelect=jQuery(this);
        var $currentVal=$currentSelect.val();
        var $currentSelectText=$currentSelect.next('.select-text');
        var $currentSelectOption=$currentSelect.find('option[value="'+$currentVal+'"]');
        var $currentHideArray= $currentSelectOption.attr('hide')?$currentSelectOption.attr('hide').split(','):[""];
        $currentSelectOption.attr('selected','selected').siblings().removeAttr('selected');
        if($currentHideArray[0]!==''){
            $currentSelect.closest('.field-item').parent().children('.field-item.hide-for-select').removeClass('hide-for-select').show();
            for(var i = 0, length=$currentHideArray.length ; i<length; i++){
                if($currentHideArray[i]==='fa'||$currentHideArray[i]==='cc'){
                    $currentSelect.closest('.field-item').siblings('.field-item.type-'+$currentHideArray[i]).addClass('hide-for-select').hide();
                }else{
                    $currentSelect.closest('.field-item').siblings('.field-item').find('>.field-data>[data-name="'+$currentHideArray[i]+'"]').closest('.field-item').addClass('hide-for-select').hide();
                }
            }
        }
        $currentSelectText.text($currentSelectOption.text());
        if($currentSelect.attr('id')==='style_shortcode'&&$currentVal!=='none'){
            $currentSelect.children('option[value="none"]').attr('selected','selected').siblings().removeAttr('selected');
            twGetShortcode($currentVal);
        }
    });
    jQuery('.field-item>.field-data>select',$currentModal).change();
    //Color Picker Item
    jQuery('.field-item>.field-data>[data-type="color"]',$currentModal).each(function(){
        var $currentInput=jQuery(this);
        jQuery($currentInput.siblings(".color-info")).ColorPicker({
            onShow: function (colpkr) {
                jQuery(colpkr).find('.colorpicker_hex>input').val($currentInput.val().replace('#','')).change();
                jQuery(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                jQuery(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb, el) {
                $currentInput.siblings('.color-info').css('background-color','#' + hex);
                $currentInput.val('#' + hex).change().trigger('input');
            }
        });
        $currentInput.unbind('input change').bind('input change',function(){
            if(jQuery(this).val()===''){
                jQuery(this).val(' ');
            }else if(jQuery(this).val().search(' ')!==-1){
                jQuery(this).val(jQuery(this).val().replace(/ /gi,''));
            }
            $currentInput.siblings('.color-info').css('background-color',jQuery(this).val());
        });
        jQuery(this).change();
    });
    //Container Item
    jQuery('.field-item>.field-data>[data-type="container"]',$currentModal).each(function(){
        var $currentContainer = jQuery(this);
        jQuery('.field-item>.field-data>[data-name="'+$currentContainer.attr('data-add-button')+'"]',$currentModal).unbind('click').bind('click',function(e){e.preventDefault();
            var $currentButton=jQuery(this);
            var $newElement = $currentButton.next('.data').find('[data-type="container"]');
            if($currentContainer.attr('data-container-type')==='toggle'){
                $currentContainer.append($newElement.html());
                pbModalInitActions($currentModal);
            }else{
                window.original_send_to_editor = window.send_to_editor;
                window.custom_editor = true;
                window.send_to_editor = function(html){
                    html = jQuery("<div />").html(html);
                    jQuery(html).find('img').each(function(){
                        $newElement.find('.image-src').attr('src',jQuery(this).attr('src'));
                        $newElement.find('[data-name="'+$newElement.attr('data-title-as')+'"]').attr('value',jQuery(this).attr('src'));
                        $currentContainer.append($newElement.html());
                    }).promise().done(function(){
                        tb_remove();
                        pbModalInitActions($currentModal);
                    });
                };
                tb_show('Upload', $homeURI+'/wp-admin/media-upload.php?post_ID=' + pID + '&type=image&TB_iframe=true',false);
                jQuery('#TB_overlay').css('z-index','9998');
                jQuery('#TB_window').css('z-index','9999');
            }
        });
        if($currentContainer.attr('data-container-type')==='toggle'){
            jQuery('.container-item>.content>.field-item>.field-data>[data-name="'+$currentContainer.attr('data-title-as')+'"]',$currentContainer).each(function(){
                var $currentChanger=jQuery(this);
                var $currentChangerType=$currentChanger.attr('data-type');
                if($currentChangerType==='select'){
                    $currentChanger.bind('change',function(){
                        $currentChanger.closest('.container-item').children('.list').children('.name').text($currentChanger.val());
                    });
                    $currentChanger.change();
                }else{
                    $currentChanger.unbind('input').bind('input',function(e){e.preventDefault();
                        $currentChanger.closest('.container-item').children('.list').children('.name').text($currentChanger.val());
                    });
                    $currentChanger.trigger('input');
                }
            });
        }
    });
    jQuery('.container-item>.list',$currentModal).unbind('click').bind('click',function(e){e.preventDefault();
        var $containerItem = jQuery(this).closest('.container-item');
        if($containerItem.closest('.container').attr('data-container-type')==='toggle'){
            if($containerItem.hasClass('expanded')){
                jQuery(this).next('.content').slideUp("normal", function(){$containerItem.removeClass('expanded');});
            }else{
                jQuery(this).next('.content').slideDown("normal", function(){$containerItem.addClass('expanded');});
            }
        }
    });
    jQuery('.container-item>.list>.actions>.action-delete',$currentModal).unbind('click').bind('click',function(e){e.preventDefault();
        jQuery(this).closest('.container-item').remove();
    });
    jQuery('.container-item>.list>.actions>.action-duplicate',$currentModal).unbind('click').bind('click',function(e){e.preventDefault();
        var $parent = jQuery(this).closest('.container-item');
        var $newItem = $parent.clone().addClass('hidded').css('display','none');
        $parent.after($newItem).promise().done(function(){
            $newItem.removeClass('hidded').fadeIn('slow').promise().done(function(){
                pbModalInitActions($currentModal);
            });
        });
        return false;
    });
    jQuery('.field-item>.field-data>[data-type="container"]',$currentModal).sortable({placeholder: 'container-item placeholding'});
    //Category Item
    function catReseter($currentCategorySelector, $currentSaveTo){
        var $currentCategoryList = $currentCategorySelector.siblings('.category-list-container');
        var $currentSaveToArray=$currentSaveTo.val().split(',');
        $currentCategorySelector.find('option').show();
        $currentCategoryList.html('');
        for (var i = 0, length=$currentSaveToArray.length ; i<length; i++){
            if($currentSaveToArray[i]!==''){
                $currentCategoryList.append('<div class="category-list-item clearfix" data-value="'+$currentSaveToArray[i]+'"><div class="name">'+$currentCategorySelector.find('option[value="'+$currentSaveToArray[i]+'"]').hide().text()+'</div><div class="actions"><a href="#" class="action-delete">X</a></div></div>');
            }
        }
        $currentCategoryList.find(".category-list-item .action-delete").unbind('click').bind('click',function(e){e.preventDefault();
            var $oldArray=$currentSaveTo.val().split(',');
            var $newArray=[];
            var $delValue=jQuery(this).closest(".category-list-item").attr('data-value');
            jQuery(this).closest(".category-list-item").remove();
            for (var i = 0, length=$oldArray.length ; i<length; i++){
                if($oldArray[i]!==$delValue && $oldArray[i]!==''){
                    $newArray.push($oldArray[i]);
                }
            }
            $currentSaveTo.val($newArray.join(','));
            catReseter($currentCategorySelector, $currentSaveTo)
        });
    }
    jQuery('.field-item>.field-data>[data-type="category"]',$currentModal).each(function(){
        var $currentCategorySelector = jQuery(this);
        var $currentCategoryList = $currentCategorySelector.siblings('.category-list-container');
        var $currentSaveTo       = jQuery('.field-item>.field-data>[data-selector="'+$currentCategorySelector.attr('data-name')+'"]',$currentModal);
        $currentCategorySelector.change(function(){
            var $val  = $currentCategorySelector.val();
            var $noProblem = true;
            $currentCategoryList.children(".category-list-item").each(function(){
                if(jQuery(this).attr('data-value') == $val) {
                    $noProblem = false;
                }
            });
            if($val == 0 || $val == '0'){
                return false;
            }else{
                $currentCategorySelector.children('option[value="0"]').attr('selected','selected').siblings().removeAttr('selected');
                $currentCategorySelector.change();
                if($noProblem){
                    var $currentSaveToArray = $currentSaveTo.val().split(',');
                    if($currentSaveToArray.indexOf($val)<0){
                        if($currentSaveToArray[0]===''){
                            $currentSaveToArray[0]=$val;
                        }else{
                            $currentSaveToArray.push($val);
                        }
                        $currentSaveTo.val($currentSaveToArray.join(','));
                    }
                    catReseter($currentCategorySelector,$currentSaveTo);
                }
            }
        });
        catReseter($currentCategorySelector,$currentSaveTo);
    });
    jQuery('textarea',$currentModal).each(function(){
        var $currTextArea=jQuery(this);
        $currTextArea.unbind('input').bind('input',function(){$currTextArea.html($currTextArea.val());});
    });
}
function pbFaModalInitActions($currentFaModal){
    jQuery('[data-name="icon_type"]',$currentFaModal).bind('change',function(){
        if(jQuery(this).val()==='fa'){
            jQuery('ul.unstyled>.row.fontawesome',$currentFaModal).show();
            jQuery('ul.unstyled>.row.simple-line-icons',$currentFaModal).hide();
        }else{
            jQuery('ul.unstyled>.row.fontawesome',$currentFaModal).hide();
            jQuery('ul.unstyled>.row.simple-line-icons',$currentFaModal).show();
        }
    });
    jQuery('ul.unstyled>.row>div',$currentFaModal).unbind('click').bind('click',function(e){e.preventDefault();
        jQuery('ul.unstyled>.row>div.active',$currentFaModal).removeClass('active');
        jQuery(this).addClass('active');
        var $iconClass=jQuery(this).children('span.muted').eq(0).text().replace(' ','');
        jQuery('[data-name="fa_icon"]',$currentFaModal).val($iconClass).trigger('input');
    });
    
    
    jQuery('[data-name="fa_type"]',$currentFaModal).bind('change',function(){
        jQuery('[data-name="fa_icon"]',$currentFaModal).trigger('input');
    });
    jQuery('[data-name="fa_size"],[data-name="fa_padding"],[data-name="fa_color"],[data-name="fa_border_color"],[data-name="fa_bg_color"],[data-name="fa_rounded"]',$currentFaModal).unbind('input').bind('input',function(){
        jQuery('[data-name="fa_icon"]',$currentFaModal).trigger('input');
    });
    jQuery('ul.unstyled>.row>div>.muted',$currentFaModal).each(function(){
        if(jQuery(this).text().trim()===jQuery('[data-name="fa_icon"]',$currentFaModal).val().trim()){
            var $tmp= jQuery(this).closest('.row').hasClass('fontawesome')?'fa':'sl';
            jQuery('[data-name="icon_type"] [value="'+$tmp+'"]',$currentFaModal).attr('selected','selected').siblings('option').removeAttr('selected');
            jQuery('[data-name="icon_type"]',$currentFaModal).change();
            jQuery(this).parent().click();
        }
    });
}
function pbCcModalInitActions($currentCcModal){
    jQuery('[data-name="icon_type"]',$currentCcModal).bind('change',function(){
        if(jQuery(this).val()==='fa'){
            jQuery('ul.unstyled>.row.fontawesome',$currentCcModal).show();
            jQuery('ul.unstyled>.row.simple-line-icons',$currentCcModal).hide();
        }else{
            jQuery('ul.unstyled>.row.fontawesome',$currentCcModal).hide();
            jQuery('ul.unstyled>.row.simple-line-icons',$currentCcModal).show();
        }
    });
    jQuery('ul.unstyled>.row>div',$currentCcModal).unbind('click').bind('click',function(e){e.preventDefault();
        jQuery('ul.unstyled>.row>div.active',$currentCcModal).removeClass('active');
        jQuery(this).addClass('active');
        var $iconClass=jQuery(this).children('span.muted').eq(0).text().replace(' ','');
        jQuery('[data-name="cc_icon"]',$currentCcModal).val($iconClass).trigger('input');
    });
    jQuery('[data-name="cc_type"]',$currentCcModal).bind('change',function(){
        if(jQuery(this).val()==='text'){
            jQuery('.fontawesome-field-container>.container>.unstyled',$currentCcModal).hide();
        }else{
            jQuery('.fontawesome-field-container>.container>.unstyled',$currentCcModal).show();
        }
        jQuery('[data-name="cc_icon"]',$currentCcModal).trigger('input');
    }).change();
    jQuery('[data-name="cc_line_width"],[data-name="cc_text"],[data-name="cc_percent"],[data-name="cc_size"],[data-name="cc_font_size"],[data-name="cc_font_color"],[data-name="cc_color"],[data-name="cc_track_color"]',$currentCcModal).unbind('input').bind('input',function(){
        jQuery('[data-name="cc_icon"]',$currentCcModal).trigger('input');
    });
    jQuery('ul.unstyled>.row>div>.muted',$currentCcModal).each(function(){
        if(jQuery(this).text().trim()===jQuery('[data-name="cc_icon"]',$currentCcModal).val().trim()){
            var $tmp= jQuery(this).closest('.row').hasClass('fontawesome')?'fa':'sl';
            jQuery('[data-name="icon_type"] [value="'+$tmp+'"]',$currentCcModal).attr('selected','selected').siblings('option').removeAttr('selected');
            jQuery('[data-name="icon_type"]',$currentCcModal).change();
            jQuery(this).parent().click();
        }
    });
}
function pbModalSaveField($from,$to){
    $from.each(function(){
        var $currentField         = jQuery(this).children('.field-data').children('.field');
        var $currentFieldSlug     = $currentField.attr('data-name');
        var $currentFieldType     = $currentField.attr('data-type');
        var $currentFieldAddButton= $currentField.attr('data-add-button');
        var $currentFieldValue    = $currentField.val();
        switch($currentFieldType){
            case 'select':{
                jQuery('>.field-data>.field[data-name="'+$currentFieldSlug+'"] option[value="'+$currentFieldValue+'"]',$to).attr('selected','selected').siblings().removeAttr('selected');
                break;
            }
            case 'textArea':{
                if($currentField.attr('data-tinyMCE')==='true'){
                    tinymce.execCommand('mceAddEditor', false, $currentContentEditor);
                    var $tmpCont=tinymce.get($currentContentEditor).getContent();
                    jQuery('>.field-data>.field[data-name="'+$currentFieldSlug+'"]',$to).html($tmpCont);
                }else{
                    jQuery('>.field-data>.field[data-name="'+$currentFieldSlug+'"]',$to).html($currentFieldValue);
                }
                break;
            }
            case 'container':{
                var $newContainer = jQuery('>.field-data>.field[data-name="'+$currentFieldSlug+'"]',$to);
                var $template=jQuery('>.field-data>.field[data-name="'+$currentFieldAddButton+'"]',$from).next('.data').children('.field-item').children('.field-data').children('.field').html();
                $template = jQuery('<div/>').append($template);
                $newContainer.html('');
                $currentField.children('.container-item').each(function(){
                    jQuery(this).find('>.content>.field-item>.field-data>.field').each(function(){
                        var $cField         = jQuery(this);
                        var $cFieldSlug     = $cField.attr('data-name');
                        var $cFieldType     = $cField.attr('data-type');
                        var $cFieldValue    = $cField.val();
                        switch($cFieldType){
                            case 'select':{
                                jQuery('.field[data-name="'+$cFieldSlug+'"] option[value="'+$cFieldValue+'"]',$template).attr('selected','selected').siblings().removeAttr('selected');
                                break;
                            }
                            case 'textArea':{
                                jQuery('.field[data-name="'+$cFieldSlug+'"]',$template).html($cFieldValue);
                                break;
                            }
                            case 'checkbox':{
                                jQuery('.field[data-name="'+$cFieldSlug+'"]',$template).attr("value",$cField.is(':checked')).attr("checked",$cField.is(':checked'));
                                break;
                            }
                            default:{
                                jQuery('.field[data-name="'+$cFieldSlug+'"]',$template).attr("value",$cFieldValue);
                                break;
                            }
                        }
                    });
                    $newContainer.append($template.html());
                });
                break;
            }
            case 'checkbox':{
                jQuery('>.field-data>.field[data-name="'+$currentFieldSlug+'"]',$to).attr("value",$currentField.is(':checked')).attr("checked",$currentField.is(':checked'));
                break;
            }
            default:{
                jQuery('>.field-data>.field[data-name="'+$currentFieldSlug+'"]',$to).attr("value",$currentFieldValue);
                break;
            }
        }
    });
}
function pbModalSave($item){
    var $saveTo   = jQuery('.action-container.item-modalled');
    $saveTo.removeClass('item-modalled');
    pbModalSaveField($item.find('.general-field-container').children('.field-item'),jQuery('>.data>.general-field-container>.field-item',$saveTo));
    pbModalSaveField($item.find('.custom-field-container') .children('.field-item'),jQuery('>.data>.custom-field-container>.field-item' ,$saveTo));
}
/* Item Right Left Width */
/* ------------------------------------------------------------------- */
function pbItemRL($item){
    $item=jQuery($item);
    var $itemMarginRL  = parseInt($item.css('margin-left') .replace('px',''))      + parseInt($item.css('margin-right').replace('px',''));
    var $itemPaddingRL = parseInt($item.css('padding-left').replace('px',''))      + parseInt($item.css('padding-right').replace('px',''));
    var $itemBorderRL  = parseInt($item.css('border-left-width').replace('px','')) + parseInt($item.css('border-right-width').replace('px',''));
    var $itemRL = $itemMarginRL+$itemPaddingRL+$itemBorderRL;
    return $itemRL;
}
/* Content Editor */
function pbModalContentEditor($id,$currentEditor){
    var $language = jQuery('html').attr('lang');
    var $currentField = $currentEditor.closest('.field-data');
    $language = $language.substr(0,$language.indexOf('-'));
    var $newEditorDiv= jQuery('<div />').append($currentEditor.clone().attr('id',$id));
    $currentEditor.hide().closest('.field-data').append(
        '<div class="wp-editor-tools tw-editor-menu hide-if-no-js">'+
            '<a class="change-to-html wp-switch-editor switch-html">Text</a>'+
            '<a class="change-to-visual disabled wp-switch-editor switch-tmce">Visual</a>'+
            '<div class="wp-media-buttons"><a href="#" id="insert-media-button" class="button insert-media add_media" data-editor="'+$id+'" title="Add Media"><span class="wp-media-buttons-icon"></span> Add Media</a></div>'+
        '</div>'+
        '<div id="wp-content-editor-container" class="tw-editor-content">'+
            $newEditorDiv.html()+
        '</div>'
    ).promise().done(function(){
        tinymce.init({
            theme:"modern",
            skin:"lightgray",
            language:$language,
            formats:{alignleft:[{selector:'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: {textAlign:'left'}},{selector: 'img,table,dl.wp-caption', classes: 'alignleft'}],aligncenter: [{selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: {textAlign:'center'}},{selector: 'img,table,dl.wp-caption', classes: 'aligncenter'}],alignright: [{selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li', styles: {textAlign:'right'}},{selector: 'img,table,dl.wp-caption', classes: 'alignright'}],strikethrough: {inline: 'del'}},
            browser_spellcheck:true,
            fix_list_elements:true,
            entities:"38,amp,60,lt,62,gt",
            entity_encoding:"raw",
            keep_styles:false,
            paste_webkit_styles:"font-weight font-style color",
            preview_styles:"font-family font-size font-weight font-style text-decoration text-transform",
            wpeditimage_disable_captions:false,
            wpeditimage_html5_captions:false,
            //plugins:"inlinepopups,spellchecker,tabfocus,paste,media,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,-twshortcodegenerator",
            plugins:"charmap,hr,media,paste,tabfocus,textcolor,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpview,wpfullscreen",
            external_plugins:{twshortcodegenerator:$homeURI+"/framework/js/admin-waves-shortcode.js"},
            selector:$id,
            resize:false,
            convert_urls:false,
            menubar:false,
            wpautop:false,
            indent:false,
            toolbar1:"bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,wp_fullscreen,wp_adv,|,twshortcodegenerator",
            toolbar2:"formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help",
            toolbar3:"",
            toolbar4:"",
            tabfocus_elements:"insert-media-button,save-post",
            body_class:"content post-type-page post-status-publish",
            add_unload_trigger:false
        });
        jQuery('a.change-to-html',$currentField).unbind('click').bind('click',function() {
            jQuery(this).closest('.wp-editor-tools').removeClass('tmce-active').addClass('html-active');
            tinymce.execCommand("mceRemoveEditor", true, $id);
        });
        jQuery('a.change-to-visual',$currentField).unbind('click').bind('click',function() {
            jQuery(this).closest('.wp-editor-tools').removeClass('html-active').addClass('tmce-active');
            tinymce.execCommand("mceAddEditor", true, $id);
        }).click();
    });
}
function twSortDragg($container,$items,$placeholder,$connectWith){
    //Sortables
    jQuery($container).sortable({
        items: $items,
        placeholder: $placeholder,
        connectWith: $connectWith,
        //        helper:'original',
        revert: true,
        update: function(event, ui){
            pbSaveData();
            pbInitEvents();
        },
        start: function(event, ui) {
            var plus;
            if(ui.item.hasClass('size-1-4')) plus = 'size-1-4';
            else if(ui.item.hasClass('size-1-3')) plus = 'size-1-3';
            else if(ui.item.hasClass('size-1-2')) plus = 'size-1-2';
            else if(ui.item.hasClass('size-2-3')) plus = 'size-2-3';
            else if(ui.item.hasClass('size-3-4')) plus = 'size-3-4';
            else if(ui.item.hasClass('size-1-1')) plus = 'size-1-1';
            else plus = '';
            ui.placeholder.addClass(plus);
        }
    });
}
function twInitSortDragg($from,$to){
    var $fromRow = jQuery('>.row-container',$from).clone();
    $to.html('');
    // Rows
    twSortDragg("#pagebuilder-area",">.row-container","row-container placeholding","#pagebuilder-area");
    $fromRow.each(function(){
        $to.append(jQuery(this).clone());
    });
    // Items
    jQuery('>.row-container>.builder-area',$to).html('');
    twSortDragg("#pagebuilder-area>.row-container>.builder-area",">.item","item placeholding","#pagebuilder-area>.row-container>.builder-area");
    jQuery('>.builder-area',$fromRow).each(function($i){
        jQuery('>.row-container>.builder-area',$to).eq($i).html(jQuery(this).html());
    });
    // Draggable
    try{
        jQuery('.pagebuilder-elements-container>.item').draggable({
            connectToSortable: '#pagebuilder-area>.row-container>.builder-area',
            helper: 'clone',
            revert: "invalid",
            start : function( event, ui ){
                var $curr       = jQuery(ui.helper);
                var $currSlug   = $curr.attr('data-slug');
                var $newElement = jQuery('#items-list>[data-slug="'+$currSlug+'"]').clone();
                $curr.html($newElement.html());
            },
            stop  : function( event, ui ) {
                var $curr       = jQuery(ui.helper);
                $curr.css({'opacity':'',width:'',height:''});
                twHideToolsMenu();
            }
        });
    }catch(err){}
    jQuery('.pb-add-layout-conteiner').removeClass('loading');
}
function twPublishEnable($status){
    if($status==='enable'){
        jQuery('#publish').removeAttr('disabled').removeClass('button-primary-disabled').siblings('.spinner').css('display','');
    }else{
        jQuery('#publish').attr('disabled','disabled').addClass('button-primary-disabled').siblings('.spinner').css('display','inline');
    }    
}
function twDlgOpen(){jQuery('body').addClass('tw-dialoged');}
function twDlgClose(){if(jQuery('body>.ui-dialog.tw-pb-main-container').length===1){jQuery('body').removeClass('tw-dialoged');}}