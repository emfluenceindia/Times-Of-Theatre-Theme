<?php
/**
 * The main template file.
 *
 * Fallback for every view that has no more specific template.
 *
 * @package timesoftheatre
 */

get_header();
?>

<main id="primary" class="site-main container">

	<?php if ( have_posts() ) : ?>

		<?php if ( is_home() && ! is_front_page() ) : ?>
			<header class="page-header">
				<h1 class="section-title"><?php single_post_title(); ?></h1>
			</header>
		<?php endif; ?>

		<div class="news-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'news-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
							<?php the_post_thumbnail( 'medium_large', array( 'class' => 'news-thumbnail' ) ); ?>
						</a>
					<?php endif; ?>
					<div class="news-content">
						<p class="news-date"><?php echo esc_html( get_the_date() ); ?></p>
						<h2 class="news-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<div class="card-description">
							<?php the_excerpt(); ?>
						</div>
					</div>
				</article>
				<?php
			endwhile;
			?>
		</div>

		<?php
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => esc_html__( 'Previous', 'timesoftheatre' ),
				'next_text' => esc_html__( 'Next', 'timesoftheatre' ),
			)
		);
		?>

	<?php else : ?>

		<section class="no-results not-found">
			<h1 class="section-title"><?php esc_html_e( 'Nothing found', 'timesoftheatre' ); ?></h1>
			<p class="about-text"><?php esc_html_e( 'It seems we cannot find what you are looking for. Perhaps searching can help.', 'timesoftheatre' ); ?></p>
			<?php get_search_form(); ?>
		</section>

	<?php endif; ?>

</main>

<?php
get_footer();
