<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Oxy_Grid_Layout_Run
 *
 * Thats where we bring the plugin to life
 *
 * @package		ONGRIDLAYOUT
 * @subpackage	Classes/Oxy_Grid_Layout_Run
 * @author		Rados51
 * @since		1.0.0
 */
class Oxy_Grid_Layout_Run{

	/**
	 * The options panel settings
	 *
	 * @since	1.0.0
	 * @var		array $options_panel The current options of the options panel
	 */
	private $options_panel;

	/**
	 * Our Oxy_Grid_Layout_Run constructor
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct(){
		$this->add_hooks();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOKS
	 * ###
	 * ######################
	 */

	/**
	 * Registers all WordPress and plugin related hooks
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function add_hooks(){

		add_action( 'oxygen_enqueue_ui_scripts', array( $this, 'enqueue_backend_scripts_and_styles' ), 20 );
		add_action( 'admin_menu', array( $this, 'register_custom_admin_menu_pages' ), 20 );
		add_action( 'admin_init', array( $this, 'register_custom_admin_options_panel' ), 20 );
		register_activation_hook( ONGRIDLAYOUT_PLUGIN_FILE, array( $this, 'activation_hook_callback' ) );

	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOK CALLBACKS
	 * ###
	 * ######################
	 */

	/**
	 * Enqueue the backend related scripts and styles for this plugin.
	 * All of the added scripts andstyles will be available on every page within the backend.
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function enqueue_backend_scripts_and_styles() {
		$options = get_option( 'oxy_grid_layout' );
        if ($options['spoustec']) {
            if ( defined('SHOW_CT_BUILDER') ) {
                wp_enqueue_style('ongridlayout', ONGRIDLAYOUT_PLUGIN_URL . 'core/includes/assets/css/backend-styles-min.css', [], ONGRIDLAYOUT_VERSION, 'all');
                wp_enqueue_script('ongridlayout', ONGRIDLAYOUT_PLUGIN_URL . 'core/includes/assets/js/backend-scripts-min.js', [], ONGRIDLAYOUT_VERSION, true);
				wp_localize_script('ongridlayout', 'ongridlayout', $options);
            }
        }
	}

	/**
	 * Add custom menu pages
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function register_custom_admin_menu_pages(){

		add_submenu_page( 'ct_dashboard_page', 'OxyGridLayout', 'OxyGridLayout', ONGRIDLAYOUT()->settings->get_capability( 'default' ), 'oxy-grid-layout', array( $this, 'custom_admin_menu_page_callback' ), 99 );

	}

	/**
	 * Add custom menu page content for the following
	 * menu item: oxy-grid-layout
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function custom_admin_menu_page_callback(){

		$this->options_panel = get_option( 'oxy_grid_layout' );

		?>
		<div class="wrap">
			<h1>OxyGridLayout</h1>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'oxy_grid_layout_settings_group' );
					do_settings_sections( 'custom-options-panel' );
					submit_button();
				?>
			</form>
			<script data-name="BMC-Widget" data-cfasync="false" src="https://cdnjs.buymeacoffee.com/1.0.0/widget.prod.min.js" data-id="rados" data-description="Support me on Buy me a coffee!" data-message="" data-color="#5F7FFF" data-position="Right" data-x_margin="18" data-y_margin="18">
			</script>
		</div>
		<?php
	}

	/**
	 * Register and add the settings
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function register_custom_admin_options_panel(){

		//Register the settings
		register_setting(
			'oxy_grid_layout_settings_group', //The option group
			'oxy_grid_layout', //The option name
			array( $this, 'sanitize_options_panel' )
		);

		//Add the settings section
		add_settings_section(
			'setting_section_id',
			__( 'Options Panel', 'oxy-grid-layout' ),
			array( $this, 'print_options_section' ),
			'custom-options-panel'
		);

		//Add all settings fields
		add_settings_field(
			'spoustec',
			__( 'Show grid layout toolbar?', 'oxy-grid-layout' ),
			array( $this, 'spoustec_callback' ),
			'custom-options-panel',
			'setting_section_id'
		);

		add_settings_field(
			'color',
			__( 'Main color of grid layout', 'oxy-grid-layout' ),
			array( $this, 'color_callback' ),
			'custom-options-panel',
			'setting_section_id'
		);

		add_settings_field(
			'width',
			__( 'Set default width in pixels. <br> If you set 1 or 100 it will be 100% on default.', 'oxy-grid-layout' ),
			array( $this, 'width_callback' ),
			'custom-options-panel',
			'setting_section_id'
		);

		add_settings_field(
			'zindex',
			__( 'Main z-index value', 'oxy-grid-layout' ),
			array( $this, 'zindex_callback' ),
			'custom-options-panel',
			'setting_section_id'
		);

		add_settings_field(
			'gap',
			__( 'Main grid layout gap in pixels', 'oxy-grid-layout' ),
			array( $this, 'gap_callback' ),
			'custom-options-panel',
			'setting_section_id'
		);
	}

	/**
	 * Sanitize the registered settings
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @param	array	$input Contains all settings fields
	 *
	 * @return	array	The sanitized $input fields
	 */
	public function sanitize_options_panel( $input ){

		if( isset( $input['spoustec'] ) ){
			$input['spoustec'] = settype( $input['spoustec'], 'boolean' );
		}

		if( isset( $input['color'] ) ){
			$input['color'] = sanitize_text_field( $input['color'] );
		}

		if( isset( $input['width'] ) ){
			$input['width'] = absint( $input['width'] );
		}

		if( isset( $input['zindex'] ) ){
			$input['zindex'] = absint( $input['zindex'] );
		}

		if( isset( $input['gap'] ) ){
			$input['gap'] = absint( $input['gap'] );
		}

		return $input;
	}

