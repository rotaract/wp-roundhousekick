<?php

// SPDX-FileCopyrightText: 2025 Niklas A. Zbick
//
// SPDX-License-Identifier: EUPL-1.2

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/rotaract/wp-roundhousekick
 * @since      1.0.0
 *
 * @package    WP_Roundhousekick
 * @subpackage WP_Roundhousekick/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    WP_Roundhousekick
 * @subpackage WP_Roundhousekick/public
 * @author     Ressort IT-Entwicklung - Rotaract Deutschland <it-entwicklung@rotaract.de>
 */
class WP_Roundhousekick_Public {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wp_roundhousekick    The ID of this plugin.
	 */
	private $wp_roundhousekick;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $wp_roundhousekick       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $wp_roundhousekick, $version ) {
		$this->wp_roundhousekick = $wp_roundhousekick;
		$this->version           = $version;
	}

	/**
	 * Return the Mail From Address for all outgoing emails.
	 *
	 * @return String Mail From Address for all outgoing emails
	 * @since    1.0.0
	 */
	public function set_mail_sender(): string {
		return get_site_option( 'mailer_address', WP_Roundhousekick_Mailer::get_mail_sender() );
	}
}
