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
	$count = 1;

	// Sets up the regex for how many &nbsp's there will be
	$regex = array();

	for ( $i = 0; $i < $count; $i++ ) {
		array_push( $regex, '/\s([^ ]*)$/' );
	}

	$string = preg_replace( '/(\s)(?=\w+.?<\/[a-zA-Z]\d?>)|(\s)(?=\w+$)/', '&nbsp', $content );

	return $string;
}

add_filter('the_content', 'widowless');
add_filter('the_title', 'widowless');
