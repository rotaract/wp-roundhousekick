<?php

// SPDX-FileCopyrightText: 2025 Niklas A. Zbick
//
// SPDX-License-Identifier: EUPL-1.2

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/rotaract/wp-roundhousekick
 * @since             1.0.0
 * @package           WP_Roundhousekick
 *
 * @wordpress-plugin
 * Plugin Name:       Rotaract WordPress Roundhousekick
 * Plugin URI:        https://github.com/rotaract/wp-roundhousekick
 * Description:       A WordPress Multisite Plugin for managing everything about Rotaract Germany Website Hosting.
 * Version:           1.1.0
 * Author:            Ressort IT-Entwicklung - Rotaract Deutschland
 * Author URI:        https://rotaract.de
 * License:           EUPL-1.2
 * License URI:       https://eupl.eu
 * Text Domain:       wp-roundhousekick
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_ROUNDHOUSEKICK_VERSION', '1.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-roundhousekick-activator.php
 */
function activate_wp_roundhousekick() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-roundhousekick-activator.php';
	WP_Roundhousekick_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-roundhousekick-deactivator.php
 */
function deactivate_wp_roundhousekick() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-roundhousekick-deactivator.php';
	WP_Roundhousekick_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_roundhousekick' );
register_deactivation_hook( __FILE__, 'deactivate_wp_roundhousekick' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-roundhousekick.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_roundhousekick() {
	$plugin = new WP_Roundhousekick();
	$plugin->run();
}
run_wp_roundhousekick();
