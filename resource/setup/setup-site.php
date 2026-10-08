<?php
/**
 * One-time site setup: creates the pages, the primary menu and the front page.
 *
 * Run from the project root (Lando):
 *   Dry run (changes nothing, prints the plan):
 *     lando wp eval-file wp-content/themes/timesoftheatre/resource/setup/setup-site.php dry-run
 *   Apply:
 *     lando wp eval-file wp-content/themes/timesoftheatre/resource/setup/setup-site.php
 *
 * Safe to re-run: existing pages are never overwritten, and an existing
 * "Primary Menu" is left untouched.
 *
 * This file is not loaded by the theme.
 *
 * @package timesoftheatre
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'WP_CLI' ) ) {
	exit;
}

$dry_run = isset( $args[0] ) && 'dry-run' === $args[0];

/* ==========================================================================
   Content helpers
   ========================================================================== */

/**
 * Builds a section as a Group block with an anchor.
 *
 * @param string   $id    Anchor ID.
 * @param string   $title Section heading.
 * @param string[] $paras Paragraphs.
 * @return string Block markup.
 */
function tot_setup_section( $id, $title, array $paras ) {
	$html  = '<!-- wp:group {"tagName":"section","anchor":"' . $id . '","className":"content-section"} -->' . "\n";
	$html .= '<section class="wp-block-group content-section" id="' . $id . '">' . "\n";
	$html .= '<!-- wp:heading -->' . "\n" . '<h2 class="wp-block-heading">' . esc_html( $title ) . '</h2>' . "\n" . '<!-- /wp:heading -->' . "\n";
	foreach ( $paras as $para ) {
		if ( is_array( $para ) ) {
			// Paragraph with its own anchor: array( anchor id, html ).
			$html .= '<!-- wp:paragraph {"anchor":"' . $para[0] . '"} -->' . "\n" . '<p id="' . $para[0] . '">' . $para[1] . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
		} else {
			$html .= '<!-- wp:paragraph -->' . "\n" . '<p>' . $para . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n";
		}
	}
	$html .= '</section>' . "\n" . '<!-- /wp:group -->' . "\n\n";

	return $html;
}

/**
 * Builds plain paragraphs as blocks.
 *
 * @param string[] $paras Paragraphs.
 * @return string Block markup.
 */
function tot_setup_paras( array $paras ) {
	$html = '';
	foreach ( $paras as $para ) {
		$html .= '<!-- wp:paragraph -->' . "\n" . '<p>' . $para . '</p>' . "\n" . '<!-- /wp:paragraph -->' . "\n\n";
	}

	return $html;
}

/**
 * Neutral placeholder paragraph for a section or page.
 *
 * @param string $title Section or page title.
 * @return string
 */
function tot_setup_placeholder( $title ) {
	return 'Details about ' . esc_html( $title ) . ' will be added here.';
}

/**
 * Builds a page made of sections from an id => title map, using known text where given.
 *
 * @param array $sections Map of id => array( title, paras|null ).
 * @return string Block markup.
 */
function tot_setup_sections( array $sections ) {
	$html = '';
	foreach ( $sections as $id => $section ) {
		$paras = $section[1] ? $section[1] : array( tot_setup_placeholder( $section[0] ) );
		$html .= tot_setup_section( $id, $section[0], $paras );
	}

	return $html;
}

/* ==========================================================================
   Page definitions: path => array( title, content ). Parents come first.
   ========================================================================== */

$pages = array();

$pages['home'] = array( 'Home', '' );

