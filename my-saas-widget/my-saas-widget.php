<?php
/**
 * Plugin Name: My SaaS Widget
 * Description: A plugin to display a SaaS widget.
 * Version: 1.0.0
 * Author: Your Name
 * License: GPLv2 or later
 */

namespace MySaaS\Widget;

use MySaaS\Widget\Settings;

defined( 'ABSPATH' ) || exit;

require_once plugin_dir_path( __FILE__ ) . 'includes/Settings.php';

new Settings();
