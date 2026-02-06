<?php
/**
 * Frontend custom item.
 *
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$tgwc_class = is_array( $tgwc_class ) ? implode( ' ', $tgwc_class ) : $tgwc_class;
?>
<li class="<?php echo esc_attr( wc_get_account_menu_item_classes( $tgwc_slug ) . ' ' . $tgwc_class ); ?>">
	<a href="<?php echo esc_url( $url ); ?>" data-endpoint="<?php echo esc_attr( $tgwc_slug ); ?>">
		<?php echo esc_html( $label ); ?>
	</a>
</li>
