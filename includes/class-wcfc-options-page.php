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

	}

}
