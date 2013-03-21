<?php
/**
 * The template for displaying search forms in Twenty Eleven
 *
 * @package WordPress
 * @subpackage Sonicbids CMS
 */
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="s" class="assistive-text"><?php _e( 'Search', 'twentyeleven' ); ?></label>
		<input type="text" name="s" id="s" class="textbox" value="Search" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
		<input type="submit" class="submit" name="submit"  id="searchsubmit" value="<?php esc_attr_e( 'Search', 'twentyeleven' ); ?>" />
	</form>
