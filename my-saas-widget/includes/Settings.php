<?php

namespace MySaaS\Widget;

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
			'My SaaS Widget Settings',
			'My SaaS Widget',
			'manage_options',
			'my-saas-widget',
			[ $this, 'render_settings_page' ]
		);
	}

	/**
	 * Register the settings, sections, and fields.
	 */
	public function register_settings() {
		register_setting(
			'my_saas_widget_options',
			'default_widget_id',
			[
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		add_settings_section(
			'my_saas_widget_general_section',
			'General Settings',
			null,
			'my-saas-widget'
		);

		add_settings_field(
			'default_widget_id',
			'Default Widget ID',
			[ $this, 'render_default_widget_id_field' ],
			'my-saas-widget',
			'my_saas_widget_general_section'
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
				settings_fields( 'my_saas_widget_options' );
				do_settings_sections( 'my-saas-widget' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Render the 'default_widget_id' field.
	 */
	public function render_default_widget_id_field() {
		$default_widget_id = get_option( 'default_widget_id' );
		?>
		<input
			type="text"
			name="default_widget_id"
			value="<?php echo esc_attr( $default_widget_id ); ?>"
			class="regular-text"
		>
		<?php
	}
}
