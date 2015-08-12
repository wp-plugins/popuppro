<?php
	/* get a global option */
	function popuppro_get_option( $option ) {
		$popuppro_default_options = popuppro_default_options();
		$settings = get_option('popuppro');
		switch($option){
		
			default:
				if (isset($settings[$option])){
					return $settings[$option];
				} else {
					return $popuppro_default_options[$option];
				}
				break;
	
		}
	}
	
	/* set a global option */
	function popuppro_feedBlitz_set_option($option, $newvalue){
		$settings = get_option('popuppro');
		$settings[$option] = $newvalue;
		update_option('popuppro', $settings);
	}
	/* default options */
	function popuppro_default_options(){
		$array['enabledpopup']='1';
		$array['rounded_corner']='1';
		$array['popup_box_content']='<h2>Welcome to popuppro <br/>of Abcdefg Gfrt Members Today</h2> [popuppro_subscribe]';
	$array['popuppro_mailchimp_integration']='0';
			
		return  $array;
	}
?>
