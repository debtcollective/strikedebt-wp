<?php 
get_header( 'drom' ); 


$args = array(
	'post_type' => 'drom',
	'meta_key' => 'chapter-number',
	'orderby' => 'meta_value_num',
	'posts_per_page' => -1,
	'order' => 'ASC'
);

//$chapter_query = new WP_Query($args);	

?>
	
	
	

  <div class="drom-wrapper">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<nav class="chapters" id="side">
		<a href="drom-chapter.html" class="previous"><i class="icon-arrow-left"></i><span class="chapter-num">Chapter 1</span>Credit Scores and Consumer Reporting Agencies: Surveillance and the Vicious Cycle of Debt</a>
		
		<?php
		//need to WP_query to get all chapters for menu; also find current chapter
		
		
		?>
		<a href="drom-chapter.html" class="next"><?php echo get_next_posts_link(); ?> </a>
		
	</nav>
	
	

	<aside class="toc" id="menu">
	
	<?php 
		$chapter_query = new WP_Query($args);
		
		if ( $chapter_query->have_posts() ) {
		//echo "HEEEYYY";
	    echo '<ol>';
		while ( $chapter_query->have_posts() ) {
			$chapter_query->the_post();
			$chapter_href = get_permalink();
			echo '<li><a href="' . $chapter_href . '">' . get_the_title() . '</a></li>';
		}
	        echo '</ol>';
		} else {
			// no posts found
		}
		/* Restore original Post Data */
		wp_reset_postdata();
		
		?>
		
		
		<ol>
			<li><a href="drom-chapter.html">Introduction</a></li>
			
			<li><a href="drom-chapter.html"><span class="chapter-num">Chapter 11</span>Strategies for Survival: Living on the Margins of the Debt System</a>
				<ol>
					<li><a href="#food" id="food_nav" class="active">Food</a></li>
					<li><a href="#clothing" id="clothing_nav">Clothing</a></li>
					<li><a href="#shelter" id="shelter_nav">Shelter</a>
						<!-- <ol>
							<li><a href="#apartment" id="apartment_nav">Renting an apartment with bad credit</a></li>
							<li><a href="#housing" id="housing_nav">Collective housing</a></li>
							<li><a href="#squatting" id="squatting_nav">Squatting</a></li>
						</ol> -->
					</li>
					<li><a href="#health" id="health_nav">Health and Care</a><!-- 
						<ol>
							<li><a href="#free-clinics" id="free-clinics_nav">Free clinics</a></li>
							<li><a href="#convenient-clinics" id="convenient-clinics_nav">Convenient care clinics</a></li>
							<li><a href="#er" id="er_nav">Emergency room</a></li>
							<li><a href="#medicaid" id="medicaid_nav">Medicaid</a></li>
							<li><a href="#institutions" id="institutions_nav">Condition-specific institutions</a></li>
							<li><a href="#dental" id="dental_nav">Dental and vision care</a></li>
						</ol> -->
					</li>
					<li><a href="#schools" id="schools_nav">Free Schools</a></li>
					<li><a href="#transportation" id="transportation_nav">Transportation</a></li>
					<li><a href="#cash" id="cash_nav">Cash Money</a></li>
					<li><a href="#microcredit" id="microcredit_nav">Microcredit</a></li>
					<li><a href="#resources" id="resources_nav">Resources</a></li>
					<li><a href="#websites" id="websites_nav">Websites</a></li>
					<li><a href="#general" id="food_nav">General</a></li>
					<li><a href="#res-food" id="food_nav">Food</a></li>
					<li><a href="#res-shelter" id="food_nav">Shelter</a></li>
					<li><a href="#res-health" id="food_nav">Health and care</a></li>
					<li><a href="#references" id="food_nav">References</a></li>
				</ol>
			</li>
			<li><a href="drom-chapter.html"><span class="chapter-num">Chapter 12</span>Municipal and State Debt: Crushing Debt from Above</a></li>
			
			<li><a href="drom-chapter.html">Glossary</a></li>
		</ol>
	</aside>
	
	<section id="main">
		
		<?php
		//need to break apart the title here
		
		?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<!--<article <?php //post_class() ?> id="post-<?php //the_ID(); ?>">-->
		<article>
			
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
	
	</section>

	<?php endwhile; endif; ?>
  </div>

<?php get_footer( 'drom' ); ?>