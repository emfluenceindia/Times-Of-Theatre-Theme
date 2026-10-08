<?php
/**
 * Template part: page content.
 *
 * @package timesoftheatre
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-content' ); ?>>
	<header class="page-header">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</header>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'timesoftheatre' ) . '">',
				'after'  => '</nav>',
			)
		);
		?>
	</div>

	<?php
	edit_post_link(
		esc_html__( 'Edit', 'timesoftheatre' ),
		'<p class="edit-link">',
		'</p>'
	);
	?>
</article>
