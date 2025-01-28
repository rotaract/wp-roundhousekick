<?php

// SPDX-FileCopyrightText: 2025 Niklas A. Zbick
//
// SPDX-License-Identifier: EUPL-1.2

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/rotaract/wp-roundhousekick
 * @since      1.0.0
 *
 * @package    WP_Roundhousekick
 * @subpackage WP_Roundhousekick/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Roundhousekick
 * @subpackage WP_Roundhousekick/admin
 * @author     Ressort IT-Entwicklung - Rotaract Deutschland <it-entwicklung@rotaract.de>
 */
class WP_Roundhousekick_Admin {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wp_roundhousekick    The ID of this plugin.
	 */
	private string $wp_roundhousekick;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private string $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $wp_roundhousekick       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $wp_roundhousekick, $version ) {

		$this->wp_roundhousekick = $wp_roundhousekick;
		$this->version           = $version;
	}

	/**
	 * Adds setting fields for this plugin.
	 */
	public function register_network_settings(): void {

		// Register our settings by feature.
		WP_Roundhousekick_Mailer::register_network_settings();
	}

	/**
	 * Adds setting menu and submenu page for this plugin.
	 */
	public function network_settings_page(): void {

		add_menu_page(
			'Rotaract',
			'Rotaract',
			'manage_network_options',
			'rotaract',
			'',
			plugins_url( 'images/wheel.svg', __DIR__ ),
		);

		WP_Roundhousekick_Mailer::network_settings_page();
	}
}
