<?php
/**
 * @package snow-monkey-event-organiser-support
 * @author inc2734
 * @license GPL-2.0+
 */

use Framework\Controller\Controller;

$default_layout = get_theme_mod( 'archive-post-layout' );

$layout = get_theme_mod( 'archive-event-layout' );
$layout = $layout ? $layout : $default_layout;

Controller::layout( $layout );
if ( have_posts() ) {
	$archive_view = get_theme_mod( 'event-archive-view' );
	$archive_view = $archive_view ? $archive_view : 'event';

	Controller::render( 'archive', $archive_view );
} else {
	Controller::render( 'none' );
}
