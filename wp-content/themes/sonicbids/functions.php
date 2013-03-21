<?php
/**
 * Sonicbids theme functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, sonicbids_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'sonicbids_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Sonicbids CMS
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 584;

/**
 * Tell WordPress to run sonicbids_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'sonicbids_setup' );

if ( ! function_exists( 'sonicbids_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override sonicbids_setup() in a child theme, add your own sonicbids_setup to your child theme's
 * functions.php file.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To style the visual editor.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links, custom headers
 * 	and backgrounds, and post formats.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Sonicbids theme 1.0
 */
function sonicbids_setup() {

	/* Make Sonicbids theme available for translation.
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Sonicbids theme, use a find and replace
	 * to change 'sonicbids' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'sonicbids', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Load up our theme options page and related code.
	require( get_template_directory() . '/inc/theme-options.php' );

	// Grab Sonicbids theme's Ephemera widget.
	require( get_template_directory() . '/inc/widgets.php' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'sonicbids' ) );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

	$theme_options = twentyeleven_get_theme_options();
	if ( 'dark' == $theme_options['color_scheme'] )
		$default_background_color = '1d1d1d';
	else
		$default_background_color = 'f1f1f1';

	// Add support for custom backgrounds.
	add_theme_support( 'custom-background', array(
		// Let WordPress know what our default background color is.
		// This is dependent on our current color scheme.
		'default-color' => $default_background_color,
	) );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );

	// Add support for custom headers.
	$custom_header_support = array(
		// The default header text color.
		'default-text-color' => '000',
		// The height and width of our custom header.
		'width' => apply_filters( 'sonicbids_header_image_width', 1000 ),
		'height' => apply_filters( 'sonicbids_header_image_height', 288 ),
		// Support flexible heights.
		'flex-height' => true,
		// Random image rotation by default.
		'random-default' => true,
		// Callback for styling the header.
		'wp-head-callback' => 'sonicbids_header_style',
		// Callback for styling the header preview in the admin.
		'admin-head-callback' => 'sonicbids_admin_header_style',
		// Callback used to display the header preview in the admin.
		'admin-preview-callback' => 'sonicbids_admin_header_image',
	);
	
	add_theme_support( 'custom-header', $custom_header_support );

	if ( ! function_exists( 'get_custom_header' ) ) {
		// This is all for compatibility with versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR', $custom_header_support['default-text-color'] );
		define( 'HEADER_IMAGE', '' );
		define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
		add_custom_image_header( $custom_header_support['wp-head-callback'], $custom_header_support['admin-head-callback'], $custom_header_support['admin-preview-callback'] );
		add_custom_background();
	}

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be the size of the header image that we just defined
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

	// Add Sonicbids theme's custom image sizes.
	// Used for large feature (header) images.
	add_image_size( 'large-feature', $custom_header_support['width'], $custom_header_support['height'], true );
	// Used for featured posts if a large-feature doesn't exist.
	add_image_size( 'small-feature', 500, 300 );

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'wheel' => array(
			'url' => '%s/images/headers/wheel.jpg',
			'thumbnail_url' => '%s/images/headers/wheel-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Wheel', 'sonicbids' )
		),
		'shore' => array(
			'url' => '%s/images/headers/shore.jpg',
			'thumbnail_url' => '%s/images/headers/shore-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Shore', 'sonicbids' )
		),
		'trolley' => array(
			'url' => '%s/images/headers/trolley.jpg',
			'thumbnail_url' => '%s/images/headers/trolley-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Trolley', 'sonicbids' )
		),
		'pine-cone' => array(
			'url' => '%s/images/headers/pine-cone.jpg',
			'thumbnail_url' => '%s/images/headers/pine-cone-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Pine Cone', 'sonicbids' )
		),
		'chessboard' => array(
			'url' => '%s/images/headers/chessboard.jpg',
			'thumbnail_url' => '%s/images/headers/chessboard-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Chessboard', 'sonicbids' )
		),
		'lanterns' => array(
			'url' => '%s/images/headers/lanterns.jpg',
			'thumbnail_url' => '%s/images/headers/lanterns-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Lanterns', 'sonicbids' )
		),
		'willow' => array(
			'url' => '%s/images/headers/willow.jpg',
			'thumbnail_url' => '%s/images/headers/willow-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Willow', 'sonicbids' )
		),
		'hanoi' => array(
			'url' => '%s/images/headers/hanoi.jpg',
			'thumbnail_url' => '%s/images/headers/hanoi-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Hanoi Plant', 'sonicbids' )
		)
	) );
}
endif; // sonicbids_setup

if ( ! function_exists( 'sonicbids_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @since Sonicbids theme 1.0
 */
function sonicbids_header_style() {
	$text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail.
	if ( $text_color == HEADER_TEXTCOLOR )
		return;
		
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $text_color ) :
	?>
		#site-title,
		#site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo $text_color; ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // sonicbids_header_style

if ( ! function_exists( 'sonicbids_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header') in sonicbids_setup().
 *
 * @since Sonicbids theme 1.0
 */
function sonicbids_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#desc {
		font-family: "Helvetica Neue", Arial, Helvetica, "Nimbus Sans L", sans-serif;
	}
	#headimg h1 {
		margin: 0;
	}
	#headimg h1 a {
		font-size: 32px;
		line-height: 36px;
		text-decoration: none;
	}
	#desc {
		font-size: 14px;
		line-height: 23px;
		padding: 0 0 3em;
	}
	<?php
		// If the user has set a custom color for the text use that
		if ( get_header_textcolor() != HEADER_TEXTCOLOR ) :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	#headimg img {
		max-width: 1000px;
		height: auto;
		width: 100%;
	}
	</style>
