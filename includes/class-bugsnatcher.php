<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://kaiserrobin.eu
 * @since      1.0.0
 *
 * @package    Bugsnatcher
 * @subpackage Bugsnatcher/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Bugsnatcher
 * @subpackage Bugsnatcher/includes
 * @author     Robin Kaiser <info@r-k.mx>
 */
class Bugsnatcher {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Bugsnatcher_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;
	
	private $plugin_data;
	private $options;
	private $user_agent;
	private $timeout;
	
	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct($plugin_data)
	{
		set_error_handler([$this, 'errorHandler']);
		set_exception_handler([$this, 'exceptionHandler']);
		
		$this->plugin_data = $plugin_data;
		$this->options = get_option($this->plugin_data['slug']);
		$this->user_agent = 'Wordpress/' . get_bloginfo('version') . '; '.$this->plugin_data['name'] . '/' . $this->plugin_data['version'];
		$this->timeout = 5;
		
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}
	
	public function writeLog($log_entry)
	{
		$file = __DIR__ . '/../../../../bugsnatcher.log';
		file_put_contents($file, $log_entry . PHP_EOL, FILE_APPEND);
	}
	
	public function errorHandler($errno, $errstr, $errfile, $errline)
	{
		$this->writeLog('Error occured at line ' . $errline . ' in file ' . $errfile . ': '.$errno . ' (' . $errstr . ')');
	}
	
	public function exceptionHandler($e)
	{
		$this->writeLog('an exception occured.');
	}

	public function sendDiscordNotification($message)
	{
		$url = $this->options['discord_webhook'];
		$fields = json_encode(array('content' => $message));
		
		$response = wp_remote_retrieve_body(wp_remote_post($url, array(
			'timeout' => $this->timeout,
			'user-agent' => $this->user_agent,
			'body' => $fields,
		)));
	}
	
	public function sendSlackNotification($message)
	{
		$fields = array(
			'token' => $this->options['slack_apikey'],
			'channel' => $this->options['slack_channel'], // prefix with a '#'
			'text' => $message,
			'username' => $this->options['slack_botname'], // freely name the sender
		);
		
		$response = wp_remote_retrieve_body(wp_remote_post('https://slack.com/api/chat.postMessage', array(
			'timeout' => $this->timeout,
			'user-agent' => $this->user_agent,
			'body' => $fields,
		)));
	}
	
	public function sendStrideNotification($message)
	{
		$fields = array(
			'body' => array(
				'version' => 1,
				'type' => 'doc',
				'content' => array(
					array(
						'type' => 'paragraph',
						'content' => array(
							array(
								'type' => 'text',
								'text' => $message,
							)
						)
					)
				)
			)
		);
		
		$url = sprintf('https://api.atlassian.com/site/%s/conversation/%s/message',
			$this->options['stride_cloud_id'], $this->options['stride_conversation_id']);
		
		$response = wp_remote_retrieve_body(wp_remote_post($url, array(
			'timeout' => $this->timeout,
			'user-agent' => $this->user_agent,
			'body' => $fields,
			'headers' => array(
				'Content-Type: application/json',
				'Authorization: Bearer ' . $this->options['stride_bearer_token'],
			),
		)));
	}
	
	public function sendHipChatNotification($message)
	{
		$fields = array(
			'color' => 'green',
			'message' => $message,
			'notify' => false,
			'message_format' => 'text'
		);
		
		$url = sprintf('https://%s.hipchat.com/v2/room/%s/notification?auth_token=%s',
			$this->options['hipchat_chatname'], $this->options['hipchat_room_number'], $this->options['hipchat_token']);
		
		$response = wp_remote_retrieve_body(wp_remote_post($url, array(
			'timeout' => $this->timeout,
			'user-agent' => $this->user_agent,
			'body' => $fields,
			'headers' => array(
				'Content-Type: application/json',
			),
		)));
	}
	
	public function sendEmailNotification($message)
	{
		$emails = explode(',', $this->options['email_list']);
		$headers = array(
			'From' => get_bloginfo('admin_email'),
		);
		foreach ($emails as $email) {
			wp_mail(trim($email), 'New verdicts grabbed', $message, $headers);
		}
	}
	
	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Bugsnatcher_Loader. Orchestrates the hooks of the plugin.
	 * - Bugsnatcher_i18n. Defines internationalization functionality.
	 * - Bugsnatcher_Admin. Defines all hooks for the admin area.
	 * - Bugsnatcher_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bugsnatcher-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bugsnatcher-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-bugsnatcher-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-bugsnatcher-public.php';

		$this->loader = new Bugsnatcher_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Bugsnatcher_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Bugsnatcher_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Bugsnatcher_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		// Add menu item
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );
		
		// Add Settings link to the plugin
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_data['slug'] . '.php' );
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );
		
		// Save/Update our plugin options
		$this->loader->add_action('admin_init', $plugin_admin, 'options_update');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Bugsnatcher_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_data['slug'];
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Bugsnatcher_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->plugin_data['version'];
	}

}
