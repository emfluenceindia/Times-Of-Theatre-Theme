<?php
/**
 * The front page template.
 *
 * Hero carousel, quick links, What We Do, a wide image band and Explore.
 * Used for the site front page whatever the Reading settings are, so the
 * homepage never renders the posts loop as its main content.
 *
 * All images are editable in Appearance > Customize > Homepage Images
 * (see inc/home-images.php).
 *
 * @package timesoftheatre
 */

get_header();

$timesoftheatre_slides = array(
	array(
		'image'    => 'hero-1',
		'title'    => __( 'Times of Theatre', 'timesoftheatre' ),
		'subtitle' => __( 'A Kolkata-based cultural platform dedicated to drama, audio theatre and performance arts.', 'timesoftheatre' ),
		'label'    => __( 'About TOT', 'timesoftheatre' ),
		'url'      => timesoftheatre_page_url( 'about-tot' ),
	),
	array(
		'image'    => 'hero-2',
		'title'    => __( 'TOT Radio & Audio Theatre', 'timesoftheatre' ),
		'subtitle' => __( 'Audio dramas, radio plays, audio biographies and video podcasts on digital platforms like YouTube.', 'timesoftheatre' ),
		'label'    => __( 'TOT on YouTube', 'timesoftheatre' ),
		'url'      => timesoftheatre_page_url( 'tot-on-youtube' ),
	),
	array(
		'image'    => 'hero-3',
		'title'    => __( 'TOT School of Drama', 'timesoftheatre' ),
		'subtitle' => __( 'Short-term and certificate courses, with masterclasses on voice acting, microphone techniques and stage performance.', 'timesoftheatre' ),
		'label'    => __( 'Academics & Admissions', 'timesoftheatre' ),
		'url'      => timesoftheatre_page_url( 'tot-school-of-drama/academics-admissions' ),
	),
);

$timesoftheatre_actions = array(
	array(
		'image' => 'quick-school',
		'icon'  => 'fa-solid fa-graduation-cap',
		'title' => __( 'TOT School of Drama', 'timesoftheatre' ),
		'label' => __( 'Explore the School', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'tot-school-of-drama/about-the-school' ),
	),
	array(
		'image' => 'quick-space',
		'icon'  => 'fa-solid fa-landmark',
		'title' => __( 'The TOT Space', 'timesoftheatre' ),
		'label' => __( 'Explore the Space', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'the-tot-space' ),
	),
	array(
		'image' => 'quick-studio',
		'icon'  => 'fa-solid fa-microphone-lines',
		'title' => __( 'The TOT Studio', 'timesoftheatre' ),
		'label' => __( 'Explore the Studio', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'the-tot-studio' ),
	),
);

// Each "What We Do" card links to its paragraph in About TOT > Our Work.
$timesoftheatre_about = timesoftheatre_page_url( 'about-tot' );

$timesoftheatre_initiatives = array(
	array(
		'image' => 'what-radio',
		'icon'  => 'fa-solid fa-radio',
		'title' => __( 'TOT Radio & Audio Theatre', 'timesoftheatre' ),
		'text'  => __( 'Audio dramas, radio plays, audio biographies and video podcasts such as TOTCast, distributed on digital platforms like YouTube.', 'timesoftheatre' ),
		'url'   => $timesoftheatre_about . '#tot-radio-audio-theatre',
	),
	array(
		'image' => 'what-school',
		'icon'  => 'fa-solid fa-graduation-cap',
		'title' => __( 'TOT School of Drama', 'timesoftheatre' ),
		'text'  => __( 'Short-term and certificate courses, including masterclasses on voice acting, microphone techniques, audio drama and stage performance.', 'timesoftheatre' ),
		'url'   => $timesoftheatre_about . '#tot-school-of-drama',
	),
	array(
		'image' => 'what-club',
		'icon'  => 'fa-solid fa-users',
		'title' => __( 'TOT Radio Drama Club', 'timesoftheatre' ),
		'text'  => __( 'A community platform for emerging actors and voice artists to take part in recorded audio plays.', 'timesoftheatre' ),
		'url'   => $timesoftheatre_about . '#tot-radio-drama-club',
	),
	array(
		'image' => 'what-events',
		'icon'  => 'fa-solid fa-trophy',
		'title' => __( 'Events & Competitions', 'timesoftheatre' ),
		'text'  => __( 'Regional talent programmes such as the Sara Bangla Shruti Natok Competition, the All-Bengal Audio Drama Competition, and career-focused workshops for artists.', 'timesoftheatre' ),
		'url'   => $timesoftheatre_about . '#events-competitions',
	),
);

