<?php

// SPDX-FileCopyrightText: 2025 Niklas A. Zbick
//
// SPDX-License-Identifier: EUPL-1.2

/**
 * The unfilter-feature-specific functionality of the plugin.
 *
 * @link       https://github.com/rotaract/wp-roundhousekick
 * @since      1.1.0
 *
 * @package    WP_Roundhousekick
 * @subpackage WP_Roundhousekick/features/unfilter
 * @author     Ressort IT-Entwicklung - Rotaract Deutschland <it-entwicklung@rotaract.de>
 */
class WP_Roundhousekick_Unfilter {
	/**
	 * Adds setting menu and submenu page for this plugin.
	 *
	 * @since 1.1.0
	 */
	public static function network_settings_page(): void {
		if ( empty( $GLOBALS['network_admin_page_hooks']['rotaract'] ) ) {

			add_submenu_page(
				'rotaract',
				'Unfilter',
				'Unfilter',
				'manage_network_options',
				'wp_roundhousekick_unfilter',
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

		add_settings_section(
			'wp_roundhousekick_unfilter',
			__( 'Role' ),
			'',
			'wp_roundhousekick_unfilter'
		);

		register_setting(
			'wp_roundhousekick',
			'unfilter_roles',
			array(
				'type'  => 'array',
				'label' => __( 'Role' ),
			)
		);

		add_settings_field(
			'wp_roundhousekick_unfilter_address',
			__( 'Role' ),
			array( __CLASS__, 'unfilter_roles_field' ),
			'wp_roundhousekick_unfilter',
			'wp_roundhousekick_unfilter',
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

		include 'page-unfilter.php';
	}

	/**
	 * Builds the HTML for the appointments submenu page.
	 */
	public static function unfilter_roles_field(): void {
		$wp_roles = wp_roles();

		$roles = array_map(
			function ( $role ) use ( $wp_roles ) {
				return array(
					'name'    => $wp_roles->roles[ $role->name ]['name'],
					'has_cap' => $role->has_cap( 'unfiltered_html' ),
				);
			},
			$wp_roles->role_objects
		);

		include 'field-unfilter-roles.php';
	}

	/**
	 * Return the Unfilter Address for all outgoing emails.
	 *
	 * @since    1.1.0
	 */
	public static function save_settings(): void {

		$roles = array();
		if ( isset( $_POST['unfilter_roles'] ) ) {
			$roles = array_keys( $_POST['unfilter_roles'] );
		}
		self::set_unfilter_roles( ...$roles );

		wp_safe_redirect(
			add_query_arg(
				array(
					'page'    => 'wp_roundhousekick_unfilter',
					'updated' => true,
				),
				network_admin_url( 'admin.php' )
			)
		);
		exit;
	}

	/**
	 * Remove KSES if user has unfiltered_html cap.
	 *
	 * @since    1.1.0
	 */
	public static function um_kses_init(): void {
		if ( current_user_can( 'unfiltered_html' ) ) {
			kses_remove_filters();
		}
	}

	/**
	 * Set 'unfiltered_html' capability for given roles.
	 *
	 * @since    1.1.0
	 * @param string ...$roles Roles to set 'unfiltered_html' cap for.
	 */
	public static function set_unfilter_roles( string ...$roles ): void {
		$wp_roles = wp_roles()->role_objects;

		foreach ( $wp_roles as $key => $role ) {
			if ( in_array( $key, $roles, true ) ) {
				$role->add_cap( 'unfiltered_html' );
			} else {
				$role->remove_cap( 'unfiltered_html' );
			}
		}
	}
}
