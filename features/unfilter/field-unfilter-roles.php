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
 * @subpackage WP_Roundhousekick/features/unfilter
 */

?>
<fieldset>
<?php foreach ( $roles as $key => $role ) : ?>
<label>
	<input type="checkbox" name="unfilter_roles[<?php echo esc_attr( $key ); ?>]" value="1"
															<?php
															if ( $role['has_cap'] ) {
																echo 'checked';}
															?>
	>
	<?php echo esc_html( translate_user_role( $role['name'] ) ); ?>
</label><br>
<?php endforeach; ?>
</fieldset>
