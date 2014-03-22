<?php
/*
Template Name: DROM Front Page
*/

?>

<?php get_header('dromfront'); ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); 

	
	$praise_array = array();
	$p_id = get_the_ID();
	
	for ($i = 1; $i < 7; $i++) {
		$m_review_key = 'sd_review_' . $i;
		$m_author_key = 'sd_author_' . $i;
		
		$m_review_val = get_post_meta( $p_id, $m_review_key, true );
		$m_author_val = get_post_meta( $p_id, $m_author_key, true );
		
		$praise_array[$i]['review'] = $m_review_val;
		$praise_array[$i]['author'] = $m_author_val;
	}


?>


<div id="TopWrapper" class="head-wrap">
	<div class="wrapper">

		<div class="intro">
			<?php the_content(); ?>
		</div>

		<figure>
			<a href="#toc">Read the DROM online</a>
		</figure>

		<figure>
			<a href="https://secure.pmpress.org/index.php?l=product_detail&p=563" target="_blank">Buy A Copy</a>
		</figure>
	</div>
</div>

		
<?php 
	//Query for all DROM chapters, display in order 
	$args = array(
		'post_type' => 'drom',
		'meta_key' => 'chapter-number',
		'orderby' => 'meta_value_num',
		'posts_per_page' => -1,
		'order' => 'ASC'
	);
	
	$chapter_query = new WP_Query( $args );
	
	// Display them in 2 columns, for now, 8 starts right column
	if ( $chapter_query->have_posts() ) {
		$count = 0; ?>
		
		<section id="toc">
			<div class="wrapper">
				<ol class="toc-list">
	        
				<?php while ( $chapter_query->have_posts() ) {
					$chapter_query->the_post(); 
					$p_id = get_the_ID();
					$subtitle = get_post_meta( $p_id, 'drom_subtitle', true ); 
					?>
					
					<?php if ($count == 8 ) { echo '</ol><ol class="toc-list">';} ?>
					
					
					
					<?php echo '<li><a href="' . get_permalink() . '"><span class="chapter-num">' . get_the_title() . '</span>' . $subtitle . '</a></li>'; ?>
					
					<?php $count++;
				} ?>
		
				<?php echo '</ol>'; ?>
			</div>
		</section>
		
	<?php } else {
		// no posts found
	}
	
	wp_reset_postdata();

	?>
	
		
	<section id="praise">
		<div class="wrapper">
	
			<h2>Praise for the Manual</h2>
			
			<?php foreach ($praise_array as $praise) { ?>
			 
				<figure>
					<p><?php echo $praise['review']; ?></p>
		
					<p class="attr"><?php echo $praise['author']; ?></p>
				</figure>
			
			
			<?php } ?>





<?php endwhile; endif; ?>





<?php get_footer('drom'); ?>
