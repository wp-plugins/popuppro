<?php
add_action( 'wp_ajax_popuppro_subscribe_user','popuppro_subscribe_user');
add_action( 'wp_ajax_nopriv_popuppro_subscribe_user',' popuppro_subscribe_user');
function popuppro_subscribe_user()
{
	
  $MailChimp = new MailChimp(popuppro_get_option('popuppro_mailchimp_api_key'));
   $args =  array(
   'id'                => popuppro_get_option('popuppro_mailchimp_list_id'),
   'email'             => array('email'=>sanitize_email($_POST['email'])),
   'double_optin'      => false,
   'update_existing'   => true,
   'replace_interests' => false,
   'send_welcome'      => false,
   );
 $result = $MailChimp->call('lists/subscribe',$args);
   die();
}
?>
