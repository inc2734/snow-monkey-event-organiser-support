<?php
/**
 * @package snow-monkey-event-organiser-support
 * @author inc2734
 * @license GPL-2.0+
 */

use Framework\Controller\Controller;

$default_layout = get_theme_mod( 'single-page-layout' );
$default_layout = $default_layout ? $default_layout : get_theme_mod( 'post-layout' );

$layout = get_theme_mod( 'event-layout' );
$layout = $layout ? $layout : $default_layout;

$content_view = get_theme_mod( 'event-view' );
$content_view = $content_view ? $content_view : 'event';

Controller::layout( $layout );
Controller::render( 'content', $content_view );
