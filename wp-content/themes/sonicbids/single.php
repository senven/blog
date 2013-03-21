<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Sonicbids CMS
 */

 
// Redirect this page to shoutout template page for showing secondary navigation
get_header();
?>
<div id="primary">
	<div id="content" role="main">
						<!-- Main Left Content Start Here -->
						
						<div class="left_blog">
						
							<?php while ( have_posts() ) : the_post(); ?>
								
								<?php get_template_part( 'content','single'); ?>
								
							<?php endwhile; // end of the loop. ?>
							
						</div>
						
						<!-- Main Left Content End Here -->

						<?php get_sidebar(); ?>
						
			<div class="clear"></div>	
			
	</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>