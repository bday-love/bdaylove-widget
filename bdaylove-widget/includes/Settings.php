<?php

namespace Bdaylove\Widget;

defined( 'ABSPATH' ) || exit;

class Settings {

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
	}

	/**
	 * Add the settings page to the admin menu.
	 */
	public function add_admin_menu() {
		add_options_page(
			__( 'Ustawienia Widgetu Bdaylove', 'bdaylove-widget' ),
			__( 'Widget Bdaylove', 'bdaylove-widget' ),
			'manage_options',
			'bdaylove-widget',
			[ $this, 'render_settings_page' ]
		);
	}

	/**
	 * Register the settings, sections, and fields.
	 */
	public function register_settings() {
		// Widget ID
		register_setting(
			'bdaylove_widget_options',
			'bdaylove_widget_id',
			[
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		// Script URL
		register_setting(
			'bdaylove_widget_options',
			'bdaylove_script_url',
			[
				'sanitize_callback' => 'esc_url_raw',
				'default'           => 'https://www.bday.love/embed.js',
			]
		);

		add_settings_section(
			'bdaylove_widget_general_section',
			__( 'Ustawienia Główne', 'bdaylove-widget' ),
			null,
			'bdaylove-widget'
		);

		add_settings_field(
			'bdaylove_widget_id',
			__( 'Domyślny Identyfikator Widgetu', 'bdaylove-widget' ),
			[ $this, 'render_widget_id_field' ],
			'bdaylove-widget',
			'bdaylove_widget_general_section'
		);

		add_settings_field(
			'bdaylove_script_url',
			__( 'Adres skryptu (URL)', 'bdaylove-widget' ),
			[ $this, 'render_script_url_field' ],
			'bdaylove-widget',
			'bdaylove_widget_general_section'
		);
	}

	/**
	 * Render the settings page.
	 */
	public function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<style>
			.bday-wrap {
				max-width: 800px;
				margin: 40px auto;
				font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
			}
			.bday-card {
				background: #fff;
				border-radius: 8px;
				box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
				overflow: hidden;
				border: 1px solid #e2e4e7;
			}
			.bday-header {
				padding: 20px 30px;
				background: #fff;
				border-bottom: 1px solid #f0f0f1;
				display: flex;
				align-items: center;
				gap: 15px;
			}
			.bday-logo {
				width: 32px;
				height: 32px;
				fill: #d63638; /* WordPress-ish red or branding color */
			}
			.bday-title {
				font-size: 20px;
				font-weight: 600;
				margin: 0;
				color: #1d2327;
			}
			.bday-body {
				padding: 30px;
			}
			.bday-info {
				background: #f0f6fc;
				border-left: 4px solid #72aee6;
				padding: 15px 20px;
				margin-bottom: 25px;
				border-radius: 0 4px 4px 0;
				color: #1d2327;
			}
			.bday-footer {
				background: #f9f9f9;
				padding: 15px;
				text-align: center;
				font-size: 13px;
				color: #646970;
				border-top: 1px solid #f0f0f1;
			}
			.bday-footer span {
				color: #d63638;
			}
			/* Overrides for WordPress default form styles inside the card */
			.bday-body h2 {
				margin-top: 0;
				padding-bottom: 10px;
				border-bottom: 1px solid #f0f0f1;
				font-size: 1.2em;
			}
			.form-table th {
				font-weight: 500;
			}
			.submit {
				margin-top: 20px;
				padding: 0;
			}
		</style>

		<div class="wrap bday-wrap">
			<div class="bday-card">
				<div class="bday-header">
					<!-- Simple heart icon SVG placeholder -->
					<svg class="bday-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
					<h1 class="bday-title"><?php echo esc_html( get_admin_page_title() ); ?></h1>
				</div>

				<div class="bday-body">
					<div class="bday-info">
						<p style="margin: 0;">
							<?php esc_html_e( 'Witaj w ustawieniach widgetu Bday Love. Tutaj możesz skonfigurować domyślne zachowanie widgetu dla całej witryny.', 'bdaylove-widget' ); ?>
						</p>
					</div>

					<form action="options.php" method="post">
						<?php
						settings_fields( 'bdaylove_widget_options' );
						do_settings_sections( 'bdaylove-widget' );
						submit_button();
						?>
					</form>
				</div>

				<div class="bday-footer">
					Created with <span>&hearts;</span> by bdaylove
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render the 'bdaylove_widget_id' field.
	 */
	public function render_widget_id_field() {
		$value = get_option( 'bdaylove_widget_id' );
		?>
		<input
			type="text"
			name="bdaylove_widget_id"
			value="<?php echo esc_attr( $value ); ?>"
			class="regular-text"
		>
		<p class="description"><?php esc_html_e( 'Wpisz tutaj swój identyfikator widgetu Bday Love.', 'bdaylove-widget' ); ?></p>
		<?php
	}

	/**
	 * Render the 'bdaylove_script_url' field.
	 */
	public function render_script_url_field() {
		$value = get_option( 'bdaylove_script_url', 'https://www.bday.love/embed.js' );
		?>
		<input
			type="url"
			name="bdaylove_script_url"
			value="<?php echo esc_attr( $value ); ?>"
			class="regular-text"
		>
		<p class="description"><?php esc_html_e( 'Adres URL zewnętrznego skryptu. Zmień na localhost do celów deweloperskich.', 'bdaylove-widget' ); ?></p>
		<?php
	}
}
