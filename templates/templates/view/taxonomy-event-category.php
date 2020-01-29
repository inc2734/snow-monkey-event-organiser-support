<?php
/**
 * @package snow-monkey-event-organiser-support
 * @author inc2734
 * @license GPL-2.0+
 *
 * @see https://github.com/stephenharris/Event-Organiser/blob/develop/templates/taxonomy-event-category.php
 */
?>

<div id="primary" role="main" class="content-area">

	<!-- Page header, display category title-->
	<header class="page-header">
		<h1 class="page-title">
			<?php printf( __( 'Event Category: %s', 'eventorganiser' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
		</h1>

		<!-- If the category has a description display it-->
		<?php
		$category_description = category_description();
		if ( ! empty( $category_description ) ) {
			echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
		}
		?>
	</header>

	<?php eo_get_template_part( 'eo-loop-events' ); //Lists the events ?>

</div><!-- #primary -->
