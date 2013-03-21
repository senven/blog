<?php
/**
 * The template for displaying Author Archive pages.
 *
 * @package WordPress
 * @subpackage Sonicbids CMS
 */

get_header(); ?>

		<section id="primary">
			<div id="content" role="main">
			<div class="left_blog">
			<?php if ( have_posts() ) : ?>

				<?php
					/* Queue the first post, that way we know
					 * what author we're dealing with (if that is the case).
					 *
					 * We reset this later so we can run the loop
					 * properly with a call to rewind_posts().
					 */
					the_post();
				?>

				<?php
					/* Since we called the_post() above, we need to
					 * rewind the loop back to the beginning that way
					 * we can run the loop properly, in full.
					 */
					rewind_posts();
				?>

				<?php sonicbids_content_nav( 'nav-above' ); ?>

				<?php
				// If a user has filled out their description, show a bio on their entries.
				if ( get_the_author_meta( 'description' ) ) : ?>
									<div class="author_detail" style=" margin: 0px 0 15px;">
										<div class="author_bio">
											<div class="author_img">
												<?php userphoto_the_author_photo();?>
											</div>
												<p>Author: <span class="author_name"><?php the_author_posts_link() ?></span></p>
												<p class="auth"><?php the_author_description(); ?> </p>
										</div>
										<div class="clear"></div>
									</div>
				<?php endif; ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', 'page');
					?>

				<?php endwhile; ?>

				<?php sonicbids_content_nav( 'nav-above' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>
			<div class="navigation">
					<div class="alignleft"><?php previous_posts_link('&laquo; Newer Posts') ?></div>
					<div class="alignright"><?php next_posts_link('Older Posts &raquo;','') ?></div>
			</div>
			</div>
			<?php get_sidebar(); ?>
			<div class="clear"></div>
			</div><!-- #content -->
		</section><!-- #primary -->


<?php get_footer(); ?>