$pages['about-tot'] = array(
	'About TOT',
	tot_setup_sections(
		array(
			'who-we-are'  => array(
				'Who We Are',
				array(
					'Times of Theatre (TOT) is a Kolkata-based cultural platform and media initiative, launched in June 2021 and dedicated to drama, audio theatre and performance arts, with a primary focus on Bengali theatre.',
					'It serves as a creative hub for theatre enthusiasts, performers, voice artists and radio play listeners.',
				),
			),
			'our-vision'  => array( 'Our Vision', null ),
			'our-work'    => array(
				'Our Work',
				array(
					array( 'tot-radio-audio-theatre', '<strong>TOT Radio &amp; Audio Theatre</strong> produces audio dramas, radio plays, audio biographies and video podcasts, such as TOTCast, distributed on digital platforms like YouTube.' ),
					array( 'tot-school-of-drama', '<strong>TOT School of Drama</strong> runs short-term and certificate courses, including masterclasses on voice acting, microphone techniques, audio drama (&#8220;Shruti Theke Betare&#8221;) and stage performance.' ),
					array( 'tot-radio-drama-club', '<strong>TOT Radio Drama Club</strong> is a community platform that gives emerging actors and voice artists the opportunity to take part in recorded audio plays.' ),
					array( 'events-competitions', '<strong>Events &amp; Competitions</strong> include regional talent programmes, such as the Sara Bangla Shruti Natok Competition (the All-Bengal Audio Drama Competition), and career-focused workshops for artists.' ),
				),
			),
			'our-mentors' => array( 'Our Mentors', null ),
		)
	),
);

$pages['tot-school-of-drama']                        = array( 'TOT School of Drama', '' );
$pages['tot-school-of-drama/about-the-school']       = array(
	'About the School',
	tot_setup_paras(
		array(
			'TOT School of Drama runs short-term and certificate courses, including masterclasses on voice acting, microphone techniques, audio drama (&#8220;Shruti Theke Betare&#8221;) and stage performance.',
			'Further details about the school will be added here.',
		)
	),
);
$pages['tot-school-of-drama/about-theatre']          = array(
	'About Theatre',
	tot_setup_sections(
		array(
			'audio-theatre'      => array(
				'Audio Theatre',
				array( 'TOT produces audio dramas, radio plays, audio biographies and video podcasts, distributed on digital platforms like YouTube.' ),
			),
			'proscenium-theatre' => array( 'Proscenium Theatre', null ),
		)
	),
);
$pages['tot-school-of-drama/academics-admissions']   = array(
	'Academics & Admissions',
	tot_setup_sections(
		array(
			'courses-programmes' => array(
				'Courses & Programmes',
				array( 'Short-term and certificate courses, including masterclasses on voice acting, microphone techniques, audio drama (&#8220;Shruti Theke Betare&#8221;) and stage performance.' ),
			),
			'admissions'         => array( 'Admissions', null ),
			'faculty-mentors'    => array( 'Faculty & Mentors', null ),
		)
	),
);
$pages['tot-school-of-drama/student-performances']   = array(
	'Student Performances',
	tot_setup_paras( array( tot_setup_placeholder( 'student performances' ) ) ),
);

$pages['the-tot-space'] = array(
	'The TOT Space',
	tot_setup_sections(
		array(
			'about-the-space'       => array( 'About the Space', null ),
			'facilities'            => array( 'Facilities', null ),
			'seating-capacity'      => array( 'Seating & Capacity', null ),
			'performances-events'   => array( 'Performances & Events', null ),
			'enquire-book-the-space' => array( 'Enquire / Book the Space', null ),
		)
	),
);

$pages['the-tot-studio'] = array(
	'The TOT Studio',
	tot_setup_sections(
		array(
			'about-the-studio'    => array( 'About the Studio', null ),
			'audio-recording'     => array( 'Audio Recording', null ),
			'dubbing'             => array( 'Dubbing', null ),
			'equipment-facilities' => array( 'Equipment & Facilities', null ),
			'studio-enquiry'      => array( 'Studio Enquiry', null ),
		)
	),
);

$pages['workshops']                           = array( 'Workshops', '' );
$pages['workshops/upcoming-workshops']        = array(
	'Upcoming Workshops',
	tot_setup_paras( array( tot_setup_placeholder( 'upcoming workshops' ) ) ),
);
$pages['workshops/past-workshops']            = array(
	'Past Workshops',
	tot_setup_paras( array( tot_setup_placeholder( 'past workshops' ) ) ),
);
$pages['workshops/join-a-workshop']           = array(
	'Join a Workshop',
	tot_setup_sections(
		array(
			'workshop-details'  => array( 'Workshop Details', null ),
			'register-enquire'  => array( 'Register / Enquire', null ),
		)
	),
);

