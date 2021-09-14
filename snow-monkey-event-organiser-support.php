<?php
/**
 * Plugin name: Snow Monkey Event Organiser Integrator
 * Description: With this plugin, Snow Monkey can use Event Organiser plugin.
 * Version: 0.4.0
 * Tested up to: 5.7
 * Requires at least: 5.7
 * Requires PHP: 5.6
 * Requires Snow Monkey: 14.0.0
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

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, '_plugins_loaded' ] );
	}

	/**
	 * Plugins loaded.
	 */
	public function _plugins_loaded() {
		load_plugin_textdomain(
			'snow-monkey-event-organiser-support',
			false,
			basename( __DIR__ ) . '/languages'
		);

		add_action( 'init', [ $this, '_activate_autoupdate' ] );

		$theme = wp_get_theme( get_template() );
		if ( 'snow-monkey' !== $theme->template && 'snow-monkey/resources' !== $theme->template ) {
			add_action(
				'admin_notices',
				function() {
					?>
					<div class="notice notice-warning is-dismissible">
						<p>
							<?php esc_html_e( '[Snow Monkey Event Organiser Integrator] Needs the Snow Monkey.', 'snow-monkey-event-organiser-support' ); ?>
						</p>
					</div>
					<?php
				}
			);
			return;
		}

		$data = get_file_data(
			__FILE__,
			[
				'RequiresSnowMonkey' => 'Requires Snow Monkey',
			]
		);

		if (
			isset( $data['RequiresSnowMonkey'] ) &&
			version_compare( $theme->get( 'Version' ), $data['RequiresSnowMonkey'], '<' )
		) {
			add_action(
				'admin_notices',
				function() use ( $data ) {
					?>
					<div class="notice notice-warning is-dismissible">
						<p>
							<?php
							echo esc_html(
								sprintf(
									// translators: %1$s: version
									__(
										'[Snow Monkey Event Organiser Integrator] Needs the Snow Monkey %1$s or more.',
										'snow-monkey-event-organiser-support'
									),
									'v' . $data['RequiresSnowMonkey']
								)
							);
							?>
						</p>
					</div>
					<?php
				}
			);
			return;
		}

		if ( ! defined( 'EVENT_ORGANISER_VER' ) ) {
			add_action(
				'admin_notices',
				function() {
					?>
					<div class="notice notice-warning is-dismissible">
						<p>
							<?php esc_html_e( '[Snow Monkey Event Organiser Integrator] Needs the Event Organiser.', 'snow-monkey-event-organiser-support' ); ?>
						</p>
					</div>
					<?php
				}
			);
			return;
		}

		add_action(
			'after_setup_theme',
			function() {
				new Controller\Front();
			}
		);
	}

	/**
	 * Updater.
	 */
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
