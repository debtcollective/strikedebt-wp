jQuery(document).ready(function($) {
	
	/*we may have to reconsider jPanelMenu, Mel thinks it's conflicting with something, since it's not working consistently
	
	
	*/
	
	// $('.menu-trigger').on('click', function (){
	// 	//e.preventDefault();
		
	// 	//if not open, open
	// 	if ( $('.menu-open-flag').data('triggered') == false ){
	// 		$('.menu-open-flag').data('triggered', true);
			
			
	// 		$(".menu-trigger").css("left", "22%");
	// 		$(".drom-wrapper").css("width", "78%");
	// 		$(".drom-wrapper").css("float", "right");
	// 		$('#chapter-menu').css("width", "22%");
	// 		$('aside#menu').css("width", "100%");
	// 		//$()
	// 		$("nav.chapters > .previous").hide();
			
	// 		$('#menu.toc').toggle('slide', {
	//             direction: 'left'
	//         }, 400, function(){ $('#chapter-menu').fadeIn('fast');});
	        
	// 		//$('#chapter-menu').show("slow");
	// 		//$('#menu.toc').show('slide', {direction: 'left'});
			
			
	// 		//console.log('false');
	// 	} else {
	// 		$('.menu-open-flag').data('triggered', false);
			
	// 		$(".menu-trigger").css("left", "");
	// 		$(".drom-wrapper").css("width", "100%");
			
	// 		$("nav.chapters > .previous").show();
			
			
	// 		$('#menu.toc').hide();
	// 		$('#chapter-menu').hide();
	// 		/*$('#menu.toc').fadeOut(function () {
	// 	        $('#chapter-menu').toggle('slide', {
	// 	            direction: 'left'
	// 	        }, 200);
	// 		});*/
			
	// 		//$('#chapter-menu').hide("slow");
	// 		//$('#menu.toc').hide('slide', {direction: 'left'});
			
	// 	}
		
	// });
	
	//gives us the anchors of our current page
	/*var subitems = $.find('.content a.submenu');
	
	var currentPage = window.location.hash;
	var currentNoHash = window.location.href.split('#')[0];
	
	var submenuID = '<ol>';
	$.each(subitems, function(key, value) {
		newHash = $(this).attr('id');
		newLink = currentNoHash + newHash;
		
		//listStart = '<li><a href="' + newHash + '">' + 
		
		
		submenuID = submenuID + thisText;
	});
	
	submenuID = submenuID + '</ol>';
	
	
	$('#currentSubmenu').html(subitems);*/
	
	
	
	vw = $(window).width();
	if (vw >= 1024) {
		var jPM = $.jPanelMenu({
			closeOnContentClick: false,
			openPosition: "22%",
			beforeOpen: function() {
				$("nav.chapters > .previous").hide();
				$(".menu-trigger").css("left", "22%");
				$(".jPanelMenu-panel").css("width", "78%");
			},
			beforeClose: function() {
				$("nav.chapters > .previous").show();
				$(".menu-trigger").css("left", "");
				$(".jPanelMenu-panel").css("width", "");
			},
		});
	} else {
		var jPM = $.jPanelMenu({
			beforeOpen: function() {
				$("nav.chapters > .previous").hide();
				$(".menu-trigger").css("left", 250);
			},
			beforeClose: function() {
				$("nav.chapters > .previous").show();
				$(".menu-trigger").css("left", "");
			},
		});
	}
	
	jPM.on();
	$("#menu").remove();
	
	
	//get all h2 class=submenu, put into list to insert into drom chapter menu
	var subitems = $.find('.content h2.submenu');
	var submenuID = '';
	var currentPage = window.location.hash;
	var currentNoHash = window.location.href.split('#')[0];
	var submenuMarkup;
	//iterate over each: get text, convert text to lowercase w slashes, insert id of prior to h2 tags, 
	if (subitems.length > 0) { //if we HAVE submenu items
		submenuMarkup = '<ol>';
		$.each(subitems, function() {
			//get text
			submenuID = $(this).html();
			
			//title for sidemenu
			submenuTitle = submenuID;
			
			//convert text to lower case w/ slashes
			submenuID = submenuID.toLowerCase().replace(/ /g, '-');
			
			//add id tags to h2 elements
			$(this).attr('id', submenuID);
			
			//add list element to markup
			submenuMarkup += '<li><a class="' + submenuID + '" href="' + currentNoHash + '#' + submenuID + '">' + submenuTitle + '</a></li>';
			
		});
		submenuMarkup += '</ol>';
		
		
		//find href of chapter-menu that == current href
		var subitems = $.find('#jPanelMenu-menu ol li a');
		var chapterHref = '';
		$.each(subitems, function() {
			//get chapter href
			chapterHref = $(this).attr('href');
			//compare
			if (chapterHref == currentNoHash) {		
				//add markup here
				$(this).parent().append(submenuMarkup);
			}
			
			
		});
	}
	//$('#currentSubmenu').html(subitems);
	
	
});


