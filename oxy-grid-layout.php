<?php
/**
 * OxyGridLayout
 *
 * @package       ONGRIDLAYOUT
 * @author        Rados51
 * @license       gplv3-or-later
 * @version       1.0.2
 *
 * @wordpress-plugin
 * Plugin Name:   OxyGridLayout by OxyNinja
 * Description:   Simple grid layout for Oxygen Builder. Similar as you can find in Adobe XD/Sketch/Figma.
 * Version:       1.0.2
 * Author:        OxyNinja
 * Author URI:    https://oxyninja.com
 * Text Domain:   oxy-grid-layout
 * Domain Path:   /languages
 * License:       GPLv3 or later
 * License URI:   https://www.gnu.org/licenses/gpl-3.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with OxyGridLayout. If not, see <https://www.gnu.org/licenses/gpl-3.0.html/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
// Plugin name
define( 'ONGRIDLAYOUT_NAME', 'OxyGridLayout' );

// Plugin version
define( 'ONGRIDLAYOUT_VERSION', '1.0.2' );

// Plugin Root File
define( 'ONGRIDLAYOUT_PLUGIN_FILE',	__FILE__ );

// Plugin base
define( 'ONGRIDLAYOUT_PLUGIN_BASE',	plugin_basename( ONGRIDLAYOUT_PLUGIN_FILE ) );

// Plugin Folder Path
define( 'ONGRIDLAYOUT_PLUGIN_DIR',	plugin_dir_path( ONGRIDLAYOUT_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'ONGRIDLAYOUT_PLUGIN_URL',	plugin_dir_url( ONGRIDLAYOUT_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once ONGRIDLAYOUT_PLUGIN_DIR . 'core/class-oxy-grid-layout.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  Rados51
 * @since   1.0.0
 * @return  object|Oxy_Grid_Layout
 */
function ONGRIDLAYOUT() {
	return Oxy_Grid_Layout::instance();
}

ONGRIDLAYOUT();
