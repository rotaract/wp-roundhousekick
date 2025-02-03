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

<input type="email" id="wp_roundhousekick_mailer_address" class="regular-text" name="mailer_address" value="<?php echo esc_attr( $mailer_address ); ?>" required
<?php
if ( defined( 'MAILER_ADDRESS' ) && MAILER_ADDRESS ) :
	?>
disabled<?php endif; ?>>
<p class="description"><?php esc_html_e( 'Set the sender address for all outgoing e-mails here.', 'wp-roundhousekick' ); ?></p>
