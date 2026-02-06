<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'tgwc_before_account_navigation' );
?>

<nav class="<?php echo esc_attr( $nav_class ); ?>">
	<?php do_action( 'tgwc_before_account_navigation_wrap' ); ?>

	<div class="tgwc-woocommerce-MyAccount-navigation-wrap">
		<?php do_action( 'tgwc_before_account_items_list' ); ?>
		<ul>
			<?php
			$tgwc_items = tgwc_get_account_menu_items();
			$tgwc_endpoints = tgwc_get_endpoints_flat();
			foreach ( $tgwc_items as $tgwc_slug => $tgwc_label ) {
				if ( tgwc_is_default_endpoint( $tgwc_slug ) || tgwc_is_free_version_endpoints( $tgwc_slug ) || 'link' === $tgwc_endpoints[ $tgwc_slug ]['type'] ) {
					do_action( "tgwc_myaccount_menu_item_{$tgwc_slug}", $tgwc_slug );
					do_action( 'tgwc_my_account_menu_item', $tgwc_slug );
				}
			}
			?>
		</ul>
		<?php do_action( 'tgwc_after_account_items_list' ); ?>
	</div>

	<?php do_action( 'tgwc_after_account_navigation_wrap' ); ?>
</nav>
<?php
do_action( 'tgwc_after_account_navigation' );
