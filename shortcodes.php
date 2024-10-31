<?php

add_shortcode('ru-slider', 'revup_slider_shortcode');
function revup_slider_shortcode() {
	ob_start();
	$options = get_option( 'revup_options' );
	$slider_id = $options['slider_key'];

	if( empty( $slider_id ) ) {
		return;
	}

	add_action( 'wp_footer', 'revup_footer_scripts_slider', 30 );
	?>
		<div id="ru-widget-<?php echo esc_html( $slider_id ); ?>"></div>
	<?php
	return ob_get_clean();
}

add_shortcode('ru-stack', 'revup_fullscreen_shortcode');
function revup_fullscreen_shortcode() {
	ob_start();
	$options = get_option( 'revup_options' );
	$fullscreen_id = $options['fullscreen_key'];

	if( empty( $fullscreen_id ) ) {
		return;
	}

	add_action( 'wp_footer', 'revup_footer_scripts_fs', 30 );
	?>
		<div id="ru-widget-<?php echo esc_html( $fullscreen_id ); ?>"></div>
	<?php
	return ob_get_clean();
}

function revup_footer_scripts_fs() {
	$options = get_option('revup_options');

	if( ! empty( $options['fullscreen_key'] ) ) : ?>
		 <script> addRuWidget("<?php echo esc_html( $options['fullscreen_key'] ); ?>"); </script>
		<?php
	endif;
}



function revup_footer_scripts_slider() {
	$options = get_option('revup_options');

	if ( ! empty( $options['slider_key'] ) ) : ?>
		<script> addRuWidget("<?php echo esc_html( $options['slider_key'] ); ?>"); </script>
		<?php
	endif;
}

