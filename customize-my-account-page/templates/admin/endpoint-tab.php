<?php
/**
 * Endpoint vertical tab.
 *
 * @since 1.0.0
 */

use ThemeGrill\WoocommerceCustomizer\Icon;

defined( 'ABSPATH' ) || exit;

$tgwc_children_count = isset( $children ) ? count( $children ) : 0;
?>
<li class="dd-item <?php echo esc_attr( $type ); ?>"
	data-id="<?php echo esc_attr( $slug ); ?>"
	data-type="<?php echo esc_attr( $type ); ?>"
	<?php ( ! $enable ) && print( esc_attr( 'data-disabled' ) ); ?>
/>
<div class="tgwc-sidenav-tab-anchor-wrap">
	<div class="tgwc_dd_custom_handle">
		<svg class="dd-custom-handle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
				<path d="m20 11 .102.005a1 1 0 0 1 0 1.99L20 13H4a1 1 0 1 1 0-2h16Zm0-6 .102.005a1 1 0 0 1 0 1.99L20 7H4a1 1 0 0 1 0-2h16Zm0 12 .102.005a1 1 0 0 1 0 1.99L20 19H4a1 1 0 1 1 0-2h16Z"/>
		</svg>
	</div>
	<div class="tgwc-sidenav-tab-action-wrap">
		<a class="tgwc-sidenav-tab-anchor" href="#<?php echo esc_attr( $slug ); ?>">
			<div class="type-wrap">
				<div class="<?php echo esc_attr( $type ); ?>" >
					<?php Icon::get_svg_icon( 'tgwc-' . $type, true ); ?>
					<span class="label"><?php echo esc_html( $label ); ?></span>
				</div>
			</div>
		</a>
		<div class="actions-wrap">
			<div class="tgwc-toggle-section">
			<span class="tgwc-toggle-form">
				<input type="checkbox"
			<?php checked( $enable ); ?>
			name="tgwc_endpoints[<?php echo esc_attr( $slug ); ?>][enable]" style="min-width: 350px;" />
				<span class="slider round"></span>
			</span>
			</div>
			<?php if ( tgwc_is_free_version_endpoints( $slug ) ) { ?>
				<input type="hidden"
					name="tgwc_endpoints[<?php echo esc_attr( $slug ); ?>][is_free]"
					value="1" />
					<span data-toggle="tgwc-tooltip"
								title="<?php esc_attr_e( 'This is a free version endpoint and cannot be deleted.', 'customize-my-account-page' ); ?>">
								<?php Icon::get_svg_icon( 'tgwc-delete', true ); ?>
				</span>
			<?php } elseif ( ! tgwc_is_default_endpoint( $slug ) ) { ?>
				<button type="button" class="tgwc-button tgwc-button--small tgwc-delete-endpoints" data-slug="<?php echo esc_attr( $slug ); ?>" >
					<?php Icon::get_svg_icon( 'tgwc-delete', true ); ?>
				</button>
			<?php } else { ?>
				<span data-toggle="tgwc-tooltip"
								title="<?php esc_attr_e( 'This is a default endpoint and cannot be deleted.', 'customize-my-account-page' ); ?>">
								<?php Icon::get_svg_icon( 'tgwc-delete', true ); ?>
				</span>
			<?php } ?>
		</div>
	</div>
</div>
</li>
<?php
