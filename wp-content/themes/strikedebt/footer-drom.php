<footer id="main">
		
	<p style="font-size: 1.75em; margin: 0.5em 0; color: #606663;">&middot;</p>
	
	<p><small><em>Strike Debt is an offshoot of <a href="http://interoccupy.net">Occupy Wall Street</a></em></small></p>
	
	<p><small>Design by <a href="http://zakgreene.com/new">Zak Greene</a></small</p>
	
</footer>


<!-- here comes the javascript -->

<!-- Grab Google CDN's jQuery. fall back to local if necessary -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write("<script src='<?php bloginfo('template_directory'); ?>/_/js/jquery-1.5.1.min.js'>\x3C/script>")</script>

<!-- this is where we put our custom functions -->
<script src="<?php bloginfo('template_directory'); ?>/_/js/respond.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/_/js/functions.js"></script>

<!-- Asynchronous google analytics; this is the official snippet.
	 Replace UA-XXXXXX-XX with your site's ID and uncomment to enable.-->
	 
<script>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36234787-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<script src="<?php bloginfo('template_directory'); ?>/_/js/jquery.jpanelmenu.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/_/js/functions.js"></script>

<script>

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
}
else {
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

// $(window).resize( function() {

// 	vw = $(window).width();
	
// 	if (jPM.isOpen())
// 		$(".jPanelMenu-panel").css("width", vw * 0.75);

// });

</script>
  
</body>
</html>