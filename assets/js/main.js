/**
 * Times of Theatre main script.
 *
 * 1. Primary navigation: mobile panel, sub-menu toggles (top-level items
 *    never navigate; they only open their sub-menu).
 * 2. Inner pages: section menu with scroll highlighting and the mobile drawer.
 * 3. Hero carousel.
 */
( function () {
	'use strict';

	var DESKTOP_NAV = '(min-width: 992px)';
	var reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	/* ----------------------------------------------------------------------
	 * 1. Primary navigation
	 * -------------------------------------------------------------------- */
	var navToggle = document.querySelector( '.menu-toggle' );
	var navPanel = document.getElementById( 'nav-panel' );
	var subToggles = document.querySelectorAll( '.main-navigation .menu-toggle-sub' );

	function closeSubMenus( except ) {
		subToggles.forEach( function ( button ) {
			var item = button.parentElement;

			if ( item === except ) {
				return;
			}

			item.classList.remove( 'expanded' );
			button.setAttribute( 'aria-expanded', 'false' );
		} );
	}

	function closeNavPanel() {
		if ( ! navToggle || ! navPanel ) {
			return;
		}

		navPanel.classList.remove( 'is-open' );
		navToggle.setAttribute( 'aria-expanded', 'false' );
	}

	if ( navToggle && navPanel ) {
		navToggle.addEventListener( 'click', function () {
			var open = ! navPanel.classList.contains( 'is-open' );

			navPanel.classList.toggle( 'is-open', open );
			navToggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );

			if ( ! open ) {
				closeSubMenus( null );
			}
		} );
	}

	subToggles.forEach( function ( button ) {
		button.addEventListener( 'click', function () {
			var item = button.parentElement;
			var open = ! item.classList.contains( 'expanded' );

			closeSubMenus( item );
			item.classList.toggle( 'expanded', open );
			button.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		} );
	} );

	// A sub-menu link was chosen: close everything.
	document.querySelectorAll( '.main-navigation .sub-menu a' ).forEach( function ( link ) {
		link.addEventListener( 'click', function () {
			closeSubMenus( null );

			if ( ! window.matchMedia( DESKTOP_NAV ).matches ) {
				closeNavPanel();
			}
		} );
	} );

	// Click outside closes open sub-menus.
	document.addEventListener( 'click', function ( event ) {
		if ( ! event.target.closest( '.main-navigation' ) ) {
			closeSubMenus( null );
		}
	} );

	document.addEventListener( 'keydown', function ( event ) {
		if ( 'Escape' !== event.key ) {
			return;
		}

		var openButton = document.querySelector( '.main-navigation .menu-toggle-sub[aria-expanded="true"]' );

		closeSubMenus( null );

		if ( openButton ) {
			openButton.focus();
		}
	} );

	window.matchMedia( DESKTOP_NAV ).addEventListener( 'change', function () {
		closeSubMenus( null );
	} );

	/* ----------------------------------------------------------------------
	 * 2. Section menu: scroll highlighting and mobile drawer
	 * -------------------------------------------------------------------- */
	var sectionNav = document.getElementById( 'section-nav' );

	if ( sectionNav ) {
		var links = Array.prototype.slice.call( sectionNav.querySelectorAll( 'a[href*="#"]' ) );
		var targets = [];

		links.forEach( function ( link ) {
			var hash = link.hash;
			var target = hash ? document.getElementById( decodeURIComponent( hash.slice( 1 ) ) ) : null;

			if ( target && link.pathname === window.location.pathname ) {
				targets.push( { link: link, target: target } );
			}
		} );

		var setActive = function ( activeLink ) {
			links.forEach( function ( link ) {
				var on = link === activeLink;

				link.classList.toggle( 'active', on );

				if ( on ) {
					link.setAttribute( 'aria-current', 'true' );
				} else if ( 'true' === link.getAttribute( 'aria-current' ) ) {
					link.removeAttribute( 'aria-current' );
				}
			} );
		};

		if ( targets.length ) {
			var visible = new Set();

			var pick = function () {
				var first = null;

				targets.forEach( function ( entry ) {
					if ( ! first && visible.has( entry.target ) ) {
						first = entry;
					}
				} );

				if ( first ) {
					setActive( first.link );
				}
			};

			if ( 'IntersectionObserver' in window ) {
				var observer = new IntersectionObserver( function ( entries ) {
					entries.forEach( function ( entry ) {
						if ( entry.isIntersecting ) {
							visible.add( entry.target );
						} else {
							visible.delete( entry.target );
						}
					} );
					pick();
				}, { rootMargin: '-30% 0px -69% 0px', threshold: 0 } );

				targets.forEach( function ( entry ) {
					observer.observe( entry.target );
				} );
			}

			// Highlight the hash target on load, or the first section.
			var initial = targets.filter( function ( entry ) {
				return entry.link.hash === window.location.hash;
			} )[ 0 ] || targets[ 0 ];

			setActive( initial.link );

			links.forEach( function ( link ) {
				link.addEventListener( 'click', function () {
					if ( link.pathname === window.location.pathname ) {
						setActive( link );
					}
				} );
			} );
		}

		// Mobile drawer.
		var drawerToggle = document.querySelector( '.drawer-toggle' );
		var drawerClose = sectionNav.querySelector( '.drawer-close' );
		var backdrop = document.querySelector( '.drawer-backdrop' );

		if ( drawerToggle && drawerClose && backdrop ) {
			var focusable = function () {
				return sectionNav.querySelectorAll( 'a[href], button:not([disabled])' );
			};

			var openDrawer = function () {
				sectionNav.classList.add( 'is-open' );
				backdrop.classList.add( 'is-open' );
				drawerToggle.setAttribute( 'aria-expanded', 'true' );
				drawerClose.focus();
			};

			var closeDrawer = function ( restoreFocus ) {
				if ( ! sectionNav.classList.contains( 'is-open' ) ) {
					return;
				}

				sectionNav.classList.remove( 'is-open' );
				backdrop.classList.remove( 'is-open' );
				drawerToggle.setAttribute( 'aria-expanded', 'false' );

				if ( restoreFocus ) {
					drawerToggle.focus();
				}
			};

			drawerToggle.addEventListener( 'click', openDrawer );
			drawerClose.addEventListener( 'click', function () {
				closeDrawer( true );
			} );
			backdrop.addEventListener( 'click', function () {
				closeDrawer( true );
			} );

			links.forEach( function ( link ) {
				link.addEventListener( 'click', function () {
					closeDrawer( false );
				} );
			} );

			document.addEventListener( 'keydown', function ( event ) {
				if ( ! sectionNav.classList.contains( 'is-open' ) ) {
					return;
				}

				if ( 'Escape' === event.key ) {
					closeDrawer( true );
					return;
				}

				if ( 'Tab' === event.key ) {
					var items = focusable();
					var first = items[ 0 ];
					var last = items[ items.length - 1 ];

					if ( event.shiftKey && document.activeElement === first ) {
						event.preventDefault();
						last.focus();
					} else if ( ! event.shiftKey && document.activeElement === last ) {
						event.preventDefault();
						first.focus();
					}
				}
			} );

			window.matchMedia( '(min-width: 768px)' ).addEventListener( 'change', function () {
				closeDrawer( false );
			} );
		}
	}

	/* ----------------------------------------------------------------------
	 * 3. Hero carousel
	 * -------------------------------------------------------------------- */
	var slides = document.querySelectorAll( '.carousel-slide' );
	var dots = document.querySelectorAll( '.carousel-dot' );

	if ( slides.length > 1 && slides.length === dots.length ) {
		var current = 0;

		var showSlide = function ( index ) {
			slides.forEach( function ( slide ) {
				slide.classList.remove( 'active' );
			} );
			dots.forEach( function ( dot ) {
				dot.classList.remove( 'active' );
			} );
			slides[ index ].classList.add( 'active' );
			dots[ index ].classList.add( 'active' );
			current = index;
		};

		dots.forEach( function ( dot, index ) {
			dot.addEventListener( 'click', function () {
				showSlide( index );
			} );
		} );

		if ( ! reduceMotion ) {
			window.setInterval( function () {
				showSlide( ( current + 1 ) % slides.length );
			}, 5000 );
		}
	}
}() );
