<?php get_header(); ?>

  <div class="wrapper">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
		<article class="post" id="post-<?php the_ID(); ?>">

			<h1><?php the_title(); ?></h1>

			<div class="entry-content">

			<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

				<?php the_content(); ?>

				<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

			</div>
			
        <p class="updated"><time datetime="<?php echo date(DATE_W3C); ?>" pubdate class="updated"><?php the_modified_time('F jS, Y') ?></time></p>

		</article>

		<?php endwhile; endif; ?>
  </div>

<?php get_footer(); ?>
