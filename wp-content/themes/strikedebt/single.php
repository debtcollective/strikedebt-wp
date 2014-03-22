<?php get_header(); ?>

  <div class="wrapper">
	<?php if (have_posts()) : while (have_posts()) : the_post(); 
	
        $toc = get_post_meta( get_the_ID(), 'Table of Contents', true);
	     
        if($toc) {
            echo '<aside class="left" class="toc">' . $toc . '</aside>';
        } ?>

		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		
		  <p><time datetime="<?php echo date(DATE_W3C); ?>" pubdate class="updated"><?php the_time('F jS, Y') ?></time></p>
			
			<h1 class="entry-title"><?php the_title(); ?></h1>
			
			<?php 
    	     $by = get_post_meta( get_the_ID(), 'By', true);
    	     
    	     if(! empty($by)) {
			     echo '<p class="by">By ' . $by . '</p>';
      	     } ?>

			<div class="entry-content">
			
		    <?php edit_post_link(__('Edit','mytheme'), '', ''); ?> 
				
				<?php the_content(); ?>

				<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
				
				<!--<?php the_tags( 'Tags: ', ', ', ''); ?>
			
				<?php include (TEMPLATEPATH . '/_/inc/meta.php' ); ?>-->

			</div>
			
		</article>

	<?php endwhile; endif; ?>
  </div>

<?php get_footer(); ?>