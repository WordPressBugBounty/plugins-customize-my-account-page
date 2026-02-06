<?php
/**
 * Settings page.
 *
 * @package ThemeGrill\WoocommerceCustomizer
 * @since 1.0.0
 */

namespace ThemeGrill\WoocommerceCustomizer;

defined( 'ABSPATH' ) || exit;

class Ajax {

	/**
	 * Ajax actions.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	private $actions;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Initialization.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function init() {
		$this->actions = apply_filters(
			'tgwc_ajax_actions',
			array(
				'tgwc_icon_list'           => array(
					'priv'   => array( $this, 'get_icon_list' ),
					'nopriv' => array( $this, 'get_icon_list' ),
				),
				'tgwc_avatar_upload'       => array(
					'priv'   => array( $this, 'handle_avatar_upload' ),
					'nopriv' => array( $this, 'handle_avatar_upload' ),
				),
				'tgwc_avatar_remove'       => array(
					'priv'   => array( $this, 'handle_avatar_remove' ),
					'nopriv' => array( $this, 'handle_avatar_remove' ),
				),
				'tgwc_handle_dropped_icon' => array(
					'priv' => array( $this, 'tgwc_handle_dropped_icon' ),
				),
			)
		);

		$this->init_hooks();

		do_action( 'tgwc_ajax_unhook', $this );
	}

	/**
	 * Initialization hooks.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function init_hooks() {
		foreach ( $this->actions as $action => $callbacks ) {
			if ( isset( $callbacks['priv'] ) ) {
				add_action( "wp_ajax_{$action}", $callbacks['priv'] );
			}
			if ( isset( $callbacks['nopriv'] ) ) {
				add_action( "wp_ajax_nopriv_{$action}", $callbacks['nopriv'] );
			}
		}
	}

	/**
	 * Return icon list.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function get_icon_list() {
		wp_send_json( tgwc_get_icon_list(), 200 );
		die;
	}

	/**
	 * Handle upload avatar.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function handle_avatar_upload() {
		if ( ! is_user_logged_in() ) {
			wp_send_json_error(
				esc_html__( 'User is not logged in', 'customize-my-account-page' ),
				400
			);
		}

		if ( ! isset( $_POST['tgwc_avatar_upload_nonce'] ) ) {
			wp_send_json_error(
				esc_html__( 'Nonce is required', 'customize-my-account-page' ),
				400
			);
		}

		$avatar_upload_nonce = sanitize_text_field( wp_unslash( $_POST['tgwc_avatar_upload_nonce'] ) );
		if ( ! wp_verify_nonce( $avatar_upload_nonce, 'tgwc_avatar_upload' ) ) {
			wp_send_json_error(
				esc_html__( 'Invalid nonce', 'customize-my-account-page' ),
				400
			);
		}

		// Get WordPress upload directory.
		$upload_dir = wp_upload_dir();

		if ( ! isset( $_FILES['file']['name'] ) ) {
			wp_send_json_error(
				esc_html__( 'File is required', 'customize-my-account-page' ),
				400
			);
		}

		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		// Use only single file.
		if ( is_array( $_FILES['file']['name'] ) ) {
			$filenames = array_map( 'sanitize_file_name', $_FILES['file']['name'] );
			foreach ( $filenames as $index => $name ) {
				$_FILES['file'] = array(
					'name'     => isset( $_FILES['file']['name'][ $index ] ) ? sanitize_file_name( $_FILES['file']['name'][ $index ] ) : '',
					'type'     => isset( $_FILES['file']['type'][ $index ] ) ? sanitize_text_field( $_FILES['file']['type'][ $index ] ) : '',
					'tmp_name' => isset( $_FILES['file']['tmp_name'][ $index ] ) ? sanitize_file_name( $_FILES['file']['tmp_name'][ $index ] ) : '',
					'error'    => isset( $_FILES['file']['error'][ $index ] ) ? absint( $_FILES['file']['error'][ $index ] ) : '',
					'size'     => isset( $_FILES['file']['size'][ $index ] ) ? absint( $_FILES['file']['size'][ $index ] ) : 0,
				);
				break;
			}
		}

		// Return error message if the upload is not successfull.
		$error_message = \tgwc_get_upload_error_messages( absint( $_FILES['file']['error'] ) );
		if ( UPLOAD_ERR_OK !== $error_message ) {
			wp_send_json_error( $error_message, 400 );
		}

		// Return error message if the file size is bigger than the specified file size.
		$max_file_size = \tgwc_get_avatar_upload_size();
		if ( absint( $_FILES['file']['size'] ) > $max_file_size ) {
			wp_send_json_error( \tgwc_get_upload_error_messages( UPLOAD_ERR_INI_SIZE ), 400 );
		}

		try {
			if ( ! is_readable( sanitize_text_field( $_FILES['file']['tmp_name'] ) ) ) {
				throw new \Exception( __( 'Temporary file is not readable', 'customize-my-account-page' ) );
			}

			$mime_types = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'png'          => 'image/png',
			);
			$filetype   = wp_check_filetype( sanitize_text_field( $_FILES['file']['name'], $mime_types ) );

			if ( false === $filetype['ext'] || false === $filetype['type'] ) {
				throw new \Exception( __( 'Invalid image type. Only JPG and PNG are allowed.', 'customize-my-account-page' ) );
			}

			if ( function_exists( 'file_get_contents' ) ) {
				$file_contents = file_get_contents( sanitize_text_field( $_FILES['file']['tmp_name'] ) ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
				if ( false === $file_contents ) {
					throw new \Exception( __( 'Could not read file contents', 'customize-my-account-page' ) );
				}
				$image_content = true;

				if ( function_exists( 'imagecreatefromstring' ) ) {
					$image_content = @imagecreatefromstring( $file_contents ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
				}

				if ( false === $image_content ) {
					throw new \Exception( __( 'The image appears to be corrupted', 'customize-my-account-page' ) );
				}

				$malicious_patterns = array(
					'<?php',
					'<?=',
					'<script',
					'eval(',
					'exec(',
					'system(',
					'shell_exec(',
					'passthru(',
					'base64_decode(',
					'gzinflate(',
					'javascript:',
					'data:text/html',
				);

				foreach ( $malicious_patterns as $pattern ) {
					if ( stripos( $file_contents, $pattern ) !== false ) {
						wp_send_json_error( esc_html__( 'Image contains suspicious content', 'customize-my-account-page' ), 400 );
					}
				}

				if ( function_exists( 'exif_read_data' ) ) {
					$exif = @exif_read_data( sanitize_text_field( $_FILES['file']['tmp_name'] ) );
					if ( $exif ) {
						foreach ( $exif as $value ) {
							if ( is_string( $value ) ) {
								foreach ( $malicious_patterns as $pattern ) {
									if ( stripos( $value, $pattern ) !== false ) {
										wp_send_json_error( esc_html__( 'Suspicious image metadata', 'customize-my-account-page' ), 400 );
									}
								}
							}
						}
					}
				}

				if ( is_resource( $image_content ) || $image_content instanceof GdImage ) {
					imagedestroy( $image_content );
				}
			}
		} catch ( \Exception $e ) {
			wp_send_json_error(
				array(
					'message' => esc_html( $e->getMessage() ),
				),
				400
			);
		}

		// Handle the media upload.
		$move_file = wp_handle_upload(
			$_FILES['file'],
			array(
				'action' => 'tgwc_avatar_upload',
			)
		);

		// Bail early if the image is not saved successfully
		if ( ! isset( $move_file['file'] ) ) {
			wp_send_json_error(
				esc_html__( 'Something went wrong, try again', 'customize-my-account-page' ),
				400
			);
		}

		$filename = $move_file['file'];

		// Prepare an array of post data for the attachment.
		$attachment = array(
			'guid'           => $move_file['url'],
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
		);
		if ( isset( $_POST['previous_attach_id'] ) ) {
			$previous_attach_id = sanitize_text_field( wp_unslash( $_POST['previous_attach_id'] ) );
			wp_delete_attachment( $previous_attach_id, true );
		}

		// Insert the attachment.
		$attach_id = wp_insert_attachment( $attachment, $filename );

		// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
		require_once ABSPATH . 'wp-admin/includes/image.php';

		// Generate the metadata for the attachment, and update the database record.
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		// Update the user meta.
		update_user_meta( get_current_user_id(), 'tgwc_avatar_image', $attach_id );

		$image_url = wp_get_attachment_image_url( $attach_id );

		wp_send_json_success(
			array(
				'message'   => esc_html__( 'Uploaded successfully', 'customize-my-account-page' ),
				'attach_id' => $attach_id,
				'image_url' => $image_url,
			)
		);
		die;
	}

	/**
	 * Remove the image handle.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function handle_avatar_remove() {
		if ( ! is_user_logged_in() ) {
			wp_send_json_error(
				esc_html__( 'User is not logged in', 'customize-my-account-page' ),
				400
			);
		}

		if ( ! isset( $_POST['tgwc_avatar_upload_nonce'] ) ) {
			wp_send_json_error(
				esc_html__( 'Nonce is required', 'customize-my-account-page' ),
				400
			);
		}

		$avatar_upload_nonce = sanitize_text_field( wp_unslash( $_POST['tgwc_avatar_upload_nonce'] ) );

		if ( ! wp_verify_nonce( $avatar_upload_nonce, 'tgwc_avatar_upload' ) ) {
			wp_send_json_error(
				esc_html__( 'Invalid nonce', 'customize-my-account-page' ),
				400
			);
		}

		$previous_attach_id = isset( $_POST['previous_attach_id'] ) ? absint( $_POST['previous_attach_id'] ) : 0;

		if ( $previous_attach_id ) {
			wp_delete_attachment( $previous_attach_id, true );
			update_user_meta( get_current_user_id(), 'tgwc_avatar_image', false );
			wp_send_json_success(
				esc_html__( 'File deleted successfully.', 'customize-my-account-page' )
			);
		} else {
			wp_send_json_error(
				esc_html__( 'Missing the attachment id.', 'customize-my-account-page' )
			);
		}
	}

	/**
	 * Handle the icon drop upload.
	 *
	 * @since 1.0.0
	 */
	public function tgwc_handle_dropped_icon() {
		check_ajax_referer( 'tgwc_upload_nonce', 'security' );

		if ( empty( $_FILES['file'] ) ) {
			wp_send_json_error( array( 'message' => 'No file was uploaded' ) );
		}

		$upload = wp_handle_upload( $_FILES['file'], array( 'test_form' => false ) );

		if ( isset( $upload['error'] ) ) {
			wp_send_json_error( array( 'message' => $upload['error'] ) );
		}

		$attachment_id = wp_insert_attachment(
			array(
				'post_mime_type' => $upload['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $upload['file'] ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
			),
			$upload['file']
		);

		if ( is_wp_error( $attachment_id ) ) {
			wp_send_json_error( array( 'message' => $attachment_id->get_error_message() ) );
		}

		require_once ABSPATH . 'wp-admin/includes/image.php';

		$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload['file'] );
		wp_update_attachment_metadata( $attachment_id, $attachment_data );

		wp_send_json_success(
			array(
				'attachment' => array(
					'id' => $attachment_id,
				),
			)
		);
	}
}