$pages['tot-on-youtube'] = array(
	'TOT on YouTube',
	tot_setup_sections(
		array(
			'tot-originals'              => array( 'TOT Originals', null ),
			'tot-students-club-members'  => array( 'TOT Students & Club Members', null ),
		)
	),
);

$pages['gallery']                          = array( 'Gallery', '' );
$pages['gallery/workshop-gallery']         = array( 'Workshop Gallery', tot_setup_paras( array( tot_setup_placeholder( 'the workshop gallery' ) ) ) );
$pages['gallery/programme-gallery']        = array( 'Programme Gallery', tot_setup_paras( array( tot_setup_placeholder( 'the programme gallery' ) ) ) );
$pages['gallery/performance-gallery']      = array( 'Performance Gallery', tot_setup_paras( array( tot_setup_placeholder( 'the performance gallery' ) ) ) );
$pages['gallery/behind-the-scenes']        = array( 'Behind the Scenes', tot_setup_paras( array( tot_setup_placeholder( 'behind the scenes' ) ) ) );

$pages['contact'] = array(
	'Contact',
	tot_setup_sections(
		array(
			'contact-information' => array( 'Contact Information', null ),
			'location-map'        => array( 'Location & Map', null ),
			'general-enquiry'     => array( 'General Enquiry', null ),
			'course-enquiry'      => array( 'Course Enquiry', null ),
			'studio-enquiry'      => array( 'Studio Enquiry', null ),
			'space-booking'       => array( 'Space Booking', null ),
		)
	),
);

/* ==========================================================================
   Create pages
   ========================================================================== */

$admins = get_users(
	array(
		'role'   => 'administrator',
		'number' => 1,
		'fields' => 'ID',
	)
);
$author = $admins ? (int) $admins[0] : 1;
$ids    = array();

foreach ( $pages as $path => $page ) {
	$existing = get_page_by_path( $path );

	if ( $existing ) {
		$ids[ $path ] = $existing->ID;
		WP_CLI::log( 'exists   ' . $path . ' (#' . $existing->ID . ')' );
		continue;
	}

	$slug        = basename( $path );
	$parent_path = dirname( $path );
	$parent_id   = ( '.' !== $parent_path && isset( $ids[ $parent_path ] ) ) ? $ids[ $parent_path ] : 0;

	if ( $dry_run ) {
		WP_CLI::log( 'would create ' . $path . ' - "' . $page[0] . '"' );
		$ids[ $path ] = 0;
		continue;
	}

	$id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => wp_slash( $page[0] ),
			'post_name'    => $slug,
			'post_parent'  => $parent_id,
			'post_content' => wp_slash( $page[1] ),
			'post_author'  => $author,
		),
		true
	);

	if ( is_wp_error( $id ) ) {
		WP_CLI::error( 'Could not create ' . $path . ': ' . $id->get_error_message() );
	}

	$ids[ $path ] = $id;
	WP_CLI::log( 'created  ' . $path . ' (#' . $id . ')' );
}

/* ==========================================================================
   Primary menu: only Home navigates; every other top-level item is a
   non-navigating parent ("#"); sub-items are pages or page#section links.
   ========================================================================== */

