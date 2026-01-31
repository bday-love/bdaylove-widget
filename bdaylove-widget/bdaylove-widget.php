<?php
/**
 * Plugin Name: Bdaylove Widget
 * Description: A plugin to display a bdaylove widget.
 * Version: 1.0.0
 * Author: bdaylove
 * License: GPLv2 or later
 */

namespace Bdaylove\Widget;

use Bdaylove\Widget\Settings;

defined( 'ABSPATH' ) || exit;

require_once plugin_dir_path( __FILE__ ) . 'includes/Settings.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/BdayloveWidget.php';

new Settings();
new BdayloveWidget();
