<?php
/**
 * User avatar template.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use ThemeGrill\WoocommerceCustomizer\Icon;

?>
<div class="tgwc-profile-upload-limit-issue tgwc-hide">
	<?php
	/* translators: %s: Maximum allowed upload size in MB */
	$tgwc_message  = esc_html__( 'Upload failed. Maximum allowed size is %s MB.', 'customize-my-account-page' );
	$tgwc_max_size = intval( tgwc_get_avatar_upload_size_mb() );

	printf( esc_html( $tgwc_message ), esc_html( $tgwc_max_size ) );
	?>
</div>


<div class="tgwc-user-avatar <?php echo esc_html( tgwc_get_avatar_layout() ); ?>">

	<?php do_action( 'tgwc_before_user_image' ); ?>
	<form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
		class="dropzone"
		id="tgwc-file-drop-zone"
		enctype="multipart/form-data">
		<?php wp_nonce_field( 'tgwc_avatar_upload', 'tgwc_avatar_upload_nonce' ); ?>
		<input type="hidden" name="action" value="tgwc_avatar_upload" />
		<div class="tgwc-user-avatar-image-wrap <?php echo esc_html( tgwc_get_avatar_type() ); ?>">
			<?php
				$tgwc_allowed_html = array(
					'img' => array(
						'src'      => array(),
						'alt'      => array(),
						'class'    => array(),
						'width'    => array(),
						'height'   => array(),
						'srcset'   => array(),
						'sizes'    => array(),
						'decoding' => array(),
					),
				);

				$tgwc_avatar = get_avatar( get_current_user_id() );

				echo wp_kses( $tgwc_avatar, $tgwc_allowed_html );
				?>
			<?php if ( apply_filters( 'tgwc_hide_upload_avatar_button', true, $args ) ) { ?>
			<a class="tgwc-user-avatar-upload-icon">
				<?php Icon::get_svg_icon( 'camera', true ); ?>
			</a>

			<div class="tgwc-remove-image<?php echo esc_attr( $is_avatar_set ? '' : ' tgwc-display-none' ); ?>">
				<?php Icon::get_svg_icon( 'times-circle', true ); ?>
			</div>
			<div class="tgwc-progress tgwc-display-none">
				<?php Icon::get_svg_icon( 'spinner', true ); ?>
			</div>
			<div class="tgwc-error-message tgwc-display-none"></div>
			<?php } ?>
		</div>
	</form>
	<?php do_action( 'tgwc_after_user_image' ); ?>

	<?php do_action( 'tgwc_before_user_info' ); ?>
	<div class="tgwc-user-info">
		<h4 class="tgwc-user-id <?php echo esc_html( tgwc_get_avatar_username() ); ?>"><?php the_author_meta( 'display_name', get_current_user_id() ); ?></h4>
		<?php do_action( 'tgwc_user_info' ); ?>
	</div>
	<?php do_action( 'tgwc_after_user_info' ); ?>
</div>
<?php
