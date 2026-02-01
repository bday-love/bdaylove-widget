<?php
/**
 * Plugin Name: Bdaylove Widget
 * Description: A plugin to display a bdaylove widget.
 * Version: 1.0.0
 * Author: bdaylove
 * License: GPLv2 or later
 */

namespace Bdaylove\Widget;

defined( 'ABSPATH' ) || exit;

require_once plugin_dir_path( __FILE__ ) . 'includes/Settings.php';

new Settings();

/**
 * Register the block.
 */
function register_block() {
	register_block_type( __DIR__ . '/build', [
		'render_callback' => __NAMESPACE__ . '\render_bday_widget',
	] );
}
add_action( 'init', __NAMESPACE__ . '\register_block' );

/**
 * Render the Bday Love widget.
 *
 * @param array $attributes The block attributes.
 * @return string The rendered HTML.
 */
function render_bday_widget( $attributes ) {
	$widget_id = ! empty( $attributes['widgetId'] ) ? $attributes['widgetId'] : '';
	if ( empty( $widget_id ) ) {
		$widget_id = get_option( 'bdaylove_widget_id' );
	}

	$widget_mode = ! empty( $attributes['widgetMode'] ) ? $attributes['widgetMode'] : 'inline';

	$script_url = get_option( 'bdaylove_script_url', 'https://www.bday.love/embed.js' );

	if ( ! is_admin() ) {
		wp_enqueue_script( 'bdaylove-embed', $script_url, [], null, true );
	}

	return sprintf(
		'<div class="bday-widget-container" data-widget-id="%s" data-mode="%s"></div>',
		esc_attr( $widget_id ),
		esc_attr( $widget_mode )
	);
}

/**
 * Handle the shortcode.
 *
 * @param array $atts The shortcode attributes.
 * @return string The widget HTML.
 */
function shortcode_handler( $atts ) {
	$atts = shortcode_atts(
		[
			'id'   => '',
			'mode' => 'inline',
		],
		$atts,
		'bday-love'
	);

	// Map shortcode attributes to block attributes
	$attributes = [
		'widgetId'   => $atts['id'],
		'widgetMode' => $atts['mode'],
	];

	return render_bday_widget( $attributes );
}
add_shortcode( 'bday-love', __NAMESPACE__ . '\shortcode_handler' );
add_shortcode( 'bday-love-widget', __NAMESPACE__ . '\shortcode_handler' );
