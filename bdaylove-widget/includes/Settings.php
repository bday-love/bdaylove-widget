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
			'Bdaylove Widget Settings',
			'Bdaylove Widget',
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
			'General Settings',
			null,
			'bdaylove-widget'
		);

		add_settings_field(
			'bdaylove_widget_id',
			'Default Widget ID',
			[ $this, 'render_widget_id_field' ],
			'bdaylove-widget',
			'bdaylove_widget_general_section'
		);

		add_settings_field(
			'bdaylove_script_url',
			'Script URL',
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
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'bdaylove_widget_options' );
				do_settings_sections( 'bdaylove-widget' );
				submit_button();
				?>
			</form>
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
		<p class="description">Enter your Bday Love Widget ID here.</p>
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
		<p class="description">The URL of the external script. Change to localhost for development.</p>
		<?php
	}
}
