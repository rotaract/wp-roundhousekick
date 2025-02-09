<?php

// SPDX-FileCopyrightText: 2025 Niklas A. Zbick
//
// SPDX-License-Identifier: EUPL-1.2

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/rotaract/wp-roundhousekick
 * @since      1.0.0
 *
 * @package    WP_Roundhousekick
 * @subpackage WP_Roundhousekick/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WP_Roundhousekick
 * @subpackage WP_Roundhousekick/includes
 * @author     Ressort IT-Entwicklung - Rotaract Deutschland <it-entwicklung@rotaract.de>
 */
class WP_Roundhousekick {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WP_Roundhousekick_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected WP_Roundhousekick_Loader $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $wp_roundhousekick    The string used to uniquely identify this plugin.
	 */
	protected string $wp_roundhousekick;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected string $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WP_ROUNDHOUSEKICK_VERSION' ) ) {
			$this->version = WP_ROUNDHOUSEKICK_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->wp_roundhousekick = 'wp-roundhousekick';

		$this->load_dependencies();
		$this->load_features();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WP_Roundhousekick_Loader. Orchestrates the hooks of the plugin.
	 * - WP_Roundhousekick_I18n. Defines internationalization functionality.
	 * - WP_Roundhousekick_Admin. Defines all hooks for the admin area.
	 * - WP_Roundhousekick_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies(): void {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-wp-roundhousekick-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-wp-roundhousekick-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-wp-roundhousekick-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'public/class-wp-roundhousekick-public.php';

		$this->loader = new WP_Roundhousekick_Loader();
	}

	/**
	 * Load the required feature dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin's admin area features:
	 *
	 * - WP_Roundhousekick_Loader. Orchestrates the hooks of the plugin.
	 * - WP_Roundhousekick_I18n. Defines internationalization functionality.
	 * - WP_Roundhousekick_Admin. Defines all hooks for the admin area.
	 * - WP_Roundhousekick_Public. Defines all hooks for the public side of the site.
	 *
	 * @since    1.1.0
	 * @access   private
	 */
	private function load_features(): void {
		/**
		 * The class responsible for Mailer feature.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'features/mailer/class-wp-roundhousekick-mailer.php';
		/**
		 * The class responsible for Unfiltered MU feature.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'features/unfilter/class-wp-roundhousekick-unfilter.php';
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WP_Roundhousekick_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale(): void {
		$plugin_i18n = new WP_Roundhousekick_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks(): void {
		$plugin_admin = new WP_Roundhousekick_Admin( $this->get_wp_roundhousekick(), $this->get_version() );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'action_register_network_settings' );
		$this->loader->add_action( 'network_admin_menu', $plugin_admin, 'action_network_settings_page' );

		/*
		 * Feature: Mailer
		 */
		$this->loader->add_action( 'network_admin_edit_mailer', $plugin_admin, 'action_network_admin_edit_mailer' );

		/*
		 * Feature: Unfilter
		 */
		$this->loader->add_action( 'network_admin_edit_unfilter', $plugin_admin, 'action_network_admin_edit_unfilter' );
		$this->loader->add_action( 'init', $plugin_admin, 'action_init', 11 );
		$this->loader->add_action( 'set_current_user', $plugin_admin, 'action_set_current_user', 11 );
	}

	/**
	 * Register all the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks(): void {
		$plugin_public = new WP_Roundhousekick_Public( $this->get_wp_roundhousekick(), $this->get_version() );

		$this->loader->add_filter( 'wp_mail_from', $plugin_public, 'set_mail_sender' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run(): void {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_wp_roundhousekick(): string {
		return $this->wp_roundhousekick;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WP_Roundhousekick_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader(): WP_Roundhousekick_Loader {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version(): string {
		return $this->version;
	}
}
