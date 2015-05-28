jQuery(window).load(function() {
    "use strict";
    //Blog 
    jQuery('.tw-blog').each(function(i){
        var $currentPortfolio=jQuery(this);
        var $currentInfinite=$currentPortfolio.children('.tw-infinite-scroll');
        var $currentIsotopeContainer=$currentPortfolio.children('.row').children('.isotope-container');
        $currentIsotopeContainer=$currentIsotopeContainer.hasClass('isotope-container')?$currentIsotopeContainer:$currentPortfolio;
        // Infinite
        $currentInfinite.find('a').unbind('click').bind('click',function(e){e.preventDefault();
            var $currentNextLink=jQuery(this);
            if($currentInfinite.attr('data-has-next')==='true'&&$currentNextLink.hasClass('next')){
                var $infiniteURL=$currentNextLink.attr('href');
                $currentInfinite.children('.next').hide();
                $currentInfinite.children('.loading').fadeIn();
                jQuery.ajax({
                    type: "POST",
                    url: $infiniteURL,
                    success: function(response){
                        var $newElements = jQuery(response).find('.tw-blog').eq(i).children('.row').children('.isotope-container').hasClass('isotope-container')?jQuery(response).find('.tw-blog').eq(i).children('.row').children('.isotope-container').html():jQuery(response).find('.tw-blog').eq(i).html();
                        var $newURL      = jQuery(response).find('.tw-blog').eq(i).find('.tw-infinite-scroll>a.next').attr('href');
                        var $hasNext     = jQuery(response).find('.tw-blog').eq(i).find('.tw-infinite-scroll').attr('data-has-next');
                        if($newElements){
                            $newElements=jQuery('<div />').append($newElements).find('article').css('opacity','0');
                            if($currentIsotopeContainer.hasClass('isotope-container')){
                                $currentIsotopeContainer.append($newElements);
                            }else{
                                $currentInfinite.before($newElements);
                            }
                            if($hasNext==='false'){
                                $currentInfinite.attr('data-has-next','false');
                                $currentInfinite.children('.loading').hide();
                                $currentInfinite.children('.no-more').fadeIn();
                            }else{
                                $currentNextLink.attr('href',$newURL);
                                $currentInfinite.children('.loading').hide();
                                $currentInfinite.children('.next').fadeIn();
                            }
                        }else{
                            $currentInfinite.attr('data-has-next','false');
                            $currentInfinite.children('.loading').hide();
                            $currentInfinite.children('.no-more').fadeIn();
                        }
                        setTimeout(function(){
                            $currentIsotopeContainer.children('article').css('opacity','1');
                            if($currentIsotopeContainer.hasClass('isotope-container')){$currentIsotopeContainer.isotope( 'reloadItems' ).isotope({ sortBy: 'original-order' });}
                            img_slider();
                        },1000);
                        setTimeout(function(){
                            $currentIsotopeContainer.children('article').css('opacity','1');
                            if($currentIsotopeContainer.hasClass('isotope-container')){$currentIsotopeContainer.isotope( 'reloadItems' ).isotope({ sortBy: 'original-order' });}
                            img_slider();
                        },6000);
                    }
                });
            }
        });
    });
});