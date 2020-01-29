<?php
/**
 * @package snow-monkey-event-organiser-support
 * @author inc2734
 * @license GPL-2.0+
 *
 * @see https://github.com/stephenharris/Event-Organiser/blob/develop/templates/single-event.php
 */
?>

<div id="primary">
	<div id="content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header class="entry-header">

				<!-- Display event title -->
				<h1 class="entry-title"><?php the_title(); ?></h1>

			</header><!-- .entry-header -->

			<div class="entry-content">
				<!-- Get event information, see template: event-meta-event-single.php -->
				<?php eo_get_template_part( 'event-meta', 'event-single' ); ?>

				<!-- The content or the description of the event-->
				<?php the_content(); ?>
			</div><!-- .entry-content -->

			<footer class="entry-meta">
			<?php
			//Events have their own 'event-category' taxonomy. Get list of categories this event is in.
			$categories_list = get_the_term_list( get_the_ID(), 'event-category', '', ', ','' );

			if ( '' != $categories_list ) {
				$utility_text = __( 'This event was posted in %1$s by <a href="%3$s">%2$s</a>.', 'eventorganiser' );
			} else {
				$utility_text = __( 'This event was posted by <a href="%3$s">%2$s</a>.', 'eventorganiser' );
			}
			printf($utility_text,
				$categories_list,
				get_the_author(),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
			);
			?>

			<?php edit_post_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-meta -->

			</article><!-- #post-<?php the_ID(); ?> -->

			<!-- If comments are enabled, show them -->
			<div class="comments-template">
				<?php comments_template(); ?>
			</div>

		<?php endwhile; // end of the loop. ?>

	</div><!-- #content -->
</div><!-- #primary -->
