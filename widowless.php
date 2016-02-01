<?php
/**
 * Plugin Name: Widowless
 * Plugin URI: https://github.com/jayfreestone/widowless
 * Description: This plugin helps prevent widows by adding a non-breaking space between the last two words in a string.
 * Version: 1.0.0
 * Author: Jay Freestone
 * Author URI: http://jayfreestone.com
 * License: GPL2
 */

function widowless( $content ) {
	return preg_replace( '/(\s)(?=\w+.?<\/[a-zA-Z]\d?>)|(\s)(?=\w+$)/', '&nbsp;', $content );
}

function setup_widowless( ) {
	$widowless_options = get_option( 'widowless_option_name' );
	$title = $widowless_options['title_0']; // Title
	$content = $widowless_options['content_1']; // Content
	$acf = $widowless_options['advanced_custom_fields_2']; // Advanced Custom Fields
	
	// Filters the title
	if ( $title ) {
		add_filter('the_title', 'widowless');
	}

	// Filters the content
	if ( $content ) {
		add_filter('the_content', 'widowless');
	}

	// Filters text-based ACF fields
	if ( $acf ) {
		add_filter('acf_the_content', 'widowless');
		add_filter('acf/load_value/type=text', 'widowless');
		add_filter('acf/load_value/type=textarea', 'widowless');
	}
}
add_action('init', 'setup_widowless');

class Widowless {
	private $widowless_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'widowless_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'widowless_page_init' ) );
	}

	public function widowless_add_plugin_page() {
		add_options_page(
			'Widowless', // page_title
			'Widowless', // menu_title
			'manage_options', // capability
			'widowless', // menu_slug
			array( $this, 'widowless_create_admin_page' ) // function
		);
	}

	public function widowless_create_admin_page() {
		$this->widowless_options = get_option( 'widowless_option_name' ); ?>

		<div class="wrap">
			<h2>Widowless</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'widowless_option_group' );
					do_settings_sections( 'widowless-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function widowless_page_init() {
		register_setting(
			'widowless_option_group', // option_group
			'widowless_option_name', // option_name
			array( $this, 'widowless_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'widowless_setting_section', // id
			'Settings', // title
			array( $this, 'widowless_section_info' ), // callback
			'widowless-admin' // page
		);

		add_settings_field(
			'title_0', // id
			'Title', // title
			array( $this, 'title_0_callback' ), // callback
			'widowless-admin', // page
			'widowless_setting_section' // section
		);

		add_settings_field(
			'content_1', // id
			'Content', // title
			array( $this, 'content_1_callback' ), // callback
			'widowless-admin', // page
			'widowless_setting_section' // section
		);

		add_settings_field(
			'advanced_custom_fields_2', // id
			'Advanced Custom Fields', // title
			array( $this, 'advanced_custom_fields_2_callback' ), // callback
			'widowless-admin', // page
			'widowless_setting_section' // section
		);
	}

	public function widowless_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['title_0'] ) ) {
			$sanitary_values['title_0'] = $input['title_0'];
		}

		if ( isset( $input['content_1'] ) ) {
			$sanitary_values['content_1'] = $input['content_1'];
		}

		if ( isset( $input['advanced_custom_fields_2'] ) ) {
			$sanitary_values['advanced_custom_fields_2'] = $input['advanced_custom_fields_2'];
		}

		return $sanitary_values;
	}

	public function widowless_section_info() {
		
	}

	public function title_0_callback() {
		printf(
			'<input type="checkbox" name="widowless_option_name[title_0]" id="title_0" value="title_0" %s> <label for="title_0">Applies filter to the_title()</label>',
			( isset( $this->widowless_options['title_0'] ) && $this->widowless_options['title_0'] === 'title_0' ) ? 'checked' : ''
		);
	}

	public function content_1_callback() {
		printf(
			'<input type="checkbox" name="widowless_option_name[content_1]" id="content_1" value="content_1" %s> <label for="content_1">Applies filter to the_content()</label>',
			( isset( $this->widowless_options['content_1'] ) && $this->widowless_options['content_1'] === 'content_1' ) ? 'checked' : ''
		);
	}

	public function advanced_custom_fields_2_callback() {
		printf(
			'<input type="checkbox" name="widowless_option_name[advanced_custom_fields_2]" id="advanced_custom_fields_2" value="advanced_custom_fields_2" %s> <label for="advanced_custom_fields_2">Applies filter to ACF fields</label>',
			( isset( $this->widowless_options['advanced_custom_fields_2'] ) && $this->widowless_options['advanced_custom_fields_2'] === 'advanced_custom_fields_2' ) ? 'checked' : ''
		);
	}

}
if ( is_admin() )
	$widowless = new Widowless();

function widowless_checkbox_field_0_render(  ) { 

	$options = get_option( 'widowless_settings' );
	?>
	<input type='checkbox' name='widowless_settings[widowless_checkbox_field_0]' <?php checked( $options['widowless_checkbox_field_0'], 1 ); ?> value='1'>
	<?php

}

function widowless_checkbox_field_1_render(  ) { 

	$options = get_option( 'widowless_settings' );
	?>
	<input type='checkbox' name='widowless_settings[widowless_checkbox_field_1]' <?php checked( $options['widowless_checkbox_field_1'], 1 ); ?> value='1'>
	<?php

}

function widowless_checkbox_field_2_render(  ) { 

	$options = get_option( 'widowless_settings' );
	?>
	<input type='checkbox' name='widowless_settings[widowless_checkbox_field_2]' <?php checked( $options['widowless_checkbox_field_2'], 1 ); ?> value='1'>
	<?php

}

function widowless_settings_section_callback(  ) { 

	echo __( 'This section description', 'wordpress' );

}

function widowless_options_page(  ) { 

	?>
	<form action='options.php' method='post'>
		
		<h2>widowless</h2>
		
		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>
		
	</form>
	<?php

}

?>
