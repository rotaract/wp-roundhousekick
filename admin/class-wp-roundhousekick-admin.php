<?php

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
	 * @param      string    $wp_roundhousekick       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wp_roundhousekick, $version ) {

		$this->wp_roundhousekick = $wp_roundhousekick;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP_Roundhousekick_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP_Roundhousekick_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->wp_roundhousekick, plugin_dir_url( __FILE__ ) . 'css/wp-roundhousekick-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP_Roundhousekick_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP_Roundhousekick_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->wp_roundhousekick, plugin_dir_url( __FILE__ ) . 'js/wp-roundhousekick-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Remove KSES if user has unfiltered_html cap.
	 *
	 * @since    1.1.0
	 */
	public function um_kses_init() {
		if ( current_user_can( 'unfiltered_html' ) ) {
			kses_remove_filters();
		}
	}

	/**
	 * If you install this plugin in wp-content/plugins, the following code
	 * will add the cap on plugin activation, and remove it on deactivation.
	 * It will be a per-blog setting (the plugin will need to be activated on
	 * each blog you want the unfiltered_html cap).
	 *
	 * @since    1.1.0
	 */
	public static function um_unfilter_roles() {
		// Makes sure $wp_roles is initialized
		get_role( 'administrator' );

		global $wp_roles;
		// Dont use get_role() wrapper, it doesn't work as a one off.
		// (get_role does not properly return as reference)
		$wp_roles->role_objects['administrator']->add_cap( 'unfiltered_html' );
		$wp_roles->role_objects['editor']->add_cap( 'unfiltered_html' );
	}
	public static function um_refilter_roles() {
		get_role( 'administrator' );
		global $wp_roles;
		// Could use the get_role() wrapper here since this function is never
		// called as a one off.  It is always called to alter the role as
		// stored in the DB.
		$wp_roles->role_objects['administrator']->remove_cap( 'unfiltered_html' );
		$wp_roles->role_objects['editor']->remove_cap( 'unfiltered_html' );
	}

	/**
	 * If you install this plugin in wp-content/mu-plugins, the following code
	 * will add give all admins and all editors on every blog the
	 * unfiltered_html cap.  Deleting this plugin will remove the cap.
	 *
	 * @since    1.1.0
	 */

	public function um_unfilter_roles_one_time() {
		get_role( 'administrator' );

		global $wp_roles, $current_user;

		$use_db = $wp_roles->use_db;
		$wp_roles->use_db = false; // Don't store in db.  Just do a one off mod to the role.
		$this->um_unfilter_roles(); // Add caps for this page load only: - ^^^^^^^
		$wp_roles->use_db = $use_db;

		if ( is_user_logged_in() ) { // Re-prime the current user's caps
			$current_user->for_site();
		}
	}

	/**
	 * Add the unfiltered_html capability back in to WordPress 5.8 multisite.
	 *
	 * @since    1.1.0
	 */
	public function um_unfilter_multisite( $caps, $cap ) {
		$map_caps = array(
			'edit_css',
			'manage_privacy_options',
			'unfiltered_html'
		);
		if ( in_array( $cap, $map_caps ) ) {
			$caps = array( 'unfiltered_html' );
		}
		return $caps;
	}
}
