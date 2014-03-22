<!DOCTYPE html>

<!--[if lt IE 7 ]> <html class="ie ie6 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. -->

<head id="strikedebt.org" data-template-set="html5-reset-wordpress-theme" profile="http://gmpg.org/xfn/11">

	<meta charset="<?php bloginfo('charset'); ?>">
	
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<?php if (is_search()) { ?>
	<meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>

	<title>
		   <?php
		      if (function_exists('is_tag') && is_tag()) {
		         single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		      elseif (is_archive()) {
		         wp_title(''); echo ' Archive - '; }
		      elseif (is_search()) {
		         echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
		      elseif (!(is_404()) && (is_single()) || (is_page())) {
		         wp_title(''); echo ' - '; }
		      elseif (is_404()) {
		         echo 'Not Found - '; }
		      if (is_home()) {
		         bloginfo('name'); echo ' - '; bloginfo('description'); }
		      else {
		          bloginfo('name'); }
		      if ($paged>1) {
		         echo ' - page '. $paged; }
		   ?>
	</title>
	
	<meta name="title" content="<?php
		      if (function_exists('is_tag') && is_tag()) {
		         single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		      elseif (is_archive()) {
		         wp_title(''); echo ' Archive - '; }
		      elseif (is_search()) {
		         echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
		      elseif (!(is_404()) && (is_single()) || (is_page())) {
		         wp_title(''); echo ' - '; }
		      elseif (is_404()) {
		         echo 'Not Found - '; }
		      if (is_home()) {
		         bloginfo('name'); echo ' - '; bloginfo('description'); }
		      else {
		          bloginfo('name'); }
		      if ($paged>1) {
		         echo ' - page '. $paged; }
		   ?>">
	<meta name="description" content="<?php bloginfo('description'); ?>">
	
	<meta name="google-site-verification" content="">
	<!-- Speaking of Google, don't forget to set your site up: http://google.com/webmasters -->
	
	<meta name="author" content="Zak Greene">
	<meta name="Copyright" content="Copyright Strike Debt 2012. All Rights Reserved.">

	<!-- Dublin Core Metadata : http://dublincore.org/ -->
	<meta name="DC.title" content="Strike Debt!">
	<meta name="DC.subject" content="A Debt Resistance Movement for the 99%">
	<meta name="DC.creator" content="Folks from Strike Debt">
	
	<!--  Mobile Viewport meta tag
	j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag 
	device-width : Occupy full width of the screen in its current orientation
	initial-scale = 1.0 retains dimensions instead of zooming out if page height > device height
	maximum-scale = 1.0 retains dimensions instead of zooming in if page width < device width -->
	<!-- Uncomment to use; use thoughtfully!-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
		 
	<link rel="apple-touch-icon" href="<?php bloginfo('template_directory'); ?>/_/img/apple-touch-icon.png">
	<!-- The is the icon for iOS's Web Clip.
		 - size: 57x57 for older iPhones, 72x72 for iPads, 114x114 for iPhone4's retina display (IMHO, just go ahead and use the biggest one)
		 - To prevent iOS from applying its styles to the icon name it thusly: apple-touch-icon-precomposed.png
		 - Transparency is not recommended (iOS will put a black BG behind the icon) -->
		 
	
	<script type="text/javascript" src="//use.typekit.net/fkx3jxi.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
	
	<!-- CSS: screen, mobile & print are all in the same file -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/drom-live.css">
	
	<link rel="stylesheet" href="http://i.icomoon.io/public/temp/54c54b72be/StrikeDebteDROM/style.css">
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

	<?php wp_head(); ?>
	
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/last-css-loaded.css">
	
</head>

<body <?php body_class('chapter drom'); ?>>

<header>
	<div class="wrapper">
		<!--<a href="" class="menu-trigger"><i class="icon-th-menu"></i>Menu</a>-->

		<div class="menu-trigger"><i class="icon-th-menu"></i>Menu</div>
		<a href="/" id="project-of"><img src="<?php bloginfo('template_directory'); ?>/_/drom_square.png" alt="Strike Debt!" id="title" /> A Project of Strike Debt </a>

		<h3><a href="http://strikedebt.org/drom">The Debt Resisters&rsquo; Operations Manual</a></h3>
	</div>
	
</header>

<div id="chapter-menu">
<aside class="toc" id="menu">
	
	<?php 
		$current_p_id = $wp_query->post->ID;
		
		$args = array(
			'post_type' => 'drom',
			'meta_key' => 'chapter-number',
			'orderby' => 'meta_value_num',
			'posts_per_page' => -1,
			'order' => 'ASC'
		);
		$chapter_query = new WP_Query($args);
		
		if ( $chapter_query->have_posts() ) {
		//echo "HEEEYYY";
	    echo '<ol>';
		while ( $chapter_query->have_posts() ) {
			$chapter_query->the_post();
			$p_id = get_the_ID();
			$subtitle = get_post_meta( $p_id, 'drom_subtitle', true);
			if (!$subtitle) {$subtitle = '';}
			$chapter_href = get_permalink();
			echo '<li><a href="' . $chapter_href . '"><span class="chapter-num">' . get_the_title() . '</span>' . $subtitle . '</a></li>';
			
			//get submenus
			if ($current_p_id == $p_id){
				echo '<div id="currentSubmenu"></div>';
			}
			
			
		}
	        echo '</ol>';
		} else {
			// no posts found
		}
		
		wp_reset_postdata();  
		
		?>
		
	
</aside>
</div>