// Menu definition: top-level label => array( sub-items ).
// A sub-item is array( label, page path ) for a page link, or
// array( label, page path, section id ) for a section link.
$menu = array(
	'About TOT'           => array(
		array( 'Who We Are', 'about-tot', 'who-we-are' ),
		array( 'Our Vision', 'about-tot', 'our-vision' ),
		array( 'Our Work', 'about-tot', 'our-work' ),
		array( 'Our Mentors', 'about-tot', 'our-mentors' ),
	),
	'TOT School of Drama' => array(
		array( 'About the School', 'tot-school-of-drama/about-the-school' ),
		array( 'Audio Theatre', 'tot-school-of-drama/about-theatre', 'audio-theatre' ),
		array( 'Proscenium Theatre', 'tot-school-of-drama/about-theatre', 'proscenium-theatre' ),
		array( 'Courses & Programmes', 'tot-school-of-drama/academics-admissions', 'courses-programmes' ),
		array( 'Admissions', 'tot-school-of-drama/academics-admissions', 'admissions' ),
		array( 'Faculty & Mentors', 'tot-school-of-drama/academics-admissions', 'faculty-mentors' ),
		array( 'Student Performances', 'tot-school-of-drama/student-performances' ),
	),
	'The TOT Space'       => array(
		array( 'About the Space', 'the-tot-space', 'about-the-space' ),
		array( 'Facilities', 'the-tot-space', 'facilities' ),
		array( 'Seating & Capacity', 'the-tot-space', 'seating-capacity' ),
		array( 'Performances & Events', 'the-tot-space', 'performances-events' ),
		array( 'Enquire / Book the Space', 'the-tot-space', 'enquire-book-the-space' ),
	),
	'The TOT Studio'      => array(
		array( 'About the Studio', 'the-tot-studio', 'about-the-studio' ),
		array( 'Audio Recording', 'the-tot-studio', 'audio-recording' ),
		array( 'Dubbing', 'the-tot-studio', 'dubbing' ),
		array( 'Equipment & Facilities', 'the-tot-studio', 'equipment-facilities' ),
		array( 'Studio Enquiry', 'the-tot-studio', 'studio-enquiry' ),
	),
	'Workshops'           => array(
		array( 'Upcoming Workshops', 'workshops/upcoming-workshops' ),
		array( 'Past Workshops', 'workshops/past-workshops' ),
		array( 'Workshop Details', 'workshops/join-a-workshop', 'workshop-details' ),
		array( 'Register / Enquire', 'workshops/join-a-workshop', 'register-enquire' ),
	),
	'TOT on YouTube'      => array(
		array( 'TOT Originals', 'tot-on-youtube', 'tot-originals' ),
		array( 'TOT Students & Club Members', 'tot-on-youtube', 'tot-students-club-members' ),
	),
	'Gallery'             => array(
		array( 'Workshop Gallery', 'gallery/workshop-gallery' ),
		array( 'Programme Gallery', 'gallery/programme-gallery' ),
		array( 'Performance Gallery', 'gallery/performance-gallery' ),
		array( 'Behind the Scenes', 'gallery/behind-the-scenes' ),
	),
	'Contact'             => array(
		array( 'Contact Information', 'contact', 'contact-information' ),
		array( 'Location & Map', 'contact', 'location-map' ),
		array( 'General Enquiry', 'contact', 'general-enquiry' ),
		array( 'Course Enquiry', 'contact', 'course-enquiry' ),
		array( 'Studio Enquiry', 'contact', 'studio-enquiry' ),
		array( 'Space Booking', 'contact', 'space-booking' ),
	),
);

$menu_name = 'Primary Menu';

