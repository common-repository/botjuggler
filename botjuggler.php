<?php
/**
 * Plugin Name: Chatbot & Social proof popup for website
 * Plugin URI: https://botjuggler.com
 * Description: Botjuggler plugin enable you to integrate chatbot and social proof popup for your wordpress website,Zero coding required, convert maximum website visitors into leads.

 * Version: 4.2.1
 * Author: Botjuggler
 * Author URI: http://www.botjuggler.com
 * License: GPLv2 or later
 */

defined('ABSPATH') or die('Silence is golden.');

class BotjugglerPlugin
{

	 public $plugin;
     function __construct(){
     	   $this->plugin=plugin_basename(__FILE__);
           
           add_action( 'admin_menu', array( &$this, 'botjuggler_admin_menu' ) );
           add_action( 'admin_init', array( &$this, 'admin_init' ) );
           add_action( 'wp_head', array( &$this, 'wp_head' ) );
           add_filter("plugin_action_links_$this->plugin",array($this,'settings_link'));
     }


     // adds menu item to wordpress admin dashboard its apper the wordpress left menu section 
     function botjuggler_admin_menu(){
        
        add_menu_page("botjuggler","Botjuggler","manage_options","botjuggler-plugins",array($this,'exampleMenu'),"dashicons-format-status",110);
      
     }

     function settings_link($links){

        $settings_links='<a href="admin.php?page=botjuggler-plugins">Settings</a>';
        array_push($links,$settings_links);
        return $links;
     }

      function exampleMenu(){

    	require_once plugin_dir_path(__FILE__).'option.php';
    }


    function admin_init() {

			// register settings for sitewide script
			register_setting( 'botjuggler-settings-group', 'botjuggler-plugin-settings' ); 

			add_settings_field( 'script', 'Script', 'trim','botjuggler' );
			add_settings_field( 'showOn', 'Show On', 'trim','botjuggler' );

			// default value for settings
			$initialSettings = get_option( 'botjuggler-plugin-settings' );
			if ( $initialSettings === false || !$initialSettings['showOn'] ) { 
				$initialSettings['showOn'] = 'all';
   			 	update_option( 'botjuggler-plugin-settings', $initialSettings );
			}

			// add meta box to all post types
			add_meta_box('cc_all_post_meta', esc_html__('botjuggler Script:', 'botjuggler-settings'), 'botjuggler_meta_setup', array('post','page'), 'normal', 'default');

			add_action('save_post','botjuggler_post_meta_save');
		}


		function botjuggler_meta_setup() {
		global $post;

		// using an underscore, prevents the meta variable
		// from showing up in the custom fields section
		$meta = get_post_meta($post->ID,'_inpost_head_script',TRUE);

		// instead of writing HTML here, lets do an include
		require_once plugin_dir_path(__FILE__).'mata.php';

		// create a custom nonce for submit verification later
		echo '<input type="hidden" name="botjuggler_post_meta_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
	}


	function botjuggler_post_meta_save($post_id) {
		// authentication checks

		// make sure data came from our meta box

         $botjuggler_post_meta_noncename=sanitize_text_field($_POST['botjuggler_post_meta_noncename']);      

		if ( ! isset($botjuggler_post_meta_noncename )
			|| !wp_verify_nonce($botjuggler_post_meta_noncename,__FILE__)) return $post_id;

		// check user permissions
		if ( sanitize_text_field($_POST['post_type']) == 'page' ) {

			if (!current_user_can('edit_page', $post_id)) 
				return $post_id;

		} else {

			if (!current_user_can('edit_post', $post_id)) 
				return $post_id;

		}

		$current_data = get_post_meta($post_id, '_inpost_head_script', TRUE);

		$new_data = sanitize_text_field($_POST['_inpost_head_script']);

		botjuggler_post_meta_clean($new_data);

		if ($current_data) {

			if (is_null($new_data)) delete_post_meta($post_id,'_inpost_head_script');

			else update_post_meta($post_id,'_inpost_head_script',$new_data);

		} elseif (!is_null($new_data)) {

			add_post_meta($post_id,'_inpost_head_script',$new_data,TRUE);

		}

		return $post_id;
	}


	function botjuggler_post_meta_clean(&$arr) {
      if(isset($arr)){
		if (is_array($arr)) {

			foreach ($arr as $i => $v) {

				if (is_array($arr[$i])) {
					botjuggler_post_meta_clean($arr[$i]);

					if (!count($arr[$i])) {
						unset($arr[$i]);
					}

				} else {

					if (trim($arr[$i]) == '') {
						unset($arr[$i]);
					}
				}
			}

			if (!count($arr)) {
				$arr = NULL;
			}
		}

	}
	}

		function wp_head() {

			$settings = get_option( 'botjuggler-plugin-settings');


			if(is_array($settings) && array_key_exists('script', $settings)) {
				$script = $settings['script'];
				$showOn = $settings['showOn'];

				// main bot
				if ( $script != '' ) {
					if(($showOn === 'all') || ($showOn === 'home' && (is_home() || is_front_page())) || ($showOn === 'nothome' && !is_home() && !is_front_page()) || !$showOn === 'none') {
						echo $script, '<script type="text/javascript">var botjugglerWordpress = true;</script>', "\n";
					}
				}	
			}

			// post and page bots
			$botjuggler_post_meta = get_post_meta( get_the_ID(), '_inpost_head_script' , TRUE );
			if ( $botjuggler_post_meta != '' && !is_home() && !is_front_page()) {
				echo $botjuggler_post_meta['synth_header_script'], '<script type="text/javascript">var botjugglerWordpress = true;</script>',"\n";
			}

		}
   
}


if(class_exists('BotjugglerPlugin')){


      $BotjugglerPlugin= new BotjugglerPlugin();

}