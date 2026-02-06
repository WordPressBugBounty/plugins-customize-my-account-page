<?php
/**
 * Frontend group item.
 *
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

use ThemeGrill\WoocommerceCustomizer\Icon;

?>
<li <?php printf( '%s', 'sidebar' === tgwc_get_menu_style() && 'collapsed' === tgwc_get_group_accordion_default_state() ? esc_attr( 'data-collapsed=true' ) : '' ); ?> class="<?php echo esc_attr( wc_get_account_menu_item_classes( $tgwc_slug ) ); ?>">
	<a href="#"
		data-endpoint="<?php echo esc_attr( $tgwc_slug ); ?>"
	>
		<span>
			<?php
			echo esc_html( $label );
			if ( 'choose_icon' === $tgwc_choose_icon_type ) {
				$tgwc_icon = str_replace( 'fas fa-', '', $tgwc_icon );
				Icon::get_svg_icon( $tgwc_icon, true );
			} elseif ( ! empty( $custom_icon ) ) {
				if ( wp_attachment_is_image( $custom_icon ) ) {
					echo wp_get_attachment_image( $custom_icon, 'thumbnail' );
				}
			}
			?>
		</span>
		<?php
		if ( isset( $tgwc_children ) && 'tab' !== tgwc_get_menu_style() ) {
			if ( 'collapsed' === tgwc_get_group_accordion_default_state() ) {
				Icon::get_svg_icon( 'chevron-right', true );
			} else {
				Icon::get_svg_icon( 'chevron-down', true );
			}
		}
		?>
	</a>

<?php if ( isset( $tgwc_children ) ) : ?>
	<ul>
		<?php
		$tgwc_children = tgwc_get_account_menu_items( $tgwc_children );
		foreach ( $tgwc_children as $tgwc_child_slug => $tgwc_child ) {
			do_action( "tgwc_myaccount_menu_item_{$tgwc_child_slug}", $tgwc_child_slug );
			do_action( 'tgwc_my_account_menu_item', $tgwc_child_slug );
		}
		?>
	</ul>
<?php endif; ?>
</li>
<?php
