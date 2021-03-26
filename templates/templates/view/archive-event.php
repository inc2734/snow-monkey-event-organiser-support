<?php
/**
 * @package snow-monkey-event-organiser-support
 * @author inc2734
 * @license GPL-2.0+
 *
 * @see https://github.com/stephenharris/Event-Organiser/blob/develop/templates/archive-event.php
 */
?>

<div id="primary" role="main" class="content-area">

	<!-- Page header-->
	<header class="page-header">
		<h1 class="page-title">
		<?php
		if ( eo_is_event_archive( 'day' ) ) {
			// Viewing date archive
			// phpcs:disable WordPress.WP.I18n.TextDomainMismatch
			echo __( 'Events: ', 'eventorganiser' ) . ' ' . eo_get_event_archive_date( 'jS F Y' );
			// phpcs:enable
		} elseif ( eo_is_event_archive( 'month' ) ) {
			// Viewing month archive
			// phpcs:disable WordPress.WP.I18n.TextDomainMismatch
			echo __( 'Events: ', 'eventorganiser' ) . ' ' . eo_get_event_archive_date( 'F Y' );
			// phpcs:enable
		} elseif ( eo_is_event_archive( 'year' ) ) {
			// Viewing year archive
			// phpcs:disable WordPress.WP.I18n.TextDomainMismatch
			echo __( 'Events: ', 'eventorganiser' ) . ' ' . eo_get_event_archive_date( 'Y' );
			// phpcs:enable
		} else {
			// phpcs:disable WordPress.WP.I18n.TextDomainMismatch
			_e( 'Events', 'eventorganiser' );
			// phpcs:enable
		}
		?>
		</h1>
	</header>

	<?php eo_get_template_part( 'eo-loop-events' ); // Lists the events ?>

</div><!-- #primary -->
