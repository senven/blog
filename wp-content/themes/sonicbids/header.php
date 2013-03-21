<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Sonicbids CMS
 */
?>
<?php //header('X-UA-Compatible: IE=8'); ?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=1146, user-scalable=yes" />
<meta name="description" content="<?php  echo get_post_meta($post->ID, "meta_description", true); ?>" />
<meta property="og:image" content="<?php  echo get_post_meta($post->ID, "og_image", true); ?>"/>
<meta property='fb:app_id' content='361324053909284' /> 
<!-- content type added for lead capture form -->
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">

<meta name="google-site-verification" content="h1M9aV5dXXrx086GXJvQLqOeeZuIUqS_GhIm6LOkEpU" />

<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	if( !is_home() && !is_front_page() ) 
		bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ){
		echo "$site_description | ";
		bloginfo( 'name' );
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link href="<?php echo get_template_directory_uri(); ?>/boilerplate.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link href="<?php echo get_template_directory_uri(); ?>/fonts/font-style.css" rel="stylesheet" type="text/css" />

<link href="<?php echo get_template_directory_uri(); ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
	
	//overriding default sub menu display
	class Submenu_Custom_Walker extends Walker_Nav_Menu {
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"sub-menu\">\n";
		}
	}
?>
<!--Social Media Plugin-->
<script type="text/javascript">
  (function() {
    var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
    li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
  })();
</script>
<script type="text/javascript">
(function() {
var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
s.type = 'text/javascript';
s.async = true;
s.src = 'http://widgets.digg.com/buttons.js';
s1.parentNode.insertBefore(s, s1);
})();
</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
<!--Social Media Plugin-->

</head>

<body <?php body_class(); ?>>
<div id="wrapper">
	<div class="menu-wrapper">
			<nav id="access" role="navigation">
				<h3 class="assistive-text"><?php _e( 'Main menu', 'twentyeleven' ); ?></h3>
				<?php /* Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff. */ ?>
				<div class="skip-link"><a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to primary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to primary content', 'twentyeleven' ); ?></a></div>
				<div class="skip-link"><a class="assistive-text" href="#secondary" title="<?php esc_attr_e( 'Skip to secondary content', 'twentyeleven' ); ?>"><?php _e( 'Skip to secondary content', 'twentyeleven' ); ?></a></div>
				<?php /* Our navigation menu. If one isn't filled out, wp_nav_menu falls back to wp_page_menu. The menu assigned to the primary location is the one used. If one isn't assigned, the menu with the lowest ID is used. */ ?>				
				
				<?php
					// Get the logo active class
					$logoactive = "";
					if (is_page()) {  // Currently displaying a Page?
						global $post;  // The data structure for the current Page is stored in this global variable.
						// Grab the template filename from Page metadata, but discard any .php extension.  
						$template_name =  str_replace('.php', '', get_post_meta($post->ID, '_wp_page_template', true));
						if($template_name == "page-front"){
							$logoactive = " logoactive";
						}
					}
					
					if(is_front_page()){
						$logoactive = " logoactive";
					}
					
				?>
				
				<div class="logo-wrapper">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="logo<?php print $logoactive; ?>"></a>
				</div>
				
				<?php //shailan_dropdown_menu(); ?>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'walker' => new Submenu_Custom_Walker ) ); ?>
				
				<div class="extra-wrapper">
					<a href="http://www.twitter.com/sonicbids" class="twitter" target="_blank"></a>
					<a href="http://www.facebook.com/sonicbids" class="facebook" target="_blank"></a>
					<a href="http://www.sonicbids.com/login" class="signup">Login</a>
					<a href="http://www.sonicbids.com/signup" class="signup">Sign Up</a>
				</div>
				<div class="clear"></div>
			</nav><!-- #access -->
	</div> <!-- #menu-wrapper -->


	<div id="main">
		<div class="sub-menu-container"></div>