if ( wp_get_nav_menu_object( $menu_name ) ) {
	WP_CLI::log( 'exists   menu "' . $menu_name . '" (left untouched)' );
} elseif ( $dry_run ) {
	$count = 1;
	foreach ( $menu as $subs ) {
		$count += 1 + count( $subs );
	}
	WP_CLI::log( 'would create menu "' . $menu_name . '" with ' . $count . ' items and assign it to the primary location' );
} else {
	$menu_id = wp_create_nav_menu( $menu_name );

	if ( is_wp_error( $menu_id ) ) {
		WP_CLI::error( 'Could not create menu: ' . $menu_id->get_error_message() );
	}

	wp_update_nav_menu_item(
		$menu_id,
		0,
		array(
			'menu-item-title'     => 'Home',
			'menu-item-type'      => 'post_type',
			'menu-item-object'    => 'page',
			'menu-item-object-id' => $ids['home'],
			'menu-item-status'    => 'publish',
		)
	);

	foreach ( $menu as $label => $subs ) {
		$parent_item = wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'  => $label,
				'menu-item-type'   => 'custom',
				'menu-item-url'    => '#',
				'menu-item-status' => 'publish',
			)
		);

		foreach ( $subs as $sub ) {
			$item = array(
				'menu-item-title'     => $sub[0],
				'menu-item-parent-id' => $parent_item,
				'menu-item-status'    => 'publish',
			);

			if ( isset( $sub[2] ) ) {
				$item['menu-item-type'] = 'custom';
				$item['menu-item-url']  = get_permalink( $ids[ $sub[1] ] ) . '#' . $sub[2];
			} else {
				$item['menu-item-type']      = 'post_type';
				$item['menu-item-object']    = 'page';
				$item['menu-item-object-id'] = $ids[ $sub[1] ];
			}

			wp_update_nav_menu_item( $menu_id, 0, $item );
		}
	}

	$locations            = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	WP_CLI::log( 'created  menu "' . $menu_name . '" (#' . $menu_id . ') and assigned it to the primary location' );
}

/* ==========================================================================
   Sub-item icons (stored in each menu item's "CSS Classes" field).
   Only items that do not have an icon yet are changed.
   ========================================================================== */

$icons = array(
	'About TOT|Who We Are'                          => 'fa-solid fa-users',
	'About TOT|Our Vision'                          => 'fa-solid fa-eye',
	'About TOT|Our Work'                            => 'fa-solid fa-masks-theater',
	'About TOT|Our Mentors'                         => 'fa-solid fa-chalkboard-user',
	'TOT School of Drama|About the School'          => 'fa-solid fa-school',
	'TOT School of Drama|Audio Theatre'             => 'fa-solid fa-microphone-lines',
	'TOT School of Drama|Proscenium Theatre'        => 'fa-solid fa-masks-theater',
	'TOT School of Drama|Courses & Programmes'      => 'fa-solid fa-book-open',
	'TOT School of Drama|Admissions'                => 'fa-solid fa-clipboard-list',
	'TOT School of Drama|Faculty & Mentors'         => 'fa-solid fa-person-chalkboard',
	'TOT School of Drama|Student Performances'      => 'fa-solid fa-star',
	'The TOT Space|About the Space'                 => 'fa-solid fa-landmark',
	'The TOT Space|Facilities'                      => 'fa-solid fa-building',
	'The TOT Space|Seating & Capacity'              => 'fa-solid fa-chair',
	'The TOT Space|Performances & Events'           => 'fa-solid fa-calendar-days',
	'The TOT Space|Enquire / Book the Space'        => 'fa-solid fa-ticket',
	'The TOT Studio|About the Studio'               => 'fa-solid fa-headphones',
	'The TOT Studio|Audio Recording'                => 'fa-solid fa-microphone',
	'The TOT Studio|Dubbing'                        => 'fa-solid fa-clapperboard',
	'The TOT Studio|Equipment & Facilities'         => 'fa-solid fa-sliders',
	'The TOT Studio|Studio Enquiry'                 => 'fa-solid fa-envelope',
	'Workshops|Upcoming Workshops'                  => 'fa-solid fa-calendar-plus',
	'Workshops|Past Workshops'                      => 'fa-solid fa-clock-rotate-left',
	'Workshops|Workshop Details'                    => 'fa-solid fa-circle-info',
	'Workshops|Register / Enquire'                  => 'fa-solid fa-pen-to-square',
	'TOT on YouTube|TOT Originals'                  => 'fa-brands fa-youtube',
	'TOT on YouTube|TOT Students & Club Members'    => 'fa-solid fa-people-group',
	'Gallery|Workshop Gallery'                      => 'fa-solid fa-images',
	'Gallery|Programme Gallery'                     => 'fa-solid fa-image',
	'Gallery|Performance Gallery'                   => 'fa-solid fa-camera-retro',
	'Gallery|Behind the Scenes'                     => 'fa-solid fa-video',
	'Contact|Contact Information'                   => 'fa-solid fa-address-card',
	'Contact|Location & Map'                        => 'fa-solid fa-location-dot',
	'Contact|General Enquiry'                       => 'fa-solid fa-envelope',
	'Contact|Course Enquiry'                        => 'fa-solid fa-graduation-cap',
	'Contact|Studio Enquiry'                        => 'fa-solid fa-headset',
	'Contact|Space Booking'                         => 'fa-solid fa-calendar-check',
);

