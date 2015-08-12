<?php
/*
Plugin Name:popuppro
Plugin URI:http://www.wpseeds.com 
Description: A simple, attractive and extremely fast popup box for your WordPress site(so you can capture visitors).
Version: 1.0
Author: wpseeds
*/
define('popuppro_path',plugin_dir_path(__FILE__ ));
define('popuppro_url',plugin_dir_url(__FILE__ ));
require_once 'scripts/customjs.php';


if ( !class_exists( "PopupPro" ) ) {
	class PopupPro {


		function install() {
			
		if (is_admin()){
		foreach (glob(popuppro_path . 'admin/*.php') as $filename) { include $filename; }
		}
		foreach (glob(popuppro_path . 'functions/*.php') as $filename) { require_once $filename; }

			
		}

		function PopupPro() {


			$this->install();
		}

	}
}
if ( !function_exists( 'cp_sp_process_content' ) ) {
	function cp_sp_process_content( $content ) {
		$content = do_shortcode(html_entity_decode($content)) ;

		return $content;
	}
}
$PopupPro = new PopupPro();

function PopupPro_html_mask() {
	include 'css.php';
	
	echo '<div id="ppmask"></div>';
	echo '<a id="popuppro" name="simplepopup" href="#dialog"></a>';
	echo '<div id="boxes"><div id="dialog" class="window">';
	echo cp_sp_process_content(popuppro_get_option( 'popup_box_content' ) );

	echo '<a class="close" href="#"></a></div></div>';


}
function PopupPro_html_script() {
	
	PopupPro_javascript(1000 );
}


if ( isset( $PopupPro ) && (popuppro_get_option('enabledpopup') =='1'  ) ) {

	

		function PopupPro_jquery_add() {
			if ( !is_admin() ) {
			
			
				wp_enqueue_script( 'jquery' );
				wp_register_script( 'jcookie', plugins_url( 'scripts/jquery.cookie.js', __FILE__ ) );
				wp_enqueue_script( 'jcookie' );
				wp_register_script( 'mailchimp', plugins_url( 'scripts/mailchimp.js', __FILE__ ) );
				wp_enqueue_script( 'mailchimp' );
				
			}
			
		}

		add_action( 'init', 'PopupPro_jquery_add' );
		add_action( 'wp_footer', 'PopupPro_html_mask' );
		add_action( 'wp_head', 'PopupPro_html_script' );
	


}
?>
