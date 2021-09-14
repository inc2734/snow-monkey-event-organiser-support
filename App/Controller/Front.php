<?php
/**
 * @package snow-monkey-event-organiser-support
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Snow_Monkey\Plugin\EventOrganiserSupport\App\Controller;

class Front {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter(
			'eventorganiser_template_stack',
			[ $this, '_eventorganiser_template_stack' ]
		);

		add_filter(
			'inc2734_wp_view_controller_expand_get_template_part',
			[ $this, '_expand_get_template_part' ],
			11,
			2
		);

		add_filter(
			'snow_monkey_template_part_root_hierarchy',
			[ $this, '_snow_monkey_template_part_root_hierarchy' ]
		);

		add_filter(
			'inc2734_wp_view_controller_render_type',
			[ $this, '_inc2734_wp_view_controller_render_type' ]
		);
	}

	/**
	 * Filters the template stack: an array of directories the plug-in looks for for templates.
	 *
	 * @param array $stack Array of directories (absolute path).
	 * @return array
	 */
	public function _eventorganiser_template_stack( $stack ) {
		return $stack;
	}

	/**
	 * Expand get_template_part().
	 *
	 * @param boolean $expand If true, expand get_template_part().
	 * @param array   $args   The template part args.
	 * @return boolean
	 */
	public function _expand_get_template_part( $expand, $args ) {
		if (
			'templates/view/content' === $args['slug'] && 'event' === $args['name']
			|| 'templates/view/archive' === $args['slug'] && 'event' === $args['name']
		) {
			return true;
		}
		return $expand;
	}

	/**
	 * Add template part root hierarchy.
	 *
	 * @param array $hierarchy Array of template part root hierarchy.
	 * @return array
	 */
	public function _snow_monkey_template_part_root_hierarchy( $hierarchy ) {
		global $wp_query;
		$post_type = $wp_query->get( 'post_type' );

		if ( 'event' === $post_type ) {
			$hierarchy[] = SNOW_MONKEY_EVENT_ORGANISER_SUPPORT_PATH . '/templates';
			$hierarchy   = array_unique( $hierarchy );
		}

		return $hierarchy;
	}

	/**
	 * Change rendered type.
	 *
	 * @param boolean $render_type "direct" or "loop".
	 */
	public function _inc2734_wp_view_controller_render_type( $render_type ) {
		if ( ! is_singular( 'event' ) ) {
			return $render_type;
		}
		return 'direct';
	}
}
