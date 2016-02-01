<?php
/**
 * Plugin Name: Widowless
 * Plugin URI: https://github.com/jayfreestone/widowless
 * Description: This plugin helps prevent widows by adding non-breaking space(s)
 * Version: 1.0.0
 * Author: Jay Freestone
 * Author URI: http://jayfreestone.com
 * License: GPL2
 */

function widowless( $content ) {
	return preg_replace( '/(\s)(?=\w+.?<\/[a-zA-Z]\d?>)|(\s)(?=\w+$)/', '&nbsp;', $content );
}

function setup_widowless( ) {
	if ( get_option( 'title' ) ) {
		add_filter('the_title', 'widowless');
	}
	if ( get_option( 'content' ) ) {
		add_filter('the_content', 'widowless');
	}
}
add_action('init', 'setup_widowless');

function widowless_add_menu(){
	add_options_page( 'Widowless', 'Widowless', 'manage_options', 'widowless-options', 'admin_page' );
}
add_action('admin_menu', 'widowless_add_menu');

function widowless_add_settings() {
	register_setting( 'widowless_settings', 'title' );
	register_setting( 'widowless_settings', 'content' );
	register_setting( 'widowless_settings', 'acf' );
}
add_action( 'admin_init', 'widowless_add_settings' );

function admin_page(){
	ob_start(); 
	?>
	<div class="wrap">
	<h2>Widowless Options</h2>

	<form method="post" action="options.php">
		<?php settings_fields( 'widowless_settings' ); ?>
		<?php do_settings_sections( 'widowless_settings' ); ?>

		<h3>Enable Widowless for:</h3>
		<table class="form-table">
			<tr valign="top">
			<th scope="row">Title</th>
			<td><input type="checkbox" name="title" value="<?php echo get_option('title'); ?>" <?php if ( get_option('title') == true ) { echo ' checked="checked"'; } ?> /></td>
			</tr>
			 
			<tr valign="top">
			<th scope="row">Content</th>
			<td><input type="checkbox" name="content" value="<?php echo get_option('content'); ?>" /></td>
			</tr>
			
			<tr valign="top">
			<th scope="row">Advanced Custom Fields</th>
			<td><input type="checkbox" name="acf" value="<?php echo get_option('acf'); ?>" /></td>
			</tr>
		</table>
		
		<?php submit_button(); ?>

	</form>
	</div>
	<?php
	echo ob_get_clean();
}
