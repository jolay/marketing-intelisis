// Resize
jQuery(window).resize(function() {
    "use strict";

    // Logo background
    logobg();

    // jPlayer
    jQuery('.jp-audio-container, .jp-video-container').each(function() {
        jQuery(this).find('.jp-progress-container').width((jQuery(this).width() - 149 < 0) ? 0 : (jQuery(this).width() - 149));
        jQuery(this).find('.jp-progress').width((jQuery(this).width() - 152 < 0) ? 0 : (jQuery(this).width() - 152));
    });
    // Testimonials
    jQuery('.tw-testimonials').each(function() {
        jQuery(this).find('>.caroufredsel_wrapper').width(jQuery(this).width());
        jQuery(this).find('ul>li').width(jQuery(this).width());
    });
    // ThemeWaves Redraw
    jQuery('.tw-redraw').each(function() {
        var $curr = jQuery(this);
        if (!$curr.hasClass('not-drawed')) {
            $curr.trigger('tw-animate');
        }
    });
    // Portfolio Carousel Responsive
    jQuery('ul.tw-carousel>li>.gallery-container').each(function() {
        var $currGallCon = jQuery(this);
        var $currWidth = $currGallCon.width();
        jQuery('>.caroufredsel_wrapper', $currGallCon).width($currWidth);
        jQuery('>.caroufredsel_wrapper>.gallery-slide>.slide-item', $currGallCon).width($currWidth);
        var $currHeight = jQuery('>.caroufredsel_wrapper>.gallery-slide>.slide-item', $currGallCon).height();
        jQuery('>.caroufredsel_wrapper>.gallery-slide', $currGallCon).height($currHeight);
        jQuery('>.caroufredsel_wrapper', $currGallCon).height($currHeight);
        $currGallCon.trigger('tw-carousel-container-height-repair');
    });
    /* Item Right Left Width */
    /* ------------------------------------------------------------------- */
    function twItemRL($item) {
        $item = jQuery($item);
        var $itemMarginRL = parseInt($item.css('margin-left').replace('px', '')      ,10) + parseInt($item.css('margin-right').replace('px', '')      ,10);
        var $itemPaddingRL = parseInt($item.css('padding-left').replace('px', '')    ,10) + parseInt($item.css('padding-right').replace('px', '')     ,10);
        var $itemBorderRL = parseInt($item.css('border-left-width').replace('px', ''),10) + parseInt($item.css('border-right-width').replace('px', ''),10);
        var $itemRL = $itemMarginRL + $itemPaddingRL + $itemBorderRL;
        return $itemRL;
    }    
    // Map (full element)
    jQuery('.tw-full-element').each(function(){
        var $currentWavesFullElement=jQuery(this);
        var $w=jQuery(window).width();
        if(!$currentWavesFullElement.closest('.theme-boxed').hasClass('theme-boxed') || (1183<=$w && $w<=1242) || $w<=974){
            $currentWavesFullElement.css('margin-left','0px').css('width','');
            var $currLayoutWidth = jQuery(window).width()-twItemRL($currentWavesFullElement);
            var $marginLeft=$currentWavesFullElement.offset().left*-1;
            $currentWavesFullElement.css('margin-left',$marginLeft+'px');
            $currentWavesFullElement.css('width',($currLayoutWidth)+'px');
        }else{
            $currentWavesFullElement.css('margin-left','');
            $currentWavesFullElement.css('width','');
        }
    });
});
jQuery(document).ready(function($) {
    "use strict";
    // One page
    if(jQuery('#one-page-home').attr('id')==='one-page-home'){
        jQuery('ul#menu li.current-menu-item').removeClass('current-menu-item');
    }
    // Vide Responsive
    jQuery('#main iframe').each(function(){if(!jQuery(this).closest('.ls-slide').hasClass('ls-slide')){jQuery(this).addClass('makeFluid');}});
    fluidvids.init({
        selector: '#main iframe.makeFluid',
        players: ['www.youtube.com', 'player.vimeo.com']
    });
    // Nice scroll
    if (jQuery().niceScroll){
        $("html").niceScroll({
            scrollspeed: 70,
            mousescrollstep: 38,
            cursorwidth: 15,
            cursorborder: 0,
            cursorcolor: '#464646',
            cursorborderradius: 0,
            autohidemode: false,
            horizrailenabled: false
        });
    }
    // Logo background
    jQuery('.tw-divider-space').closest('.tw-element').addClass('tw-divider-space-container');
    // Logo background
    logobg();
    // Load Complete
    setTimeout(function() {
        loadComplete();
    }, 6000);
    jQuery(window).scroll(function() {
        var $filter = jQuery('#header.affix');
        var $filterHeight = $filter.height();
        var $scrollTop = jQuery(window).scrollTop();

        // START - One Page Home
        if ($scrollTop <= 50 && jQuery('ul#menu a[href$=#one-page-home]').closest('li').hasClass('menu-item')) {
            setTimeout(function() {
                jQuery('ul#menu li.current_page_item').removeClass('current_page_item');
                jQuery('ul#menu li.current-menu-item').removeClass('current-menu-item');
                jQuery('ul#menu a[href$=#one-page-home]').closest('li').addClass('current_page_item current-menu-item');
            }, 500);
        }
        // END   - One Page Home
        if ($filterHeight <= $scrollTop) {
            $filter.addClass('stuck animated fadeIn');
            if (!jQuery('#header-holder').hasClass('header-holder')) {
                $filter.after(jQuery('<div id="header-holder" class="header-holder" />').height($filterHeight));
            }
        } else {
            $filter.removeClass('stuck animated fadeIn');
            jQuery('#header-holder').remove();
        }
        if (jQuery(this).scrollTop() > jQuery('#header').height()) {
            jQuery('#scrollUp').fadeIn();
        } else {
            jQuery('#scrollUp').fadeOut();
        }
        logobg();
        setTimeout(function() {
            logobg();
        }, 100);
        setTimeout(function() {
            logobg();
        }, 500);
        setTimeout(function() {
            logobg();
        }, 1000);
    });
    jQuery(window).scroll();
    jQuery('#scrollUp').click(function() {
        jQuery("html, body").animate({scrollTop: 0}, 500);
        return false;
    });

    if (jQuery().parallax) {
        jQuery('.bg-parallax').each(function() {
            jQuery(this).parallax("50%", 0.2);
        });
    }

    $(".btn.btn-border").each(function() {
        var $color = jQuery(this).css('color');
        $('span', this).css('background-color', $color);
    });

    $(".btn.btn-flat").hover(
            function() {
                var $color = jQuery(this).css('background-color');
                $(this).css('color', $color);
            },
            function() {
                $(this).css('color', '#fff');
            }
    );


    jQuery('.likeit').live('click', function() {
        var $this = jQuery(this);
        jQuery.post($this.data('ajaxurl'), {liked_pid: $this.data('pid')})
                .done(function(response) {
            var $aa = jQuery(response).find('#portfolio_liked');
            if ($aa.attr('id') == 'portfolio_liked') {
                $this.addClass('liked');
                var $val = $aa.text();
                $this.find('span').text($val);
            }
        });
    });


    /* navigation */
    $('ul#menu').superfish({
        delay: 200,
        animation: {
            opacity: 'show',
            height: 'show'
        },
        speed: 'fast',
        autoArrows: false,
        dropShadows: false
    });

    /* mobile navigation */
    jQuery('.show-mobile-menu').click(function() {
        jQuery('#mobile-menu').slideToggle('fast').promise().done(function() {
            jQuery('#mobile-menu li').css('width', '100%').css('width', '');
        });
    });
    jQuery('#mobile-menu ul.sub-menu').each(function() {
        var $parentMenu = jQuery(this).parent('li');
        $parentMenu.addClass('has-children').prepend('<div class="action-expand"><span class="opened">-</span><span class="closed">+</span></div>');
        $parentMenu.children('.action-expand').click(function(e) {
            e.preventDefault();
            var $this = jQuery(this).closest('.has-children');
            $this.siblings('li.menu-open').removeClass('menu-open').children('.sub-menu').slideUp('fast');
            $this.toggleClass('menu-open');
            if ($this.hasClass('menu-open')) {
                $this.children('.sub-menu').slideDown('fast');
            } else {
                $this.children('.sub-menu').slideUp('fast');
            }
            return false;
        });


    });


    // One Page
    $(document).on('click', 'ul#menu a', function() {
        //get current
        var targetSection = $(this).attr('href').split("#")[1];
        if (!targetSection || targetSection == '') {
            return;
        }
        targetSection = '#' + targetSection;

        //get pos of target section
        var targetOffset = Math.floor($(targetSection).offset().top - $('#header').height());

        //scroll			 
        $('html,body').animate({scrollTop: targetOffset}, 1000, function() {
            jQuery(window).scroll();
        });
        return false;
    });
    if(window.location.toString().split("#")[1]){jQuery('.menu-container ul#menu a[href="'+window.location.toString()+'"]').click();}

    /*nav handling
     -------------------*/
    $(function() {
        jQuery('.row-container').waypoint({
            handler: function(direction) {
                var activeSection = jQuery(this);

                if (direction === "up") {
                    activeSection = activeSection.prev();
                }
                if (activeSection.attr('id')) {
                    var activeMenuLink = jQuery('ul#menu a[href$=#' + activeSection.attr('id') + ']');

                    jQuery('ul#menu a').parent('li').removeClass('current_page_item current-menu-item');
                    activeMenuLink.parent('li').addClass('current_page_item current-menu-item');
                }
            },
            offset: $('#header').height()	//when it should switch on consecutive page
        });
    });


    // Accordion
    $('.tw-accordion').each(function($index) {
        $(this).attr('id', 'accordion' + $index);
        $(this).find('.accordion-group').each(function($i) {
            $(this).find('.accordion-toggle').attr('data-parent', '#accordion' + $index).attr('href', '#accordion_' + $index + '_' + $i);
            $(this).find('.accordion-body').attr('id', 'accordion_' + $index + '_' + $i);
        });
        /* Bootstrap Accordion adding active class */
        jQuery(this).on('show', function(e) {
            jQuery(e.target).prev('.accordion-heading').find('.accordion-toggle').addClass('active');
        });
        jQuery(this).on('hide', function(e) {
            jQuery(this).find('.accordion-toggle').not(jQuery(e.target)).removeClass('active');
        });
    });

    // Toggle
    $('.tw-toggle').each(function($index) {
        $(this).find('.accordion-group').each(function($i) {
            $(this).find('.accordion-toggle').attr('href', '#toggle_' + $index + '_' + $i);
            $(this).find('.accordion-body').attr('id', 'toggle_' + $index + '_' + $i);
        });
        /* Bootstrap Accordion adding active class */
        jQuery(this).on('show', function(e) {
            jQuery(e.target).prev('.accordion-heading').find('.accordion-toggle').addClass('active');
        });
        jQuery(this).on('hide', function(e) {
            jQuery(e.target).prev('.accordion-heading').children('.accordion-toggle').removeClass('active');
        });
    });
    // Tab
    $('.tw-tab').each(function($index) {
        $(this).find(">li").each(function($i) {
            jQuery(this).appendTo(jQuery(this).closest('.tw-tab').find('ul.nav-tabs'));
            $(this).find(">a").attr('href', '#tabitem_' + $index + '_' + $i);
            if ($i === 0) {
                $(this).addClass('active');
            }
        });
        $(this).find(".tab-pane").each(function($in) {
            jQuery(this).appendTo(jQuery(this).closest('.tw-tab').find('div.tab-content'));
            $(this).attr('id', 'tabitem_' + $index + '_' + $in);
            if ($in === 0) {
                $(this).addClass('active');
            }
        });
    });
    $('.tw-tab>ul a').click(function(e) {
        e.preventDefault();
        jQuery(this).tab('show');
    });



    if (jQuery().jPlayer) {
        jQuery('.jp-jplayer-audio').each(function() {
            jQuery(this).jPlayer({
                ready: function() {
                    jQuery(this).jPlayer("setMedia", {
                        mp3: jQuery(this).data('mp3')
                    });
                },
                swfPath: "",
                cssSelectorAncestor: "#jp_interface_" + jQuery(this).data('pid'),
                supplied: "mp3, all"
            });
        });

        jQuery('.jp-jplayer-video').each(function(i) {
            jQuery(this).attr('id',"jquery_jplayer_" + i).attr('data-pid',i).siblings('.jp-video-container').find('.jp-interface').addClass('aaa').attr('id',"jp_interface_" + i);
            jQuery(this).jPlayer({
                ready: function() {
                    jQuery(this).jPlayer("setMedia", {
                        m4v: jQuery(this).data('m4v'),
                        poster: jQuery(this).data('thumb')
                    });
                },
                play: function() {jQuery(this).jPlayer("pauseOthers", 0);},
                size: {
                    width: '100%',
                    height: 'auto'
                },
                swfPath: "",
                cssSelectorAncestor: "#jp_interface_" + i,
                supplied: "m4v, all"
            });
        });
        
        jQuery('.jp-jplayer-bgvideo').each(function() {
            var $bgPlayer=jQuery(this);
            var $bgPauseBtn=$bgPlayer.closest('.row-container');
            var $bgPlayBtn =$bgPauseBtn.children('.container').find('.bg-video-play').hasClass('bg-video-play')?$bgPlayer.closest('.row-container').children('.container').find('.bg-video-play'):false;
            $bgPlayer.jPlayer({
                ready: function() {
                    $bgPlayer.jPlayer("setMedia", {
                        m4v: $bgPlayer.data('m4v'),
                        poster: $bgPlayer.data('thumb')
                    });
                    if($bgPlayBtn===false){
                        $bgPlayer.jPlayer("play");
                    }
                },
                size: {
                    width: '100%',
                    height: 'auto'
                },
                muted: true,
                loop: true,
                swfPath: "",
                cssSelectorAncestor: "#jp_interface_" + $bgPlayer.data('pid'),
                supplied: "m4v, all"
            });
            if($bgPlayBtn){
                $bgPlayBtn.unbind('click').bind('click',function(){
                    if($bgPauseBtn.hasClass('paused')){
                        $bgPlayer.jPlayer("play");
                        $bgPauseBtn.removeClass('paused').css({height:$bgPauseBtn.height()+'px',cursor: 'pointer'}).children('.container').fadeOut();
                        return false;
                    }
                });
                $bgPauseBtn.unbind('click').bind('click',function(){
                    if(!$bgPauseBtn.hasClass('paused')){
                        $bgPlayer.jPlayer("pause");
                        $bgPauseBtn.addClass("paused").css({height:'',cursor: ''}).children('.container').fadeIn();
                    }
                });
                $bgPauseBtn.click();
            }
        });
    }


    // PrettyPhoto
    jQuery("a[rel^='prettyPhoto']").prettyPhoto({
        deeplinking: false
    });

    // Milestones
    jQuery('.tw-milestones-box').each(function() {
        var $curr = jQuery(this);
        var $delay = 1000;
        if($curr.attr('data-animation-delay')!==''){
            $delay += parseInt($curr.attr('data-animation-delay'), 10);
        }
        jQuery('>.tw-milestones-content>.tw-milestones-count>.tw-milestones-show>ul', $curr).each(function() {
            jQuery(this).css('bottom', '-' + jQuery(this).height() + 'px');
        });
        $curr.bind('tw-animate', function() {
            setTimeout(function() {
                jQuery('>.tw-milestones-content>.tw-milestones-count>.tw-milestones-show>ul', $curr).each(function() {
                    jQuery(this).animate({bottom: '5px'}, 800).animate({bottom: '0px'}, 'slow');
                });
            }, $delay);
        });
    });
    

    
    // ThemeWaves Animate General - Init
    jQuery('.tw-animate-gen').each(function() {
        var $curr = jQuery(this);
        var $currChild = $curr.children().eq(-1);
        if ($currChild.attr('id') === 'sidebar' || $currChild.hasClass('tw-pricing') || $currChild.hasClass('tw-our-team') || $currChild.hasClass('tw-blog')) {
            $currChild.children().addClass('tw-animate-gen').attr('data-gen', $curr.attr('data-gen')).attr('data-gen-delay', $curr.attr('data-gen-delay')).attr('data-gen-offset', $curr.attr('data-gen-offset')).css('opacity', '0');
            $curr.removeClass('tw-animate-gen').attr('data-gen', '').attr('data-gen-offset', '').attr('data-gen-delay', '').css('opacity', '');
        }
    });
    jQuery(window).resize();
});

