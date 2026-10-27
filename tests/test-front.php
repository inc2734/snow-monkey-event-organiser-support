<?php
/**
 * Tests integration with Event Organiser and Snow Monkey.
 */
class FrontTest extends WP_UnitTestCase {

	/**
	 * The real dependencies must load before the integration can register its filters.
	 */
	public function test_integration_is_loaded() {
		$this->assertTrue( defined( 'EVENT_ORGANISER_VER' ) );
		$this->assertTrue( post_type_exists( 'event' ) );
		$this->assertSame( 'snow-monkey', get_template() );
		$this->assertTrue( class_exists( 'Framework\\Controller\\Controller' ) );
		$this->assertTrue(
			apply_filters(
				'inc2734_wp_view_controller_expand_get_template_part',
				false,
				array( 'slug' => 'templates/view/content', 'name' => 'event' )
			)
		);
		$this->assertTrue(
			apply_filters(
				'inc2734_wp_view_controller_expand_get_template_part',
				false,
				array( 'slug' => 'templates/view/archive', 'name' => 'event' )
			)
		);
	}

	/**
	 * Event queries must find the integration templates without duplicate roots.
	 */
	public function test_event_archive_template_hierarchy() {
		$this->go_to( get_post_type_archive_link( 'event' ) );
		$this->assertTrue( is_post_type_archive( 'event' ) );
		$root      = SNOW_MONKEY_EVENT_ORGANISER_SUPPORT_PATH . '/templates';
		$hierarchy = apply_filters( 'snow_monkey_template_part_root_hierarchy', array() );
		$this->assertContains( $root, $hierarchy );
		$hierarchy = apply_filters( 'snow_monkey_template_part_root_hierarchy', $hierarchy );
		$this->assertSame( 1, count( array_keys( $hierarchy, $root, true ) ) );
	}

	/**
	 * Ordinary posts must retain the original template roots and rendering mode.
	 */
	public function test_post_rendering_is_preserved() {
		$post_id = self::factory()->post->create();
		$this->go_to( get_permalink( $post_id ) );
		$this->assertNotContains(
			SNOW_MONKEY_EVENT_ORGANISER_SUPPORT_PATH . '/templates',
			apply_filters( 'snow_monkey_template_part_root_hierarchy', array() )
		);
		$this->assertSame( 'loop', apply_filters( 'inc2734_wp_view_controller_render_type', 'loop' ) );
	}

	/**
	 * Single events must use direct rendering and display their title and content.
	 */
	public function test_single_event_rendering() {
		$event_id = eo_insert_event(
			array(
				'post_status'  => 'publish',
				'post_title'   => 'Integration event title',
				'post_content' => 'Integration event description',
			),
			array(
				'start'    => new DateTime( '+1 day 12:00', eo_get_blog_timezone() ),
				'end'      => new DateTime( '+1 day 13:00', eo_get_blog_timezone() ),
				'schedule' => 'once',
			)
		);
		$this->assertNotWPError( $event_id );
		$this->go_to( get_permalink( $event_id ) );
		$this->assertTrue( is_singular( 'event' ) );
		$this->assertSame( 'direct', apply_filters( 'inc2734_wp_view_controller_render_type', 'loop' ) );
		wp_set_template_globals();
		ob_start();
		try {
			require SNOW_MONKEY_EVENT_ORGANISER_SUPPORT_PATH . '/templates/templates/view/content-event.php';
			$output = ob_get_contents();
		} finally {
			ob_end_clean();
		}
		$this->assertStringContainsString( 'Integration event title', $output );
		$this->assertStringContainsString( 'Integration event description', $output );
	}
}
