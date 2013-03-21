<?php
/**
 * The Sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage Sonicbids CMS
 */

$options = twentyeleven_get_theme_options();
$current_layout = $options['theme_layout'];

if ( 'content' != $current_layout ) :
?>
	<div class="right_blog">
	
		<!-- Search Sidebar -->
		<div id="secondary" class="widget-area" role="complementary">
			<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
			
					<aside id="archives" class="widget">
						<h3 class="widget-title"><?php _e( 'Archives', 'twentyeleven' ); ?></h3>
							<ul>
								<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
							</ul>
					</aside>

					<aside id="meta" class="widget">
						<h3 class="widget-title"><?php _e( 'Meta', 'twentyeleven' ); ?></h3>
							<ul>
								<?php wp_register(); ?>
								<li><?php wp_loginout(); ?></li>
								<?php wp_meta(); ?>
							</ul>
					</aside>
			<?php endif; // end sidebar widget area ?>
		</div><!-- #secondary .widget-area -->
		<!-- Search Sidebar -->
		
		<!-- Most popular, most recent sidebar-->
		<div class="right_archives">
		
			<?php if ( ! dynamic_sidebar( 'sidebar-2' ) ) : ?>

					<aside id="archives" class="widget">
							<h3 class="widget-title"><?php _e( 'Archives', 'twentyeleven' ); ?></h3>
								<ul>
									<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
								</ul>
					</aside>

					<aside id="meta" class="widget">
							<h3 class="widget-title"><?php _e( 'Meta', 'twentyeleven' ); ?></h3>
								<ul>
									<?php wp_register(); ?>
									<li><?php wp_loginout(); ?></li>
										<?php wp_meta(); ?>
								</ul>
					</aside>

			<?php endif; // end sidebar widget area ?>
									
		</div>
		<!-- Most popular, most recent sidebar-->
		
		<!-- tweet sidebar -->
		<div class="tweets">
		
			<div class="tweet_follow">
					<a href="https://twitter.com/sonicbidsgigs" class="twitter-follow-button" data-show-count="false" data-size="large" data-show-screen-name="false">Follow @sonicbidsgigs</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            </div>  
			
				<?php if ( ! dynamic_sidebar( 'sidebar-6' ) ) : ?>

						<aside id="archives" class="widget">
						
							<h3 class="widget-title"><?php _e( 'Archives', 'twentyeleven' ); ?></h3>
								<ul>
									<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
								</ul>
						</aside>

						<aside id="meta" class="widget">
							<h3 class="widget-title"><?php _e( 'Meta', 'twentyeleven' ); ?></h3>
								<ul>
									<?php wp_register(); ?>
									<li><?php wp_loginout(); ?></li>
									<?php wp_meta(); ?>
								</ul>
						</aside>
						
						<div class="clear"></div>
				<?php endif; // end sidebar widget area ?>
		</div>
		<!-- tweet sidebar -->
	</div>
		
<?php endif; ?>