jQuery(window).load(function() {
    "use strict";
    // Logo background
    logobg();
    // Load Complete
    loadComplete();
    // Gallery
    img_slider();

    // Testimonials
    jQuery('.tw-testimonials').each(function() {
        var $prev = jQuery(this).find(".carousel-prev");
        var $next = jQuery(this).find(".carousel-next");
        var $easing = 'quadratic';
        var $direction = jQuery(this).data("direction");
        var $duration = jQuery(this).data("duration");
        var $timeout = jQuery(this).data("timeout");
        jQuery(this).find('>ul').carouFredSel({
            items: 1,
            direction: $direction,
            prev: $prev,
            next: $next,
            auto: {
                easing: $easing,
                duration: $duration,
                timeoutDuration: $timeout,
                pauseOnHover: true
            }
        });
    });
    // Carousel
    list_carousel();

    // Carousel Container Height Repair
    jQuery('ul.tw-carousel>li>.gallery-container').unbind('tw-carousel-container-height-repair').bind('tw-carousel-container-height-repair', function() {
        var $currGallCon = jQuery(this);
        var $currLiHeight = $currGallCon.closest('li').height();
        if ($currGallCon.closest('.caroufredsel_wrapper').height() < $currLiHeight) {
            $currGallCon.closest('.caroufredsel_wrapper').animate({height: $currLiHeight}, 600);
            $currGallCon.closest('ul.tw-carousel').height($currLiHeight);
        }
    });
    jQuery('ul.tw-carousel>li>.gallery-container').each(function() {
        var $currGallCon = jQuery(this);
        jQuery('>.carousel-arrow>a', $currGallCon).each(function() {
            jQuery(this).bind('click', function() {
                setTimeout(function() {
                    $currGallCon.trigger('tw-carousel-container-height-repair');
                }, 1100);
            });
        });
    });

    // Twitter
    if (jQuery().jtwt) {
        jQuery('.tw-twitter').each(function() {
            var currentTwitter = jQuery(this);
            currentTwitter.find('a').live("click", function() {
                jQuery(this).attr('target', "_blank");
            });
            currentTwitter.jtwt({
                count: currentTwitter.attr('data-count'),
                username: currentTwitter.attr('data-name'),
                image_size: 0
            });
            currentTwitter.children('.twitter-follow').appendTo(currentTwitter);
        });
    }
    // ThemeWaves Animate Custom
    jQuery('.tw-animate').each(function() {
        var $curr = jQuery(this);
        var $currOffset = $curr.attr('data-gen-offset');
        if ($currOffset === '' || $currOffset === 'undefined' || $currOffset === undefined) {
            $currOffset = 'bottom-in-view';
        }
        if ($currOffset === 'none') {
            $curr.trigger('tw-animate');
        } else {
            $curr.waypoint(function() {
                $curr.trigger('tw-animate');
            }, {triggerOnce: true, offset: $currOffset});
        }
    });
    // ThemeWaves Animate General - Bind
    jQuery('.tw-animate-gen').each(function() {
        var $curr = jQuery(this);
        var $removeClass = true;
        if ($curr.data('gen') === 'pulse' || $curr.data('gen') === 'floating' || $curr.data('gen') === 'tossing') {
            $removeClass = false;
        }
        $curr.bind('tw-animate', function() {
            var $currDelay = parseInt($curr.attr('data-gen-delay'), 10);
            if($currDelay<0){$currDelay=0;}
            setTimeout(function(){
                $curr.css('opacity', '');
                $curr.addClass('animated ' + $curr.data('gen'));
                if ($removeClass) {
                    setTimeout(function() {
                        $curr.removeClass('animated');
                        $curr.removeClass($curr.data('gen'));
                    }, 3000);
                }
            },$currDelay);
        });
    });
    // ThemeWaves Animate General
    jQuery('.tw-animate-gen').each(function() {
        var $curr = jQuery(this);
        var $currOffset = $curr.attr('data-gen-offset');
        if ($currOffset === '' || $currOffset === 'undefined' || $currOffset === undefined) {
            $currOffset = 'bottom-in-view';
        }
        $curr.waypoint(function() {
            $curr.trigger('tw-animate');
        }, {triggerOnce: true, offset: $currOffset});
    });

    ///////////////////////////////////
    jQuery(window).resize();
});

