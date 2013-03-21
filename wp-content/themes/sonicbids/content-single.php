<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 * @subpackage Sonicbids CMS
 */
?>
<!-- Place this snippet wherever appropriate -->

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<!-- Single Post blog display content start -->
	<div class="blog_post_cont">
	
		<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		<p>By <span class="author"><?php the_author_posts_link() ?></span>, on <?php the_time('F jS, Y') ?> | <?php the_category(', '); ?></p>
		
			<!-- Tag Content Start -->
			<div class="tag_head">
				<img src="<?php echo get_template_directory_uri(); ?>/images/tagicon.jpg" alt="Tags"/><?php the_tags('', ', ', ''); ?> 
			</div>
			<!-- Tag Content End -->
			
				<div class="blog_post_txt">
					
					<?php the_content(); ?>		
					
					<!-- share Icon start -->
					<div class="share_icon">
					    <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo the_permalink();?>" data-counturl="<?php echo the_permalink(); ?>" data-lang="en" data-count="vertical">Tweet</a>
						<span class='st_fblike_vcount' st_url="<?php the_permalink(); ?>" displayText='Facebook Like'></span>
						<g:plusone size="tall" href="<?php echo the_permalink(); ?>"></g:plusone>
						<su:badge layout="5" href="<?php echo the_permalink(); ?>"></su:badge>
						<a class="DiggThisButton DiggMedium" href="<?php echo the_permalink(); ?>"></a>
						<span class='st_pinterest_vcount' st_url="<?php echo the_permalink();?>" displayText='Pinit'></span>
						<span class='st_linkedin_vcount' st_url="<?php echo the_permalink();?>" displayText='LinkedIn'></span>
 					</div>
					<!-- Share icoon end-->
					
					<!-- authoe details  start -->
					<div class="author_detail">
						<div class="author_bio">
							<div class="author_img">
								<?php userphoto_the_author_photo();?>
							</div>
								<p>Author: <span class="author_name"><?php the_author_posts_link() ?></span></p>
								<p class="auth"><?php the_author_description(); ?> </p>
						</div>
						<div class="clear"></div>
					</div>	
					<!-- author detail end -->
					
					<div class="post-footer">
						<img src="<?php echo get_template_directory_uri(); ?>/images/comments_icon.jpg" width="20" height="20" alt="Leave a comment"/>
						<a href="#face_comment">Leave a comment</a>
						<img src="<?php echo get_template_directory_uri(); ?>/images/categoryicon.jpg" alt="category"/>
						<?php the_category(','); ?>
						<img src="<?php echo get_template_directory_uri(); ?>/images/tagicon.jpg" alt="tags"/>
						<?php the_tags('', ', ', ''); ?>
					</div>
					
					<!-- face book comments start -->
					<div class="face_comment" id="face_comment">
						Comments
						<?php if ( comments_open() ) : ?>  
							<div id="fbcomments"><div id="fb-root"></div><script src="http://connect.facebook.net/de_EN/all.js#xfbml=1"></script><fb:comments href="<?php the_permalink(); ?>" width="640"></fb:comments></div>  
						<?php endif; ?>  
					</div>
					<!-- facebook comments end -->
					
				</div>	
				
				<div class="clear"></div>
				
	</div>
	<!-- Single Post blog display content end -->
	
</article><!-- #post-<?php the_ID(); ?> -->
