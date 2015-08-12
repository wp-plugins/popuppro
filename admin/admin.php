<?php

class popuppro_admin {

	var $options;

	function __construct() {
	
		/* Plugin slug and version */
		$this->slug = 'popuppro';
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$this->plugin_data = get_plugin_data(popuppro_path . 'index.php', false, false);
		
		
		/* Priority actions */
		add_action('admin_menu', array(&$this, 'add_menu'), 9);
		add_action('admin_enqueue_scripts', array(&$this, 'add_styles'), 9);
		
		add_action('admin_init', array(&$this, 'admin_init'), 9);
		
	}

	function admin_init() {
		
		$this->tabs = array(
			'settings' => __('Settings','popuppro'),
			
		);
		$this->default_tab = 'settings';
		
		$this->options = get_option('popuppro');
		if (!get_option('popuppro')) {
			update_option('popuppro', popuppro_default_options() );
		}
		
	}
	
	
	

	function add_styles(){
	
		wp_register_style('popuppro_admin', popuppro_url.'admin/css/admin.css');
		wp_enqueue_style('popuppro_admin');
		
		
		
		
	}
	
	function add_menu() {
	
		
		add_menu_page( __('PopupPro','popuppro'), 'PopupPro', 'manage_options', $this->slug, array(&$this, 'admin_page'), popuppro_url .'admin/images/popuppro.ico');
		
		
	
	}

	function admin_tabs( $current = null ) {
			$tabs = $this->tabs;
			$links = array();
			if ( isset ( $_GET['tab'] ) ) {
				$current = $_GET['tab'];
			} else {
				$current = $this->default_tab;
			}
			foreach( $tabs as $tab => $name ) :
				if ( $tab == $current ) :
					$links[] = "<a class='nav-tab nav-tab-active' href='?page=".$this->slug."&tab=$tab'>$name</a>";
				else :
					$links[] = "<a class='nav-tab' href='?page=".$this->slug."&tab=$tab'>$name</a>";
				endif;
			endforeach;
			foreach ( $links as $link )
				echo $link;
	}

	function get_tab_content() {
		$screen = get_current_screen();
		if( strstr($screen->id, $this->slug ) ) {
			if ( isset ( $_GET['tab'] ) ) {
				$tab = $_GET['tab'];
			} else {
				$tab = $this->default_tab;
			}
			require_once popuppro_path.'admin/panels/'.$tab.'.php';
		}
	}
	
	
	
	function save() {
	
		foreach($_POST as $key => $value) {
	
			if ($key != 'submit') {
				if (!is_array($_POST[$key])) {
				
					$this->options[$key] = stripslashes( esc_attr($_POST[$key]) );
				} else {
					
				
					$this->options[$key] = $_POST[$key];
					
				}
			}
		}
		
		update_option('popuppro', $this->options);
		
		echo '<div class="updated"><p><strong>'.__('Settings saved.','popuppro').'</strong></p></div>';
	}

	function reset() {
		update_option('popuppro', popuppro_default_options() );
		$this->options = array_merge( $this->options, popuppro_default_options() );
		echo '<div class="updated"><p><strong>'.__('Settings are reset to default.','popuppro').'</strong></p></div>';
	}
	
	
	
	function admin_page() {
	
		
		
		if (isset($_POST['submit'])) {
			$this->save();
		}
		
		if (isset($_POST['reset-options'])) {
			$this->reset();
		}
		
		
		
	?>
	
		<div class="wrap <?php echo $this->slug; ?>-admin">
		
			<h2 class="nav-tab-wrapper"><?php $this->admin_tabs(); ?></h2>

			<div class="<?php echo $this->slug; ?>-admin-contain">
				
				<?php $this->get_tab_content(); ?>
				
				<div class="clear"></div>
				
			</div>
			
		</div>

	<?php }

}
$popuppro_admin = new popuppro_admin();
?>
