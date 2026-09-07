<?php
/**
 * Nav walker that adds lock icons for password-protected menu items.
 */

if ( ! class_exists( 'Custom_Nav_Walker' ) ) :

class Custom_Nav_Walker extends Walker_Nav_Menu {
	function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = isset( $args->before ) ? $args->before : '';
		$item_output .= '<a' . $attributes .'>';
		$item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . apply_filters( 'the_title', $item->title, $item->ID ) . ( isset( $args->link_after ) ? $args->link_after : '' );

		// Check if this menu item points to a password protected post/page
		$post_id = null;

		// Method 1: Check by object_id (most reliable)
		if ( ! empty( $item->object_id ) ) {
			$is_post_type = ( isset( $item->type ) && $item->type == 'post_type' ) ||
			                ( isset( $item->object ) && in_array( $item->object, array( 'page', 'post' ) ) );

			if ( $is_post_type ) {
				$post_id = $item->object_id;
			}
		}

		// Method 2: Fallback - get post ID from URL if object_id not available
		if ( ! $post_id && ! empty( $item->url ) ) {
			$post_id = url_to_postid( $item->url );
		}

		if ( $post_id ) {
			// Get post password directly from database to work for all users
			global $wpdb;
			$post_password = $wpdb->get_var( $wpdb->prepare(
				"SELECT post_password FROM {$wpdb->posts} WHERE ID = %d AND post_status = 'publish'",
				$post_id
			) );

			if ( ! empty( $post_password ) ) {
				// Get the post object to check if password has been entered
				$post = get_post( $post_id );

				if ( $post ) {
					// Check if password has been entered correctly (page is unlocked)
					$is_unlocked = ! post_password_required( $post );

					// Customize icons here - you can use SVG, icon fonts, or emoji
					$locked_icon = apply_filters( 'menu_lock_icon_html', '<span class="dashicons dashicons-lock"></span>', 'locked' );
					$unlocked_icon = apply_filters( 'menu_lock_icon_html', '<span class="dashicons dashicons-unlock"></span>', 'unlocked' );

					if ( $is_unlocked ) {
						// Show unlocked icon if password has been entered
						$item_output .= ' <span class="menu-lock-icon menu-unlock-icon" aria-label="Password Entered">' . $unlocked_icon . '</span>';
					} else {
						// Show locked icon if password hasn't been entered
						$item_output .= ' <span class="menu-lock-icon" aria-label="Password Protected">' . $locked_icon . '</span>';
					}
				}
			}
		}

		$item_output .= '</a>';
		$item_output .= isset( $args->after ) ? $args->after : '';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= "</li>\n";
	}
}

endif;
