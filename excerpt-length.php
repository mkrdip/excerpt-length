<?php
/*
Plugin Name: Excerpt Length
Plugin URI: http://leekelleher.com/wordpress/plugins/excerpt-length/
Description: Adds an Excerpt Length field setting to the <a href="options-reading.php">Reading Settings</a> section. This value is used to specify the number of words that you would like to appear in the <a href="http://codex.wordpress.org/Template_Tags/the_excerpt" rel="external">the_excerpt()</a>.
Author: Mrinal Kanti Roy
Version: 1.1
Author URI: http://mkrdip.me
*/

function lk_excerpt_length_init() {
	add_settings_field( 'lk-excerpt-length-field', 'Excerpt Length', 'lk_excerpt_length_field_callback_function', 'reading', 'default', array( 'label_for' => 'lk-excerpt-length-field' ) );
	
	register_setting( 'reading', 'lk-excerpt-length-value', 'intval' );
}

function lk_excerpt_length_field_callback_function() {
	$option_value = get_option( 'lk-excerpt-length-value', 55 );
	
	if ( '' == $option_value || '0' == $option_value )
		$option_value = 55; // the default value
	
	echo "<input type='text' name='lk-excerpt-length-value' id='lk-excerpt-length-field' value='$option_value' />\n";
	echo '<span class="setting-description">The number of words that you want to appear in <a href="http://codex.wordpress.org/Template_Tags/the_excerpt" rel="external">the_excerpt()</a></span>';
}


function lk_excerpt_length( $default_value ) {
	$option_value = get_option( 'lk-excerpt-length-value' );
	return ( '' != $option_value && '0' != $option_value ) ? $option_value : $default_value;
}


function filter_plugin_meta($links, $file) {
	if ( $file == plugin_basename( __FILE__ ) )
		return array_merge( $links, array( sprintf( '<a href="options-reading.php">%s</a>', __('Settings') ) ) );
	return $links;
}

add_action( 'admin_init', 'lk_excerpt_length_init' );
add_filter( 'excerpt_length', 'lk_excerpt_length' );
add_filter( 'plugin_row_meta', 'filter_plugin_meta', 10, 2 );
