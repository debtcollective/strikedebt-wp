<?php 
get_header( 'drom' ); 


$args = array(
	'post_type' => 'drom',
	'meta_key' => 'chapter-number',
	'orderby' => 'meta_value_num',
	'posts_per_page' => -1,
	'order' => 'ASC'
);

$chapter_query = new WP_Query($args);	
$chapter_id_array = array();
	
if ( $chapter_query->have_posts() ) {
	while ( $chapter_query->have_posts() ) {
		$chapter_query->the_post();
		$p_id = get_the_ID();
		
		//get an array of ids ordered by postmeta 'chapter-number'
		$chapter_id_array[] = $p_id;
		
	}
} 

wp_reset_postdata();  
$total_num_chapters = count( $chapter_id_array ); //0-indexed 

?>
	
	
	
	<div class="menu-open-flag" data-triggered="false"></div>

	<div class="drom-wrapper">
	<?php if (have_posts()) : while (have_posts()) : the_post(); 
		$current_id = get_the_ID(); 
		?>
	
	<nav class="chapters" id="side">
		
		<?php
		//check post id against chapter id array to see if match. Use count to get prev/next
		
		//soon-to-be the INDEX of the array: $chapter_id_array
		$count_chapter = 0; //introduction
		$prev_chapter = 0; //0 means doesn't exist
		$next_chapter = 0;
		$current_chapter = 0;
		
		//search through each ordered id in array to compare
		foreach ( $chapter_id_array as $chapter_id ) {
			
			//we've got a match
			if ( $current_id == $chapter_id ) { 
				$current_chapter = $count_chapter;
				
				if ( $current_chapter != 0 ){
					$prev_chapter = $count_chapter - 1;
				} else { //we are at the introduction
					$prev_chapter = $total_num_chapters - 1;
				}
				
				if ($current_chapter < ($total_num_chapters-1)) { //if we're not at the end
					$next_chapter = $count_chapter + 1;
				} else { //we are at the end
					$next_chapter = 0;
				}
			
			}
			$count_chapter++;
		}
		
		//we've got our prev/next chapters; now get title/subtitle
		$prev_title = get_the_title( $chapter_id_array[$prev_chapter] );
		$prev_sub = get_post_meta( $chapter_id_array[$prev_chapter], 'drom_subtitle', true );
		$prev_link = get_permalink( $chapter_id_array[$prev_chapter] );
		$next_title = get_the_title( $chapter_id_array[$next_chapter] );
		$next_sub = get_post_meta( $chapter_id_array[$next_chapter], 'drom_subtitle', true );
		$next_link = get_permalink( $chapter_id_array[$next_chapter] );
		
		?>
		
		<a href="<?php echo $prev_link; ?>" class="previous"><i class="icon-arrow-left"></i><span class="chapter-num"><?php echo $prev_title; ?></span><?php echo $prev_sub; ?></a>
		
		<a href="<?php echo $next_link; ?>" class="next"><i class="icon-arrow-right"></i><span class="chapter-num"><?php echo $next_title; ?></span><?php echo $next_sub; ?></a>
		
	</nav>
	
		
	<section id="main">
		
		<?php
		//need to break apart the title here
		$p_id = get_the_ID();
		$subtitle = get_post_meta( $p_id, 'drom_subtitle', true);
		?>
		<h2><?php the_title(); ?></h2>
		<h1><?php if ($subtitle) {echo $subtitle;} ?></h1>
		<!--<article <?php //post_class() ?> id="post-<?php //the_ID(); ?>">-->
		
		<article>
			<div class="content">
		    <?php the_content(); ?>
			</div>
		</article>
	
	</section>

	<?php endwhile; endif; ?>
  </div>

<?php get_footer( 'drom' ); ?>