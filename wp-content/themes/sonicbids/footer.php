<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Sonicbids CMS
 */
?>

	</div><!-- #main -->

	<div id="footer"><!-- #footer -->  
        	<div class="footer-logo-area">
            	<a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="Sonicbids"></a>
            </div>
			
            <ul>
            	<li class="header-txt">About</li>
				<?php
						$bookmarks = get_bookmarks( array(
								'orderby'        => 'id',
								'order'          => 'ASC',
								'category_name'  => 'About'
						));
						// Loop through each bookmark and print formatted output
						foreach ( $bookmarks as $bm ) {
								$pos = strpos($bm->link_url, 'http');
								$link_url = ($pos === false) ? get_bloginfo( 'url', 'display' ). $bm->link_url : $bm->link_url;
								printf( '<li><a class="relatedlink" href="%s">%s</a></li>', $link_url, __($bm->link_name) );
						}
				?>
				<?php //get_links(4, '<li>', '</li>', '', TRUE, 'id', FALSE); ?>
            </ul>
            <ul>
            	<li class="header-txt">Bands</li>
				<?php
						$bookmarks = get_bookmarks( array(
								'orderby'        => 'id',
								'order'          => 'ASC',
								'category_name'  => 'Bands'
						));
						// Loop through each bookmark and print formatted output
						foreach ( $bookmarks as $bm ) {
								$pos = strpos($bm->link_url, 'http');
								$link_url = ($pos === false) ? get_bloginfo( 'url', 'display' ). $bm->link_url : $bm->link_url;
								printf( '<li><a class="relatedlink" href="%s">%s</a></li>', $link_url, __($bm->link_name) );
						}
				?>
                <?php //get_links(5, '<li>', '</li>', '', TRUE, 'id', FALSE); ?>
            </ul>
            <ul>
            	<li class="header-txt">Promoters</li>
				<?php
						$bookmarks = get_bookmarks( array(
								'orderby'        => 'id',
								'order'          => 'ASC',
								'category_name'  => 'Promoters'
						));
						// Loop through each bookmark and print formatted output
						foreach ( $bookmarks as $bm ) {
								$pos = strpos($bm->link_url, 'http');
								$link_url = ($pos === false) ? get_bloginfo( 'url', 'display' ). $bm->link_url : $bm->link_url;
								printf( '<li><a class="relatedlink" href="%s">%s</a></li>', $link_url, __($bm->link_name) );
						}
				?>
                <?php //get_links(6, '<li>', '</li>', '', TRUE, 'id', FALSE); ?>
            </ul>
            <ul>
            	<li class="header-txt">Brands</li>
				<?php
						$bookmarks = get_bookmarks( array(
								'orderby'        => 'id',
								'order'          => 'ASC',
								'category_name'  => 'Brands'
						));
						// Loop through each bookmark and print formatted output
						foreach ( $bookmarks as $bm ) {
								$pos = strpos($bm->link_url, 'http');
								$link_url = ($pos === false) ? get_bloginfo( 'url', 'display' ). $bm->link_url : $bm->link_url;
								printf( '<li><a class="relatedlink" href="%s">%s</a></li>', $link_url, __($bm->link_name) );
						}
				?>
                <?php //get_links(7, '<li>', '</li>', '', TRUE, 'id', FALSE); ?>
            </ul>
            <ul>
            	<li class="header-txt">Help</li>
				<?php
						$bookmarks = get_bookmarks( array(
								'orderby'        => 'id',
								'order'          => 'ASC',
								'category_name'  => 'Help'
						));
						// Loop through each bookmark and print formatted output
						foreach ( $bookmarks as $bm ) {
								$pos = strpos($bm->link_url, 'http');
								$link_url = ($pos === false) ? get_bloginfo( 'url', 'display' ). $bm->link_url : $bm->link_url;
								printf( '<li><a class="relatedlink" href="%s">%s</a></li>', $link_url, __($bm->link_name) );
						}
				?>
                <?php //get_links(8, '<li>', '</li>', '', TRUE, 'id', FALSE); ?>
            </ul>
            <div class="clear"></div>
			
    </div><!-- #footer -->
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>