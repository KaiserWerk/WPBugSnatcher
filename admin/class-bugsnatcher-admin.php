<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://kaiserrobin.eu
 * @since      1.0.0
 *
 * @package    Bugsnatcher
 * @subpackage Bugsnatcher/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bugsnatcher
 * @subpackage Bugsnatcher/admin
 * @author     Robin Kaiser <info@r-k.mx>
 */
class Bugsnatcher_Admin
{
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version )
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bugsnatcher_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bugsnatcher_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bugsnatcher-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bugsnatcher_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bugsnatcher_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bugsnatcher-admin.js', array( 'jquery' ), $this->version, false );
	}
	
	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu()
	{
		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 */
		add_options_page( 'BugSnatcher', 'BugSnatcher', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
		);
	}
	
	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links )
	{
		/*
		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		*/
		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
		);
		return array_merge(  $settings_link, $links );
		
	}
	
	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_setup_page()
	{
		include_once 'partials/bugsnatcher-admin-display.php';
	}
	
	public function options_update()
	{
		register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
	}
	
	public function validate($input)
	{
		$valid = array();
		
		$options = get_option($this->plugin_name);
		
		if ( isset( $_POST['btn_log_settings'] ) ) {
			$valid['log_enabled'] = ( isset($input['log_enabled'] ) && !empty( $input['log_enabled'] ) ) ? 1 : 0;
			$valid['log_file'] = sanitize_text_field( $input['log_file'] );
			
			$valid['discord_enabled'] = $options['discord_enabled'];
			$valid['discord_webhook'] = $options['discord_webhook'];
			
			$valid['slack_enabled'] = $options['slack_enabled'];
			$valid['slack_apikey']  = $options['slack_apikey'];
			$valid['slack_channel'] = $options['slack_channel'];
			$valid['slack_botname'] = $options['slack_botname'];
			
			$valid['stride_enabled'] = $options['stride_enabled'];
			$valid['stride_bearer_token'] = $options['stride_bearer_token'];
			$valid['stride_cloud_id'] = $options['stride_cloud_id'];
			$valid['stride_conversation_id'] = $options['stride_conversation_id'];
			
			$valid['hipchat_enabled'] = $options['hipchat_enabled'];
			$valid['hipchat_chatname'] = $options['hipchat_chatname'];
			$valid['hipchat_room_number'] = $options['hipchat_room_number'];
			$valid['hipchat_token'] = $options['hipchat_token'];
			
			$valid['email_enabled'] = $options['email_enabled'];
			$valid['email_list'] = $options['email_list'];
			
			$valid['custom_webhooks_enabled'] = $options['custom_webhooks_enabled'];
			$valid['custom_webhooks_list'] = $options['custom_webhooks_list'];
		}
		
		if ( isset( $_POST['btn_discord_settings'] ) ) {
			$valid['log_enabled'] = $options['log_enabled'];
			$valid['log_file'] = $options['log_file'];
			
			$valid['discord_enabled'] = ( isset($input['discord_enabled'] ) && !empty( $input['discord_enabled'] ) ) ? 1 : 0;
			$valid['discord_webhook'] = sanitize_text_field( $input['discord_webhook'] );
			
			$valid['slack_enabled'] = $options['slack_enabled'];
			$valid['slack_apikey']  = $options['slack_apikey'];
			$valid['slack_channel'] = $options['slack_channel'];
			$valid['slack_botname'] = $options['slack_botname'];
			
			$valid['stride_enabled'] = $options['stride_enabled'];
			$valid['stride_bearer_token'] = $options['stride_bearer_token'];
			$valid['stride_cloud_id'] = $options['stride_cloud_id'];
			$valid['stride_conversation_id'] = $options['stride_conversation_id'];
			
			$valid['hipchat_enabled'] = $options['hipchat_enabled'];
			$valid['hipchat_chatname'] = $options['hipchat_chatname'];
			$valid['hipchat_room_number'] = $options['hipchat_room_number'];
			$valid['hipchat_token'] = $options['hipchat_token'];
			
			$valid['email_enabled'] = $options['email_enabled'];
			$valid['email_list'] = $options['email_list'];
			
			$valid['custom_webhooks_enabled'] = $options['custom_webhooks_enabled'];
			$valid['custom_webhooks_list'] = $options['custom_webhooks_list'];
		}
		if ( isset( $_POST['btn_slack_settings'] ) ) {
			$valid['log_enabled'] = $options['log_enabled'];
			$valid['log_file'] = $options['log_file'];
			
			$valid['discord_enabled'] = $options['discord_enabled'];
			$valid['discord_webhook'] = $options['discord_webhook'];
			
			$valid['slack_enabled'] = ( isset( $input['slack_enabled'] ) && !empty( $input['slack_enabled'] ) ) ? 1 : 0;
			$valid['slack_apikey'] = sanitize_text_field( $input['slack_apikey'] );
			$valid['slack_channel'] = sanitize_text_field( $input['slack_channel'] );
			$valid['slack_botname'] = sanitize_text_field( $input['slack_botname'] );
			
			$valid['stride_enabled'] = $options['stride_enabled'];
			$valid['stride_bearer_token'] = $options['stride_bearer_token'];
			$valid['stride_cloud_id'] = $options['stride_cloud_id'];
			$valid['stride_conversation_id'] = $options['stride_conversation_id'];
			
			$valid['hipchat_enabled'] = $options['hipchat_enabled'];
			$valid['hipchat_chatname'] = $options['hipchat_chatname'];
			$valid['hipchat_room_number'] = $options['hipchat_room_number'];
			$valid['hipchat_token'] = $options['hipchat_token'];
			
			$valid['email_enabled'] = $options['email_enabled'];
			$valid['email_list'] = $options['email_list'];
			
			$valid['custom_webhooks_enabled'] = $options['custom_webhooks_enabled'];
			$valid['custom_webhooks_list'] = $options['custom_webhooks_list'];
		}
		if ( isset( $_POST['btn_stride_settings'] ) ) {
			$valid['log_enabled'] = $options['log_enabled'];
			$valid['log_file'] = $options['log_file'];
			
			$valid['discord_enabled'] = $options['discord_enabled'];
			$valid['discord_webhook'] = $options['discord_webhook'];
			
			$valid['slack_enabled'] = $options['slack_enabled'];
			$valid['slack_apikey']  = $options['slack_apikey'];
			$valid['slack_channel'] = $options['slack_channel'];
			$valid['slack_botname'] = $options['slack_botname'];
			
			$valid['stride_enabled'] = ( isset( $input['stride_enabled'] ) && !empty( $input['stride_enabled'] ) ) ? 1 : 0;
			$valid['stride_bearer_token'] = sanitize_text_field( $input['stride_bearer_token'] );
			$valid['stride_cloud_id'] = sanitize_text_field( $input['stride_cloud_id'] );
			$valid['stride_conversation_id'] = sanitize_text_field( $input['stride_conversation_id'] );
			
			$valid['hipchat_enabled'] = $options['hipchat_enabled'];
			$valid['hipchat_chatname'] = $options['hipchat_chatname'];
			$valid['hipchat_room_number'] = $options['hipchat_room_number'];
			$valid['hipchat_token'] = $options['hipchat_token'];
			
			$valid['email_enabled'] = $options['email_enabled'];
			$valid['email_list'] = $options['email_list'];
			
			$valid['custom_webhooks_enabled'] = $options['custom_webhooks_enabled'];
			$valid['custom_webhooks_list'] = $options['custom_webhooks_list'];
		}
		if ( isset( $_POST['btn_hipchat_settings'] ) ) {
			$valid['log_enabled'] = $options['log_enabled'];
			$valid['log_file'] = $options['log_file'];
			
			$valid['discord_enabled'] = $options['discord_enabled'];
			$valid['discord_webhook'] = $options['discord_webhook'];
			
			$valid['slack_enabled'] = $options['slack_enabled'];
			$valid['slack_apikey'] = $options['slack_apikey'];
			$valid['slack_channel'] = $options['slack_channel'];
			$valid['slack_botname'] = $options['slack_botname'];
			
			$valid['stride_enabled'] = $options['stride_enabled'];
			$valid['stride_bearer_token'] = $options['stride_bearer_token'];
			$valid['stride_cloud_id'] = $options['stride_cloud_id'];
			$valid['stride_conversation_id'] = $options['stride_conversation_id'];
			
			$valid['hipchat_enabled'] = ( isset( $input['hipchat_enabled'] ) && !empty( $input['hipchat_enabled'] ) ) ? 1 : 0;
			$valid['hipchat_chatname'] = sanitize_text_field( $input['hipchat_chatname'] );
			$valid['hipchat_room_number'] = sanitize_text_field( $input['hipchat_room_number'] );
			$valid['hipchat_token'] = sanitize_text_field( $input['hipchat_token'] );
			
			$valid['email_enabled'] = $options['email_enabled'];
			$valid['email_list'] = $options['email_list'];
			
			$valid['custom_webhooks_enabled'] = $options['custom_webhooks_enabled'];
			$valid['custom_webhooks_list'] = $options['custom_webhooks_list'];
		}
		if ( isset( $_POST['btn_email_settings'] ) ) {
			$valid['log_enabled'] = $options['log_enabled'];
			$valid['log_file'] = $options['log_file'];
			
			$valid['discord_enabled'] = $options['discord_enabled'];
			$valid['discord_webhook'] = $options['discord_webhook'];
			
			$valid['slack_enabled'] = $options['slack_enabled'];
			$valid['slack_apikey'] = $options['slack_apikey'];
			$valid['slack_channel'] = $options['slack_channel'];
			$valid['slack_botname'] = $options['slack_botname'];
			
			$valid['stride_enabled'] = $options['stride_enabled'];
			$valid['stride_bearer_token'] = $options['stride_bearer_token'];
			$valid['stride_cloud_id'] = $options['stride_cloud_id'];
			$valid['stride_conversation_id'] = $options['stride_conversation_id'];
			
			$valid['hipchat_enabled'] = $options['hipchat_enabled'];
			$valid['hipchat_chatname'] = $options['hipchat_chatname'];
			$valid['hipchat_room_number'] = $options['hipchat_room_number'];
			$valid['hipchat_token'] = $options['hipchat_token'];
			
			$valid['email_enabled'] = ( isset( $input['email_enabled'] ) && !empty( $input['email_enabled'] ) ) ? 1 : 0;
			$valid['email_list'] = esc_textarea($input['email_list']);
			
			$valid['custom_webhooks_enabled'] = $options['custom_webhooks_enabled'];
			$valid['custom_webhooks_list'] = $options['custom_webhooks_list'];
		}
		if ( isset( $_POST['btn_custom_webhooks_settings'] ) ) {
			$valid['log_enabled'] = $options['log_enabled'];
			$valid['log_file'] = $options['log_file'];
			
			$valid['discord_enabled'] = $options['discord_enabled'];
			$valid['discord_webhook'] = $options['discord_webhook'];
			
			$valid['slack_enabled'] = $options['slack_enabled'];
			$valid['slack_apikey'] = $options['slack_apikey'];
			$valid['slack_channel'] = $options['slack_channel'];
			$valid['slack_botname'] = $options['slack_botname'];
			
			$valid['stride_enabled'] = $options['stride_enabled'];
			$valid['stride_bearer_token'] = $options['stride_bearer_token'];
			$valid['stride_cloud_id'] = $options['stride_cloud_id'];
			$valid['stride_conversation_id'] = $options['stride_conversation_id'];
			
			$valid['hipchat_enabled'] = $options['hipchat_enabled'];
			$valid['hipchat_chatname'] = $options['hipchat_chatname'];
			$valid['hipchat_room_number'] = $options['hipchat_room_number'];
			$valid['hipchat_token'] = $options['hipchat_token'];
			
			$valid['email_enabled'] = $options['email_enabled'];
			$valid['email_list'] = $options['email_list'];
			
			$valid['email_enabled'] = ( isset( $input['email_enabled'] ) && !empty( $input['email_enabled'] ) ) ? 1 : 0;
			$valid['email_list'] = ($input['email_list']);
			
			$valid['custom_webhooks_enabled'] = ( isset( $input['custom_webhooks_enabled'] ) && !empty( $input['custom_webhooks_enabled'] ) ) ? 1 : 0;
			$valid['custom_webhooks_list'] = esc_textarea( $input['custom_webhooks_list'] );
		}
		
		if ( isset( $_POST['btn_import_settings'] ) ) {
			if ( isset( $_FILES['bugsnatcher']['tmp_name']['import_file'] ) ) {
				
				$cont = trim( file_get_contents( $_FILES['bugsnatcher']['tmp_name']['import_file'] ) );
				if ( $this->isJson( $cont ) ) {
					$json = json_decode( $cont, true );
					foreach ( $json as $key => $value ) {
						if ( array_key_exists( $key, $options ) ) {
							$valid[$key] = $json[$key];
						}
					}
					
					foreach ( $valid as $key => $value ) {
						if ( empty( $valid[$key] ) ) {
							$valid[$key] = $options[$key];
						}
					}
				} else {
					die( 'invalid json!' );
				}
				
			} elseif ( ! empty( $input['import_settings_text'] ) ) {
				if ( $this->isJson( $input['import_settings_text'] ) ) {
					$json = json_decode( $input['import_settings_text'], true );
					foreach ( $json as $key => $value ) {
						if ( array_key_exists( $key, $options ) ) {
							$valid[$key] = $json[$key];
						}
					}
					
					foreach ( $valid as $key => $value ) {
						if ( empty( $valid[$key] ) ) {
							$valid[$key] = $options[$key];
						}
					}
				} else {
					die( 'invalid json!' );
				}
			}
		}
		if ( isset( $_POST['btn_export_settings'] ) ) {
			$json = json_encode( $options, JSON_PRETTY_PRINT );
			header( 'Content-Type: application/json' );
			header( 'Content-Disposition: attachment; filename="settings.json"' );
			echo $json;
			die;
		}
		
		return $valid;
	}
	
	private function isJson( $str ) {
		$json = json_decode( $str );
		return $json && $str != $json;
	}
}
