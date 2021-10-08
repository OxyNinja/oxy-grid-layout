<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Oxy_Grid_Layout_Helpers
 *
 * This class contains repetitive functions that
 * are used globally within the plugin.
 *
 * @package		ONGRIDLAYOUT
 * @subpackage	Classes/Oxy_Grid_Layout_Helpers
 * @author		Rados51
 * @since		1.0.0
 */
class Oxy_Grid_Layout_Helpers{

	/**
	 * ######################
	 * ###
	 * #### CALLABLE FUNCTIONS
	 * ###
	 * ######################
	 */

	static public function network_active() {
		if (is_plugin_active_for_network('oxy-grid-layout/oxy-grid-layout.php')) {
			return true;
		} else {
			return false;
		}
	}
}
