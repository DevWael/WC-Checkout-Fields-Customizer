<?php


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

}
