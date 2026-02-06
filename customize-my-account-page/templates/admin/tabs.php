<?php
/**
 * Customize page tabs list.g
 *
 * @since 1.0.0
 */

use ThemeGrill\WoocommerceCustomizer\Icon;

defined( 'ABSPATH' ) || exit;
?>

<div class="tgwc-header">
	<div class="nav-tab-wrapper">
		<div class="tgwc-brand">
			<?php printf( '<img src="%s" />', esc_url( TGWC()->plugin_url() . '/assets/images/wooCommerce-customize-my-account-logo.png' ) ); ?>
		</div>
		<div class="nav-tabs">
		<?php
		foreach ( $tabs as $tgwc_tab_slug => $tgwc_tab_name ) {
			$tgwc_class = ( $tab_selected === $tgwc_tab_slug ) ? ' tab-active' : '';
			printf(
				'<div class="tab-wrap"><a class="tab%1$s" href="%2$s"  id="%3$s"><p>%4$s</p></a></div>',
				esc_attr( $tgwc_class ),
				'customizer' !== $tgwc_tab_slug ? '?page=tgwc-customize-my-account&tab=' . esc_attr( $tgwc_tab_slug ) : '',
				esc_attr( $tgwc_tab_slug ) . '_tab',
				esc_html( $tgwc_tab_name ),
			);
		}
		?>
		</div>
	</div>
	<?php
	if ( 'endpoints' === $tab_selected ) :
		$tgwc_new_adds = array(
			'link' => __( 'Add link', 'customize-my-account-page' ),
		);
		?>
	<div class="actions tgwc-endpoint-actions">
		<a data-toggle="tgwc-tooltip-down" title="<?php esc_attr_e( 'View My Account', 'customize-my-account-page' ); ?>"
		href="<?php echo esc_url( home_url( 'my-account' ) ); ?>" target="_blank">
			<div id="tgwc_view_my_account">
				<svg xmlns="http://www.w3.org/2000/svg" fill="#000" viewBox="0 0 24 24">
					<path d="M2 18.98V5.02c0-.801.317-1.57.883-2.137A3.022 3.022 0 0 1 5.02 2h5.983l.206.02a1.026 1.026 0 0 1 0 2.01l-.206.02H5.02a.971.971 0 0 0-.97.97v13.96a.971.971 0 0 0 .97.97h13.96a.971.971 0 0 0 .97-.97v-5.983a1.025 1.025 0 1 1 2.05 0v5.983c0 .801-.317 1.57-.883 2.137A3.022 3.022 0 0 1 18.98 22H5.02c-.801 0-1.57-.317-2.137-.883A3.022 3.022 0 0 1 2 18.98Z"/>
					<path d="M20.25 2.3a1.024 1.024 0 1 1 1.45 1.45l-8.975 8.975a1.024 1.024 0 1 1-1.45-1.45L20.25 2.3Z"/>
					<path d="M19.95 9.008V4.05h-4.958a1.025 1.025 0 1 1 0-2.05h5.983C21.541 2 22 2.459 22 3.025v5.983a1.025 1.025 0 1 1-2.05 0Z"/>
				</svg>
			</div>
		</a>
		<?php foreach ( $tgwc_new_adds as $tgwc_key => $tgwc_new_add ) : ?>
		<button type="button" class="button" data-type="<?php echo esc_attr( $tgwc_key ); ?>">
			<?php Icon::get_svg_icon( 'tgwc-' . $tgwc_key, true ); ?>
			<p class="btn-text"><?php echo esc_html( $tgwc_new_add ); ?></p>
		</button>
		<?php endforeach ?>
	</div>
	<?php endif; ?>
</div>
<?php
