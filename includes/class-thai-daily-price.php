<?php



/**

 * The file that defines the core plugin class

 *

 * A class definition that includes attributes and functions used across both the

 * public-facing side of the site and the admin area.

 *

 * @link       kwanggan.me

 * @since      1.0.0

 *

 * @package    Thai_Daily_Price

 * @subpackage Thai_Daily_Price/includes

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

 * @package    Thai_Daily_Price

 * @subpackage Thai_Daily_Price/includes

 * @author     KwangGan <kwanggan@gmail.com>

 */

class Thai_Daily_Price {



	/**

	 * The loader that's responsible for maintaining and registering all hooks that power

	 * the plugin.

	 *

	 * @since    1.0.0

	 * @access   protected

	 * @var      Thai_Daily_Price_Loader    $loader    Maintains and registers all hooks for the plugin.

	 */

	protected $loader;



	/**

	 * The unique identifier of this plugin.

	 *

	 * @since    1.0.0

	 * @access   protected

	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.

	 */

	protected $plugin_name;



	/**

	 * The current version of the plugin.

	 *

	 * @since    1.0.0

	 * @access   protected

	 * @var      string    $version    The current version of the plugin.

	 */

	protected $version;



	/**

	 * Define the core functionality of the plugin.

	 *

	 * Set the plugin name and the plugin version that can be used throughout the plugin.

	 * Load the dependencies, define the locale, and set the hooks for the admin area and

	 * the public-facing side of the site.

	 *

	 * @since    1.0.0

	 */

	public function __construct() {



		$this->plugin_name = 'thai-daily-price';

		$this->version = '1.0.0';



		$this->load_dependencies();

	//	$this->set_locale();

		$this->define_admin_hooks();

		$this->define_public_hooks();

		$this->define_widgets_hooks();



	}



	/**

	 * Load the required dependencies for this plugin.

	 *

	 * Include the following files that make up the plugin:

	 *

	 * - Thai_Daily_Price_Loader. Orchestrates the hooks of the plugin.

	 * - Thai_Daily_Price_i18n. Defines internationalization functionality.

	 * - Thai_Daily_Price_Admin. Defines all hooks for the admin area.

	 * - Thai_Daily_Price_Public. Defines all hooks for the public side of the site.

	 *

	 * Create an instance of the loader which will be used to register the hooks

	 * with WordPress.

	 *

	 * @since    1.0.0

	 * @access   private

	 */

	private function load_dependencies() {

			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/simple_html_dom.php';

		

        	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-thai-daily-price-widgets.php';

		/**

		 * The class responsible for orchestrating the actions and filters of the

		 * core plugin.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-thai-daily-price-loader.php';

        

		/**

		 * The class responsible for defining internationalization functionality

		 * of the plugin.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-thai-daily-price-i18n.php';



		/**

		 * The class responsible for defining all actions that occur in the admin area.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-thai-daily-price-admin.php';



		/**

		 * The class responsible for defining all actions that occur in the public-facing

		 * side of the site.

		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-thai-daily-price-public.php';



		$this->loader = new Thai_Daily_Price_Loader();



	}



	/**

	 * Define the locale for this plugin for internationalization.

	 *

	 * Uses the Thai_Daily_Price_i18n class in order to set the domain and to register the hook

	 * with WordPress.

	 *

	 * @since    1.0.0

	 * @access   private

	 */

	private function set_locale() {



		$plugin_i18n = new Thai_Daily_Price_i18n();

		$plugin_i18n->set_domain( $this->get_plugin_name() );



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



		$plugin_admin = new Thai_Daily_Price_Admin( $this->get_plugin_name(), $this->get_version() );



		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );



	}



	/**

	 * Register all of the hooks related to the public-facing functionality

	 * of the plugin.

	 *

	 * @since    1.0.0

	 * @access   private

	 */

	private function define_public_hooks() {



		$plugin_public = new Thai_Daily_Price_Public( $this->get_plugin_name(), $this->get_version() );

        

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'thai_price_enqueue_styles',15 );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'thai_price_enqueue_scripts',15 );



	}



    	private function define_widgets_hooks() {

        

		$plugin_public = new Thai_Daily_Price_Widgets();



		$this->loader->add_action( 'widgets_init', $plugin_public, 'Thai_Daily_Price_load_widget' );

	   // $this->loader->add_action( 'http_response', $plugin_public, 'wp_log_http_requests',10, 3  );

	   



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

		return $this->plugin_name;

	}



	/**

	 * The reference to the class that orchestrates the hooks with the plugin.

	 *

	 * @since     1.0.0

	 * @return    Thai_Daily_Price_Loader    Orchestrates the hooks of the plugin.

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

		return $this->version;

	}



}

