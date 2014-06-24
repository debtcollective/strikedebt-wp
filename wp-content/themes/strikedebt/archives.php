<?php 

/*
Template Name: Archives
*/

get_header(); ?>

	<section><div class="wrapper">

		<article class="post">
			<h1><?php the_title() ?></h1>

			<ul>
			<?php
			    $recentPosts = new WP_Query();
			    $recentPosts->query('showposts=200');
			?>
			<?php while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
			    <li>
				    <h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>

			    	<p><time datetime="<?php echo date(DATE_W3C); ?>" pubdate class="updated"><?php the_time('F j, Y') ?></time></p>
				    <?php the_excerpt(); ?>
				    <p style="margin-top: -1em;"><a href="<?php the_permalink() ?>" style="float: left;">Read More &rarr;</a></p>
			    </li>
			<?php endwhile; ?>
			</ul>
		</article>

	</div></section>

<?php get_footer(); ?>