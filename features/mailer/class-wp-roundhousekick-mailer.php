<?php

// SPDX-FileCopyrightText: 2025 Niklas A. Zbick
//
// SPDX-License-Identifier: EUPL-1.2

/**
 * The mailer-feature-specific functionality of the plugin.
 *
 * @link       https://github.com/rotaract/wp-roundhousekick
 * @since      1.1.0
 *
 * @package    WP_Roundhousekick
 * @subpackage WP_Roundhousekick/features/mailer
 * @author     Ressort IT-Entwicklung - Rotaract Deutschland <it-entwicklung@rotaract.de>
 */
class WP_Roundhousekick_Mailer {
	/**
	 * Adds setting menu and submenu page for this plugin.
	 */
	public static function network_settings_page(): void {
		if ( empty( $GLOBALS['network_admin_page_hooks']['rotaract'] ) ) {

			add_submenu_page(
				'rotaract',
				__( 'Mail Settings', 'wp-roundhousekick' ),
				__( 'Mail Settings', 'wp-roundhousekick' ),
				'manage_network_options',
				'wp_roundhousekick_mailer',
				array( __CLASS__, 'page_output' ),
			);

		}
	}

	/**
	 * Adds setting fields for this plugin.
	 *
	 * @since 1.1.0
	 */
	public static function register_network_settings(): void {

		if ( ! get_site_option( 'mailer_address' ) ) {
			add_site_option( 'mailer_address', self::get_mail_sender() );
		}
		// Register our settings.
		add_settings_section(
			'wp_roundhousekick_mailer',
			__( 'Email Address', 'wp-roundhousekick' ),
			'',
			'wp_roundhousekick_mailer'
		);

		register_setting(
			'wp_roundhousekick',
			'mailer_address',
			array(
				'type'              => 'string',
				'default'           => self::get_mail_sender(),
				'sanitize_callback' => 'sanitize_email',
			)
		);

		add_settings_field(
			'wp_roundhousekick_mailer_address',
			__( 'Address', 'wp-roundhousekick' ),
			array( __CLASS__, 'mailer_address_field' ),
			'wp_roundhousekick_mailer',
			'wp_roundhousekick_mailer',
			array(
				'label_for' => 'wp_roundhousekick_mailer_address',
			)
		);
	}

	/**
	 * Builds the HTML for the appointments submenu page.
	 */
	public static function page_output(): void {
		// Check user capabilities.
		if ( ! current_user_can( 'manage_network_options' ) ) {
			return;
		}

		// Add error/update messages.

		// Check if the user has submitted the settings.
		// WordPress will add the "settings-updated" $_GET parameter to the URL.
		if ( isset( $_GET['updated'] ) ) { // phpcs:ignore
			// Add settings saved message with the class of "updated".
			add_settings_error( 'rotaract_messages', 'rotaract_message', __( 'Settings Saved', 'wp-roundhousekick' ), 'updated' );
		}

		// Show error/update messages.
		settings_errors( 'rotaract_messages' );

		include 'page-mailer.php';
	}

	/**
	 * Builds the HTML for the appointments submenu page.
	 */
	public static function mailer_address_field(): void {
		$mailer_address = get_site_option( 'mailer_address', self::get_mail_sender() );

		include 'field-mailer-address.php';
	}

	/**
	 * Return the Mailer Address for all outgoing emails.
	 *
	 * @return String Mailer Address for all outgoing emails
	 * @since    1.0.0
	 */
	public static function get_mail_sender(): string {
		if ( defined( 'MAILER_ADDRESS' ) && MAILER_ADDRESS ) {
			return MAILER_ADDRESS;
		}
		return 'noreply@rotaract.de';
	}

	/**
	 * Return the Mailer Address for all outgoing emails.
	 *
	 * @since    1.1.0
	 */
	public static function save_settings(): void {

		if ( isset( $_POST ) && isset( $_POST['mailer_address'] ) ) {
			update_site_option( 'mailer_address', sanitize_text_field( $_POST['mailer_address'] ) );
		}

		wp_safe_redirect(
			add_query_arg(
				array(
					'page'    => 'wp_roundhousekick_mailer',
					'updated' => true,
				),
				network_admin_url( 'admin.php' )
			)
		);
		exit;
	}
}
