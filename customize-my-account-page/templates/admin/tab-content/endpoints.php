<?php
/**
 * Endpoints tab content page.
 *
 * @since 1.0.0
 */

use ThemeGrill\WoocommerceCustomizer\Icon;

defined( 'ABSPATH' ) || exit;
?>

<div id="tgwc-endpoints">
	<div id="tgwc-tabs" class="tgwc-tabs-with-sidenav">
		<div class="dd tgwc-sidenav background-white default-border-8 tgwc-sidenav--collapsed">
			<ul class="dd-list">
			<?php
			foreach ( $endpoints as $tgwc_slug => $tgwc_endpoint ) {
				if ( tgwc_is_default_endpoint( $tgwc_slug ) || tgwc_is_free_version_endpoints( $tgwc_slug ) || 'link' === $tgwc_endpoint['type'] ) {
					$tgwc_endpoint['slug'] = $tgwc_slug;
					wc_get_template(
						'admin/endpoint-tab.php',
						$tgwc_endpoint,
						TGWC_TEMPLATE_PATH,
						TGWC_TEMPLATE_PATH
					);
				}
			}
			?>
			</ul>
			<svg class="tgwc-sidenav-toggle tgwc-sidenav-toggle--collapsed" style="display: none;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 12">
				<path fill-rule="evenodd" d="M.91.41a.833.833 0 0 1 1.18 0l5 5a.833.833 0 0 1 0 1.18l-5 5a.833.833 0 1 1-1.18-1.18L5.323 6 .91 1.59a.833.833 0 0 1 0-1.18Z" clip-rule="evenodd"/>
			</svg>
		</div>
		<div class="tgwc-sidecontent background-white default-border-8">
		<?php
		$tgwc_initial = current( array_keys( $endpoints ) );
		foreach ( $endpoints as $tgwc_slug => $tgwc_endpoint ) {
			if ( tgwc_is_default_endpoint( $tgwc_slug ) || tgwc_is_free_version_endpoints( $tgwc_slug ) || 'link' === $tgwc_endpoint['type'] ) {
				do_action( "tgwc_endpoints_content_{$tgwc_endpoint['type']}", $tgwc_slug, $tgwc_endpoint, $tgwc_initial );
				do_action( 'tgwc_endpoints_content', $tgwc_slug, $tgwc_endpoint, $tgwc_initial );
			}
		}
		?>
		</div>
	</div>
</div>
<div id="tgwc-active-endpoint"><input name="tgwc_active_endpoint" type="hidden" value=""/></div>
<div id="tgwc-dialog-delete" style="display: none;"
	title="<?php esc_html_e( 'Confirm Delete', 'customize-my-account-page' ); ?>">
	<div class="tgwc-dialog-content">
		<p>
		<?php esc_html_e( 'It will be permanently deleted and cannot be recovered. Are you sure?', 'customize-my-account-page' ); ?>
		</p>
	</div>
</div>
<div id="tgwc-dialog-save-changes" style="display: none;"
	title="<?php esc_html_e( 'Do you want to continue?', 'customize-my-account-page' ); ?>">
	<div class="tgwc-dialog-content">
		<p>
			<?php esc_html_e( 'Unsaved changes will be permanently lost. Discard anyway', 'customize-my-account-page' ); ?>
		</p>
	</div>
</div>
<?php
