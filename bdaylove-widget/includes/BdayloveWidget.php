<?php

namespace Bdaylove\Widget;

defined( 'ABSPATH' ) || exit;

class BdayloveWidget {

	/**
	 * Initialize the class.
	 */
	public function __construct() {
		add_shortcode( 'bday-love-widget', [ $this, 'handle_shortcode' ] );
	}

	/**
	 * Render the widget HTML.
	 *
	 * @param string $id The widget ID.
	 * @return string The rendered HTML.
	 */
	public function render_widget( $id ) {
		$safe_id = esc_attr( $id );
		$html    = sprintf(
			'<div id="bday-love-widget-%1$s" class="bday-widget-container" data-widget-id="%1$s"></div>',
			$safe_id
		);
		$html   .= '<script src="https://www.bday.love/embed.js"></script>';

		return $html;
	}

	/**
	 * Handle the shortcode.
	 *
	 * @param array $atts The shortcode attributes.
	 * @return string The widget HTML.
	 */
	public function handle_shortcode( $atts ) {
		$atts = shortcode_atts(
			[
				'id' => '',
			],
			$atts,
			'bday-love-widget'
		);

		$id = $atts['id'];

		if ( empty( $id ) ) {
			$id = get_option( 'default_widget_id' );
		}

		if ( ! empty( $id ) ) {
			return $this->render_widget( $id );
		}

		return '';
	}
}
