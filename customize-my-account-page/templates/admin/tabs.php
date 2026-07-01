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

			// Customizer is a premium-only tab: render it locked with a crown + upgrade popup.
			if ( 'customizer' === $tgwc_tab_slug ) {
				?>
				<div class="tab-wrap tgwc-tab-wrap--locked">
					<span class="tab tgwc-tab--locked" id="customizer_tab" role="link" aria-disabled="true">
						<p><?php echo esc_html( $tgwc_tab_name ); ?></p>
						<?php
						tgwc_pro_feature_badge(
							array(
								'utm_content' => 'customizer-tab',
								'title'       => __( 'Unlock the Visual Customizer', 'customize-my-account-page' ),
								'message'     => '',
								'features'    => array(
									array(
										'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>',
										'title' => __( 'Color palettes', 'customize-my-account-page' ),
										'desc'  => __( 'Pre-built palettes + custom colors for your brand', 'customize-my-account-page' ),
									),
									array(
										'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>',
										'title' => __( 'Layout styles', 'customize-my-account-page' ),
										'desc'  => __( 'Default, Modern, and Classic layout options', 'customize-my-account-page' ),
									),
									array(
										'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
										'title' => __( 'Profile Settings', 'customize-my-account-page' ),
										'desc'  => __( 'Customize Profile Image, Style, and Picture Size Limit', 'customize-my-account-page' ),
									),
									array(
										'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3"/><path d="M21 8V5a2 2 0 0 0-2-2h-3"/><path d="M3 16v3a2 2 0 0 0 2 2h3"/><path d="M16 21h3a2 2 0 0 0 2-2v-3"/></svg>',
										'title' => __( 'Responsive spacing', 'customize-my-account-page' ),
										'desc'  => __( 'Fine-tune padding and spacing per breakpoint', 'customize-my-account-page' ),
									),
								),
							)
						);
						?>
					</span>
				</div>
				<?php
				continue;
			}

			printf(
				'<div class="tab-wrap"><a class="tab%1$s" href="%2$s"  id="%3$s"><p>%4$s</p></a></div>',
				esc_attr( $tgwc_class ),
				'?page=tgwc-customize-my-account&tab=' . esc_attr( $tgwc_tab_slug ),
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
		<?php
		// Premium-only actions: rendered disabled with a crown + upgrade popup.
		// Order: Add endpoint, Add group (locked) then Add link (free).
		$tgwc_locked_adds = array(
			'endpoint' => __( 'Add Endpoint', 'customize-my-account-page' ),
			'group'    => __( 'Add Group', 'customize-my-account-page' ),
		);
		foreach ( $tgwc_locked_adds as $tgwc_lkey => $tgwc_locked_add ) :
			?>
		<div class="tgwc-locked-action">
			<button type="button" class="button tgwc-button--locked" data-type="<?php echo esc_attr( $tgwc_lkey ); ?>" disabled aria-disabled="true">
				<?php Icon::get_svg_icon( 'tgwc-' . $tgwc_lkey, true ); ?>
				<p class="btn-text"><?php echo esc_html( $tgwc_locked_add ); ?></p>
				<span class="tgwc-pro__crown tgwc-locked-action__crown" aria-hidden="true"><?php echo tgwc_get_crown_svg(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			</button>
			<?php
			tgwc_pro_feature_badge(
				array(
					'message'     => __( 'This is a premium feature, please Upgrade to Pro.', 'customize-my-account-page' ),
					'utm_content' => 'action-' . $tgwc_lkey,
					'no_crown'    => true,
				)
			);
			?>
		</div>
		<?php endforeach; ?>

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
