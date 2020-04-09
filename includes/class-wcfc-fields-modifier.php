<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Wcfc_Fields_Modifier {

	protected $saved_fields;

	public function __construct() {
		$this->saved_fields = Wcfc_db::get( 'fields' );
	}

	private function required_fields( $fields ) {
		$billing_fields = isset( $this->saved_fields['required_billing_fields'] ) ? $this->saved_fields['required_billing_fields'] : array();
		if ( ! empty( $billing_fields ) ) {
			foreach ( $fields['billing'] as $field_key => $field_val ) {
				if ( in_array( $field_key, $billing_fields ) ) {
					$fields['billing'][ $field_key ] ['required'] = true;
				}
			}
		}

		$shipping_fields = isset( $this->saved_fields['required_shipping_fields'] ) ? $this->saved_fields['required_shipping_fields'] : array();
		if ( ! empty( $shipping_fields ) ) {
			foreach ( $fields['shipping'] as $field_key => $field_val ) {
				if ( in_array( $field_key, $shipping_fields ) ) {
					$fields['shipping'][ $field_key ]['required'] = true;
				}
			}
		}

		return $fields;
	}

	private function optional_fields( $fields ) {
		$billing_fields = isset( $this->saved_fields['not_required_billing_fields'] ) ? $this->saved_fields['not_required_billing_fields'] : array();
		if ( ! empty( $billing_fields ) ) {
			foreach ( $fields['billing'] as $field_key => $field_val ) {
				if ( in_array( $field_key, $billing_fields ) ) {
					$fields['billing'][ $field_key ]['required'] = false;
				}
			}
		}

		$shipping_fields = isset( $this->saved_fields['not_required_shipping_fields'] ) ? $this->saved_fields['not_required_shipping_fields'] : array();
		if ( ! empty( $shipping_fields ) ) {
			foreach ( $fields['shipping'] as $field_key => $field_val ) {
				if ( in_array( $field_key, $shipping_fields ) ) {
					$fields['shipping'][ $field_key ]['required'] = false;
				}
			}
		}

		return $fields;
	}

	private function hidden_fields( $fields ) {
		$billing_fields = isset( $this->saved_fields['hidden_billing_fields'] ) ? $this->saved_fields['hidden_billing_fields'] : array();
		if ( ! empty( $billing_fields ) ) {
			foreach ( $fields['billing'] as $field_key => $field_val ) {
				if ( in_array( $field_key, $billing_fields ) ) {
					unset( $fields['billing'][ $field_key ] );
				}
			}
		}

		$shipping_fields = isset( $this->saved_fields['hidden_shipping_fields'] ) ? $this->saved_fields['hidden_shipping_fields'] : array();
		if ( ! empty( $shipping_fields ) ) {
			foreach ( $fields['shipping'] as $field_key => $field_val ) {
				if ( in_array( $field_key, $shipping_fields ) ) {
					unset( $fields['shipping'][ $field_key ] );
				}
			}
		}

		return $fields;
	}

	public function fields( $fields_array ) {
		if ( ! is_checkout() ) {
			return $fields_array;
		}

		$required_fields = $this->required_fields( $fields_array );
		$optional_fields = $this->optional_fields( $required_fields );
		return $this->hidden_fields( $optional_fields );
	}

}