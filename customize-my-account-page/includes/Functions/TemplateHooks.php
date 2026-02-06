<?php
/**
 * Template hooks.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// My Account.
if ( ! function_exists( 'add_action' ) ) {
	return;
}
add_action( 'woocommerce_account_navigation', 'tgwc_account_navigation', 10, 3 );
add_action( 'woocommerce_account_content', 'tgwc_account_content' );
add_action( 'tgwc_my_account_menu_item', 'tgwc_display_myaccount_menu_item', 10 );
add_action( 'tgwc_before_account_navigation_wrap', 'tgwc_user_avatar' );
add_filter( 'get_avatar', 'tgwc_replace_gravatar_image', PHP_INT_MAX - 1, 6 );
