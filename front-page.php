<?php
/**
 * The front page template.
 *
 * Hero carousel, quick actions, about, what we do, explore and latest news.
 * Used for the site front page whatever the Reading settings are, so the
 * homepage never renders the posts loop as its main content.
 *
 * @package timesoftheatre
 */

get_header();

$timesoftheatre_img = get_template_directory_uri() . '/assets/images/hero/';

$timesoftheatre_slides = array(
	array(
		'image'    => $timesoftheatre_img . 'hero-stage.jpg',
		'title'    => __( 'Times of Theatre', 'timesoftheatre' ),
		'subtitle' => __( 'A Kolkata-based cultural platform dedicated to drama, audio theatre and performance arts.', 'timesoftheatre' ),
		'label'    => __( 'About TOT', 'timesoftheatre' ),
		'url'      => timesoftheatre_page_url( 'about-tot' ),
	),
	array(
		'image'    => $timesoftheatre_img . 'hero-audio.jpg',
		'title'    => __( 'TOT Radio & Audio Theatre', 'timesoftheatre' ),
		'subtitle' => __( 'Audio dramas, radio plays, audio biographies and video podcasts on digital platforms like YouTube.', 'timesoftheatre' ),
		'label'    => __( 'TOT on YouTube', 'timesoftheatre' ),
		'url'      => timesoftheatre_page_url( 'tot-on-youtube' ),
	),
	array(
		'image'    => $timesoftheatre_img . 'hero-school.jpg',
		'title'    => __( 'TOT School of Drama', 'timesoftheatre' ),
		'subtitle' => __( 'Short-term and certificate courses, with masterclasses on voice acting, microphone techniques and stage performance.', 'timesoftheatre' ),
		'label'    => __( 'Academics & Admissions', 'timesoftheatre' ),
		'url'      => timesoftheatre_page_url( 'tot-school-of-drama/academics-admissions' ),
	),
);

$timesoftheatre_actions = array(
	array(
		'icon'  => 'fa-solid fa-graduation-cap',
		'title' => __( 'TOT School of Drama', 'timesoftheatre' ),
		'label' => __( 'Explore the School', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'tot-school-of-drama/about-the-school' ),
	),
	array(
		'icon'  => 'fa-solid fa-landmark',
		'title' => __( 'The TOT Space', 'timesoftheatre' ),
		'label' => __( 'Explore the Space', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'the-tot-space' ),
	),
	array(
		'icon'  => 'fa-solid fa-microphone-lines',
		'title' => __( 'The TOT Studio', 'timesoftheatre' ),
		'label' => __( 'Explore the Studio', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'the-tot-studio' ),
	),
);

$timesoftheatre_initiatives = array(
	array(
		'icon'  => 'fa-solid fa-radio',
		'title' => __( 'TOT Radio & Audio Theatre', 'timesoftheatre' ),
		'text'  => __( 'Audio dramas, radio plays, audio biographies and video podcasts such as TOTCast, distributed on digital platforms like YouTube.', 'timesoftheatre' ),
	),
	array(
		'icon'  => 'fa-solid fa-graduation-cap',
		'title' => __( 'TOT School of Drama', 'timesoftheatre' ),
		'text'  => __( 'Short-term and certificate courses, including masterclasses on voice acting, microphone techniques, audio drama and stage performance.', 'timesoftheatre' ),
	),
	array(
		'icon'  => 'fa-solid fa-users',
		'title' => __( 'TOT Radio Drama Club', 'timesoftheatre' ),
		'text'  => __( 'A community platform for emerging actors and voice artists to take part in recorded audio plays.', 'timesoftheatre' ),
	),
	array(
		'icon'  => 'fa-solid fa-trophy',
		'title' => __( 'Events & Competitions', 'timesoftheatre' ),
		'text'  => __( 'Regional talent programmes such as the Sara Bangla Shruti Natok Competition, the All-Bengal Audio Drama Competition, and career-focused workshops for artists.', 'timesoftheatre' ),
	),
);

$timesoftheatre_explore = array(
	array(
		'icon'  => 'fa-solid fa-masks-theater',
		'title' => __( 'About TOT', 'timesoftheatre' ),
		'text'  => __( 'Who we are, our vision, our work and our mentors.', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'about-tot' ),
	),
	array(
		'icon'  => 'fa-solid fa-graduation-cap',
		'title' => __( 'TOT School of Drama', 'timesoftheatre' ),
		'text'  => __( 'Courses, masterclasses and student performances.', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'tot-school-of-drama/about-the-school' ),
	),
	array(
		'icon'  => 'fa-solid fa-landmark',
		'title' => __( 'The TOT Space', 'timesoftheatre' ),
		'text'  => __( 'Facilities, seating and booking enquiries.', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'the-tot-space' ),
	),
	array(
		'icon'  => 'fa-solid fa-microphone-lines',
		'title' => __( 'The TOT Studio', 'timesoftheatre' ),
		'text'  => __( 'Audio recording, dubbing and equipment.', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'the-tot-studio' ),
	),
	array(
		'icon'  => 'fa-solid fa-chalkboard-user',
		'title' => __( 'Workshops', 'timesoftheatre' ),
		'text'  => __( 'Upcoming and past workshops, details and registration.', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'workshops/upcoming-workshops' ),
	),
	array(
		'icon'  => 'fa-brands fa-youtube',
		'title' => __( 'TOT on YouTube', 'timesoftheatre' ),
		'text'  => __( 'TOT Originals and videos by students and club members.', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'tot-on-youtube' ),
	),
	array(
		'icon'  => 'fa-solid fa-images',
		'title' => __( 'Gallery', 'timesoftheatre' ),
		'text'  => __( 'Photographs from workshops, programmes and performances.', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'gallery/workshop-gallery' ),
	),
	array(
		'icon'  => 'fa-solid fa-envelope',
		'title' => __( 'Contact', 'timesoftheatre' ),
		'text'  => __( 'Get in touch with the TOT team.', 'timesoftheatre' ),
		'url'   => timesoftheatre_page_url( 'contact' ),
	),
);