$menu_object = wp_get_nav_menu_object( $menu_name );

if ( $menu_object ) {
	$menu_items = wp_get_nav_menu_items( $menu_object->term_id );
	$titles     = array();

	foreach ( (array) $menu_items as $menu_item ) {
		$titles[ (int) $menu_item->ID ] = html_entity_decode( $menu_item->title );
	}

	$icon_count = 0;

	foreach ( (array) $menu_items as $menu_item ) {
		$parent = (int) $menu_item->menu_item_parent;

		if ( ! $parent || ! isset( $titles[ $parent ] ) ) {
			continue;
		}

		$key = $titles[ $parent ] . '|' . html_entity_decode( $menu_item->title );

		if ( ! isset( $icons[ $key ] ) ) {
			continue;
		}

		$has_icon = false;
		foreach ( (array) $menu_item->classes as $class_name ) {
			if ( 0 === strpos( (string) $class_name, 'fa-' ) ) {
				$has_icon = true;
			}
		}

		if ( $has_icon ) {
			continue;
		}

		++$icon_count;

		if ( ! $dry_run ) {
			$classes = array_values( array_filter( (array) $menu_item->classes ) );
			update_post_meta( $menu_item->ID, '_menu_item_classes', array_merge( $classes, explode( ' ', $icons[ $key ] ) ) );
		}
	}

	WP_CLI::log( ( $dry_run ? 'would add' : 'added   ' ) . ' icons to ' . $icon_count . ' sub-items' );
}

/* ==========================================================================
   Social links (top right corner of the header)
   ========================================================================== */

$social = array(
	'Facebook'  => 'https://www.facebook.com/timesoftheatre',
	'Instagram' => 'https://www.instagram.com/timesoftheatre?stkn=MTNmeHhhaWJyazg1MQ==',
	'YouTube'   => 'https://www.youtube.com/@timesoftheatre',
);

$social_menu_name = 'Social Links';

if ( wp_get_nav_menu_object( $social_menu_name ) ) {
	WP_CLI::log( 'exists   menu "' . $social_menu_name . '" (left untouched)' );
} elseif ( $dry_run ) {
	WP_CLI::log( 'would create menu "' . $social_menu_name . '" with ' . count( $social ) . ' items and assign it to the social location' );
} else {
	$social_menu_id = wp_create_nav_menu( $social_menu_name );

	if ( is_wp_error( $social_menu_id ) ) {
		WP_CLI::error( 'Could not create menu: ' . $social_menu_id->get_error_message() );
	}

	foreach ( $social as $label => $url ) {
		wp_update_nav_menu_item(
			$social_menu_id,
			0,
			array(
				'menu-item-title'  => $label,
				'menu-item-type'   => 'custom',
				'menu-item-url'    => $url,
				'menu-item-status' => 'publish',
			)
		);
	}

	$locations           = get_theme_mod( 'nav_menu_locations', array() );
	$locations['social'] = $social_menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	WP_CLI::log( 'created  menu "' . $social_menu_name . '" (#' . $social_menu_id . ') and assigned it to the social location' );
}

/* ==========================================================================
   Front page
   ========================================================================== */

if ( $dry_run ) {
	WP_CLI::log( 'would set the front page to "Home"' );
} else {
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $ids['home'] );
	WP_CLI::log( 'set      front page to "Home" (#' . $ids['home'] . ')' );
}

WP_CLI::success( $dry_run ? 'Dry run complete. Nothing was changed.' : 'Setup complete.' );
