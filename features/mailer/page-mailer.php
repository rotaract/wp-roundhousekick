<?php

// SPDX-FileCopyrightText: 2025 Niklas A. Zbick
//
// SPDX-License-Identifier: EUPL-1.2

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/rotaract/wp-roundhousekick
 * @since      1.1.0
 *
 * @package    WP_Roundhousekick
 * @subpackage WP_Roundhousekick/features/mailer
 */

?>

<div class="wrap">
	<h1><?php esc_html_e( 'Email Settings', 'wp-roundhousekick' ); ?></h1>
	<form method="post" action="<?php echo add_query_arg( 'action', 'mailer', 'edit.php' ); ?>">
		<?php
			settings_fields( 'wp_roundhousekick' );
			do_settings_sections( 'wp_roundhousekick_mailer' );
			submit_button();
		?>
	</form>
</div>
