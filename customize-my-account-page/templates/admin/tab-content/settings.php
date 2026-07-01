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

				<!-- Default Endpoint (premium) -->
				<div class="row tgwc-settings-row tgwc-settings-row--locked">
					<div class="col-label tgwc-settings-col-label">
						<p class="setting-label">
							<span class="tgwc-label-text"><?php esc_html_e( 'Default Endpoint', 'customize-my-account-page' ); ?></span>
							<?php tgwc_pro_feature_badge( array( 'utm_content' => 'default-endpoint' ) ); ?>
						</p>
						<span class="setting-help"><?php esc_html_e( 'Choose which endpoint loads first when a customer opens their account page.', 'customize-my-account-page' ); ?></span>
					</div>
					<div class="col-input">
						<select class="tgwc-locked-control" disabled aria-disabled="true">
							<option><?php esc_html_e( 'Dashboard', 'customize-my-account-page' ); ?></option>
						</select>
					</div>
				</div>
				<!-- ./ Default Endpoint -->

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

				<!-- AJAX Navigation (premium) -->
				<div class="row tgwc-settings-row tgwc-settings-row--locked">
					<div class="col-label tgwc-settings-col-label">
						<p class="setting-label">
							<span class="tgwc-label-text"><?php esc_html_e( 'AJAX Navigation', 'customize-my-account-page' ); ?></span>
							<?php tgwc_pro_feature_badge( array( 'utm_content' => 'ajax-navigation' ) ); ?>
						</p>
						<span class="setting-help"><?php esc_html_e( 'Load account page sections without a full page reload for a smoother experience.', 'customize-my-account-page' ); ?></span>
					</div>
					<div class="col-input">
						<div class="tgwc-toggle-section tgwc-locked-control">
							<span class="tgwc-toggle-form">
								<input type="checkbox" disabled aria-disabled="true" style="min-width: 350px;" />
								<span class="slider round"></span>
							</span>
						</div>
					</div>
				</div>
				<!-- ./ AJAX Navigation -->

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
