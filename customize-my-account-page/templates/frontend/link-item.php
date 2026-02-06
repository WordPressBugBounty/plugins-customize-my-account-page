<?php
/**
 * Frontend link item.
 *
 * @since 1.0.0
 */


defined( 'ABSPATH' ) || exit;

use ThemeGrill\WoocommerceCustomizer\Icon;

$tgwc_target = $new_tab ? ' target="_blank"' : '';
?>
<li class="<?php echo esc_attr( wc_get_account_menu_item_classes( $slug ) ); ?>">
	<a href="<?php echo esc_url( wc_get_account_endpoint_url( $slug ) ); ?>"
		data-endpoint="<?php echo esc_attr( $slug ); ?>"
		<?php echo esc_attr( $tgwc_target ); ?>>
		<?php echo esc_html( $label ); ?>

		<?php
		if ( 'choose_icon' === $tgwc_choose_icon_type ) {
			$tgwc_icon = str_replace( 'fas fa-', '', $tgwc_icon );
			Icon::get_svg_icon( $tgwc_icon, true );
		} elseif ( ! empty( $custom_icon ) ) {
			if ( wp_attachment_is_image( $custom_icon ) ) {
				echo wp_get_attachment_image( $custom_icon, 'thumbnail' );
			}
		}
		?>
	</a>
</li>
<?php
