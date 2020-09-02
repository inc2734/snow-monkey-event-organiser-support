<?php
/**
 * Plugin name: Snow Monkey Event Organiser Integrator
 * Description: With this plugin, Snow Monkey can use Event Organiser plugin.
 * Version: 0.2.1
 * Tested up to: 5.5
 * Requires at least: 5.5
 * Requires PHP: 5.6
 * Author: inc2734
 * Author URI: https://2inc.org
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: snow-monkey-event-organiser-support
 *
 * @package snow-monkey-event-organiser-support
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Snow_Monkey\Plugin\EventOrganiserSupport;

use Snow_Monkey\Plugin\EventOrganiserSupport\App\Controller;
use Framework\Helper;
use Inc2734\WP_GitHub_Plugin_Updater\Bootstrap as Updater;

define( 'SNOW_MONKEY_EVENT_ORGANISER_SUPPORT_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'SNOW_MONKEY_EVENT_ORGANISER_SUPPORT_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

class Bootstrap {

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, '_plugins_loaded' ] );
	}

	public function _plugins_loaded() {
		load_plugin_textdomain( 'snow-monkey-event-organiser-support', false, basename( __DIR__ ) . '/languages' );

		add_action( 'init', [ $this, '_activate_autoupdate' ] );

		$theme = wp_get_theme( get_template() );
		if ( 'snow-monkey' !== $theme->template && 'snow-monkey/resources' !== $theme->template ) {
			return;
		}

		if ( ! defined( 'EVENT_ORGANISER_VER' ) ) {
			return;
		}

		add_action(
			'after_setup_theme',
			function() {
				new Controller\Front();
			}
		);
	}

	public function _activate_autoupdate() {
		new Updater(
			plugin_basename( __FILE__ ),
			'inc2734',
			'snow-monkey-event-organiser-support',
			[
				'homepage' => 'https://snow-monkey.2inc.org',
			]
		);
	}
}

require_once( SNOW_MONKEY_EVENT_ORGANISER_SUPPORT_PATH . '/vendor/autoload.php' );
new Bootstrap();
