<?php
/**
 * Admin settings page.
 *
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div id="tgwc-customization" class="wrap">
	<?php
		/**
		 * My account customization page header.
		 */
		do_action( 'tgwc_customization_panel_tabs' );
	?>

	<?php
		/**
		 * Customization form before.
		 */
		do_action( 'tgwc_before_customization_panel_form' );
	?>
	<form method="post" action="options.php" id="tgwc-customization-form">
		<input type="hidden" name="tgwc_page" value="<?php echo esc_attr( 'debug' !== $selected_tab ? 'settings' : $selected_tab ); ?>" />

		<?php
		/**
		 * Nonces, actions and referrers.
		 */
		settings_fields( 'tgwc' );

		/**
		 * Added custom nonce.
		 *
		 * @since 1.0.0
		 */
		wp_nonce_field( 'tgwc_custom_options', '_tgwc_custom_nonce', false );

		/**
		 * My account customization tab content.
		 */
		do_action( 'tgwc_customization_panel_tab_content' );
		?>

		<div class="form-btn-wrapper">
			<button type="submit" name="submit" id="tgwc-submit"
				class="button">
				<?php esc_html_e( 'Save Changes', 'customize-my-account-page' ); ?>
			</button>
		</div>
	</form>
	<?php
		/**
		 * Customization form before.
		 */
		do_action( 'tgwc_after_customization_panel_form' );
	?>
</div>
<?php
