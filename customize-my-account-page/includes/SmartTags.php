<?php
/**
 * SmartTags page.
 *
 * @package ThemeGrill\WoocommerceCustomizer
 * @since 1.0.0
 */

namespace ThemeGrill\WoocommerceCustomizer;

defined( 'ABSPATH' ) || exit;

class SmartTags {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		if ( ! did_action( 'tgwc_smart_tags_init' ) ) {
			$this->init_hooks();
			do_action( 'tgwc_smart_tags_init' );
		}
	}

	/**
	 * Init hooks function.
	 *
	 * @since 1.0.0
	 */
	public function init_hooks() {
		add_filter( 'tgwc_parse_smart_tag', array( $this, 'tgwc_parse_smart_tag' ), 10, 2 );
		add_action( 'media_buttons', array( $this, 'media_button' ), 15 );
	}

	/**
	 * Render smart tags.
	 *
	 * @since 1.0.0
	 */
	public function tgwc_select_smart_tags( $editor_id ) {
		$smart_tags_list = $this->smart_tags_list();

		$selector  = '<a id="tgwc-smart-tags-selector">';
		$selector .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
		<path d="M10 3.33203L14.2 7.53203C14.3492 7.68068 14.4675 7.85731 14.5483 8.05179C14.629 8.24627 14.6706 8.45478 14.6706 8.66536C14.6706 8.87595 14.629 9.08446 14.5483 9.27894C14.4675 9.47342 14.3492 9.65005 14.2 9.7987L11.3333 12.6654" stroke="#6B6B6B" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
		<path d="M6.39132 3.7227C6.14133 3.47263 5.80224 3.33211 5.44865 3.33203H2.00065C1.82384 3.33203 1.65427 3.40227 1.52925 3.52729C1.40422 3.65232 1.33398 3.82189 1.33398 3.9987V7.4467C1.33406 7.80029 1.47459 8.13938 1.72465 8.38937L5.52732 12.192C5.83033 12.4931 6.24015 12.6621 6.66732 12.6621C7.09449 12.6621 7.50431 12.4931 7.80732 12.192L10.194 9.80537C10.4951 9.50236 10.6641 9.09253 10.6641 8.66537C10.6641 8.2382 10.4951 7.82837 10.194 7.52537L6.39132 3.7227Z" stroke="#6B6B6B" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
		<path d="M4.33333 6.66667C4.51743 6.66667 4.66667 6.51743 4.66667 6.33333C4.66667 6.14924 4.51743 6 4.33333 6C4.14924 6 4 6.14924 4 6.33333C4 6.51743 4.14924 6.66667 4.33333 6.66667Z" fill="#6B6B6B" stroke="#6B6B6B" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>';
		$selector .= esc_html__( 'Add Smart Tags', 'customize-my-account-page' );
		$selector .= '</a>';
		$selector .= '<select class="select-smart-tags" style="display: none;">';
		$selector .= '<option></option>';

		foreach ( $smart_tags_list as $key => $value ) {
			$selector .= '<option class="ur-select-smart-tag" value = "' . esc_attr( $key ) . '"> ' . esc_html( $value ) . '</option>';
		}
		$selector .= '</select>';

		echo $selector; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Process the smart tags.
	 *
	 * @since 1.0.0
	 */
	public function tgwc_parse_smart_tag( $content, $endpoint ) {
		preg_match_all( '/\{\{(.*?)\}\}/', $content, $other_tags );

		if ( ! empty( $other_tags[1] ) ) {

			foreach ( $other_tags[1] as $key => $tag ) {
				$other_tag = explode( ' ', $tag )[0];
				switch ( $other_tag ) {
					case 'admin_email':
						$admin_email = sanitize_email( get_option( 'admin_email' ) );
						$content     = str_replace( '{{' . $other_tag . '}}', $admin_email, $content );
						break;

					case 'site_name':
						$site_name = get_option( 'blogname' );
						$content   = str_replace( '{{' . $other_tag . '}}', $site_name, $content );
						break;

					case 'site_url':
						$site_url = get_option( 'siteurl' );
						$content  = str_replace( '{{' . $other_tag . '}}', $site_url, $content );
						break;

					case 'page_title':
						$page_title = get_the_title( get_the_ID() );
						$content    = str_replace( '{{' . $other_tag . '}}', $page_title, $content );
						break;

					case 'page_url':
						$page_url = get_permalink( get_the_ID() );
						$content  = str_replace( '{{' . $other_tag . '}}', $page_url, $content );
						break;

					case 'user_ip_address':
						$user_ip_add = tgwc_get_ip_address();
						$content     = str_replace( '{{' . $other_tag . '}}', $user_ip_add, $content );
						break;

					case 'user_id':
						$user_id = is_user_logged_in() ? get_current_user_id() : '';
						$content = str_replace( '{{' . $other_tag . '}}', $user_id, $content );
						break;

					case 'user_email':
						if ( is_user_logged_in() ) {
							$user  = wp_get_current_user();
							$email = sanitize_email( $user->user_email );
						} else {
							$email = '';
						}
						$content = str_replace( '{{' . $other_tag . '}}', $email, $content );
						break;

					case 'username':
						if ( is_user_logged_in() ) {
							$user = wp_get_current_user();
							$name = sanitize_text_field( $user->user_login );
						} else {
							$name = '';
						}
						$content = str_replace( '{{' . $other_tag . '}}', $name, $content );
						break;

					case 'display_name':
						if ( is_user_logged_in() ) {
							$user = wp_get_current_user();
							$name = sanitize_text_field( $user->display_name );
						} else {
							$name = '';
						}
						$content = str_replace( '{{' . $other_tag . '}}', $name, $content );
						break;

					case 'first_name':
						if ( is_user_logged_in() ) {
							$user = wp_get_current_user();
							$name = sanitize_text_field( $user->user_firstname );
						} else {
							$name = '';
						}
						$content = str_replace( '{{' . $other_tag . '}}', $name, $content );
						break;

					case 'last_name':
						if ( is_user_logged_in() ) {
							$user = wp_get_current_user();
							$name = sanitize_text_field( $user->user_lastname );
						} else {
							$name = '';
						}
						$content = str_replace( '{{' . $other_tag . '}}', $name, $content );
						break;

					case 'current_date':
						$current_date = date_i18n( get_option( 'date_format' ) );
						$content      = str_replace( '{{' . $other_tag . '}}', sanitize_text_field( $current_date ), $content );
						break;
					case 'current_time':
						$current_time = date_i18n( get_option( 'time_format' ) );
						$content      = str_replace( '{{' . $other_tag . '}}', sanitize_text_field( $current_time ), $content );
						break;
					case 'billing_address':
					case 'shipping_address':
						if ( is_user_logged_in() ) {
							$meta_prefix = ( 'billing_address' === $other_tag ) ? 'billing_' : 'shipping_';
							$user_id     = get_current_user_id();
							$address     = array(
								'first_name' => get_user_meta( $user_id, $meta_prefix . 'first_name', true ),
								'last_name'  => get_user_meta( $user_id, $meta_prefix . 'last_name', true ),
								'company'    => get_user_meta( $user_id, $meta_prefix . 'company', true ),
								'address_1'  => get_user_meta( $user_id, $meta_prefix . 'address_1', true ),
								'address_2'  => get_user_meta( $user_id, $meta_prefix . 'address_2', true ),
								'city'       => get_user_meta( $user_id, $meta_prefix . 'city', true ),
								'state'      => get_user_meta( $user_id, $meta_prefix . 'state', true ),
								'postcode'   => get_user_meta( $user_id, $meta_prefix . 'postcode', true ),
								'country'    => get_user_meta( $user_id, $meta_prefix . 'country', true ),
							);

							$address = array_filter( $address );
							if ( ! empty( $address ) ) {
								$formatted_address = $this->get_formatted_address( $address );
								$content           = str_replace( '{{' . $other_tag . '}}', $formatted_address, $content );
							} else {
								$content = str_replace( '{{' . $other_tag . '}}', esc_html__( 'You have not set up this type of address yet.', 'customize-my-account-page' ), $content );
							}
						}
						break;
					case 'billing_company':
					case 'shipping_company':
						if ( is_user_logged_in() ) {
							$meta_prefix  = ( 'billing_address' === $other_tag ) ? 'billing_' : 'shipping_';
							$company_name = get_user_meta( $user_id, $meta_prefix . 'company', true );

							if ( empty( $company_name ) ) {
								$company_name = '';
							}

							$content = str_replace( '{{' . $other_tag . '}}', $company_name, $content );
						}
						break;
				}
			}
		}
		return $content;
	}

	/**
	 * Format the address.
	 *
	 * @since 1.0.0
	 */
	private function get_formatted_address( $address ) {
		$countries = new \WC_Countries();
		$formatted = $countries->get_formatted_address( $address );

		if ( empty( $formatted ) ) {
			$formatted = implode(
				'<br>',
				array_filter(
					array(
						trim( $address['first_name'] . ' ' . $address['last_name'] ),
						$address['company'],
						$address['address_1'],
						$address['address_2'],
						trim( $address['city'] . ' ' . $address['state'] . ' ' . $address['postcode'] ),
						$address['country'],
					)
				)
			);
		}

		return wp_kses_post( $formatted );
	}

	/**
	 * Get smart tag lists.
	 *
	 * @since 1.0.0
	 */
	public function smart_tags_list() {
		$smart_tags_list = apply_filters(
			'tgwc_smart_tags_list',
			array(
				'{{user_id}}'          => esc_html__( 'User ID', 'customize-my-account-page' ),
				'{{username}}'         => esc_html__( 'User Name', 'customize-my-account-page' ),
				'{{user_email}}'       => esc_html__( 'User Email', 'customize-my-account-page' ),
				'{{first_name}}'       => esc_html__( 'First Name', 'customize-my-account-page' ),
				'{{last_name}}'        => esc_html__( 'Last Name', 'customize-my-account-page' ),
				'{{display_name}}'     => esc_html__( 'User Display Name', 'customize-my-account-page' ),
				'{{user_ip_address}}'  => esc_html__( 'User IP Address', 'customize-my-account-page' ),
				'{{site_name}}'        => esc_html__( 'Site Name', 'customize-my-account-page' ),
				'{{site_url}}'         => esc_html__( 'Site URL ', 'customize-my-account-page' ),
				'{{page_url}}'         => esc_html__( 'Page URL', 'customize-my-account-page' ),
				'{{current_date}}'     => esc_html__( 'Current Date', 'customize-my-account-page' ),
				'{{current_time}}'     => esc_html__( 'Current Time', 'customize-my-account-page' ),
				'{{billing_address}}'  => esc_html__( 'Billing address', 'customize-my-account-page' ),
				'{{billing_company}}'  => esc_html__( 'Billing Company', 'customize-my-account-page' ),
				'{{shipping_address}}' => esc_html__( 'Shipping address', 'customize-my-account-page' ),
				'{{shipping_company}}' => esc_html__( 'Shipping Company', 'customize-my-account-page' ),
			)
		);
		return $smart_tags_list;
	}

	/**
	 * Trigger when editor loads.
	 *
	 * @since 1.0.0
	 */
	public function media_button( $editor_id ) {
		global $pagenow;
		$page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		$tab  = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_FULL_SPECIAL_CHARS );

		$is_correct_page = (
		'admin.php' === $pagenow &&
		'tgwc-customize-my-account' === $page &&
		'endpoints' === $tab
		);

		if ( ! $is_correct_page ) {
			return;
		}

		static $smart_tags_html = null;

		if ( null === $smart_tags_html ) {
			ob_start();
			$this->tgwc_select_smart_tags( $editor_id );
			$smart_tags_html = ob_get_clean();
		}

		echo $smart_tags_html; //Phpcs:ignore
	}
}