<?php
}
endif; // sonicbids_admin_header_style

if ( ! function_exists( 'sonicbids_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header') in sonicbids_setup().
 *
 * @since Sonicbids theme 1.0
 */
function sonicbids_admin_header_image() { ?>
	<div id="headimg">
		<?php
		$color = get_header_textcolor();
		$image = get_header_image();
		if ( $color && $color != 'blank' )
			$style = ' style="color:#' . $color . '"';
		else
			$style = ' style="display:none"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( $image ) : ?>
			<img src="<?php echo esc_url( $image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }
endif; // sonicbids_admin_header_image

/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function sonicbids_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'sonicbids_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function sonicbids_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'sonicbids' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and sonicbids_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function sonicbids_auto_excerpt_more( $more ) {
	return ' &hellip;' . sonicbids_continue_reading_link();
}
add_filter( 'excerpt_more', 'sonicbids_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function sonicbids_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= sonicbids_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'sonicbids_custom_excerpt_more' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function sonicbids_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'sonicbids_page_menu_args' );

/**
 * Register our sidebars and widgetized areas. Also register the default Epherma widget.
 *
 * @since Sonicbids theme 1.0
 */
function sonicbids_widgets_init() {

	register_widget( 'Twenty_Eleven_Ephemera_Widget' );

	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'sonicbids' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Showcase Sidebar', 'sonicbids' ),
		'id' => 'sidebar-2',
		'description' => __( 'The sidebar for the optional Showcase Template', 'sonicbids' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Tweet Sidebar', 'sonicbids' ),
		'id' => 'sidebar-6',
		'description' => __( 'The sidebar for the optional Showcase Template', 'sonicbids' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area One', 'sonicbids' ),
		'id' => 'sidebar-3',
		'description' => __( 'An optional widget area for your site footer', 'sonicbids' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Two', 'sonicbids' ),
		'id' => 'sidebar-4',
		'description' => __( 'An optional widget area for your site footer', 'sonicbids' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Three', 'sonicbids' ),
		'id' => 'sidebar-5',
		'description' => __( 'An optional widget area for your site footer', 'sonicbids' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'sonicbids_widgets_init' );

if ( ! function_exists( 'sonicbids_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function sonicbids_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'sonicbids' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'sonicbids' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'sonicbids' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}
endif; // sonicbids_content_nav

/**
 * Return the URL for the first link found in the post content.
 *
 * @since Sonicbids theme 1.0
 * @return string|bool URL or false when no link is present.
 */
function sonicbids_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function sonicbids_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}

if ( ! function_exists( 'sonicbids_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own sonicbids_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Sonicbids theme 1.0
 */
function sonicbids_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'sonicbids' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'sonicbids' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'sonicbids' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'sonicbids' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'sonicbids' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'sonicbids' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'sonicbids' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for sonicbids_comment()

if ( ! function_exists( 'sonicbids_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own sonicbids_posted_on to override in a child theme
 *
 * @since Sonicbids theme 1.0
 */
function sonicbids_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'sonicbids' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'sonicbids' ), get_the_author() ) ),
		get_the_author()
	);
}
endif;

/**
 * Adds two classes to the array of body classes.
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 *
 * @since Sonicbids theme 1.0
 */
function sonicbids_body_classes( $classes ) {

	if ( function_exists( 'is_multi_author' ) && ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) )
		$classes[] = 'singular';

	return $classes;
}
add_filter( 'body_class', 'sonicbids_body_classes' );



/** Custom functions ***/

/**
 * Function get hero images
 */
function get_homepage_top_hero_images(){
  global $wpdb;
  
  // Get hero iamges
  $heros = $wpdb->get_results("
	SELECT * 
	FROM sc_cus_heroimages
	WHERE status = '1' ORDER BY weight ASC"
  );
  
  $upload_dir = wp_upload_dir();
  $base_url = $upload_dir["baseurl"];
  $output = '';
  if ($heros){
    foreach ($heros as $hero){
      $image_url = $base_url. "/" . $hero->image;
      $output .= '<div class="hero-slider-content" data-caption="'. $hero->arrow_slider_text .'">
        <div class="slider-image">
          <img width="1440" height="478" alt="'. $hero->arrow_slider_text .'" src="'. $image_url .'">
        </div>
		<div class="hero-next-caption" style="visibility: hidden;">
			<span class="caption-right"></span>
			<span class="caption-middle">'. $hero->arrow_slider_text .'</span>
			<span class="caption-left"></span>
		</div>
		<div class="clear"></div>
      </div>';
    }
  }
  
  return $output;
}

/**
 * Function get hero images text
 */
function get_homepage_top_hero_text(){
  global $wpdb;
  $output = '';
  
  $heros = $wpdb->get_results("
	SELECT * 
	FROM sc_cus_heroimages
	WHERE status = '1' ORDER BY weight ASC"
  );
  
  if ($heros){
    $i = 0;
    foreach ($heros as $hero){
      
      // Get hero image text
      $hero_texts = $wpdb->get_results("
        SELECT * 
        FROM sc_cus_heroimages_text
        WHERE heroimage_id = '". $hero->id ."' ORDER BY weight ASC"
      );
      
      if($i == 0){
        $output .= '<div class="hero-slider-boxes">
          <!--Slider Contents-->
          <div class="hero-slider slider-1" style="top: 198px; opacity: 1;">';
      }
      else{
        $output .= '<div class="hero-slider-boxes">
          <!--Slider Contents-->
          <div class="hero-slider">';
      }
      $output .= '
            <!-- Left Box -->
            <div class="hero-box-left">';
      
      $count = 1;
      // Get hero image appropriate text
      foreach ($hero_texts as $hero_text){
        // Get first last class
        $fl_class = (count($hero_texts) == 1) ? " first last" : (($count==1) ? " first" : ((count($hero_texts) == $count) ? " last" : ""));
        
        // Check small text
        if($hero_text->text_size == "small"){
          $output .= '<div><span class="hero-txt'. $fl_class .'">'. $hero_text->hero_text .'</span></div>';
        }
        
        // Check medium text
        if($hero_text->text_size == "medium"){
          $output .= '<div><span class="hero-medium-txt'. $fl_class .'">'. $hero_text->hero_text .'</span></div>';
        }
        
        // Check large text
        if($hero_text->text_size == "large"){
          $output .= '<div><span class="hero-larger-txt'. $fl_class .'">'. $hero_text->hero_text .'</span></div>';
        }
        
        $count++;
      }
            
      if($hero->button_text != ""){
        $pos = strpos($hero->button_link, 'http');
        if ($pos === false) {
          $button_link = get_bloginfo( 'url', 'display' ). $hero->button_link;
        }
        else{
          $button_link = $hero->button_link;
        }
        $output .= '<span class="btn-holder"><a href="'. $button_link .'" class="call-to-action-btn">'. $hero->button_text .'</a></span>';
      }
      
      $output .= '</div>
        <!-- Right Box -->';
        
      if($hero->slider_right_text != ""){
        $output .= '<div class="hero-box-right experience">
                <span class="hero-right-txt">'. $hero->slider_right_text .'</span>
            </div>';
      }
      
      $output .= '</div>
      </div>';
      
    $i++;
    }
  }
  
  return $output;
}


/**
 * Function get products page - Carousel images
 */
function get_products_carousel_images($category = null){
  global $wpdb;
  
  $category = ($category == "") ? "band" : $category;
  
  // Get carousel images
  $carousel_images = $wpdb->get_results("
	SELECT * 
	FROM sc_cus_success_stories
	WHERE status = '1' AND category = '$category' ORDER BY weight ASC"
  );
  
  $upload_dir = wp_upload_dir();
  $base_url = $upload_dir["baseurl"];
  $output = '';
  if ($carousel_images){
    $total = count($carousel_images);
    $i = 0;
    foreach ($carousel_images as $carousel_image){
      $image_url = $base_url. "/" . $carousel_image->image;
      $tag = ($carousel_image->link_url == "") ? "div" : "a";
      
      $pos = strpos($carousel_image->link_url, 'http');
      if ($pos === false) {
        $link_url = get_bloginfo( 'url', 'display' ). $carousel_image->link_url;
      }
      else{
        $link_url = $carousel_image->link_url;
      }
        
      if($total == $i+1)
        $output .= '<'. $tag .' href="'. $link_url .'" class="carousel-img last">';
      else
        $output .= '<'. $tag .' href="'. $link_url .'" class="carousel-img">';
        
      $output .= '<img src="'. $image_url .'" width="312" height="234" alt="'. stripslashes($carousel_image->image_text) .'">';
      if($carousel_image->image_text != ""){
        $output .= '<span class="carousel-msg">'. stripslashes($carousel_image->image_text) .'</span>';
      }
        $output .= '<div class="carousel-caption">
          <span class="bands-big-txt">'. stripslashes($carousel_image->story_text) .'</span>
        </div>
      </'. $tag .'>';
      $i++;
    }
  }
  
  return $output;
}

/**
 * Function get success stories top slider image
 */
function get_success_stories_slider_text($category = null, $story = null){
  global $wpdb;
  
  $category = ($category == "") ? "band" : $category;
  
  $where ="";
  if($story){
    $where = " AND name = '$story'";
  }
  
  // Get slider images
  $slider_images = $wpdb->get_results("
	SELECT * 
	FROM sc_cus_success_stories_slider
	WHERE status = '1' AND category = '$category' $where ORDER BY weight ASC"
  );
  
  $upload_dir = wp_upload_dir();
  $base_url = $upload_dir["baseurl"];
  $output = '';
  
  if ($slider_images){
    foreach ($slider_images as $slider_image){
      
      $output .= '<div class="msg-box">
			<div class="msg-box-txt">
				<p>'. stripslashes($slider_image->description) .'</p>';
      if($slider_image->link_text != ""){
        $pos = strpos($slider_image->link_url, 'http');
        if ($pos === false) {
          $link_url = get_bloginfo( 'url', 'display' ). $slider_image->link_url;
          $output .= '<a href="'. $link_url .'" class="blue-txt">'. $slider_image->link_text .'</a>';
        }
        else{
          $output .= '<a href="'. $slider_image->link_url .'" class="blue-txt">'. $slider_image->link_text .'</a>';
        }
      }
	  $output .= '</div>';
      
      if($slider_image->button_text != ""){
        
        $pos = strpos($slider_image->button_link_url, 'http');
        if ($pos === false) {
          $button_link_url = get_bloginfo( 'url', 'display' ). $slider_image->button_link_url;
        }
        else{
          $button_link_url = $slider_image->button_link_url;
        }
        
        $output .= '<div class="msg-btn-holder">
            <a href="'. $button_link_url .'" class="big-btn right">'. $slider_image->button_text .'</a>
        </div>';
      }
	  $output .= '</div>';
      
    }
  }
  
  return $output;
}

/**
 * Function get success stories top slider image
 */
function get_success_stories_slider($category = null, $story = null){
  global $wpdb;
  
  $category = ($category == "") ? "band" : $category;
  
  $where ="";
  if($story){
    $where = " AND name = '$story'";
  }
  
  // Get slider images
  $slider_images = $wpdb->get_results("
	SELECT * 
	FROM sc_cus_success_stories_slider
	WHERE status = '1' AND category = '$category' $where ORDER BY weight ASC"
  );
  
  $upload_dir = wp_upload_dir();
  $base_url = $upload_dir["baseurl"];
  $output = '<div class="inner-slider-display"><div class="inner-slider-container">';
  $output_text = '';
  if ($slider_images){
    foreach ($slider_images as $slider_image){
      $image_url = $base_url. "/" . $slider_image->slider_image;
      $output .= '<div class="inner-slider-images">
          <img src="'. $image_url .'" width="976" height="478">
      </div>';
	  $output_text .= '<div class="inner-slider-txt">'. $slider_image->slider_image_text .'</div>';
    }
  }
  
  $output .= '<div class="clear"></div>';
  $output .= '</div></div>';
  $output .= '<div id="inner-slider-text-wrapper">' . $output_text . '</div>';
  return $output;
}



/**
 * Function get success stories page - bottom thumbnail boxes
 */
function get_succstories_btm_images($category = null){
  global $wpdb;
  
  $category = ($category == "") ? "band" : $category;
  
  // Get carousel images
  $carousel_images = $wpdb->get_results("
	SELECT * 
	FROM sc_cus_success_stories
	WHERE status = '1' AND category = '$category' ORDER BY weight ASC"
  );
  
  $upload_dir = wp_upload_dir();
  $base_url = $upload_dir["baseurl"];
  $output = '<ul>';
  if ($carousel_images){
    $total = count($carousel_images);
    $i = 0;
    foreach ($carousel_images as $carousel_image){
      $image_url = $base_url. "/" . $carousel_image->image;
      $tag = ($carousel_image->link_url == "") ? "a" : "a";
      
      $pos = strpos($carousel_image->link_url, 'http');
      if ($pos === false) {
        $link_url = get_bloginfo( 'url', 'display' ). $carousel_image->link_url;
      }
      else{
        $link_url = $carousel_image->link_url;
      }
      
      if(($total == $i+1) || (($i+1)%3 == 0))
        $output .= '<li class="last"><'. $tag .' href="'. $link_url .'">';
      else
        $output .= '<li><'. $tag .' href="'. $link_url .'">';
        
      $output .= '<img src="'. $image_url .'" width="146" height="110" alt="'. stripslashes($carousel_image->image_text) .'">';

        $output .= '<div class="story-caption">
          <span class="bands-small-txt">'. stripslashes($carousel_image->story_text) .'</span>
        </div>
      </'. $tag .'></li>';
      
      $i++;
    }
  }
  
  $output .= '</ul>';
  return $output;
}

/**
 * Send basic html email
 */
function send_html_email($to, $from, $subject, $body){
    //begin of HTML message
    $message = '<html>
      <body>
        '. $body .'
      </body>
    </html>';
    //end of message
        $headers  = "From: $from\r\n";
        $headers .= "Content-type: text/html\r\n";
  $mail_sent = mail($to, $subject, $message, $headers);
  return $mail_sent ? true : false;
}


/**
 * Function get home page callback images
 */
function get_homepage_callback_images(){
  global $wpdb;
  
  // Get slider images
  $callback_images = $wpdb->get_results("
	SELECT * 
	FROM sc_cus_home_callback_image
	WHERE status = '1' ORDER BY weight ASC"
  );
  
  $upload_dir = wp_upload_dir();
  $base_url = $upload_dir["baseurl"];
  $output_text = '';
  if ($callback_images){
    $i = 0;
    foreach ($callback_images as $callback_image){
      
      if(($total == $i+1) || (($i+1)%3 == 0))
        $class = "brands-box";
      else
        $class = "bands-box";
        
      $image_url = $base_url. "/" . $callback_image->image;
      $output .= '<a href="'. $callback_image->link .'" class="'. $class .' box-links">
			<img src="'. $image_url .'" width="312" height="234" alt="bands">
			<span class="bands-box-txt-bg box-txt-bg">
				<span class="bands-small-txt">'. $callback_image->small_text .'</span>
				<span class="bands-big-txt">'. $callback_image->big_text .'
                  <span class="box-arrow"><img src="'. get_template_directory_uri() .'/images/box-arrow.png" width="15" height="24" alt="arrow"></span>
				</span>
			</span>
			<div class="box-caption">
				<span class="bands-big-txt caption-text">'. $callback_image->hover_big .'</span>
				<span class="bands-small-txt caption-text">'. $callback_image->hover_samll .'</span>
			</div>
		</a>';
        $i++;
    }
  }
  
  return $output;
}


/**
 * Get archives
 */
function wp_get_custom_archives($args = '') {
	global $wpdb, $wp_locale;

	$defaults = array(
		'type' => 'monthly', 'limit' => '',
		'format' => 'html', 'before' => '',
		'after' => '', 'show_post_count' => false,
		'echo' => 1
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	if ( '' == $type )
		$type = 'monthly';

	if ( '' != $limit ) {
		$limit = absint($limit);
		$limit = ' LIMIT '.$limit;
	}

	// this is what will separate dates on weekly archive links
	$archive_week_separator = '&#8211;';

	// over-ride general date format ? 0 = no: use the date format set in Options, 1 = yes: over-ride
	$archive_date_format_over_ride = 0;

	// options for daily archive (only if you over-ride the general date format)
	$archive_day_date_format = 'Y/m/d';

	// options for weekly archive (only if you over-ride the general date format)
	$archive_week_start_date_format = 'Y/m/d';
	$archive_week_end_date_format	= 'Y/m/d';

	if ( !$archive_date_format_over_ride ) {
		$archive_day_date_format = get_option('date_format');
		$archive_week_start_date_format = get_option('date_format');
		$archive_week_end_date_format = get_option('date_format');
	}

	//filters
	$where = apply_filters( 'getarchives_where', "WHERE post_type = 'post' AND post_status = 'publish'", $r );
	$join = apply_filters( 'getarchives_join', '', $r );

	$output = '';

	if ( 'monthly' == $type ) {
		$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC $limit";
		$key = md5($query);
		$cache = wp_cache_get( 'wp_get_archives' , 'general');
		if ( !isset( $cache[ $key ] ) ) {
			$arcresults = $wpdb->get_results($query);
			$cache[ $key ] = $arcresults;
			wp_cache_set( 'wp_get_archives', $cache, 'general' );
		} else {
			$arcresults = $cache[ $key ];
		}
		if ( $arcresults ) {
			$afterafter = $after;
			foreach ( (array) $arcresults as $arcresult ) {
				$url = get_month_link( $arcresult->year, $arcresult->month );
				/* translators: 1: month name, 2: 4-digit year */
				$text = sprintf(__('%1$s %2$d'), $wp_locale->get_month($arcresult->month), $arcresult->year);
				if ( $show_post_count )
					$after = '&nbsp;('.$arcresult->posts.')' . $afterafter;
				$output .= get_archives_link($url, $text, $format, $before, $after);
			}
		}
	} elseif ('yearly' == $type) {
		$query = "SELECT YEAR(post_date) AS `year`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date) ORDER BY post_date DESC $limit";
		$key = md5($query);
		$cache = wp_cache_get( 'wp_get_archives' , 'general');
		if ( !isset( $cache[ $key ] ) ) {
			$arcresults = $wpdb->get_results($query);
			$cache[ $key ] = $arcresults;
			wp_cache_set( 'wp_get_archives', $cache, 'general' );
		} else {
			$arcresults = $cache[ $key ];
		}
		if ($arcresults) {
			$afterafter = $after;
			foreach ( (array) $arcresults as $arcresult) {
				$url = get_year_link($arcresult->year);
				$text = sprintf('%d', $arcresult->year);
				if ($show_post_count)
					$after = '&nbsp;('.$arcresult->posts.')' . $afterafter;
				$output .= get_archives_link($url, $text, $format, $before, $after);
			}
		}
	} elseif ( 'daily' == $type ) {
		$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, DAYOFMONTH(post_date) AS `dayofmonth`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date), DAYOFMONTH(post_date) ORDER BY post_date DESC $limit";
		$key = md5($query);
		$cache = wp_cache_get( 'wp_get_archives' , 'general');
		if ( !isset( $cache[ $key ] ) ) {
			$arcresults = $wpdb->get_results($query);
			$cache[ $key ] = $arcresults;
			wp_cache_set( 'wp_get_archives', $cache, 'general' );
		} else {
			$arcresults = $cache[ $key ];
		}
		if ( $arcresults ) {
			$afterafter = $after;
			foreach ( (array) $arcresults as $arcresult ) {
				$url	= get_day_link($arcresult->year, $arcresult->month, $arcresult->dayofmonth);
				$date = sprintf('%1$d-%2$02d-%3$02d 00:00:00', $arcresult->year, $arcresult->month, $arcresult->dayofmonth);
				$text = mysql2date($archive_day_date_format, $date);
				if ($show_post_count)
					$after = '&nbsp;('.$arcresult->posts.')'.$afterafter;
				$output .= get_archives_link($url, $text, $format, $before, $after);
			}
		}
	} elseif ( 'weekly' == $type ) {
		$week = _wp_mysql_week( '`post_date`' );
		$query = "SELECT DISTINCT $week AS `week`, YEAR( `post_date` ) AS `yr`, DATE_FORMAT( `post_date`, '%Y-%m-%d' ) AS `yyyymmdd`, count( `ID` ) AS `posts` FROM `$wpdb->posts` $join $where GROUP BY $week, YEAR( `post_date` ) ORDER BY `post_date` DESC $limit";
		$key = md5($query);
		$cache = wp_cache_get( 'wp_get_archives' , 'general');
		if ( !isset( $cache[ $key ] ) ) {
			$arcresults = $wpdb->get_results($query);
			$cache[ $key ] = $arcresults;
			wp_cache_set( 'wp_get_archives', $cache, 'general' );
		} else {
			$arcresults = $cache[ $key ];
		}
		$arc_w_last = '';
		$afterafter = $after;
		if ( $arcresults ) {
				foreach ( (array) $arcresults as $arcresult ) {
					if ( $arcresult->week != $arc_w_last ) {
						$arc_year = $arcresult->yr;
						$arc_w_last = $arcresult->week;
						$arc_week = get_weekstartend($arcresult->yyyymmdd, get_option('start_of_week'));
						$arc_week_start = date_i18n($archive_week_start_date_format, $arc_week['start']);
						$arc_week_end = date_i18n($archive_week_end_date_format, $arc_week['end']);
						$url  = sprintf('%1$s/%2$s%3$sm%4$s%5$s%6$sw%7$s%8$d', home_url(), '', '?', '=', $arc_year, '&amp;', '=', $arcresult->week);
						$text = $arc_week_start . $archive_week_separator . $arc_week_end;
						if ($show_post_count)
							$after = '&nbsp;('.$arcresult->posts.')'.$afterafter;
						$output .= get_archives_link($url, $text, $format, $before, $after);
					}
				}
		}
	} elseif ( ( 'postbypost' == $type ) || ('alpha' == $type) ) {
		$orderby = ('alpha' == $type) ? 'post_title ASC ' : 'post_date DESC ';
		$query = "SELECT * FROM $wpdb->posts $join $where ORDER BY $orderby $limit";
		$key = md5($query);
		$cache = wp_cache_get( 'wp_get_archives' , 'general');
		if ( !isset( $cache[ $key ] ) ) {
			$arcresults = $wpdb->get_results($query);
			$cache[ $key ] = $arcresults;
			wp_cache_set( 'wp_get_archives', $cache, 'general' );
		} else {
			$arcresults = $cache[ $key ];
		}
		if ( $arcresults ) {
			foreach ( (array) $arcresults as $arcresult ) {
				if ( $arcresult->post_date != '0000-00-00 00:00:00' ) {
                    $url  = get_bloginfo( 'url', 'display' ) . "/shoutout/?post_id=" . $arcresult->ID;
					if ( $arcresult->post_title )
						$text = strip_tags( apply_filters( 'the_title', $arcresult->post_title, $arcresult->ID ) );
					else
						$text = $arcresult->ID;
					$output .= get_archives_link($url, $text, $format, $before, $after);
				}
			}
		}
	}
	if ( $echo )
		echo $output;
	else
		return $output;
}
