<?php 

/*
Template Name: Archives
*/

get_header(); ?>

	<section><div class="wrapper">

		<article class="post">
			<h1>Blog Archive</h1>

			<ul>
				<?php wp_get_archives('type=postbypost'); ?>
			</ul>
		</article>

	</div></section>

<?php get_footer(); ?>