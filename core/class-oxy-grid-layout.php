<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'Oxy_Grid_Layout' ) ) :

	/**
	 * Main Oxy_Grid_Layout Class.
	 *
	 * @package		ONGRIDLAYOUT
	 * @subpackage	Classes/Oxy_Grid_Layout
	 * @since		1.0.0
	 * @author		Rados51
	 */
	final class Oxy_Grid_Layout {

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Oxy_Grid_Layout
		 */
		private static $instance;

		/**
		 * ONGRIDLAYOUT helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Oxy_Grid_Layout_Helpers
		 */
		public $helpers;

		/**
		 * ONGRIDLAYOUT settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Oxy_Grid_Layout_Settings
		 */
		public $settings;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'oxy-grid-layout' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'oxy-grid-layout' ), '1.0.0' );
		}

		/**
		 * Main Oxy_Grid_Layout Instance.
		 *
		 * Insures that only one instance of Oxy_Grid_Layout exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Oxy_Grid_Layout	The one true Oxy_Grid_Layout
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Oxy_Grid_Layout ) ) {
				self::$instance					= new Oxy_Grid_Layout;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers		= new Oxy_Grid_Layout_Helpers();
				self::$instance->settings		= new Oxy_Grid_Layout_Settings();

				//Fire the plugin logic
				new Oxy_Grid_Layout_Run();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				do_action( 'ONGRIDLAYOUT/plugin_loaded' );
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes() {
			require_once ONGRIDLAYOUT_PLUGIN_DIR . 'core/includes/classes/class-oxy-grid-layout-helpers.php';
			require_once ONGRIDLAYOUT_PLUGIN_DIR . 'core/includes/classes/class-oxy-grid-layout-settings.php';

			require_once ONGRIDLAYOUT_PLUGIN_DIR . 'core/includes/classes/class-oxy-grid-layout-run.php';
		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'oxy-grid-layout', FALSE, dirname( plugin_basename( ONGRIDLAYOUT_PLUGIN_FILE ) ) . '/languages/' );
		}

	}

endif; // End if class_exists check.
