# Times of Theatre (TOT) Classic Theme: Initial Planning

Date: 08-10-2026 (8 October 2026)
Theme: `wp-content/themes/timesoftheatre/` | Text domain: `timesoftheatre`
Source prompt: `resource/prompts/theme.md` (WordPress Classic Theme Architect, phased build, confirm after each step)

---

## 1. Non-negotiable rules

1. Build a **Classic WordPress theme** (no FSE or block theme). Follow WPCS, escape all output, wrap strings in `__()`/`esc_html__()` with the `timesoftheatre` text domain, enqueue every asset through `wp_enqueue_scripts` (no hardcoded `<link>` or `<script>`).
2. **Design rules**
   - No drop shadows anywhere.
   - No rounded corners anywhere (icons only, and only if really required).
   - Flat colors only. No gradients anywhere.
   - Smooth **web fonts, loaded locally**.
   - No unnecessary white space. Compact layout.
   - **100% mobile-first** (`min-width` media queries).
   - **Navigation must be 100% perfect.** No overlapping.
3. **All libraries are local copies**, never CDN: latest stable Bootstrap and latest Font Awesome (check the real current version at download time; do not assume).
4. **Images:** only real, royalty-free images (license verified and recorded, stored in the theme). Strictly no placeholder images.
5. **Text content:** pages get neatly bound, well-punctuated content. Use only facts supplied by the user. For pages with no supplied facts, use neutral placeholder text under relevant headings (user-approved for text only).
6. No guesswork. Ask when something is not defined in the source files.
7. Confirm with the user at the end of each step before moving on.

---

## 2. Reference files

| File | Purpose |
|---|---|
| `resource/nav/main-nav-v2.md` | **Authoritative** menu structure and page clarifications |
| `resource/suggestions/homepage_mockup.html` | Colour scheme and layout reference (colours only; its shadows, radii, gradients and desktop-first CSS are now disallowed) |
| `resource/screenshots/logo-275x100.png` | Logo (custom-logo support is 275x100) |
| `resource/prompts/element-guide.md`, `urls/laoyout-ref.md`, `nav/main-nav-v1.md` | Older material. v1 and `laoyout-ref.md` include "Preservation & Archive", which is **not** in v2. Use v2. |

Palette from the mockup: gold `#D4AF37`, light gold `#F0E68C`, dark `#2a2a2a`, dark-alt `#3a3a3a`, darkest `#1a1a1a`, page bg `#f5f5f5`, text `#333`, white, borders `#e0e0e0`/`#eee`. Gradients in the mockup are replaced by flat colours.

---

## 3. Navigation decisions

Menu (v2): Home, About TOT, TOT School of Drama, The TOT Space, The TOT Studio, Workshops, TOT on YouTube, Gallery, Contact.

- **Only Home navigates.** Every other top-level item never navigates. It only expands its sub-menu (desktop: CSS pull-down on hover/focus; mobile: accordion).
- The custom **Nav_Walker** (planned at `inc/class-tot-nav-walker.php`, extending `Walker_Nav_Menu`, loaded from `functions.php`) renders every depth-0 item that has children as a non-navigating control with `aria-haspopup` and `aria-expanded`, even if a page is assigned to it in the admin. It also adds `aria-current`.
- `wp_nav_menu()` args: `theme_location => primary`, `menu_class => primary-menu`, `container => false`, `depth => 2`, `fallback_cb => false`, custom walker. Wrapped in `<nav class="main-navigation">` (expected by `totmain.css`/`main.js`).
- Sub-items that are sections link to `/<page-slug>/#<section-id>`; section IDs are derived from the sub-item labels (for example `#who-we-are`).
- Smooth scrolling via CSS `scroll-behavior: smooth` plus `scroll-margin-top` on sections; disabled under `prefers-reduced-motion`.
- Breakpoint for mobile accordion and drawer: 768px (mobile-first, so `min-width: 769px` for desktop rules). Confirmed as the default; user did not object.

---

## 4. Pages (20 in total)

Parent pages (About TOT, TOT School of Drama, Workshops, Gallery) are created **empty** and are never linked from the menu.

| Menu item | Structure | Pages |
|---|---|---|
| Home | Front page (only top-level link that navigates) | 1 |
| About TOT | One page, 4 sections: Who We Are, Our Vision, Our Work, Our Mentors | 1 |
| TOT School of Drama | Empty parent + **About the School** (own page) + **About Theatre** (Audio Theatre + Proscenium Theatre sections) + **Academics & Admissions** (Courses & Programmes + Admissions + Faculty & Mentors sections) + **Student Performances** (own page) | 1 + 4 |
| The TOT Space | One page, 5 sections: About the Space, Facilities, Seating & Capacity, Performances & Events, Enquire / Book the Space | 1 |
| The TOT Studio | One page, 5 sections: About the Studio, Audio Recording, Dubbing, Equipment & Facilities, Studio Enquiry | 1 |
| Workshops | Empty parent + **Upcoming Workshops** + **Past Workshops** + **Join a Workshop** (Workshop Details + Register / Enquire sections) | 1 + 3 |
| TOT on YouTube | One page, 2 sections: TOT Originals (videos fetched from the YouTube channel), TOT Students & Club Members | 1 |
| Gallery | Empty parent + Workshop Gallery, Programme Gallery, Performance Gallery, Behind the Scenes (separate pages) | 1 + 4 |
| Contact | One page, 6 sections: Contact Information, Location & Map, General Enquiry, Course Enquiry, Studio Enquiry, Space Booking | 1 |

User-confirmed titles for the three grouped pages:
- Audio Theatre + Proscenium Theatre = **About Theatre**
- Courses & Programmes + Admissions + Faculty & Mentors = **Academics & Admissions**
- Workshop Details + Register / Enquire = **Join a Workshop**

