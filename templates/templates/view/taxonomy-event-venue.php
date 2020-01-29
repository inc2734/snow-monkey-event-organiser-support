<?php
/**
 * @package snow-monkey-event-organiser-support
 * @author inc2734
 * @license GPL-2.0+
 *
 * @see https://github.com/stephenharris/Event-Organiser/blob/develop/templates/taxonomy-event-venue.php
 */
?>

<div id="primary" role="main" class="content-area">

	<!-- Page header, display venue title-->
	<header class="page-header">

		<?php $venue_id = get_queried_object_id(); ?>

		<h1 class="page-title">
			<?php printf( __( 'Events at: %s', 'eventorganiser' ), '<span>' . eo_get_venue_name( $venue_id ) . '</span>' );?>
		</h1>

		<?php
		if ( $venue_description = eo_get_venue_description( $venue_id ) ) {
			echo '<div class="venue-archive-meta">' . $venue_description . '</div>';
		}
		?>

		<!-- Display the venue map. If you specify a class, ensure that class has height/width dimensions-->
		<?php
		if ( eo_venue_has_latlng( $venue_id ) ) {
			echo eo_get_venue_map( $venue_id, array( 'width' => '100%' ) );
		}
		?>

	</header>

	<?php eo_get_template_part( 'eo-loop-events' ); //Lists the events ?>

</div><!-- #primary -->