$timesoftheatre_explore = array(
	array(
		'image' => 'explore-about',
		'icon'  => 'fa-solid fa-masks-theater',
		'title' => __( 'About TOT', 'timesoftheatre' ),
		'text'  => __( 'Who we are, our vision, our work and our mentors.', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'about-tot' ),
	),
	array(
		'image' => 'explore-school',
		'icon'  => 'fa-solid fa-graduation-cap',
		'title' => __( 'TOT School of Drama', 'timesoftheatre' ),
		'text'  => __( 'Courses, masterclasses and student performances.', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'tot-school-of-drama/about-the-school' ),
	),
	array(
		'image' => 'explore-space',
		'icon'  => 'fa-solid fa-landmark',
		'title' => __( 'The TOT Space', 'timesoftheatre' ),
		'text'  => __( 'Facilities, seating and booking enquiries.', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'the-tot-space' ),
	),
	array(
		'image' => 'explore-studio',
		'icon'  => 'fa-solid fa-microphone-lines',
		'title' => __( 'The TOT Studio', 'timesoftheatre' ),
		'text'  => __( 'Audio recording, dubbing and equipment.', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'the-tot-studio' ),
	),
	array(
		'image' => 'explore-workshops',
		'icon'  => 'fa-solid fa-chalkboard-user',
		'title' => __( 'Workshops', 'timesoftheatre' ),
		'text'  => __( 'Upcoming and past workshops, details and registration.', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'workshops/upcoming-workshops' ),
	),
	array(
		'image' => 'explore-youtube',
		'icon'  => 'fa-brands fa-youtube',
		'title' => __( 'TOT on YouTube', 'timesoftheatre' ),
		'text'  => __( 'TOT Originals and videos by students and club members.', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'tot-on-youtube' ),
	),
	array(
		'image' => 'explore-gallery',
		'icon'  => 'fa-solid fa-images',
		'title' => __( 'Gallery', 'timesoftheatre' ),
		'text'  => __( 'Photographs from workshops, programmes and performances.', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'gallery/workshop-gallery' ),
	),
	array(
		'image' => 'explore-contact',
		'icon'  => 'fa-solid fa-envelope',
		'title' => __( 'Contact', 'timesoftheatre' ),
		'text'  => __( 'Get in touch with the TOT team.', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'contact' ),
	),
);

$timesoftheatre_band_text = get_theme_mod( 'tot_band_text', timesoftheatre_band_text_default() );
?>

