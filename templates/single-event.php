<?php
/**
 * @package snow-monkey-event-organiser-support
 * @author inc2734
 * @license GPL-2.0+
 */

use Framework\Controller\Controller;

Controller::layout( get_theme_mod( 'single-page-layout' ) );
Controller::render( 'content', 'event' );
