<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Sonicbids CMS
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<!-- main blog content start-->
			<div class="blog_cont">
			
				<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
				<p>By <span class="author"><?php the_author_posts_link() ?></span>, on <?php the_time('F jS, Y') ?> | <?php the_category(', '); ?></p>
				
					<!-- Tag Content  start-->
					<div class="tag_head">
						<img src="<?php echo get_template_directory_uri(); ?>/images/tagicon.jpg" alt="Tags"/><?php the_tags('', ', ', ''); ?> 
					</div>
					<!-- Tag Content end-->
					
						<div class="blog_main">
						
							<!-- Left Featured Thumnail image start -->
							<div class="blog_img">
								<?php the_post_thumbnail("thumbnail"); ?>
							</div>
							<!-- Left Featured Thumnail image end -->
							
							<!-- Right Short Content start -->
							<div class="blog_txt">
							
								<p><?php echo substr(strip_tags(get_the_content()),0,300); ?>....</p>
								<span class="read"><a href="<?php echo get_permalink(); ?>">Read more <span class="read_cont">></span></a></span>
								
								<!-- share icon Start-->
								<div class="share_icon">
									<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo the_permalink();?>" data-counturl="<?php echo the_permalink(); ?>" data-lang="en" data-count="vertical">Tweet</a>
									<span class='st_fblike_vcount' st_url="<?php the_permalink(); ?>" displayText='Facebook Like'></span>
									<g:plusone size="tall" href="<?php echo the_permalink(); ?>"></g:plusone>
									<su:badge layout="5" href="<?php echo the_permalink(); ?>"></su:badge>
									<a class="DiggThisButton DiggMedium" href="<?php echo the_permalink(); ?>"></a>
									<span class='st_pinterest_vcount' st_url="<?php echo the_permalink();?>" displayText='Pinit'></span>
									<span class='st_linkedin_vcount' st_url="<?php echo the_permalink();?>" displayText='LinkedIn'></span>
								</div>
								<!-- share icon End -->
								
								<div class="post-footer">
									<img src="<?php echo get_template_directory_uri(); ?>/images/comments_icon.jpg" width="20" height="20" alt="Leave a comment"/>
									<a href="<?php echo get_permalink(); ?>/#face_comment">Leave a comment</a>
									<img src="<?php echo get_template_directory_uri(); ?>/images/categoryicon.jpg" alt="category"/>
									<?php the_category(','); ?>
									<img src="<?php echo get_template_directory_uri(); ?>/images/tagicon.jpg" alt="tags"/>
									<?php the_tags('',',',''); ?>
								</div>
								
							</div>
							<!-- Right Short Content End -->
							
						</div>
						
				<div class="clear"></div>
				
			</div>	
			<!-- main blog content End-->
</article><!-- #post-<?php the_ID(); ?> -->
