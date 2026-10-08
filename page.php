<?php
/**
 * The template for displaying pages.
 *
 * Pages that are sub-items of the primary menu use a two-column layout: the
 * left column lists the sub-items of their menu parent (sections or sibling
 * pages); on mobile it becomes a drawer. Any other page is a single column.
 *
 * @package timesoftheatre
 */

get_header();

$timesoftheatre_menu = timesoftheatre_section_menu();
?>

<main id="primary" class="site-main">
	<div class="tot-wrap page-layout<?php echo $timesoftheatre_menu ? ' page-layout--with-nav' : ''; ?>">
		<?php
		while ( have_posts() ) :
			the_post();

			if ( $timesoftheatre_menu ) :
				?>
				<div class="row">
					<div class="col-md-3">
						<?php get_template_part( 'template-parts/section-nav', null, $timesoftheatre_menu ); ?>
					</div>
					<div class="col-md-9">
						<?php get_template_part( 'template-parts/content', 'page' ); ?>
					</div>
				</div>
				<?php
			else :
				get_template_part( 'template-parts/content', 'page' );
			endif;

			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