function logobg() {
    if (jQuery('#header .tw-logo').hasClass('tw-logo')) {
        if (jQuery('body').hasClass('rtl'))
            var logoTmpSize = jQuery('#header .tw-logo').offset().right;
        else
            var logoTmpSize = jQuery('#header .tw-logo').offset().left;
        jQuery('.tw-logo-bg').width(logoTmpSize);
        jQuery('.tw-logo').css('height', '');
        if (jQuery('.show-mobile-menu').css('display') === 'none') {
            jQuery('.tw-logo').css('height', jQuery('#header').height() + 'px');
        }
    }
}

function img_slider() {
    "use strict";
    // Gallery
    jQuery('.gallery-container').each(function() {
        var $prev = jQuery(this).find(".carousel-prev");
        var $next = jQuery(this).find(".carousel-next");
        jQuery(this).find('.gallery-slide').carouFredSel({
            auto: false,
            responsive: true,
            scroll: {fx: 'uncover-fade', easing: "swing", duration: 1000},
            width: '100%',
            heigth: 'auto',
            padding: 0,
            prev: $prev,
            next: $next,
            items: {
                width: 870,
                visible: {
                    min: 1,
                    max: 1
                }
            }
        });
    });
}
function list_carousel() {
    "use strict";
    jQuery('.list_carousel').each(function() {
        var $prev = jQuery(this).closest('.carousel-container').find(".tw-carrow .carousel-prev");
        var $next = jQuery(this).closest('.carousel-container').find(".tw-carrow .carousel-next");
        var $width = 310;
        var $min = 1;
        var $max = 4;
        var $currentCrslPrnt = jQuery(this);
        var $currentCrsl = $currentCrslPrnt.children('ul.tw-carousel');
        if (jQuery(this).hasClass('tw-carousel-partner')) {
            $width = 200;
            $max = 6;
        }
        else if (jQuery(this).hasClass('tw-carousel-post')) {
            $width = 400;
            $max = 3;
        }
        else if (jQuery(this).hasClass('tw-carousel-portfolio')) {
            $width = 350;
            $max = 4;
        }
        else if (jQuery(this).hasClass('tw-carousel-twitter')) {
            $width = 400;
            $max = 1;
        }
        $currentCrsl.carouFredSel({
            responsive: true,
            auto: false,
            prev: $prev,
            next: $next,
            width: '100%',
            heigth: 'auto',
            scroll: 1,
            items: {
                width: $width,
                visible: {
                    min: $min,
                    max: $max
                }
            }
        });
    });
}

// Load Complete
function loadComplete() {
    "use strict";
    jQuery('#loading').remove();
    jQuery('body').removeClass('loading');
}