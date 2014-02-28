<?php
/*
Template Name: Grid 10x10
*/

get_header(); 

?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
<div class="grid-10x10">
	<table>
		<tbody>
<?php
	for ($l = 0; $l < 10; $l++) {
		echo '<tr>';
		for ($c = 0; $c < 10; $c++) {
			echo '<td>';
			echo '<div class="cell"></div>';
			echo '</td>';
		}
		echo '</tr>';
	}
?>
		</tbody>
	</table>
</div>
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					get_template_part( 'content', 'page' );
				?>

			<?php endwhile; ?>


		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

