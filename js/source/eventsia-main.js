jQuery( function() {
		
		// Search toggle.
		var searchbutton = jQuery('#search-toggle');
		var searchbox = jQuery('#search-box');

			searchbutton.on('click', function(){
		    if (searchbutton.hasClass('header-search')){
		        searchbutton.removeClass('header-search').addClass('header-search-x');
		        searchbox.addClass('show-search-box');
		    }
		    
		    else{
		        searchbutton.removeClass('header-search-x').addClass('header-search');
		        searchbox.removeClass('show-search-box');
		    }
		});

		// Menu toggle for below 981px screens.
		( function() {
			var togglenav = jQuery( '.main-navigation' ), button, menu;
			if ( ! togglenav ) {
				return;
			}

			button = togglenav.find( '.menu-toggle' );
			if ( ! button ) {
				return;
			}
			
			menu = togglenav.find( '.menu' );
			if ( ! menu || ! menu.children().length ) {
				button.hide();
				return;
			}

			jQuery( '.menu-toggle' ).on( 'click', function() {
				jQuery(this).toggleClass("on");
				togglenav.toggleClass( 'toggled-on' );
			} );
		} )();

		jQuery( function() {
			if(jQuery( window ).width() < 980){
				//responsive sub menu toggle
                jQuery('#site-navigation .menu-item-has-children, #site-navigation .page_item_has_children').prepend('<button class="sub-menu-toggle"> <i class="fas fa-plus"></i> </button>');
				jQuery(".main-navigation .menu-item-has-children ul, .main-navigation .page_item_has_children ul").hide();
				jQuery(".main-navigation .menu-item-has-children > .sub-menu-toggle, .main-navigation .page_item_has_children > .sub-menu-toggle").on('click', function () {
					jQuery(this).parent(".main-navigation .menu-item-has-children, .main-navigation .page_item_has_children").children('ul').first().slideToggle();
					jQuery(this).children('i').first().toggleClass('fa-minus fa-plus');
					
				});
			}
		});

		// Menu toggle for side nav.
		jQuery(document).ready( function() {
		  //when the button is clicked
		  jQuery(".show-menu-toggle, .hide-menu-toggle, .page-overlay").click( function() {
		    //apply toggleable classes
		    jQuery(".side-menu").fadeToggle('slow');
		    jQuery(".side-menu").addClass("show");
		    jQuery(".page-overlay").toggleClass("side-menu-open"); 
		    jQuery("#page").addClass("side-content-open");  
		  });
		  
		  jQuery(".hide-menu-toggle, .page-overlay").click( function() {
		    jQuery(".side-menu").removeClass("show");
		    jQuery(".page-overlay").removeClass("side-menu-open");
		    jQuery("#page").removeClass("side-content-open");
		  });
		});

		jQuery('.box-title, .fp-template-wrap .widget-title').html(function() {
		  return this.innerText.split(' ').map(function(e, word_) {
		    return jQuery('<span />', {
		      class: 'word_' + word_,
		      text: e
		    });
		  });
		});

		jQuery(document).ready(function() {
			var moveBg = 25;
			var height = moveBg / jQuery(window).height();
			var width = moveBg / jQuery(window).width();
			jQuery(".about-box-bg").mousemove(function(e){
				var pageX = e.pageX - (jQuery(window).width() / 2);
				var pageY = e.pageY - (jQuery(window).height() / 2);
				var newvalueX = width * pageX * -1 - 25;
				var newvalueY = height * pageY * -1 - 50;
			jQuery('.about-box-bg').css("background-position", newvalueX+"px  "+newvalueY+"px");
			});
		});

		// Go to top button.
		jQuery(document).ready(function(){

		// Hide Go to top icon.
		jQuery(".go-to-top").hide();

		  jQuery(window).scroll(function(){

		    var windowScroll = jQuery(window).scrollTop();
		    if(windowScroll > 900)
		    {
		      jQuery('.go-to-top').fadeIn();
		    }
		    else
		    {
		      jQuery('.go-to-top').fadeOut();
		    }
		  });

		  // scroll to Top on click
		  jQuery('.go-to-top').click(function(){
		    jQuery('html,header,body').animate({
		    	scrollTop: 0
			}, 700);
			return false;
		  });

		});

} );