<?php
/**
 * Settings tab content page.
 *
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

use ThemeGrill\WoocommerceCustomizer\Icon;
?>
<div class="settings-content-wrapper">

		<div class="settings settings-table">
			<div class="settings-table-wrapper">

				<!-- Custom avatar -->
				<div class="row tgwc-settings-row">
					<div class="col-label tgwc-settings-col-label">
						<p class="setting-label"><?php esc_html_e( 'Account Profile Picture', 'customize-my-account-page' ); ?></p>
						<span class="setting-help"><?php esc_html_e( 'Allow customers to upload a profile picture on their WooCommerce account page.', 'customize-my-account-page' ); ?></span>
					</div>
					<div class="col-input">
						<div class="tgwc-toggle-section">
							<span class="tgwc-toggle-form">
								<input type="checkbox"
							<?php checked( $settings['custom_avatar'] ); ?>
							name="tgwc_settings[custom_avatar]" style="min-width: 350px;" />
								<span class="slider round"></span>
							</span>
						</div>
					</div>
				</div>
				<!-- ./ Custom avatar -->

				<div class="tgwc-settings-developer-section">
					<div class="tgwc-section-header">Developer Options</div>
					<!-- Enable debug -->
					<div class="row tgwc-settings-row">
						<div class="col-label tgwc-settings-col-label">
							<p class="setting-label"><?php esc_html_e( 'Load Unminified Assets', 'customize-my-account-page' ); ?></p>
							<span class="setting-help"><?php esc_html_e( 'Load uncompressed CSS and JS files to help with debugging and development.', 'customize-my-account-page' ); ?></span>
						</div>
						<div class="col-input">
							<div class="tgwc-toggle-section">
								<span class="tgwc-toggle-form">
									<input type="checkbox" value="1"
								<?php checked( $settings['enable_debug'] ); ?>
								name="tgwc_settings[enable_debug]" style="min-width: 350px;" />
									<span class="slider round"></span>
								</span>
							</div>
						</div>
					</div>
					<!-- Account Page Libraries -->
					<div class="row tgwc-settings-row">
						<div class="col-label tgwc-settings-col-label">
							<p class="setting-label"><?php esc_html_e( 'Account Page Libraries', 'customize-my-account-page' ); ?></p>
							<span class="setting-help"><?php esc_html_e( 'Control which CSS and JS libraries are loaded on the WooCommerce account page. Uncheck to test for theme or plugin conflicts.', 'customize-my-account-page' ); ?></span>
						</div>
						<div class="col-input tgwc-settings-developer-col-input">
							<label for="tgwc-frontend-dropzone-css">
								<input type="checkbox" id="tgwc-frontend-dropzone-css" <?php checked( $settings['frontend']['dropzone']['css'] ); ?> name="tgwc_settings[frontend][dropzone][css]" />
								<span style="margin-left: 8px;">
											<?php esc_html_e( 'Dropzone - CSS', 'customize-my-account-page' ); ?>
										</span>
							</label>

							<label for="tgwc-frontend-dropzone-js">
								<input type="checkbox" id="tgwc-frontend-dropzone-js" <?php checked( $settings['frontend']['dropzone']['js'] ); ?> name="tgwc_settings[frontend][dropzone][js]" />
								<span style="margin-left: 8px;">
											<?php esc_html_e( 'Dropzone - JS', 'customize-my-account-page' ); ?>
										</span>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
<?php
