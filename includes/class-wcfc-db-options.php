<?php

class Wcfc_db {
	public static function add( $option, $value = '', $deprecated = '', $autoload = 'yes' ) {
		add_option( 'wcfc_' . $option, $value, $deprecated, $autoload );
	}

	public static function update( $option, $value, $autoload = null ) {
		update_option( 'wcfc_' . $option, $value, $autoload = null );
	}

	public static function get( $option, $default = false ) {
		return get_option( 'wcfc_' . $option, $default = false );
	}

	public static function delete( $option ) {
		delete_option( 'wcfc_' . $option );
	}
}