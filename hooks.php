<?php

add_action( 'wp_footer', 'revup_footer_scripts' );

function revup_footer_scripts() {
	$options = get_option('revup_options');

	wp_enqueue_script( 'reviews_up_script', 'https://app.getreviewsup.com/api/js', array(), false, true );

	if( ! empty( $options['floating_key'] ) && ! empty( $options['floating_enable'] ) && $options['floating_enable'] == 'on' ) {
		$script_path = revup_get_plugin_path() . 'assets/floating.js';

		wp_enqueue_script( 'revup-floating', $script_path, array( 'reviews_up_script' ), false, true );
		wp_localize_script( 'revup-floating', 'key', array( 'floating' => $options['floating_key'] ) );
	}
}