<main id="primary" class="site-main front-page">

	<section class="hero-carousel" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Featured', 'timesoftheatre' ); ?>">
		<?php foreach ( $timesoftheatre_slides as $timesoftheatre_index => $timesoftheatre_slide ) : ?>
			<div class="carousel-slide<?php echo 0 === $timesoftheatre_index ? ' active' : ''; ?>" role="group" aria-roledescription="slide">
				<?php
				echo timesoftheatre_home_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in helper.
					$timesoftheatre_slide['image'],
					array(
						'class'         => 'slide-image',
						// Hidden slides never trigger lazy loading, so load them normally at low priority.
						'loading'       => 'eager',
						'decoding'      => '',
						'fetchpriority' => 0 === $timesoftheatre_index ? 'high' : 'low',
					)
				);
				?>
				<div class="hero-content">
					<?php if ( 0 === $timesoftheatre_index ) : ?>
						<h1 class="hero-title"><?php echo esc_html( $timesoftheatre_slide['title'] ); ?></h1>
					<?php else : ?>
						<h2 class="hero-title"><?php echo esc_html( $timesoftheatre_slide['title'] ); ?></h2>
					<?php endif; ?>
					<p class="hero-subtitle"><?php echo esc_html( $timesoftheatre_slide['subtitle'] ); ?></p>
					<?php if ( $timesoftheatre_slide['url'] ) : ?>
						<a class="btn-primary" href="<?php echo esc_url( $timesoftheatre_slide['url'] ); ?>"><?php echo esc_html( $timesoftheatre_slide['label'] ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>

		<div class="carousel-controls">
			<?php foreach ( $timesoftheatre_slides as $timesoftheatre_index => $timesoftheatre_slide ) : ?>
				<button type="button" class="carousel-dot<?php echo 0 === $timesoftheatre_index ? ' active' : ''; ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: slide number. */ __( 'Show slide %d', 'timesoftheatre' ), $timesoftheatre_index + 1 ) ); ?>"></button>
			<?php endforeach; ?>
		</div>
	</section>

	<div class="tot-wrap">
		<section class="quick-actions" aria-label="<?php esc_attr_e( 'Quick links', 'timesoftheatre' ); ?>">
			<?php foreach ( $timesoftheatre_actions as $timesoftheatre_action ) : ?>
				<div class="action-card">
					<?php
					echo timesoftheatre_home_image( $timesoftheatre_action['image'], array( 'class' => 'action-bg' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in helper.
					?>
					<div class="action-body">
						<div class="action-icon"><i class="<?php echo esc_attr( $timesoftheatre_action['icon'] ); ?>" aria-hidden="true"></i></div>
						<h2 class="action-title"><?php echo esc_html( $timesoftheatre_action['title'] ); ?></h2>
						<?php if ( $timesoftheatre_action['url'] ) : ?>
							<a class="btn-primary" href="<?php echo esc_url( $timesoftheatre_action['url'] ); ?>"><?php echo esc_html( $timesoftheatre_action['label'] ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</section>
	</div>

	<section class="home-band home-band--light" aria-labelledby="initiatives-heading">
		<div class="tot-wrap">
			<h2 id="initiatives-heading" class="section-title"><?php esc_html_e( 'What We Do', 'timesoftheatre' ); ?></h2>
			<div class="featured-grid">
				<?php foreach ( $timesoftheatre_initiatives as $timesoftheatre_item ) : ?>
					<a class="featured-card" href="<?php echo esc_url( $timesoftheatre_item['url'] ); ?>">
						<?php
						echo timesoftheatre_home_image( $timesoftheatre_item['image'], array( 'class' => 'card-image' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in helper.
						?>
						<div class="card-content">
							<div class="action-icon"><i class="<?php echo esc_attr( $timesoftheatre_item['icon'] ); ?>" aria-hidden="true"></i></div>
							<h3 class="card-title"><?php echo esc_html( $timesoftheatre_item['title'] ); ?></h3>
							<p class="card-description"><?php echo esc_html( $timesoftheatre_item['text'] ); ?></p>
							<span class="card-link"><?php esc_html_e( 'Read more', 'timesoftheatre' ); ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></span>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php if ( $timesoftheatre_band_text ) : ?>
		<section class="home-feature" aria-label="<?php esc_attr_e( 'Times of Theatre', 'timesoftheatre' ); ?>">
			<?php
			echo timesoftheatre_home_image( 'band', array( 'class' => 'feature-bg' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in helper.
			?>
			<p class="feature-text"><?php echo esc_html( $timesoftheatre_band_text ); ?></p>
		</section>
	<?php endif; ?>

	<section class="home-band home-band--yellow" aria-labelledby="explore-heading">
		<div class="tot-wrap">
			<h2 id="explore-heading" class="section-title"><?php esc_html_e( 'Explore', 'timesoftheatre' ); ?></h2>
			<div class="categories-grid">
				<?php foreach ( $timesoftheatre_explore as $timesoftheatre_item ) : ?>
					<?php if ( $timesoftheatre_item['url'] ) : ?>
						<a class="category-card" href="<?php echo esc_url( $timesoftheatre_item['url'] ); ?>">
							<?php
							echo timesoftheatre_home_image( $timesoftheatre_item['image'], array( 'class' => 'card-image' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in helper.
							?>
							<div class="category-body">
								<div class="category-icon"><i class="<?php echo esc_attr( $timesoftheatre_item['icon'] ); ?>" aria-hidden="true"></i></div>
								<h3 class="category-name"><?php echo esc_html( $timesoftheatre_item['title'] ); ?></h3>
								<p class="category-desc"><?php echo esc_html( $timesoftheatre_item['text'] ); ?></p>
							</div>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
