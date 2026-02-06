<?php
/**
 * Restore defaults modal dialog.
 *
 * @since 1.0.0
 */

use ThemeGrill\WoocommerceCustomizer\Icon;

defined( 'ABSPATH' ) || exit;
?>

<div id="tgwc-dialog-restore-defaults" style="display: none;" title="<?php esc_html_e( 'Confirm Restore', 'customize-my-account-page' ); ?>">
	<div class="tgwc-dialog-content">
		<p>
			<?php esc_html_e( 'Restoring will reset the selected options and cannot be undone. Are you sure?', 'customize-my-account-page' ); ?>
		</p>
		<form>
			<div>
				<input type="checkbox" id="tgwc-restore-defaults-settings" />
				<label for="tgwc-restore-defaults-settings">
					<?php esc_html_e( 'Settings', 'customize-my-account-page' ); ?>
				</label>
			</div>
			<div>
				<input type="checkbox" id="tgwc-restore-defaults-customization" />
				<label for="tgwc-restore-defaults-customization">
					<?php esc_html_e( 'Design Customization', 'customize-my-account-page' ); ?>
				</label>
			</div>
		</form>
	</div>
	<div class="tgwc-dialog-notice"></div>
</div>
