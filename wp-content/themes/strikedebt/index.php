<?php get_header(); ?>

  <section class="intro" id="about">
	   <h3 class="asphaltcondensedblack">You are not a loan.</h3>
	   
	   <p class="special">Strike Debt is a nationwide movement of debt resisters fighting for economic justice and democratic freedom.</p>

      <p>Debt is a tie that binds the 99%. With stagnant wages, systemic unemployment, and public service cuts, we are forced to go into debt for the basic things in life &mdash; and thus surrender our futures to the banks. Debt is major source of profit and power for Wall Street that works to keep us isolated, ashamed, and afraid. Using direct action, research, education, and the arts, we are coming together to challenge this illegitimate system while imagining and creating alternatives. We want an economy in which our debts are to our friends, families, and communities &mdash; and not to the 1%.</p>

      <div id="drom2">
        <a style="color:white;" href="<?php echo esc_url( home_url( '/' ) ); ?>drom"><img src="<?php bloginfo('template_directory'); ?>/_/drom2_sm.png" alt="The Debt Resisters' Operations Manual" /></a>

        <div><h2><a style="color:white;" href="<?php echo esc_url( home_url( '/' ) ); ?>drom">Available Now</a></h2>
          <h3>The Debt Resisters’ Operations Manual<br />
          <em>Available in print and <a style="color:white;" href="<?php echo esc_url( home_url( '/' ) ); ?>drom">on the web</a></em></h3></div>
      </div>
	</section>
	
    
    <section id="principles" class="clearfix">
    <div class="wrapper">
        <a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>/principles">Read our principles &rarr;</a>
    </div>
	</section>
	
	
	<section class="clearfix" id="get-involved">
    <div class="wrapper">
    
      <h2>Get Involved</h2>
      
      <aside>
         
         <figure>
         
         	<h3><a href="https://rally.org/strikedebt">Donate to Strike Debt</a></h3>
         <!-- Rally.org donation meter BEGIN -->
			<iframe height="100" scrolling="no" src="https://rally.org/causes/1G6ksHkiyjM/donation_meter?no_recent_donor=1" style="border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: none; border-width: initial; border-color: initial; border-image: initial; overflow-x: hidden; overflow-y: hidden;" width="100%"></iframe>
<!-- Rally.org donation meter END -->
         
         </figure>
         
         <figure class="clearfix">
           <h3>Join Our Mailing List</h3>
           
           <form action="http://occupystudentdebtcampaign.createsend.com/t/j/s/ijhydy/" method="post" id="subForm">
            <div>
            <label>Email Address</label>
            <input type="text" name="cm-ijhydy-ijhydy" id="ijhydy-ijhydy" placeholder="Email Address" /><br />
            <input type="submit" value="Subscribe" style="display: block;" />
            </div>
          </form>
        </figure>
      </aside>
      
      <h3 id="event">Visit a Strike Debt Event</h3>
      <?php echo do_shortcode( '[google-calendar-events id="1, 2" type="list-grouped" title="Strike Debt Events" max="6"]' ); ?>
      
    </div>
	</section>
	
  <div class="wrapper">
	   <h2 id="initiatives">Current Initiatives</h2>
  </div>
	
	<section class="clearfix initiatives" id="big">
	   <article class="clearfix" id="rollingjub">
	     <div>
	     
	     <h4>The Rolling Jubilee</h4>
	     
	     <p>We buy debt for pennies on the dollar, but instead of collecting it, we abolish it. We cannot buy specific individuals' debt &mdash; instead, we help liberate debtors at random through a campaign of mutual support, good will, and collective refusal. All proceeds go directly to buying and canceling people's debt.</p>
        
        <a href="http://rollingjubilee.org"><button>Visit the Rolling Jubilee Site</button></a>
        </div>
	   </article>
	   
	   <article class="clearfix" id="drom">
	     <div>
	     
	     <h4>The Debt Resisters&rsquo; Operations Manual</h4>
	     
	     <p>Written by a network of activists, writers, and academics, The Debt Resisters&rsquo; Operations Manual reveals how the predatory debt system works to increase inequality, undermine democracy, and ruin lives. It provides detailed strategies for fighting common forms of debt and lays out an expansive vision for a societal movement of debt resistance. The full text of the manual is available for free.</p>

	     <a href="<?php echo esc_url( home_url( '/' ) ); ?>drom"><button>Read the Manual</button></a>
	   </div>
	   </article>
  </section>
  
  <section class="clearfix initiatives" id="kit">
    <div class="wrapper">
        <h4>The Strike Debt Organizing Kit</h4>
        
        <article class="one clearfix">
        <p style="margin-top: 0.5em;"><em>Want to build your own Strike Debt chapter? Here's how.</em> The information and advice in this kit can be used by Strike Debt affiliates, or by existing groups who would like to affiliate because they have shared goals. It is a living document, which means it will be revised periodically to reflect the experience and input of new affiliates.</p>
        </article>
        
        <article class="two clearfix">
        <a href="Strike-Debt-Organizing-Kit.pdf" onClick="javascript: pageTracker._trackPageview('/downloads/kit'); "><button style="margin-top: 0.5em;" class="dark">Download the Kit (PDF) &darr;</button></a>
        </article>
      </div>
  </section>

	<section class="clearfix" id="blog">
    <div class="wrapper clearfix" style="margin-top: 0;">
    <h2><a href="/blog-archive">Blog</a></h2>
    
  	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  
  		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
  
  			<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
  
  			<!--<?php include (TEMPLATEPATH . '/_/inc/meta.php' ); ?>-->
  			
        <?php edit_post_link(__('Edit','mytheme'), '', ''); ?> 
  			<div class="entry">
  				<?php the_excerpt(); ?>
  			</div>
  			
  			<a href="<?php the_permalink() ?>"><button>Read More &rarr;</button></a>
  
  		</article>
  
  	<?php endwhile; ?>
  
  	<?php else : ?>
  
  		<h2>Not Found</h2>
  
  	<?php endif; ?>
  
  <?php get_sidebar(); ?>
    </div>
  </section>
	
	<section class="clearfix" id="more">
	   <div class="wrapper">
	   
	     <aside class="contact clearfix">
  	     <h3>Contact Us</h3>
  	     
  	     <p>General Inquiries<br />
  	     <a href="mailto:info@strikedebt.org">info@strikedebt.org</a></p>
  	     
  	     <p>Organize a Chapter<br />
  	     <a href="mailto:organize@strikedebt.org">organize@strikedebt.org</a></p>
  	     
  	     <p>Press<br />
  	     <a href="mailto:Press@strikedebt.org">press@strikedebt.org</a></p>
	     </aside>
	   
	   <h2>More Information</h2>
	   
	   <a href="http://whystrikedebt.tumblr.com/"><button>Why We Strike Debt</button></a>
  	
  	<a href="http://www.facebook.com/pages/Strike-Debt/244850825627699"><button>Facebook</button></a>
  	
  	<a href="http://twitter.com/StrikeDebt"><button>Twitter</button></a>

    <a href="http://strikedebt.wordpress.com/"><button>Internal Blog</button></a>
  	
  	
  	</div>
  </section>

<?php get_footer(); ?>
