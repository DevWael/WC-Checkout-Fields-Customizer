<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Wcfc_Options_Page {

	public function add_page() {
		add_menu_page(
			__( 'Fields Customizer', 'wcfc' ),
			__( 'Fields Customizer', 'wcfc' ),
			'manage_options',
			'wcfc_options',
			array( $this, 'page_content' ),
			'',
			6
		);
	}

	public function page_content() {
		$this->prepare_for_woocommerce();
		echo '<div class="wrap">';
		include WCFC_DIR . 'admin/partials/wcfc-admin-display.php';
		echo '</div>';
	}

	private function prepare_for_woocommerce() {
		/**
		 * WooCommerce does not load session class on backend, so we need to do this manually
		 */
		if ( ! class_exists( 'WC_Session' ) ) {
			include_once( WP_PLUGIN_DIR . '/woocommerce/includes/abstracts/abstract-wc-session.php' );
		}

		/**
		 * First lets start the session. You cant use here WC_Session directly
		 * because it's an abstract class. But you can use WC_Session_Handler which
		 * extends WC_Session
		 */
		WC()->session = new WC_Session_Handler;

		/**
		 * Next lets create a customer so we can access checkout fields
		 * If you will check a constructor for WC_Customer class you will see
		 * that if you will not provide user to create customer it will use some
		 * default one. Magic.
		 */
		WC()->customer = new WC_Customer;
	}

	public function process_fields() {
		if ( ! isset( $_POST['nonce'] ) or empty( $_POST['nonce'] ) ) {
			wp_die( 'Not Allowed' );
		}

		if ( ! wp_verify_nonce( $_POST['nonce'], 'customize_checkout' ) ) {
			wp_die( 'Cheating' );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Not Allowed' );
		}

		$required_billing_fields = array();
		if ( isset( $_POST['required_billing_fields'] ) && is_array( $_POST['required_billing_fields'] ) ) {
			foreach ( $_POST['required_billing_fields'] as $field ) {
				$required_billing_fields[] = sanitize_text_field( $field );
			}
		}

		$required_shipping_fields = array();
		if ( isset( $_POST['required_shipping_fields'] ) && is_array( $_POST['required_shipping_fields'] ) ) {
			foreach ( $_POST['required_shipping_fields'] as $field ) {
				$required_shipping_fields[] = sanitize_text_field( $field );
			}
		}
		$not_required_billing_fields = array();
		if ( isset( $_POST['not_required_billing_fields'] ) && is_array( $_POST['not_required_billing_fields'] ) ) {
			foreach ( $_POST['not_required_billing_fields'] as $field ) {
				$not_required_billing_fields[] = sanitize_text_field( $field );
			}
		}
		$not_required_shipping_fields = array();
		if ( isset( $_POST['not_required_shipping_fields'] ) && is_array( $_POST['not_required_shipping_fields'] ) ) {
			foreach ( $_POST['not_required_shipping_fields'] as $field ) {
				$not_required_shipping_fields[] = sanitize_text_field( $field );
			}
		}
		$hidden_billing_fields = array();
		if ( isset( $_POST['hidden_billing_fields'] ) && is_array( $_POST['hidden_billing_fields'] ) ) {
			foreach ( $_POST['hidden_billing_fields'] as $field ) {
				$hidden_billing_fields[] = sanitize_text_field( $field );
			}
		}
		$hidden_shipping_fields = array();
		if ( isset( $_POST['hidden_shipping_fields'] ) && is_array( $_POST['hidden_shipping_fields'] ) ) {
			foreach ( $_POST['hidden_shipping_fields'] as $field ) {
				$hidden_shipping_fields[] = sanitize_text_field( $field );
			}
		}


		$data = array(
			'required_billing_fields'      => $required_billing_fields,
			'required_shipping_fields'     => $required_shipping_fields,
			'not_required_billing_fields'  => $not_required_billing_fields,
			'not_required_shipping_fields' => $not_required_shipping_fields,
			'hidden_billing_fields'        => $hidden_billing_fields,
			'hidden_shipping_fields'       => $hidden_shipping_fields
		);


		Wcfc_db::update( 'fields', $data );//save to db
		wp_safe_redirect( admin_url( 'admin.php?page=wcfc_options&success=true' ) );
		exit;
	}
}
