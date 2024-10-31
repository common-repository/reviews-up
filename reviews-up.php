<?php
/**
	* Plugin Name: Reviews Up
	* Plugin URI : https://getreviewsup.com/
	* Description: Allows Reviews Up accounts to easily activate and embed various reputation widgets accross their Wordpress sites
	* Version: 1.0.10
	* Author: Things Up
	* Text Domain: reviews-up
	*/

function revup_get_plugin_path()
{
	return plugin_dir_url(__FILE__);
}

if ( is_admin() ) {
	function revup_enqueue_admin_styles() {
		wp_enqueue_style('style', revup_get_plugin_path() . "/style.css");
	}

	add_action('admin_enqueue_scripts', 'revup_enqueue_admin_styles');
}
?>
<?php

include_once('hooks.php');
include_once('shortcodes.php');

function revup_display_menu_content()
{
	?>
					<div class="wrap">
						<h1>Reviews Up</h1>

						<div id="icon-options-general" class="icon32"></div>

						<?php
						$active_tab = "settings";

						if (isset($_GET["tab"])) {
							if ($_GET["tab"] == "settings") {
								$active_tab = "settings";
							} else {
								$active_tab = "video";
							}
						}
						?>
						<h2 class="nav-tab-wrapper">
										<a href="?page=reviews-up-admin.php&tab=settings" class="nav-tab <?php if ($active_tab == 'settings') {
											echo 'nav-tab-active';
										} ?>	"><?php _e('API Settings', 'reviews-up'); ?></a>
										<a href="?page=reviews-up-admin.php&tab=video" class="nav-tab <?php if ($active_tab == 'video') {
											echo 'nav-tab-active';
										} ?>"><?php _e('Video', 'reviews-up'); ?></a>
						</h2>

						<?php if (!isset($_GET['tab']) || (isset($_GET['tab']) && $_GET['tab'] == 'settings')): ?>
					<form action="options.php" method="post">
						<?php
						settings_fields('revup_key_data');
						do_settings_sections('reviews-up-admin.php');
						?>

						<hr>

						<p>This plugin requires an active Reviews Up account. Need one <a href="https://app.getreviewsup.com/auth/signup">create new account</a></p>

						<input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save Changes', 'reviews-up'); ?>" />
					</form>

						<?php elseif (isset($_GET['tab']) && $_GET['tab'] == 'video'): ?>
								<div class="video-container">
									<div class="video">
										<iframe src="https://player.vimeo.com/video/658162610?h=e8f86c60c6&color=58B300&title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen>
										</iframe>
									</div><!-- /.video -->

									<h2>For more plugin setup tips please <a href="https://getreviewsup.com/awesome-reviews-wordpress-plugin/">CLICK HERE</a>.</h2>
								</div><!-- /.video-container -->

						<?php endif; ?>
		<?php
}

add_action('admin_menu', 'revup_register_admin_page');
function revup_register_admin_page()
{

	if (function_exists('add_menu_page')) {

		add_menu_page(
			'Reviews Up',
			'Reviews Up',
			'manage_options',
			'reviews-up-admin.php',
			'revup_display_menu_content',
			revup_get_plugin_path() . '/assets/logo.svg'
		);
	}
}

add_action('admin_init', 'revup_register_settings');
function revup_register_settings()
{
	register_setting('revup_key_data', 'revup_options', 'revup_key_validate');
	add_settings_section('revup_api_settings', 'Widgets', 'revup_title_render', 'reviews-up-admin.php');

	add_settings_field('revup_setting_floating_key', 'Floating', 'revup_floating_key', 'reviews-up-admin.php', 'revup_api_settings');
	add_settings_field('revup_setting_slider_key', 'Slider', 'revup_slider_key', 'reviews-up-admin.php', 'revup_api_settings');
	add_settings_field('revup_setting_fullheight', 'Stack', 'revup_fullheight', 'reviews-up-admin.php', 'revup_api_settings');
}

function revup_floating_key()
{
	$options = get_option('revup_options');

	if ($options) {
		$checked = in_array('on', $options) ? 'checked' : '';
	}

	echo "<input class='input__wider' placeholder='Floating Widget Key' id='floating_key' name='revup_options[floating_key]' type='text' value='" . esc_attr($options['floating_key']) . "' />";

	echo "<input id='floating_enable' class='margin' name='revup_options[floating_enable]' type='checkbox' " . $checked . " />";

	echo "<label for='floating_enable'>Display Floating Widget</label>";
}

function revup_slider_key()
{
	$options = get_option('revup_options');

	echo "<input class='input__wider' placeholder='Slider Widget Key' id='slider_key' name='revup_options[slider_key]' type='text' value='" . esc_attr($options['slider_key']) . "' />";

	if (!empty($options['slider_key'])) {
		echo "<h3 class='shortcode margin'>[ru-slider]</h3>";
	}
}

function revup_fullheight()
{
	$options = get_option('revup_options');

	echo "<input class='input__wider' placeholder='Stack Widget Key' id='fullscreen_key' name='revup_options[fullscreen_key]' type='text' value='" . esc_attr($options['fullscreen_key']) . "' />";

	if (!empty($options['fullscreen_key'])) {
		echo "<h3 class='shortcode margin'>[ru-stack]</h3>";
	}
}


function revup_title_render()
{
	echo "<p>To activate please add the widget ID below.</p>";
}

function revup_key_validate($input)
{
	return $input;
}
