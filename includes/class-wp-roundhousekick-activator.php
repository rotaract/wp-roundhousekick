<?php

// SPDX-FileCopyrightText: 2025 Niklas A. Zbick
//
// SPDX-License-Identifier: EUPL-1.2

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/rotaract/wp-roundhousekick
 * @since      1.0.0
 *
 * @package    WP_Roundhousekick
 * @subpackage WP_Roundhousekick/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WP_Roundhousekick
 * @subpackage WP_Roundhousekick/includes
 * @author     Ressort IT-Entwicklung - Rotaract Deutschland <it-entwicklung@rotaract.de>
 */
class WP_Roundhousekick_Activator {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate(): void {
		require_once plugin_dir_path( __DIR__ ) . 'features/unfilter/class-wp-roundhousekick-unfilter.php';

		WP_Roundhousekick_Unfilter::set_unfilter_roles( 'administrator', 'editor' );
	}
}
