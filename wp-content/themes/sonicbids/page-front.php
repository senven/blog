<?php
/*
Template Name: Page - Front
*/

get_header(); ?>

<!--Content Section-->
<div id="content">
						<!-- Main Left Content Start Here -->
						<div class="left_blog">
							<?php while ( have_posts() ) : the_post(); ?>
									<?php get_template_part( 'content','page'); ?>
							<?php endwhile; // end of the loop. ?>
							
							<!-- pagination start -->
							<div class="navigation">
								<div class="alignleft"><?php previous_posts_link('&laquo; Newer Posts') ?></div>
								<div class="alignright"><?php next_posts_link('Older Posts &raquo;','') ?></div>
							</div>
							<!-- pagination end -->
							
						</div>
						<!-- Main Left Content End Here -->
						
						<!-- Main Right Content Start Here -->
							<?php get_sidebar(); ?>
						<!-- Main Right Content  End Here -->
						
	<div class="clear"></div>
	
</div>

<?php get_footer(); ?>