	/**
	 * Print the section text for the registered options section
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function print_options_section(){
		print __( 'Set your preferences so you can use it inside Oxygen Builder.', 'oxy-grid-layout' );
	}

	/**
	 * Print the content for the ON/OFF setting
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function spoustec_callback(){
		printf(
			'<input type="checkbox" id="spoustec" name="oxy_grid_layout[spoustec]" value="%1$s" %2$s />',
			isset( $this->options_panel['spoustec'] ) ? esc_attr( $this->options_panel['spoustec']) : '',
			checked( isset( $this->options_panel['spoustec'] ), true, false )
		);
	}

	/**
	 * Print the content for the color setting
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function color_callback(){
		printf(
			'<input type="color" id="barva" name="oxy_grid_layout[color]" value="%s" />',
			isset( $this->options_panel['color'] ) ? esc_attr( $this->options_panel['color']) : ''
		);
	}

	/**
	 * Print the content for the width setting
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function width_callback(){
		printf(
			'<input type="number" id="sirka" name="oxy_grid_layout[width]" value="%s" />',
			isset( $this->options_panel['width'] ) ? esc_attr( $this->options_panel['width']) : ''
		);
	}

	/**
	 * Print the content for the z-index setting
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function zindex_callback(){
		$options = isset( $this->options_panel['zindex'] ) ? esc_attr( $this->options_panel['zindex']) : '';
		?>
		<select name="oxy_grid_layout[zindex]">
			<option value="1" <?php selected( $this->options_panel['zindex'], 1 ); ?>>-1</option>
			<option value="0" <?php selected( $this->options_panel['zindex'], 0 ); ?>>0</option>
		</select>
		<?php
	}

	/**
	 * Print the content for the gap setting
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function gap_callback(){
		printf(
			'<input type="number" id="gap" name="oxy_grid_layout[gap]" value="%s" />',
			isset( $this->options_panel['gap'] ) ? esc_attr( $this->options_panel['gap']) : ''
		);
	}



	/**
	 * Print the content for the title_example setting
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function title_example_callback(){
		printf(
			'<input type="text" id="title_example" name="oxy_grid_layout[title_example]" value="%s" />',
			isset( $this->options_panel['title_example'] ) ? esc_attr( $this->options_panel['title_example']) : ''
		);
	}

	/**
	 * Print the content for the number_example setting
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function number_example_callback(){
		printf(
			'<input type="number" id="number_example" name="oxy_grid_layout[number_example]" value="%s" />',
			isset( $this->options_panel['number_example'] ) ? esc_attr( $this->options_panel['number_example']) : ''
		);
	}

	/**
	 * ####################
	 * ### Activation hook
	 * ####################
	 */

	/*
	 * This function is called on activation of the plugin
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function activation_hook_callback(){

		$default = array (
			'spoustec' => true,
			'color' => '#12d997',
			'zindex' => 0,
			'width' => 100,
			'gap' => 15,
		);

		if( Oxy_Grid_Layout_Helpers::network_active() ) {
			if( ! get_site_option('oxy_grid_layout') ){
				update_site_option( 'oxy_grid_layout', $default );
			}
		} else {
			if( ! get_option('oxy_grid_layout') ){
				update_option( 'oxy_grid_layout', $default );
			}
		}
	}

}