$timesoftheatre_news = new WP_Query(
	array(
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

$timesoftheatre_posts_page = (int) get_option( 'page_for_posts' );
?>

<main id="primary" class="site-main front-page">

	<section class="hero-carousel" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Featured', 'timesoftheatre' ); ?>">
		<?php foreach ( $timesoftheatre_slides as $timesoftheatre_index => $timesoftheatre_slide ) : ?>
			<div class="carousel-slide<?php echo 0 === $timesoftheatre_index ? ' active' : ''; ?>" role="group" aria-roledescription="slide">
				<img class="slide-image" src="<?php echo esc_url( $timesoftheatre_slide['image'] ); ?>" alt="" <?php echo 0 === $timesoftheatre_index ? 'fetchpriority="high"' : 'loading="lazy"'; ?>>
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
					<div class="action-icon"><i class="<?php echo esc_attr( $timesoftheatre_action['icon'] ); ?>" aria-hidden="true"></i></div>
					<h2 class="action-title"><?php echo esc_html( $timesoftheatre_action['title'] ); ?></h2>
					<?php if ( $timesoftheatre_action['url'] ) : ?>
						<a class="btn-secondary" href="<?php echo esc_url( $timesoftheatre_action['url'] ); ?>"><?php echo esc_html( $timesoftheatre_action['label'] ); ?></a>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</section>

		<section class="about-section" aria-labelledby="about-heading">
			<h2 id="about-heading" class="section-title"><?php esc_html_e( 'About Times of Theatre', 'timesoftheatre' ); ?></h2>
			<p class="about-text"><?php esc_html_e( 'Times of Theatre (TOT) is a Kolkata-based cultural platform and media initiative, launched in June 2021 and dedicated to drama, audio theatre and performance arts, with a primary focus on Bengali theatre.', 'timesoftheatre' ); ?></p>
			<p class="about-text"><?php esc_html_e( 'It serves as a creative hub for theatre enthusiasts, performers, voice artists and radio play listeners.', 'timesoftheatre' ); ?></p>
			<?php if ( timesoftheatre_page_url( 'about-tot' ) ) : ?>
				<a class="learn-more" href="<?php echo esc_url( timesoftheatre_page_url( 'about-tot' ) ); ?>"><?php esc_html_e( 'Learn more about TOT', 'timesoftheatre' ); ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
			<?php endif; ?>
		</section>

		<section class="featured-section" aria-labelledby="initiatives-heading">
			<h2 id="initiatives-heading" class="section-title"><?php esc_html_e( 'What We Do', 'timesoftheatre' ); ?></h2>
			<div class="featured-grid">
				<?php foreach ( $timesoftheatre_initiatives as $timesoftheatre_item ) : ?>
					<article class="featured-card">
						<div class="card-content">
							<div class="action-icon"><i class="<?php echo esc_attr( $timesoftheatre_item['icon'] ); ?>" aria-hidden="true"></i></div>
							<h3 class="card-title"><?php echo esc_html( $timesoftheatre_item['title'] ); ?></h3>
							<p class="card-description"><?php echo esc_html( $timesoftheatre_item['text'] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="categories-section" aria-labelledby="explore-heading">
			<h2 id="explore-heading" class="section-title"><?php esc_html_e( 'Explore', 'timesoftheatre' ); ?></h2>
			<div class="categories-grid">
				<?php foreach ( $timesoftheatre_explore as $timesoftheatre_item ) : ?>
					<?php if ( $timesoftheatre_item['url'] ) : ?>
						<a class="category-card" href="<?php echo esc_url( $timesoftheatre_item['url'] ); ?>">
							<div class="category-icon"><i class="<?php echo esc_attr( $timesoftheatre_item['icon'] ); ?>" aria-hidden="true"></i></div>
							<h3 class="category-name"><?php echo esc_html( $timesoftheatre_item['title'] ); ?></h3>
							<p class="category-desc"><?php echo esc_html( $timesoftheatre_item['text'] ); ?></p>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</section>

		<?php if ( $timesoftheatre_news->have_posts() ) : ?>
			<section class="news-section" aria-labelledby="news-heading">
				<h2 id="news-heading" class="section-title"><?php esc_html_e( 'Latest News', 'timesoftheatre' ); ?></h2>
				<div class="news-grid">
					<?php
					while ( $timesoftheatre_news->have_posts() ) :
						$timesoftheatre_news->the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'news-card' ); ?>>
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
									<?php the_post_thumbnail( 'medium_large', array( 'class' => 'news-thumbnail' ) ); ?>
								</a>
							<?php endif; ?>
							<div class="news-content">
								<p class="news-date"><?php echo esc_html( get_the_date() ); ?></p>
								<h3 class="news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
				<?php if ( $timesoftheatre_posts_page ) : ?>
					<a class="view-all-link" href="<?php echo esc_url( get_permalink( $timesoftheatre_posts_page ) ); ?>"><?php esc_html_e( 'View all news', 'timesoftheatre' ); ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
				<?php endif; ?>
			</section>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
