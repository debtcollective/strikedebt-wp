jQuery(document).ready(function($) {
	
	/*we may have to reconsider jPanelMenu, Mel thinks it's conflicting with something, since it's not working consistently
	
	
	*/
	
	jQuery('.menu-trigger').on('click', function (){
		//e.preventDefault();
		
		//if not open, open
		if ( jQuery('.menu-open-flag').data('triggered') == false ){
			jQuery('.menu-open-flag').data('triggered', true);
			
			
			jQuery(".menu-trigger").css("left", "22%");
			jQuery(".drom-wrapper").css("width", "78%");
			jQuery(".drom-wrapper").css("float", "right");
			jQuery('#chapter-menu').css("width", "22%");
			jQuery('aside#menu').css("width", "100%");
			//jQuery()
			jQuery("nav.chapters > .previous").hide();
			jQuery('#chapter-menu').show("slow");
			jQuery('#menu.toc').show('slide', {direction: 'left'});
			
			
			//console.log('false');
		} else {
			jQuery('.menu-open-flag').data('triggered', false);
			
			jQuery(".menu-trigger").css("left", "");
			jQuery(".drom-wrapper").css("width", "100%");
			
			jQuery("nav.chapters > .previous").show();
			jQuery('#chapter-menu').hide("slow");
			jQuery('#menu.toc').hide('slide', {direction: 'left'});
			
		}
		
	});
	
	//gives us the anchors of our current page
	var subitems = jQuery.find('.content h2 a');
	
	var currentPage = window.location.hash;
	/*var submenuText = '';
	jQuery.each(subitems, function(key, value) {
	
		
		submenuText = submenuText + thisText;
	});*/
	
	jQuery('#currentSubmenu').html(subitems);
	
	
	/*
	vw = jQuery(window).width();
	if (vw >= 1024) {
		var jPM = $.jPanelMenu({
			closeOnContentClick: false,
			openPosition: "22%",
			beforeOpen: function() {
				jQuery("nav.chapters > .previous").hide();
				jQuery(".menu-trigger").css("left", "22%");
				jQuery(".jPanelMenu-panel").css("width", "78%");
			},
			beforeClose: function() {
				jQuery("nav.chapters > .previous").show();
				jQuery(".menu-trigger").css("left", "");
				jQuery(".jPanelMenu-panel").css("width", "");
			},
		});
	} else {
		var jPM = jQuery.jPanelMenu({
			beforeOpen: function() {
				jQuery("nav.chapters > .previous").hide();
				jQuery(".menu-trigger").css("left", 250);
			},
			beforeClose: function() {
				jQuery("nav.chapters > .previous").show();
				jQuery(".menu-trigger").css("left", "");
			},
		});
	}
	
	jPM.on();
	jQuery("#menu").remove();
	*/
	
	//get all h2 a id anchors, put into list to insert into drom chapter menu
	//var subitems = jQuery.find('.content h2 a');
	/*var submenuText = '';
	jQuery.each(subitems, function(key, value) {
	
		
		submenuText = submenuText + thisText;
	});*/
	
	//jQuery('#currentSubmenu').html(subitems);
	
	
});


