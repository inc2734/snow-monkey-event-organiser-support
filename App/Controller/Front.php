<?php
/**
 * @package snow-monkey-event-organiser-support
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Snow_Monkey\Plugin\EventOrganiserSupport\App\Controller;

class Front {

	public function __construct() {
		add_filter( 'eventorganiser_template_stack', [ $this, '_eventorganiser_template_stack' ] );
		add_filter( 'snow_monkey_template_part_root_hierarchy', [ $this, '_snow_monkey_template_part_root_hierarchy' ], 10, 3 );
		add_filter( 'inc2734_wp_view_controller_render_type', [ $this, '_inc2734_wp_view_controller_render_type' ] );
	}

	public function _eventorganiser_template_stack( $stack ) {
		return $stack;
	}

	public function _snow_monkey_template_part_root_hierarchy( $hierarchy, $slug, $name ) {
		global $wp_query;
		$post_type = $wp_query->get( 'post_type' );

		if ( 'event' === $post_type ) {
			$hierarchy[] = SNOW_MONKEY_EVENT_ORGANISER_SUPPORT_PATH . '/templates';
			$hierarchy   = array_unique( $hierarchy );
		}

		return $hierarchy;
	}

	public function _inc2734_wp_view_controller_render_type( $render_type ) {
		if ( ! is_singular( 'event' ) ) {
			return $render_type;
		}
		return 'direct';
	}
}