Slugs follow from these titles (for example `about-theatre`, `academics-admissions`, `join-a-workshop`). Confirm the final slugs when creating the pages.

---

## 5. Inner-page layout

- **Every inner page uses a Bootstrap two-column layout**: left column `col-3`, right column `col-9`.
- **Left column content (the "sibling concept")**
  - A page with sections lists its own sections (smooth scroll, current section highlighted via scrollspy).
  - A page with no sections lists its **sibling pages under the same menu parent**, with the current page highlighted. For example, on Workshop Gallery the left menu lists the four galleries.
  - On TOT School of Drama pages, start with the sibling concept (the whole School sub-menu). The user may change this later.
- Arriving at a page without an anchor opens it at the top with the first item highlighted.
- Clicking a nav sub-item behaves the same as clicking the in-page list item: smooth scroll plus highlight.
- **Mobile (below 768px)**
  - The left menu is hidden by default so users do not scroll past it.
  - A **sticky left-wall button** opens a **drawer** with that page's items.
  - The drawer slides in from the left edge with a smooth animation, uses an **85% opacity** background (flat colour, no gradient), and has a nicely placed **[ X ] close button**.
  - Also: close on item click, Esc, or tap outside; `aria-expanded`; focus moved into the drawer; animation removed under `prefers-reduced-motion`.

---

## 6. Content decisions

- **About TOT** uses only this supplied brief (no added claims): TOT is a Kolkata-based cultural platform and media initiative launched in June 2021, dedicated to drama, audio theatre and performance arts, with a primary focus on Bengali theatre. It serves theatre enthusiasts, performers, voice artists and radio play listeners. Key initiatives:
  - **TOT Radio & Audio Theatre:** audio dramas, radio plays, audio biographies and video podcasts (such as TOTCast), distributed via digital platforms like YouTube.
  - **TOT School of Drama:** short-term and certificate courses, including masterclasses on voice acting, microphone techniques, audio drama ("Shruti Theke Betare") and stage performance.
  - **TOT Radio Drama Club:** a community platform for emerging actors and voice artists to take part in recorded audio plays.
  - **Events & Competitions:** regional talent programs such as the Sara Bangla Shruti Natok Competition (All-Bengal Audio Drama Competition), and career-focused workshops for artists.
- The brief has nothing on Our Mentors; that section gets neutral placeholder text.
- All other pages: neutral placeholder text under context-relevant headings.
- Forms: **Fluent Forms** plugin is already active on the site. Use it for the enquiry and booking forms (General, Course, Studio, Space).
- YouTube: channel ID/handle and the source for "TOT Students & Club Members" will be provided by the user later.

---

## 7. Defaults chosen (not objected to; revisit if the user says so)

- Font: **Inter**, self-hosted WOFF2 (SIL Open Font License).
- Images: real royalty-free photos from Unsplash, Pexels or Wikimedia Commons, license checked and recorded, stored in the theme. No hotlinking.
- Bootstrap: use the grid and bundled JS (scrollspy) from the local copy, loaded through `wp_enqueue_scripts`.
- Small screens: left list becomes the drawer (see section 5).

---

## 8. Creating pages and menu

- Use a **WP-CLI script**. WP-CLI is installed in WSL (`/usr/local/bin/wp`, PHP 8.3).
- The script must be idempotent (check pages by slug), create the 20 pages with exact titles, slugs and parents, build the menu, and assign it to the `primary` location.
- Before running: confirm WP-CLI can reach the database (`wp core is-installed`) and **ask the user before changing the database**.

---

## 9. Current state of the theme (as of this document)

Done:
- `style.css`: theme header only (user later edited Author URI and "Tested up to"; keep their values). Points to `assets/css/totmain.css`.
- `functions.php`: `after_setup_theme` (title-tag, post-thumbnails, custom-logo 275x100, html5, automatic-feed-links, responsive-embeds, `primary` and `footer` menus), content width, `wp_enqueue_scripts` for `assets/css/totmain.css`, `assets/js/main.js` (deferred, in footer) and `comment-reply`.
- `assets/css/totmain.css`: written from the mockup, **but it breaks the strict rules** (box-shadows, 3px radii, gradients, desktop-first `max-width` queries, system font). **It must be rewritten.**
- `assets/js/main.js`: mobile submenu accordion plus hero carousel. To be revised for the Nav_Walker markup and the drawer.
- `index.php`: standard loop with cards, pagination and a "Nothing found" block. It calls `get_header()`/`get_footer()`, which do not exist yet, so the WordPress default header/footer fall back with a deprecation notice until Phase 2.

Not done: `header.php`, `footer.php`, `sidebar.php`, `template-parts/`, `single.php`, `page.php`, `archive.php`, `search.php`, `searchform.php`, `404.php`, `comments.php`, widgets, Nav_Walker, local Bootstrap/Font Awesome/Inter, images, pages, menu, forms.

---

## 10. Planned order of work

1. Rewrite `totmain.css` to the strict rules (mobile-first, flat, no shadows, radii or gradients, Inter).
2. Download local Bootstrap, Font Awesome and Inter. Check current versions at download time.
3. Write `header.php`, `footer.php` and the Nav_Walker.
4. Write the page templates: two-column layout, scrollspy, sibling menus, mobile drawer.
5. Write and run the WP-CLI setup script for pages and menu (with prior confirmation).
6. Continue the remaining theme.md phases (sidebar, content parts, single/page/archive/search/404, widgets, comments), confirming with the user at each step.

---

## 11. Open items

- Final slugs for the three grouped pages (titles are fixed).
- YouTube channel ID/handle and source for Students & Club Members videos (user will provide).
- Whether the user wants a different font or image approach than the defaults in section 7.
