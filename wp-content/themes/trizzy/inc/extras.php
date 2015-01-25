<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Trizzy
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
if ( ! function_exists( 'trizzy_page_menu_args' ) ) :
function trizzy_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'trizzy_page_menu_args' );
endif;


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
if ( ! function_exists( 'trizzy_body_classes' ) ) :
function trizzy_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	return $classes;
}
add_filter( 'body_class', 'trizzy_body_classes' );
endif;

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
if ( ! function_exists( 'trizzy_wp_title' ) ) :
function trizzy_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'trizzy' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'trizzy_wp_title', 10, 2 );
endif;


/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
if ( ! function_exists( 'trizzy_setup_author' ) ) :
	function trizzy_setup_author() {
		global $wp_query;
		if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
			$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
		}
	}
	add_action( 'wp', 'trizzy_setup_author' );
endif;


if ( ! function_exists( 'trizzy_get_rating_class' ) ) :
function trizzy_get_rating_class($average) {
	switch ($average) {
		case $average >= 1 and $average < 1.5:
			$class="one-stars";
			break;
		case $average >= 1.5 and $average < 2:
			$class="one-and-half-stars";
			break;
		case $average >= 2 and $average < 2.5:
			$class="two-stars";
			break;
		case $average >= 2.5 and $average < 3:
			$class="two-and-half-stars";
			break;
		case $average >= 3 and $average < 3.5:
			$class="three-stars";
			break;
		case $average >= 3.5 and $average < 4:
			$class="three-and-half-stars";
			break;
		case $average >= 4 and $average < 4.5:
			$class="four-stars";
			break;
		case $average >= 4.5 and $average < 5:
			$class="four-and-half-stars";
			break;
		case $average >= 5:
			$class="five-stars";
			break;
		default:
			$class="no-rating";
			break;
	}
	return $class;
}
endif;


if ( ! function_exists( 'trizzy_get_number_from_column' ) ) :
function trizzy_get_number_from_column($column) {
	switch ($column) {
		case "1/3" : $w = "3"; break;
		case "one-third" : $w = "3"; break;
        case "one" : $w = "1"; break;
        case "two" : $w = "2"; break;
        case "three" : $w = "3"; break;
        case "four" : $w = "4"; break;
        case "five" : $w = "5"; break;
        case "six" : $w = "6"; break;
        case "seven" : $w = "7"; break;
        case "eight" : $w = "8"; break;
        case "nine" : $w = "9"; break;
        case "ten" : $w = "10"; break;
        case "eleven" : $w = "11"; break;
        case "twelve" : $w = "12"; break;
        case "thirteen" : $w = "13"; break;
        case "fourteen" : $w = "14"; break;
        case "fifteen" : $w = "15"; break;
        case "sixteen" : $w = "16"; break;
		default: $w=3; break;
	}
	return $w;
}
endif;



//customize the PageNavi HTML before it is output
add_filter( 'wp_pagenavi', 'trizzy_pagination', 10, 2 );
function trizzy_pagination($html) {
	$out = '';
	//wrap a's and span's in li's
	$out = str_replace("<a","<li><a",$html);
	$out = str_replace("</a>","</a></li>",$out);
	$out = str_replace("<span","<li><span",$out);
	$out = str_replace("</span>","</span></li>",$out);
	return '<div class="paging"><ul>'.$out.'</ul></div>';
}

if ( ! function_exists( 'ebor_icons_list' ) ) :
function ebor_icons_list(){
	$icon = array(
		'none' => 'No Icon',
		'fa-adjust' => 'adjust',
		'fa-anchor' => 'anchor',
		'fa-archive' => 'archive',
		'fa-arrows' => 'arrows',
		'fa-arrows-h' => 'arrows-h',
		'fa-arrows-v' => 'arrows-v',
		'fa-asterisk' => 'asterisk',
		'fa-automobile' => 'automobile',
		'fa-ban' => 'ban',
		'fa-bank' => 'bank',
		'fa-bar-chart-o' => 'bar-chart-o',
		'fa-barcode' => 'barcode',
		'fa-bars' => 'bars',
		'fa-beer' => 'beer',
		'fa-bell' => 'bell',
		'fa-bell-o' => 'bell-o',
		'fa-bolt' => 'bolt',
		'fa-bomb' => 'bomb',
		'fa-book' => 'book',
		'fa-bookmark' => 'bookmark',
		'fa-bookmark-o' => 'bookmark-o',
		'fa-briefcase' => 'briefcase',
		'fa-bug' => 'bug',
		'fa-building' => 'building',
		'fa-building-o' => 'building-o',
		'fa-bullhorn' => 'bullhorn',
		'fa-bullseye' => 'bullseye',
		'fa-cab' => 'cab',
		'fa-calendar' => 'calendar',
		'fa-calendar-o' => 'calendar-o',
		'fa-camera' => 'camera',
		'fa-camera-retro' => 'camera-retro',
		'fa-car' => 'car',
		'fa-caret-square-o-down' => 'caret-square-o-down',
		'fa-caret-square-o-left' => 'caret-square-o-left',
		'fa-caret-square-o-right' => 'caret-square-o-right',
		'fa-caret-square-o-up' => 'caret-square-o-up',
		'fa-certificate' => 'certificate',
		'fa-check' => 'check',
		'fa-check-circle' => 'check-circle',
		'fa-check-circle-o' => 'check-circle-o',
		'fa-check-square' => 'check-square',
		'fa-check-square-o' => 'check-square-o',
		'fa-child' => 'child',
		'fa-circle' => 'circle',
		'fa-circle-o' => 'circle-o',
		'fa-circle-o-notch' => 'circle-o-notch',
		'fa-circle-thin' => 'circle-thin',
		'fa-clock-o' => 'clock-o',
		'fa-cloud' => 'cloud',
		'fa-cloud-download' => 'cloud-download',
		'fa-cloud-upload' => 'cloud-upload',
		'fa-code' => 'code',
		'fa-code-fork' => 'code-fork',
		'fa-coffee' => 'coffee',
		'fa-cog' => 'cog',
		'fa-cogs' => 'cogs',
		'fa-comment' => 'comment',
		'fa-comment-o' => 'comment-o',
		'fa-comments' => 'comments',
		'fa-comments-o' => 'comments-o',
		'fa-compass' => 'compass',
		'fa-credit-card' => 'credit-card',
		'fa-crop' => 'crop',
		'fa-crosshairs' => 'crosshairs',
		'fa-cube' => 'cube',
		'fa-cubes' => 'cubes',
		'fa-cutlery' => 'cutlery',
		'fa-dashboard' => 'dashboard',
		'fa-database' => 'database',
		'fa-desktop' => 'desktop',
		'fa-dot-circle-o' => 'dot-circle-o',
		'fa-download' => 'download',
		'fa-edit' => 'edit',
		'fa-ellipsis-h' => 'ellipsis-h',
		'fa-ellipsis-v' => 'ellipsis-v',
		'fa-envelope' => 'envelope',
		'fa-envelope-o' => 'envelope-o',
		'fa-envelope-square' => 'envelope-square',
		'fa-eraser' => 'eraser',
		'fa-exchange' => 'exchange',
		'fa-exclamation' => 'exclamation',
		'fa-exclamation-circle' => 'exclamation-circle',
		'fa-exclamation-triangle' => 'exclamation-triangle',
		'fa-external-link' => 'external-link',
		'fa-external-link-square' => 'external-link-square',
		'fa-eye' => 'eye',
		'fa-eye-slash' => 'eye-slash',
		'fa-fax' => 'fax',
		'fa-female' => 'female',
		'fa-fighter-jet' => 'fighter-jet',
		'fa-file-archive-o' => 'file-archive-o',
		'fa-file-audio-o' => 'file-audio-o',
		'fa-file-code-o' => 'file-code-o',
		'fa-file-excel-o' => 'file-excel-o',
		'fa-file-image-o' => 'file-image-o',
		'fa-file-movie-o' => 'file-movie-o',
		'fa-file-pdf-o' => 'file-pdf-o',
		'fa-file-photo-o' => 'file-photo-o',
		'fa-file-picture-o' => 'file-picture-o',
		'fa-file-powerpoint-o' => 'file-powerpoint-o',
		'fa-file-sound-o' => 'file-sound-o',
		'fa-file-video-o' => 'file-video-o',
		'fa-file-word-o' => 'file-word-o',
		'fa-file-zip-o' => 'file-zip-o',
		'fa-film' => 'film',
		'fa-filter' => 'filter',
		'fa-fire' => 'fire',
		'fa-fire-extinguisher' => 'fire-extinguisher',
		'fa-flag' => 'flag',
		'fa-flag-checkered' => 'flag-checkered',
		'fa-flag-o' => 'flag-o',
		'fa-flash' => 'flash',
		'fa-flask' => 'flask',
		'fa-folder' => 'folder',
		'fa-folder-o' => 'folder-o',
		'fa-folder-open' => 'folder-open',
		'fa-folder-open-o' => 'folder-open-o',
		'fa-frown-o' => 'frown-o',
		'fa-gamepad' => 'gamepad',
		'fa-gavel' => 'gavel',
		'fa-gear' => 'gear',
		'fa-gears' => 'gears',
		'fa-gift' => 'gift',
		'fa-glass' => 'glass',
		'fa-globe' => 'globe',
		'fa-graduation-cap' => 'graduation-cap',
		'fa-group' => 'group',
		'fa-hdd-o' => 'hdd-o',
		'fa-headphones' => 'headphones',
		'fa-heart' => 'heart',
		'fa-heart-o' => 'heart-o',
		'fa-history' => 'history',
		'fa-home' => 'home',
		'fa-image' => 'image',
		'fa-inbox' => 'inbox',
		'fa-info' => 'info',
		'fa-info-circle' => 'info-circle',
		'fa-institution' => 'institution',
		'fa-key' => 'key',
		'fa-keyboard-o' => 'keyboard-o',
		'fa-language' => 'language',
		'fa-laptop' => 'laptop',
		'fa-leaf' => 'leaf',
		'fa-legal' => 'legal',
		'fa-lemon-o' => 'lemon-o',
		'fa-level-down' => 'level-down',
		'fa-level-up' => 'level-up',
		'fa-life-bouy' => 'life-bouy',
		'fa-life-ring' => 'life-ring',
		'fa-life-saver' => 'life-saver',
		'fa-lightbulb-o' => 'lightbulb-o',
		'fa-location-arrow' => 'location-arrow',
		'fa-lock' => 'lock',
		'fa-magic' => 'magic',
		'fa-magnet' => 'magnet',
		'fa-mail-forward' => 'mail-forward',
		'fa-mail-reply' => 'mail-reply',
		'fa-mail-reply-all' => 'mail-reply-all',
		'fa-male' => 'male',
		'fa-map-marker' => 'map-marker',
		'fa-meh-o' => 'meh-o',
		'fa-microphone' => 'microphone',
		'fa-microphone-slash' => 'microphone-slash',
		'fa-minus' => 'minus',
		'fa-minus-circle' => 'minus-circle',
		'fa-minus-square' => 'minus-square',
		'fa-minus-square-o' => 'minus-square-o',
		'fa-mobile' => 'mobile',
		'fa-mobile-phone' => 'mobile-phone',
		'fa-money' => 'money',
		'fa-moon-o' => 'moon-o',
		'fa-mortar-board' => 'mortar-board',
		'fa-music' => 'music',
		'fa-navicon' => 'navicon',
		'fa-paper-plane' => 'paper-plane',
		'fa-paper-plane-o' => 'paper-plane-o',
		'fa-paw' => 'paw',
		'fa-pencil' => 'pencil',
		'fa-pencil-square' => 'pencil-square',
		'fa-pencil-square-o' => 'pencil-square-o',
		'fa-phone' => 'phone',
		'fa-phone-square' => 'phone-square',
		'fa-photo' => 'photo',
		'fa-picture-o' => 'picture-o',
		'fa-plane' => 'plane',
		'fa-plus' => 'plus',
		'fa-plus-circle' => 'plus-circle',
		'fa-plus-square' => 'plus-square',
		'fa-plus-square-o' => 'plus-square-o',
		'fa-power-off' => 'power-off',
		'fa-print' => 'print',
		'fa-puzzle-piece' => 'puzzle-piece',
		'fa-qrcode' => 'qrcode',
		'fa-question' => 'question',
		'fa-question-circle' => 'question-circle',
		'fa-quote-left' => 'quote-left',
		'fa-quote-right' => 'quote-right',
		'fa-random' => 'random',
		'fa-recycle' => 'recycle',
		'fa-refresh' => 'refresh',
		'fa-reorder' => 'reorder',
		'fa-reply' => 'reply',
		'fa-reply-all' => 'reply-all',
		'fa-retweet' => 'retweet',
		'fa-road' => 'road',
		'fa-rocket' => 'rocket',
		'fa-rss' => 'rss',
		'fa-rss-square' => 'rss-square',
		'fa-search' => 'search',
		'fa-search-minus' => 'search-minus',
		'fa-search-plus' => 'search-plus',
		'fa-send' => 'send',
		'fa-send-o' => 'send-o',
		'fa-share' => 'share',
		'fa-share-alt' => 'share-alt',
		'fa-share-alt-square' => 'share-alt-square',
		'fa-share-square' => 'share-square',
		'fa-share-square-o' => 'share-square-o',
		'fa-shield' => 'shield',
		'fa-shopping-cart' => 'shopping-cart',
		'fa-sign-in' => 'sign-in',
		'fa-sign-out' => 'sign-out',
		'fa-signal' => 'signal',
		'fa-sitemap' => 'sitemap',
		'fa-sliders' => 'sliders',
		'fa-smile-o' => 'smile-o',
		'fa-sort' => 'sort',
		'fa-sort-alpha-asc' => 'sort-alpha-asc',
		'fa-sort-alpha-desc' => 'sort-alpha-desc',
		'fa-sort-amount-asc' => 'sort-amount-asc',
		'fa-sort-amount-desc' => 'sort-amount-desc',
		'fa-sort-asc' => 'sort-asc',
		'fa-sort-desc' => 'sort-desc',
		'fa-sort-down' => 'sort-down',
		'fa-sort-numeric-asc' => 'sort-numeric-asc',
		'fa-sort-numeric-desc' => 'sort-numeric-desc',
		'fa-sort-up' => 'sort-up',
		'fa-space-shuttle' => 'space-shuttle',
		'fa-spinner' => 'spinner',
		'fa-spoon' => 'spoon',
		'fa-square' => 'square',
		'fa-square-o' => 'square-o',
		'fa-star' => 'star',
		'fa-star-half' => 'star-half',
		'fa-star-half-empty' => 'star-half-empty',
		'fa-star-half-full' => 'star-half-full',
		'fa-star-half-o' => 'star-half-o',
		'fa-star-o' => 'star-o',
		'fa-suitcase' => 'suitcase',
		'fa-sun-o' => 'sun-o',
		'fa-support' => 'support',
		'fa-tablet' => 'tablet',
		'fa-tachometer' => 'tachometer',
		'fa-tag' => 'tag',
		'fa-tags' => 'tags',
		'fa-tasks' => 'tasks',
		'fa-taxi' => 'taxi',
		'fa-terminal' => 'terminal',
		'fa-thumb-tack' => 'thumb-tack',
		'fa-thumbs-down' => 'thumbs-down',
		'fa-thumbs-o-down' => 'thumbs-o-down',
		'fa-thumbs-o-up' => 'thumbs-o-up',
		'fa-thumbs-up' => 'thumbs-up',
		'fa-ticket' => 'ticket',
		'fa-times' => 'times',
		'fa-times-circle' => 'times-circle',
		'fa-times-circle-o' => 'times-circle-o',
		'fa-tint' => 'tint',
		'fa-toggle-down' => 'toggle-down',
		'fa-toggle-left' => 'toggle-left',
		'fa-toggle-right' => 'toggle-right',
		'fa-toggle-up' => 'toggle-up',
		'fa-trash-o' => 'trash-o',
		'fa-tree' => 'tree',
		'fa-trophy' => 'trophy',
		'fa-truck' => 'truck',
		'fa-umbrella' => 'umbrella',
		'fa-university' => 'university',
		'fa-unlock' => 'unlock',
		'fa-unlock-alt' => 'unlock-alt',
		'fa-unsorted' => 'unsorted',
		'fa-upload' => 'upload',
		'fa-user' => 'user',
		'fa-users' => 'users',
		'fa-video-camera' => 'video-camera',
		'fa-volume-down' => 'volume-down',
		'fa-volume-off' => 'volume-off',
		'fa-volume-up' => 'volume-up',
		'fa-warning' => 'warning',
		'fa-wheelchair' => 'wheelchair',
		'fa-wrench' => 'wrench',
		'fa-file' => 'file',
		'fa-file-archive-o' => 'file-archive-o',
		'fa-file-audio-o' => 'file-audio-o',
		'fa-file-code-o' => 'file-code-o',
		'fa-file-excel-o' => 'file-excel-o',
		'fa-file-image-o' => 'file-image-o',
		'fa-file-movie-o' => 'file-movie-o',
		'fa-file-o' => 'file-o',
		'fa-file-pdf-o' => 'file-pdf-o',
		'fa-file-photo-o' => 'file-photo-o',
		'fa-file-picture-o' => 'file-picture-o',
		'fa-file-powerpoint-o' => 'file-powerpoint-o',
		'fa-file-sound-o' => 'file-sound-o',
		'fa-file-text' => 'file-text',
		'fa-file-text-o' => 'file-text-o',
		'fa-file-video-o' => 'file-video-o',
		'fa-file-word-o' => 'file-word-o',
		'fa-file-zip-o' => 'file-zip-o',
		'fa-circle-o-notch' => 'circle-o-notch',
		'fa-cog' => 'cog',
		'fa-gear' => 'gear',
		'fa-refresh' => 'refresh',
		'fa-spinner' => 'spinner',
		'fa-check-square' => 'check-square',
		'fa-check-square-o' => 'check-square-o',
		'fa-circle' => 'circle',
		'fa-circle-o' => 'circle-o',
		'fa-dot-circle-o' => 'dot-circle-o',
		'fa-minus-square' => 'minus-square',
		'fa-minus-square-o' => 'minus-square-o',
		'fa-plus-square' => 'plus-square',
		'fa-plus-square-o' => 'plus-square-o',
		'fa-square' => 'square',
		'fa-square-o' => 'square-o',
		'fa-bitcoin' => 'bitcoin',
		'fa-btc' => 'btc',
		'fa-cny' => 'cny',
		'fa-dollar' => 'dollar',
		'fa-eur' => 'eur',
		'fa-euro' => 'euro',
		'fa-gbp' => 'gbp',
		'fa-inr' => 'inr',
		'fa-jpy' => 'jpy',
		'fa-krw' => 'krw',
		'fa-money' => 'money',
		'fa-rmb' => 'rmb',
		'fa-rouble' => 'rouble',
		'fa-rub' => 'rub',
		'fa-ruble' => 'ruble',
		'fa-rupee' => 'rupee',
		'fa-try' => 'try',
		'fa-turkish-lira' => 'turkish-lira',
		'fa-usd' => 'usd',
		'fa-won' => 'won',
		'fa-yen' => 'yen',
		'fa-align-center' => 'align-center',
		'fa-align-justify' => 'align-justify',
		'fa-align-left' => 'align-left',
		'fa-align-right' => 'align-right',
		'fa-bold' => 'bold',
		'fa-chain' => 'chain',
		'fa-chain-broken' => 'chain-broken',
		'fa-clipboard' => 'clipboard',
		'fa-columns' => 'columns',
		'fa-copy' => 'copy',
		'fa-cut' => 'cut',
		'fa-dedent' => 'dedent',
		'fa-eraser' => 'eraser',
		'fa-file' => 'file',
		'fa-file-o' => 'file-o',
		'fa-file-text' => 'file-text',
		'fa-file-text-o' => 'file-text-o',
		'fa-files-o' => 'files-o',
		'fa-floppy-o' => 'floppy-o',
		'fa-font' => 'font',
		'fa-header' => 'header',
		'fa-indent' => 'indent',
		'fa-italic' => 'italic',
		'fa-link' => 'link',
		'fa-list' => 'list',
		'fa-list-alt' => 'list-alt',
		'fa-list-ol' => 'list-ol',
		'fa-list-ul' => 'list-ul',
		'fa-outdent' => 'outdent',
		'fa-paperclip' => 'paperclip',
		'fa-paragraph' => 'paragraph',
		'fa-paste' => 'paste',
		'fa-repeat' => 'repeat',
		'fa-rotate-left' => 'rotate-left',
		'fa-rotate-right' => 'rotate-right',
		'fa-save' => 'save',
		'fa-scissors' => 'scissors',
		'fa-strikethrough' => 'strikethrough',
		'fa-subscript' => 'subscript',
		'fa-superscript' => 'superscript',
		'fa-table' => 'table',
		'fa-text-height' => 'text-height',
		'fa-text-width' => 'text-width',
		'fa-th' => 'th',
		'fa-th-large' => 'th-large',
		'fa-th-list' => 'th-list',
		'fa-underline' => 'underline',
		'fa-undo' => 'undo',
		'fa-unlink' => 'unlink',
		'fa-angle-double-down' => 'angle-double-down',
		'fa-angle-double-left' => 'angle-double-left',
		'fa-angle-double-right' => 'angle-double-right',
		'fa-angle-double-up' => 'angle-double-up',
		'fa-angle-down' => 'angle-down',
		'fa-angle-left' => 'angle-left',
		'fa-angle-right' => 'angle-right',
		'fa-angle-up' => 'angle-up',
		'fa-arrow-circle-down' => 'arrow-circle-down',
		'fa-arrow-circle-left' => 'arrow-circle-left',
		'fa-arrow-circle-o-down' => 'arrow-circle-o-down',
		'fa-arrow-circle-o-left' => 'arrow-circle-o-left',
		'fa-arrow-circle-o-right' => 'arrow-circle-o-right',
		'fa-arrow-circle-o-up' => 'arrow-circle-o-up',
		'fa-arrow-circle-right' => 'arrow-circle-right',
		'fa-arrow-circle-up' => 'arrow-circle-up',
		'fa-arrow-down' => 'arrow-down',
		'fa-arrow-left' => 'arrow-left',
		'fa-arrow-right' => 'arrow-right',
		'fa-arrow-up' => 'arrow-up',
		'fa-arrows' => 'arrows',
		'fa-arrows-alt' => 'arrows-alt',
		'fa-arrows-h' => 'arrows-h',
		'fa-arrows-v' => 'arrows-v',
		'fa-caret-down' => 'caret-down',
		'fa-caret-left' => 'caret-left',
		'fa-caret-right' => 'caret-right',
		'fa-caret-square-o-down' => 'caret-square-o-down',
		'fa-caret-square-o-left' => 'caret-square-o-left',
		'fa-caret-square-o-right' => 'caret-square-o-right',
		'fa-caret-square-o-up' => 'caret-square-o-up',
		'fa-caret-up' => 'caret-up',
		'fa-chevron-circle-down' => 'chevron-circle-down',
		'fa-chevron-circle-left' => 'chevron-circle-left',
		'fa-chevron-circle-right' => 'chevron-circle-right',
		'fa-chevron-circle-up' => 'chevron-circle-up',
		'fa-chevron-down' => 'chevron-down',
		'fa-chevron-left' => 'chevron-left',
		'fa-chevron-right' => 'chevron-right',
		'fa-chevron-up' => 'chevron-up',
		'fa-hand-o-down' => 'hand-o-down',
		'fa-hand-o-left' => 'hand-o-left',
		'fa-hand-o-right' => 'hand-o-right',
		'fa-hand-o-up' => 'hand-o-up',
		'fa-long-arrow-down' => 'long-arrow-down',
		'fa-long-arrow-left' => 'long-arrow-left',
		'fa-long-arrow-right' => 'long-arrow-right',
		'fa-long-arrow-up' => 'long-arrow-up',
		'fa-toggle-down' => 'toggle-down',
		'fa-toggle-left' => 'toggle-left',
		'fa-toggle-right' => 'toggle-right',
		'fa-toggle-up' => 'toggle-up',
		'fa-arrows-alt' => 'arrows-alt',
		'fa-backward' => 'backward',
		'fa-compress' => 'compress',
		'fa-eject' => 'eject',
		'fa-expand' => 'expand',
		'fa-fast-backward' => 'fast-backward',
		'fa-fast-forward' => 'fast-forward',
		'fa-forward' => 'forward',
		'fa-pause' => 'pause',
		'fa-play' => 'play',
		'fa-play-circle' => 'play-circle',
		'fa-play-circle-o' => 'play-circle-o',
		'fa-step-backward' => 'step-backward',
		'fa-step-forward' => 'step-forward',
		'fa-stop' => 'stop',
		'fa-youtube-play' => 'youtube-play',
		'fa-adn' => 'adn',
		'fa-android' => 'android',
		'fa-apple' => 'apple',
		'fa-behance' => 'behance',
		'fa-behance-square' => 'behance-square',
		'fa-bitbucket' => 'bitbucket',
		'fa-bitbucket-square' => 'bitbucket-square',
		'fa-bitcoin' => 'bitcoin',
		'fa-btc' => 'btc',
		'fa-codepen' => 'codepen',
		'fa-css3' => 'css3',
		'fa-delicious' => 'delicious',
		'fa-deviantart' => 'deviantart',
		'fa-digg' => 'digg',
		'fa-dribbble' => 'dribbble',
		'fa-dropbox' => 'dropbox',
		'fa-drupal' => 'drupal',
		'fa-empire' => 'empire',
		'fa-facebook' => 'facebook',
		'fa-facebook-square' => 'facebook-square',
		'fa-flickr' => 'flickr',
		'fa-foursquare' => 'foursquare',
		'fa-ge' => 'ge',
		'fa-git' => 'git',
		'fa-git-square' => 'git-square',
		'fa-github' => 'github',
		'fa-github-alt' => 'github-alt',
		'fa-github-square' => 'github-square',
		'fa-gittip' => 'gittip',
		'fa-google' => 'google',
		'fa-google-plus' => 'google-plus',
		'fa-google-plus-square' => 'google-plus-square',
		'fa-hacker-news' => 'hacker-news',
		'fa-html5' => 'html5',
		'fa-instagram' => 'instagram',
		'fa-joomla' => 'joomla',
		'fa-jsfiddle' => 'jsfiddle',
		'fa-linkedin' => 'linkedin',
		'fa-linkedin-square' => 'linkedin-square',
		'fa-linux' => 'linux',
		'fa-maxcdn' => 'maxcdn',
		'fa-openid' => 'openid',
		'fa-pagelines' => 'pagelines',
		'fa-pied-piper' => 'pied-piper',
		'fa-pied-piper-alt' => 'pied-piper-alt',
		'fa-pied-piper-square' => 'pied-piper-square',
		'fa-pinterest' => 'pinterest',
		'fa-pinterest-square' => 'pinterest-square',
		'fa-qq' => 'qq',
		'fa-ra' => 'ra',
		'fa-rebel' => 'rebel',
		'fa-reddit' => 'reddit',
		'fa-reddit-square' => 'reddit-square',
		'fa-renren' => 'renren',
		'fa-share-alt' => 'share-alt',
		'fa-share-alt-square' => 'share-alt-square',
		'fa-skype' => 'skype',
		'fa-slack' => 'slack',
		'fa-soundcloud' => 'soundcloud',
		'fa-spotify' => 'spotify',
		'fa-stack-exchange' => 'stack-exchange',
		'fa-stack-overflow' => 'stack-overflow',
		'fa-steam' => 'steam',
		'fa-steam-square' => 'steam-square',
		'fa-stumbleupon' => 'stumbleupon',
		'fa-stumbleupon-circle' => 'stumbleupon-circle',
		'fa-tencent-weibo' => 'tencent-weibo',
		'fa-trello' => 'trello',
		'fa-tumblr' => 'tumblr',
		'fa-tumblr-square' => 'tumblr-square',
		'fa-twitter' => 'twitter',
		'fa-twitter-square' => 'twitter-square',
		'fa-vimeo-square' => 'vimeo-square',
		'fa-vine' => 'vine',
		'fa-vk' => 'vk',
		'fa-wechat' => 'wechat',
		'fa-weibo' => 'weibo',
		'fa-weixin' => 'weixin',
		'fa-windows' => 'windows',
		'fa-wordpress' => 'wordpress',
		'fa-xing' => 'xing',
		'fa-xing-square' => 'xing-square',
		'fa-yahoo' => 'yahoo',
		'fa-youtube' => 'youtube',
		'fa-youtube-play' => 'youtube-play',
		'fa-youtube-square' => 'youtube-square',
		'fa-ambulance' => 'ambulance',
		'fa-h-square' => 'h-square',
		'fa-hospital-o' => 'hospital-o',
		'fa-medkit' => 'medkit',
		'fa-plus-square' => 'plus-square',
		'fa-stethoscope' => 'stethoscope',
		'fa-user-md' => 'user-md',
		'fa-wheelchair' => 'wheelchair',
	);
	$icons = array();
	foreach ($icon as $key => $value) {
		$icons[] = $value;
	}
	return $icons;
}
endif;



/**
 * Add Author Name and URL fields to media uploader
 *
 * @param $form_fields array, fields to include in attachment form
 * @param $post object, attachment record in database
 * @return $form_fields, modified form fields
 */
function admin_attachment_field_media_author_credit( $form_fields, $post ) {

    $form_fields['media-author-name'] = array(
        'label' => __('Author Name','trizzy'),
        'input' => 'text',
        'value' => get_post_meta( $post->ID, 'media_author_name', true )
        //'helps' => 'If provided, author credit will be displayed'
    );

    $form_fields['media-author-url'] = array(
        'label' => __('Author URL','trizzy'),
        'input' => 'text',
        'value' => get_post_meta( $post->ID, 'media_author_url', true )
        //'helps' => 'If provided, the author credit will be linked'
    );

    return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'admin_attachment_field_media_author_credit', 10, 2 );
// what is it for?


/**
 * Save values of Author Name and URL in media uploader
 *
 * @param $post array, the post data for database
 * @param $attachment array, attachment fields from $_POST form
 * @return $post array, modified post data
 */

function admin_attachment_field_media_author_credit_save( $post, $attachment ) {

    if( isset( $attachment['media-author-name'] ) )
        update_post_meta( $post['ID'], 'media_author_name', $attachment['media-author-name'] );

    if( isset( $attachment['media-author-url'] ) )
        update_post_meta( $post['ID'], 'media_author_url', $attachment['media-author-url'] );

    return $post;

} add_filter( 'attachment_fields_to_save', 'admin_attachment_field_media_author_credit_save', 10, 2 );

/**
 * Save values of Author Name and URL in media uploader modal via AJAX
 */

function admin_attachment_field_media_author_credit_ajax_save() {

    $post_id = $_POST['id'];

    if( isset( $_POST['attachments'][$post_id]['media-author-name'] ) )
        update_post_meta( $post_id, 'media_author_name', $_POST['attachments'][$post_id]['media-author-name'] );

    if( isset( $_POST['attachments'][$post_id]['media-author-url'] ) )
        update_post_meta( $post_id, 'media_author_url', $_POST['attachments'][$post_id]['media-author-url'] );

    clean_post_cache($post_id);

}
add_action('wp_ajax_save-attachment-compat', 'admin_attachment_field_media_author_credit_ajax_save', 0, 1);


global $phantom_googlefonts;
$phantom_googlefonts = 'a:657:{s:7:"ABeeZee";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:4:"Abel";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:13:"Abril Fatface";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:8:"Aclonica";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:4:"Acme";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Actor";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Adamina";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Advent Pro";a:2:{s:8:"variants";a:7:{i:0;s:3:"100";i:1;s:3:"200";i:2;s:3:"300";i:3;s:7:"regular";i:4;s:3:"500";i:5;s:3:"600";i:6;s:3:"700";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"greek";i:2;s:5:"latin";}}s:15:"Aguafina Script";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Akronim";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Aladin";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Aldrich";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:4:"Alef";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Alegreya";a:2:{s:8:"variants";a:6:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";i:4;s:3:"900";i:5;s:9:"900italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Alegreya SC";a:2:{s:8:"variants";a:6:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";i:4;s:3:"900";i:5;s:9:"900italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:13:"Alegreya Sans";a:2:{s:8:"variants";a:14:{i:0;s:3:"100";i:1;s:9:"100italic";i:2;s:3:"300";i:3;s:9:"300italic";i:4;s:7:"regular";i:5;s:6:"italic";i:6;s:3:"500";i:7;s:9:"500italic";i:8;s:3:"700";i:9;s:9:"700italic";i:10;s:3:"800";i:11;s:9:"800italic";i:12;s:3:"900";i:13;s:9:"900italic";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:10:"vietnamese";}}s:16:"Alegreya Sans SC";a:2:{s:8:"variants";a:14:{i:0;s:3:"100";i:1;s:9:"100italic";i:2;s:3:"300";i:3;s:9:"300italic";i:4;s:7:"regular";i:5;s:6:"italic";i:6;s:3:"500";i:7;s:9:"500italic";i:8;s:3:"700";i:9;s:9:"700italic";i:10;s:3:"800";i:11;s:9:"800italic";i:12;s:3:"900";i:13;s:9:"900italic";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:10:"vietnamese";}}s:10:"Alex Brush";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:13:"Alfa Slab One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Alice";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Alike";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:13:"Alike Angular";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Allan";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Allerta";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:15:"Allerta Stencil";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Allura";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:8:"Almendra";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:16:"Almendra Display";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Almendra SC";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Amarante";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:8:"Amaranth";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Amatic SC";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Amethysta";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Anaheim";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Andada";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Andika";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:4:{i:0;s:9:"latin-ext";i:1;s:12:"cyrillic-ext";i:2;s:5:"latin";i:3;s:8:"cyrillic";}}s:6:"Angkor";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:24:"Annie Use Your Telescope";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:13:"Anonymous Pro";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:6:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:12:"cyrillic-ext";i:3;s:5:"greek";i:4;s:5:"latin";i:5;s:8:"cyrillic";}}s:5:"Antic";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:12:"Antic Didone";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Antic Slab";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Anton";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Arapey";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Arbutus";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Arbutus Slab";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:19:"Architects Daughter";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:13:"Archivo Black";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:14:"Archivo Narrow";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Arimo";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:7:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:12:"cyrillic-ext";i:3;s:5:"greek";i:4;s:5:"latin";i:5;s:10:"vietnamese";i:6;s:8:"cyrillic";}}s:8:"Arizonia";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Armata";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:8:"Artifika";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:4:"Arvo";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:4:"Asap";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Asset";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Astloch";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:4:"Asul";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Atomic Age";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Aubrey";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Audiowide";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Autour One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Average";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Average Sans";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:19:"Averia Gruesa Libre";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Averia Libre";a:2:{s:8:"variants";a:6:{i:0;s:3:"300";i:1;s:9:"300italic";i:2;s:7:"regular";i:3;s:6:"italic";i:4;s:3:"700";i:5;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:17:"Averia Sans Libre";a:2:{s:8:"variants";a:6:{i:0;s:3:"300";i:1;s:9:"300italic";i:2;s:7:"regular";i:3;s:6:"italic";i:4;s:3:"700";i:5;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:18:"Averia Serif Libre";a:2:{s:8:"variants";a:6:{i:0;s:3:"300";i:1;s:9:"300italic";i:2;s:7:"regular";i:3;s:6:"italic";i:4;s:3:"700";i:5;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Bad Script";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:5:"latin";i:1;s:8:"cyrillic";}}s:9:"Balthazar";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Bangers";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Basic";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Battambang";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:7:"Baumans";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Bayon";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:8:"Belgrano";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Belleza";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"BenchNine";a:2:{s:8:"variants";a:3:{i:0;s:3:"300";i:1;s:7:"regular";i:2;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Bentham";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:15:"Berkshire Swash";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Bevan";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:13:"Bigelow Rules";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Bigshot One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Bilbo";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:16:"Bilbo Swash Caps";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Bitter";a:2:{s:8:"variants";a:3:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:13:"Black Ops One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Bokor";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:6:"Bonbon";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Boogaloo";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Bowlby One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:13:"Bowlby One SC";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Brawler";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Bree Serif";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:14:"Bubblegum Sans";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Bubbler One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:4:"Buda";a:2:{s:8:"variants";a:1:{i:0;s:3:"300";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Buenard";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Butcherman";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:14:"Butterfly Kids";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Cabin";a:2:{s:8:"variants";a:8:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"500";i:3;s:9:"500italic";i:4;s:3:"600";i:5;s:9:"600italic";i:6;s:3:"700";i:7;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:15:"Cabin Condensed";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:3:"500";i:2;s:3:"600";i:3;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:12:"Cabin Sketch";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:15:"Caesar Dressing";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Cagliostro";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:14:"Calligraffitti";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Cambo";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Candal";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Cantarell";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Cantata One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Cantora One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:8:"Capriola";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Cardo";a:2:{s:8:"variants";a:3:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";}s:7:"subsets";a:4:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:5:"greek";i:3;s:5:"latin";}}s:5:"Carme";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:14:"Carrois Gothic";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:17:"Carrois Gothic SC";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Carter One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Caudex";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:4:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:5:"greek";i:3;s:5:"latin";}}s:18:"Cedarville Cursive";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Ceviche One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Changa One";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Chango";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:18:"Chau Philomene One";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Chela One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:14:"Chelsea Market";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Chenla";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:17:"Cherry Cream Soda";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:12:"Cherry Swash";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Chewy";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Chicle";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Chivo";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"900";i:3;s:9:"900italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Cinzel";a:2:{s:8:"variants";a:3:{i:0;s:7:"regular";i:1;s:3:"700";i:2;s:3:"900";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:17:"Cinzel Decorative";a:2:{s:8:"variants";a:3:{i:0;s:7:"regular";i:1;s:3:"700";i:2;s:3:"900";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:14:"Clicker Script";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:4:"Coda";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"800";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:12:"Coda Caption";a:2:{s:8:"variants";a:1:{i:0;s:3:"800";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Codystar";a:2:{s:8:"variants";a:2:{i:0;s:3:"300";i:1;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Combo";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Comfortaa";a:2:{s:8:"variants";a:3:{i:0;s:3:"300";i:1;s:7:"regular";i:2;s:3:"700";}s:7:"subsets";a:5:{i:0;s:9:"latin-ext";i:1;s:12:"cyrillic-ext";i:2;s:5:"greek";i:3;s:5:"latin";i:4;s:8:"cyrillic";}}s:11:"Coming Soon";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Concert One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Condiment";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Content";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:12:"Contrail One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Convergence";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Cookie";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Copse";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Corben";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Courgette";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Cousine";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:7:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:12:"cyrillic-ext";i:3;s:5:"greek";i:4;s:5:"latin";i:5;s:10:"vietnamese";i:6;s:8:"cyrillic";}}s:8:"Coustard";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"900";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:21:"Covered By Your Grace";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:12:"Crafty Girls";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Creepster";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Crete Round";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Crimson Text";a:2:{s:8:"variants";a:6:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"600";i:3;s:9:"600italic";i:4;s:3:"700";i:5;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:13:"Croissant One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Crushed";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Cuprum";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:6:"Cutive";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Cutive Mono";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Damion";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:14:"Dancing Script";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Dangrek";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:20:"Dawning of a New Day";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Days One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Delius";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:17:"Delius Swash Caps";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:14:"Delius Unicase";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:13:"Della Respira";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Denk One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Devonshire";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:13:"Didact Gothic";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:6:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:12:"cyrillic-ext";i:3;s:5:"greek";i:4;s:5:"latin";i:5;s:8:"cyrillic";}}s:9:"Diplomata";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Diplomata SC";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Domine";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Donegal One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Doppio One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Dorsa";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Dosis";a:2:{s:8:"variants";a:7:{i:0;s:3:"200";i:1;s:3:"300";i:2;s:7:"regular";i:3;s:3:"500";i:4;s:3:"600";i:5;s:3:"700";i:6;s:3:"800";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Dr Sugiyama";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Droid Sans";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:15:"Droid Sans Mono";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Droid Serif";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Duru Sans";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Dynalight";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"EB Garamond";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:5:{i:0;s:9:"latin-ext";i:1;s:12:"cyrillic-ext";i:2;s:5:"latin";i:3;s:10:"vietnamese";i:4;s:8:"cyrillic";}}s:10:"Eagle Lake";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Eater";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Economica";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Electrolize";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Elsie";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"900";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:16:"Elsie Swash Caps";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"900";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Emblema One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Emilys Candy";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Engagement";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Englebert";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Enriqueta";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Erica One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Esteban";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:15:"Euphoria Script";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Ewert";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:3:"Exo";a:2:{s:8:"variants";a:18:{i:0;s:3:"100";i:1;s:9:"100italic";i:2;s:3:"200";i:3;s:9:"200italic";i:4;s:3:"300";i:5;s:9:"300italic";i:6;s:7:"regular";i:7;s:6:"italic";i:8;s:3:"500";i:9;s:9:"500italic";i:10;s:3:"600";i:11;s:9:"600italic";i:12;s:3:"700";i:13;s:9:"700italic";i:14;s:3:"800";i:15;s:9:"800italic";i:16;s:3:"900";i:17;s:9:"900italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Exo 2";a:2:{s:8:"variants";a:18:{i:0;s:3:"100";i:1;s:9:"100italic";i:2;s:3:"200";i:3;s:9:"200italic";i:4;s:3:"300";i:5;s:9:"300italic";i:6;s:7:"regular";i:7;s:6:"italic";i:8;s:3:"500";i:9;s:9:"500italic";i:10;s:3:"600";i:11;s:9:"600italic";i:12;s:3:"700";i:13;s:9:"700italic";i:14;s:3:"800";i:15;s:9:"800italic";i:16;s:3:"900";i:17;s:9:"900italic";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:13:"Expletus Sans";a:2:{s:8:"variants";a:8:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"500";i:3;s:9:"500italic";i:4;s:3:"600";i:5;s:9:"600italic";i:6;s:3:"700";i:7;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:12:"Fanwood Text";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Fascinate";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:16:"Fascinate Inline";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Faster One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Fasthand";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:9:"Fauna One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:8:"Federant";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Federo";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Felipa";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Fenix";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Finger Paint";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Fjalla One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Fjord One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Flamenco";a:2:{s:8:"variants";a:2:{i:0;s:3:"300";i:1;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Flavors";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Fondamento";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:16:"Fontdiner Swanky";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Forum";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:4:{i:0;s:9:"latin-ext";i:1;s:12:"cyrillic-ext";i:2;s:5:"latin";i:3;s:8:"cyrillic";}}s:12:"Francois One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Freckle Face";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:20:"Fredericka the Great";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Fredoka One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Freehand";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:6:"Fresca";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Frijole";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Fruktur";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Fugaz One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"GFS Didot";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"greek";}}s:15:"GFS Neohellenic";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"greek";}}s:8:"Gabriela";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Gafata";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:8:"Galdeano";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Galindo";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:13:"Gentium Basic";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:18:"Gentium Book Basic";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:3:"Geo";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Geostar";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:12:"Geostar Fill";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:12:"Germania One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:13:"Gilda Display";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:14:"Give You Glory";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:13:"Glass Antiqua";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Glegoo";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:17:"Gloria Hallelujah";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Goblin One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Gochi Hand";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Gorditas";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:21:"Goudy Bookletter 1911";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Graduate";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Grand Hotel";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Gravitas One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Great Vibes";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Griffy";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Gruppo";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Gudea";a:2:{s:8:"variants";a:3:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Habibi";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:15:"Hammersmith One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Hanalei";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Hanalei Fill";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Handlee";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Hanuman";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:12:"Happy Monkey";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Headland One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Henny Penny";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:20:"Herr Von Muellerhoff";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:15:"Holtwood One SC";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:14:"Homemade Apple";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Homenaje";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:15:"IM Fell DW Pica";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:18:"IM Fell DW Pica SC";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:19:"IM Fell Double Pica";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:22:"IM Fell Double Pica SC";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:15:"IM Fell English";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:18:"IM Fell English SC";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:20:"IM Fell French Canon";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:23:"IM Fell French Canon SC";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:20:"IM Fell Great Primer";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:23:"IM Fell Great Primer SC";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Iceberg";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Iceland";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Imprima";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Inconsolata";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Inder";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Indie Flower";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Inika";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Irish Grover";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Istok Web";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:4:{i:0;s:9:"latin-ext";i:1;s:12:"cyrillic-ext";i:2;s:5:"latin";i:3;s:8:"cyrillic";}}s:8:"Italiana";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Italianno";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:16:"Jacques Francois";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:23:"Jacques Francois Shadow";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:14:"Jim Nightshade";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Jockey One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Jolly Lodger";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Josefin Sans";a:2:{s:8:"variants";a:10:{i:0;s:3:"100";i:1;s:9:"100italic";i:2;s:3:"300";i:3;s:9:"300italic";i:4;s:7:"regular";i:5;s:6:"italic";i:6;s:3:"600";i:7;s:9:"600italic";i:8;s:3:"700";i:9;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:12:"Josefin Slab";a:2:{s:8:"variants";a:10:{i:0;s:3:"100";i:1;s:9:"100italic";i:2;s:3:"300";i:3;s:9:"300italic";i:4;s:7:"regular";i:5;s:6:"italic";i:6;s:3:"600";i:7;s:9:"600italic";i:8;s:3:"700";i:9;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Joti One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Judson";a:2:{s:8:"variants";a:3:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Julee";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:15:"Julius Sans One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Junge";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:4:"Jura";a:2:{s:8:"variants";a:4:{i:0;s:3:"300";i:1;s:7:"regular";i:2;s:3:"500";i:3;s:3:"600";}s:7:"subsets";a:6:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:12:"cyrillic-ext";i:3;s:5:"greek";i:4;s:5:"latin";i:5;s:8:"cyrillic";}}s:17:"Just Another Hand";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:23:"Just Me Again Down Here";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Kameron";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Kantumruy";a:2:{s:8:"variants";a:3:{i:0;s:3:"300";i:1;s:7:"regular";i:2;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:5:"Karla";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:14:"Kaushan Script";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Kavoon";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Kdam Thmor";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:10:"Keania One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Kelly Slab";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:5:"Kenia";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Khmer";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:8:"Kite One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Knewave";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Kotta One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Koulen";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:6:"Kranky";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Kreon";a:2:{s:8:"variants";a:3:{i:0;s:3:"300";i:1;s:7:"regular";i:2;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Kristi";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Krona One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:15:"La Belle Aurore";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Lancelot";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:4:"Lato";a:2:{s:8:"variants";a:10:{i:0;s:3:"100";i:1;s:9:"100italic";i:2;s:3:"300";i:3;s:9:"300italic";i:4;s:7:"regular";i:5;s:6:"italic";i:6;s:3:"700";i:7;s:9:"700italic";i:8;s:3:"900";i:9;s:9:"900italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:13:"League Script";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:12:"Leckerli One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Ledger";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:6:"Lekton";a:2:{s:8:"variants";a:3:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Lemon";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:17:"Libre Baskerville";a:2:{s:8:"variants";a:3:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Life Savers";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Lilita One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:15:"Lily Script One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Limelight";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Linden Hill";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Lobster";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:4:{i:0;s:9:"latin-ext";i:1;s:12:"cyrillic-ext";i:2;s:5:"latin";i:3;s:8:"cyrillic";}}s:11:"Lobster Two";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:16:"Londrina Outline";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:15:"Londrina Shadow";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:15:"Londrina Sketch";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:14:"Londrina Solid";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:4:"Lora";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:21:"Love Ya Like A Sister";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:17:"Loved by the King";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:14:"Lovers Quarrel";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Luckiest Guy";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Lusitana";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Lustria";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Macondo";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:18:"Macondo Swash Caps";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Magra";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:13:"Maiden Orange";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:4:"Mako";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Marcellus";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Marcellus SC";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Marck Script";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:9:"Margarine";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Marko One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Marmelad";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:6:"Marvel";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:4:"Mate";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Mate SC";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Maven Pro";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:3:"500";i:2;s:3:"700";i:3;s:3:"900";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"McLaren";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Meddon";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:13:"MedievalSharp";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Medula One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Megrim";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Meie Script";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:8:"Merienda";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Merienda One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:12:"Merriweather";a:2:{s:8:"variants";a:8:{i:0;s:3:"300";i:1;s:9:"300italic";i:2;s:7:"regular";i:3;s:6:"italic";i:4;s:3:"700";i:5;s:9:"700italic";i:6;s:3:"900";i:7;s:9:"900italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:17:"Merriweather Sans";a:2:{s:8:"variants";a:8:{i:0;s:3:"300";i:1;s:9:"300italic";i:2;s:7:"regular";i:3;s:6:"italic";i:4;s:3:"700";i:5;s:9:"700italic";i:6;s:3:"800";i:7;s:9:"800italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Metal";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:11:"Metal Mania";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Metamorphous";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Metrophobic";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Michroma";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Milonga";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Miltonian";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:16:"Miltonian Tattoo";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Miniver";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:14:"Miss Fajardose";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:14:"Modern Antiqua";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Molengo";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Molle";a:2:{s:8:"variants";a:1:{i:0;s:6:"italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Monda";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:8:"Monofett";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Monoton";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:20:"Monsieur La Doulaise";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Montaga";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Montez";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Montserrat";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:21:"Montserrat Alternates";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:20:"Montserrat Subrayada";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:4:"Moul";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:8:"Moulpali";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:22:"Mountains of Christmas";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:13:"Mouse Memoirs";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Mr Bedfort";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:8:"Mr Dafoe";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:14:"Mr De Haviland";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:19:"Mrs Saint Delafield";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:13:"Mrs Sheppards";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:4:"Muli";a:2:{s:8:"variants";a:4:{i:0;s:3:"300";i:1;s:9:"300italic";i:2;s:7:"regular";i:3;s:6:"italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:13:"Mystery Quest";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Neucha";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:5:"latin";i:1;s:8:"cyrillic";}}s:6:"Neuton";a:2:{s:8:"variants";a:6:{i:0;s:3:"200";i:1;s:3:"300";i:2;s:7:"regular";i:3;s:6:"italic";i:4;s:3:"700";i:5;s:3:"800";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"New Rocker";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"News Cycle";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Niconne";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Nixie One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Nobile";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Nokora";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:7:"Norican";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Nosifer";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:20:"Nothing You Could Do";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:12:"Noticia Text";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:10:"vietnamese";}}s:9:"Noto Sans";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:8:{i:0;s:10:"devanagari";i:1;s:9:"greek-ext";i:2;s:9:"latin-ext";i:3;s:12:"cyrillic-ext";i:4;s:5:"greek";i:5;s:5:"latin";i:6;s:10:"vietnamese";i:7;s:8:"cyrillic";}}s:10:"Noto Serif";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:7:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:12:"cyrillic-ext";i:3;s:5:"greek";i:4;s:5:"latin";i:5;s:10:"vietnamese";i:6;s:8:"cyrillic";}}s:8:"Nova Cut";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Nova Flat";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Nova Mono";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:5:"greek";i:1;s:5:"latin";}}s:9:"Nova Oval";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Nova Round";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Nova Script";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Nova Slim";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Nova Square";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Numans";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Nunito";a:2:{s:8:"variants";a:3:{i:0;s:3:"300";i:1;s:7:"regular";i:2;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:14:"Odor Mean Chey";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:7:"Offside";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:15:"Old Standard TT";a:2:{s:8:"variants";a:3:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Oldenburg";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Oleo Script";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:22:"Oleo Script Swash Caps";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Open Sans";a:2:{s:8:"variants";a:10:{i:0;s:3:"300";i:1;s:9:"300italic";i:2;s:7:"regular";i:3;s:6:"italic";i:4;s:3:"600";i:5;s:9:"600italic";i:6;s:3:"700";i:7;s:9:"700italic";i:8;s:3:"800";i:9;s:9:"800italic";}s:7:"subsets";a:8:{i:0;s:10:"devanagari";i:1;s:9:"greek-ext";i:2;s:9:"latin-ext";i:3;s:12:"cyrillic-ext";i:4;s:5:"greek";i:5;s:5:"latin";i:6;s:10:"vietnamese";i:7;s:8:"cyrillic";}}s:19:"Open Sans Condensed";a:2:{s:8:"variants";a:3:{i:0;s:3:"300";i:1;s:9:"300italic";i:2;s:3:"700";}s:7:"subsets";a:7:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:12:"cyrillic-ext";i:3;s:5:"greek";i:4;s:5:"latin";i:5;s:10:"vietnamese";i:6;s:8:"cyrillic";}}s:11:"Oranienbaum";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:4:{i:0;s:9:"latin-ext";i:1;s:12:"cyrillic-ext";i:2;s:5:"latin";i:3;s:8:"cyrillic";}}s:8:"Orbitron";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:3:"500";i:2;s:3:"700";i:3;s:3:"900";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Oregano";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Orienta";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:15:"Original Surfer";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Oswald";a:2:{s:8:"variants";a:3:{i:0;s:3:"300";i:1;s:7:"regular";i:2;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:16:"Over the Rainbow";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Overlock";a:2:{s:8:"variants";a:6:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";i:4;s:3:"900";i:5;s:9:"900italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Overlock SC";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:3:"Ovo";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Oxygen";a:2:{s:8:"variants";a:3:{i:0;s:3:"300";i:1;s:7:"regular";i:2;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Oxygen Mono";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"PT Mono";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:4:{i:0;s:9:"latin-ext";i:1;s:12:"cyrillic-ext";i:2;s:5:"latin";i:3;s:8:"cyrillic";}}s:7:"PT Sans";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:4:{i:0;s:9:"latin-ext";i:1;s:12:"cyrillic-ext";i:2;s:5:"latin";i:3;s:8:"cyrillic";}}s:15:"PT Sans Caption";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:4:{i:0;s:9:"latin-ext";i:1;s:12:"cyrillic-ext";i:2;s:5:"latin";i:3;s:8:"cyrillic";}}s:14:"PT Sans Narrow";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:4:{i:0;s:9:"latin-ext";i:1;s:12:"cyrillic-ext";i:2;s:5:"latin";i:3;s:8:"cyrillic";}}s:8:"PT Serif";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:4:{i:0;s:9:"latin-ext";i:1;s:12:"cyrillic-ext";i:2;s:5:"latin";i:3;s:8:"cyrillic";}}s:16:"PT Serif Caption";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:4:{i:0;s:9:"latin-ext";i:1;s:12:"cyrillic-ext";i:2;s:5:"latin";i:3;s:8:"cyrillic";}}s:8:"Pacifico";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Paprika";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Parisienne";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Passero One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Passion One";a:2:{s:8:"variants";a:3:{i:0;s:7:"regular";i:1;s:3:"700";i:2;s:3:"900";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:18:"Pathway Gothic One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Patrick Hand";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:10:"vietnamese";}}s:15:"Patrick Hand SC";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:10:"vietnamese";}}s:9:"Patua One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Paytone One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Peralta";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:16:"Permanent Marker";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:19:"Petit Formal Script";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Petrona";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Philosopher";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:2:{i:0;s:5:"latin";i:1;s:8:"cyrillic";}}s:6:"Piedra";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:13:"Pinyon Script";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Pirata One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Plaster";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:4:"Play";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:6:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:12:"cyrillic-ext";i:3;s:5:"greek";i:4;s:5:"latin";i:5;s:8:"cyrillic";}}s:8:"Playball";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:16:"Playfair Display";a:2:{s:8:"variants";a:6:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";i:4;s:3:"900";i:5;s:9:"900italic";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:19:"Playfair Display SC";a:2:{s:8:"variants";a:6:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";i:4;s:3:"900";i:5;s:9:"900italic";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:7:"Podkova";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Poiret One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:10:"Poller One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:4:"Poly";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Pompiere";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:12:"Pontano Sans";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:16:"Port Lligat Sans";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:16:"Port Lligat Slab";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Prata";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Preahvihear";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:14:"Press Start 2P";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:4:{i:0;s:9:"latin-ext";i:1;s:5:"greek";i:2;s:5:"latin";i:3;s:8:"cyrillic";}}s:14:"Princess Sofia";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:8:"Prociono";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Prosto One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:7:"Puritan";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:12:"Purple Purse";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Quando";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:8:"Quantico";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:12:"Quattrocento";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:17:"Quattrocento Sans";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Questrial";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Quicksand";a:2:{s:8:"variants";a:3:{i:0;s:3:"300";i:1;s:7:"regular";i:2;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:14:"Quintessential";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Qwigley";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:15:"Racing Sans One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Radley";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Raleway";a:2:{s:8:"variants";a:9:{i:0;s:3:"100";i:1;s:3:"200";i:2;s:3:"300";i:3;s:7:"regular";i:4;s:3:"500";i:5;s:3:"600";i:6;s:3:"700";i:7;s:3:"800";i:8;s:3:"900";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:12:"Raleway Dots";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Rambla";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Rammetto One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:8:"Ranchers";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Rancho";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Rationale";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Redressed";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:13:"Reenie Beanie";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Revalia";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Ribeye";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:13:"Ribeye Marrow";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Righteous";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Risque";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Roboto";a:2:{s:8:"variants";a:12:{i:0;s:3:"100";i:1;s:9:"100italic";i:2;s:3:"300";i:3;s:9:"300italic";i:4;s:7:"regular";i:5;s:6:"italic";i:6;s:3:"500";i:7;s:9:"500italic";i:8;s:3:"700";i:9;s:9:"700italic";i:10;s:3:"900";i:11;s:9:"900italic";}s:7:"subsets";a:7:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:12:"cyrillic-ext";i:3;s:5:"greek";i:4;s:5:"latin";i:5;s:10:"vietnamese";i:6;s:8:"cyrillic";}}s:16:"Roboto Condensed";a:2:{s:8:"variants";a:6:{i:0;s:3:"300";i:1;s:9:"300italic";i:2;s:7:"regular";i:3;s:6:"italic";i:4;s:3:"700";i:5;s:9:"700italic";}s:7:"subsets";a:7:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:12:"cyrillic-ext";i:3;s:5:"greek";i:4;s:5:"latin";i:5;s:10:"vietnamese";i:6;s:8:"cyrillic";}}s:11:"Roboto Slab";a:2:{s:8:"variants";a:4:{i:0;s:3:"100";i:1;s:3:"300";i:2;s:7:"regular";i:3;s:3:"700";}s:7:"subsets";a:7:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:12:"cyrillic-ext";i:3;s:5:"greek";i:4;s:5:"latin";i:5;s:10:"vietnamese";i:6;s:8:"cyrillic";}}s:9:"Rochester";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Rock Salt";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Rokkitt";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Romanesco";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Ropa Sans";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Rosario";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Rosarivo";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Rouge Script";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:4:"Ruda";a:2:{s:8:"variants";a:3:{i:0;s:7:"regular";i:1;s:3:"700";i:2;s:3:"900";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Rufina";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Ruge Boogie";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Ruluko";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Rum Raisin";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:14:"Ruslan Display";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:4:{i:0;s:9:"latin-ext";i:1;s:12:"cyrillic-ext";i:2;s:5:"latin";i:3;s:8:"cyrillic";}}s:9:"Russo One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:6:"Ruthie";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:3:"Rye";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Sacramento";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:4:"Sail";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Salsa";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Sanchez";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:8:"Sancreek";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Sansita One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Sarina";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Satisfy";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Scada";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:10:"Schoolbell";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:14:"Seaweed Script";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Sevillana";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Seymour One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:18:"Shadows Into Light";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:22:"Shadows Into Light Two";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Shanti";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Share";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Share Tech";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:15:"Share Tech Mono";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Shojumaru";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Short Stack";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Siemreap";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:10:"Sigmar One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Signika";a:2:{s:8:"variants";a:4:{i:0;s:3:"300";i:1;s:7:"regular";i:2;s:3:"600";i:3;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:16:"Signika Negative";a:2:{s:8:"variants";a:4:{i:0;s:3:"300";i:1;s:7:"regular";i:2;s:3:"600";i:3;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Simonetta";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"900";i:3;s:9:"900italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Sintony";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:13:"Sirin Stencil";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Six Caps";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Skranji";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Slackey";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Smokum";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Smythe";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Sniglet";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"800";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Snippet";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:13:"Snowburst One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Sofadi One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Sofia";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Sonsie One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:16:"Sorts Mill Goudy";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:6:"italic";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:15:"Source Code Pro";a:2:{s:8:"variants";a:7:{i:0;s:3:"200";i:1;s:3:"300";i:2;s:7:"regular";i:3;s:3:"500";i:4;s:3:"600";i:5;s:3:"700";i:6;s:3:"900";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:15:"Source Sans Pro";a:2:{s:8:"variants";a:12:{i:0;s:3:"200";i:1;s:9:"200italic";i:2;s:3:"300";i:3;s:9:"300italic";i:4;s:7:"regular";i:5;s:6:"italic";i:6;s:3:"600";i:7;s:9:"600italic";i:8;s:3:"700";i:9;s:9:"700italic";i:10;s:3:"900";i:11;s:9:"900italic";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:10:"vietnamese";}}s:13:"Special Elite";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Spicy Rice";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Spinnaker";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Spirax";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Squada One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Stalemate";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:13:"Stalinist One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:15:"Stardos Stencil";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:21:"Stint Ultra Condensed";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:20:"Stint Ultra Expanded";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Stoke";a:2:{s:8:"variants";a:2:{i:0;s:3:"300";i:1;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Strait";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:19:"Sue Ellen Francisco";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Sunshiney";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:16:"Supermercado One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Suwannaphum";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:18:"Swanky and Moo Moo";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Syncopate";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:9:"Tangerine";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Taprom";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"khmer";}}s:5:"Tauri";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Telex";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Tenor Sans";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:4:{i:0;s:9:"latin-ext";i:1;s:12:"cyrillic-ext";i:2;s:5:"latin";i:3;s:8:"cyrillic";}}s:11:"Text Me One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:18:"The Girl Next Door";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Tienne";a:2:{s:8:"variants";a:3:{i:0;s:7:"regular";i:1;s:3:"700";i:2;s:3:"900";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Tinos";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:7:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:12:"cyrillic-ext";i:3;s:5:"greek";i:4;s:5:"latin";i:5;s:10:"vietnamese";i:6;s:8:"cyrillic";}}s:9:"Titan One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:13:"Titillium Web";a:2:{s:8:"variants";a:11:{i:0;s:3:"200";i:1;s:9:"200italic";i:2;s:3:"300";i:3;s:9:"300italic";i:4;s:7:"regular";i:5;s:6:"italic";i:6;s:3:"600";i:7;s:9:"600italic";i:8;s:3:"700";i:9;s:9:"700italic";i:10;s:3:"900";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:11:"Trade Winds";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Trocchi";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Trochut";a:2:{s:8:"variants";a:3:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Trykker";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Tulpen One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Ubuntu";a:2:{s:8:"variants";a:8:{i:0;s:3:"300";i:1;s:9:"300italic";i:2;s:7:"regular";i:3;s:6:"italic";i:4;s:3:"500";i:5;s:9:"500italic";i:6;s:3:"700";i:7;s:9:"700italic";}s:7:"subsets";a:6:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:12:"cyrillic-ext";i:3;s:5:"greek";i:4;s:5:"latin";i:5;s:8:"cyrillic";}}s:16:"Ubuntu Condensed";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:6:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:12:"cyrillic-ext";i:3;s:5:"greek";i:4;s:5:"latin";i:5;s:8:"cyrillic";}}s:11:"Ubuntu Mono";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:6:{i:0;s:9:"greek-ext";i:1;s:9:"latin-ext";i:2;s:12:"cyrillic-ext";i:3;s:5:"greek";i:4;s:5:"latin";i:5;s:8:"cyrillic";}}s:5:"Ultra";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:14:"Uncial Antiqua";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Underdog";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:9:"Unica One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:14:"UnifrakturCook";a:2:{s:8:"variants";a:1:{i:0;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:18:"UnifrakturMaguntia";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:7:"Unkempt";a:2:{s:8:"variants";a:2:{i:0;s:7:"regular";i:1;s:3:"700";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Unlock";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:4:"Unna";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"VT323";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Vampiro One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:6:"Varela";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:12:"Varela Round";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:11:"Vast Shadow";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:5:"Vibur";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Vidaloka";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:4:"Viga";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:5:"Voces";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:7:"Volkhov";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Vollkorn";a:2:{s:8:"variants";a:4:{i:0;s:7:"regular";i:1;s:6:"italic";i:2;s:3:"700";i:3;s:9:"700italic";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Voltaire";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:23:"Waiting for the Sunrise";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:8:"Wallpoet";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:15:"Walter Turncoat";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Warnes";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Wellfleet";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:9:"Wendy One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:8:"Wire One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:17:"Yanone Kaffeesatz";a:2:{s:8:"variants";a:4:{i:0;s:3:"200";i:1;s:3:"300";i:2;s:7:"regular";i:3;s:3:"700";}s:7:"subsets";a:2:{i:0;s:9:"latin-ext";i:1;s:5:"latin";}}s:10:"Yellowtail";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:10:"Yeseva One";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:3:{i:0;s:9:"latin-ext";i:1;s:5:"latin";i:2;s:8:"cyrillic";}}s:10:"Yesteryear";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}s:6:"Zeyada";a:2:{s:8:"variants";a:1:{i:0;s:7:"regular";}s:7:"subsets";a:1:{i:0;s:5:"latin";}}}';

if ( ! function_exists( 'ot_type_googlefonts' ) ) {

  function ot_type_googlefonts( $args = array() ) {

    /* turns arguments array into variables */
    extract( $args );

    /* verify a description */
    $has_desc = $field_desc ? true : false;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-typography ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

      /* description */
      echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '';

      /* format setting inner wrapper */
      echo '<div class="format-setting-inner" id="'.esc_attr( $field_id ).'">';

        /* allow fields to be filtered */
        $ot_recognized_typography_fields = apply_filters( 'ot_recognized_typography_fields', array(
          'font-family',
          'font-variant',
          'font-subset',

        ), $field_id );

        global $phantom_googlefonts;
        $fontsarray = unserialize($phantom_googlefonts);

        /* build font family */
            if ( in_array( 'font-family', $ot_recognized_typography_fields ) ) {
              $font_family = isset( $field_value['font-family'] ) ? $field_value['font-family'] : '';
              echo '<select id="' . esc_attr( $field_id ) . '-font-family" class="option-tree-ui-select ot-google-fonts-ajax ' . esc_attr( $field_class ) . '">';
                echo '<option value="">font-family</option>';
                foreach ( $fontsarray as $key => $value ) {
                  echo '<option value="' . esc_attr( $key ) . '" ' . selected( $font_family, $key, false ) . '>' . esc_attr( $key ) . '</option>';
                }
              echo '</select>';
            }
        echo '<div style="clear:both"></div>';
            echo '<div class="ot-google-fonts-wrapper">';
            if($font_family) {
                if( isset($fontsarray[$font_family]) ) {
                    $variants = $fontsarray[$font_family]['variants'];
                    if( isset($fontsarray[$font_family]['subsets']) ) {
                        $subsets = $fontsarray[$font_family]['subsets'];
                    } else {
                        $subset = '';
                    }
                }
            }?>
            <div class="format-setting-inner">
            <?php if(!empty($variants)) { ?>
                <div id="variants">
                    <h4 class="label"><?php _e('Font variants','trizzy'); ?></h4>
                    <?php $i = 0; foreach ($variants as $key => $value) { ?>
                    <p>
                        <input type="checkbox"  id="pp-<?php echo $field_id; ?>-variants-<?php echo $i; ?>" value="<?php echo $value ?>" <?php isset( $field_value['variants'][$i] ) ? checked( $field_value['variants'][$i], $value, true ) : ''; ?> class="option-tree-ui-checkbox ">
                        <label for="pp-<?php echo $field_id; ?>-variants-<?php echo $i; ?>"><?php echo $value; ?></label>
                    </p>
                    <?php $i++; }
                } ?>
                </div>
            <?php if(!empty($subsets)) { ?>
                <div id="subsets">
                    <h4 class="label"><?php _e('Font subsets','trizzy'); ?></h4>
                    <?php $y = 0; foreach ($subsets as $key => $value) { ?>
                        <p>
                        <input type="checkbox" id="pp-<?php echo $field_id; ?>-subsets-<?php echo $y; ?>" value="<?php echo $value ?>" <?php isset( $field_value['subsets'][$y] ) ? checked( $field_value['subsets'][$y], $value, true ) : ''; ?> class="option-tree-ui-checkbox ">
                        <label for="pp-<?php echo $field_id; ?>-subsets-0"><?php echo $value ?></label>
                    </p>
                    <?php $y++;
                    }
                } ?>
                </div>
            </div>
            <?php
      echo '</div>';
    ?>
    <a id="ot-google-fonts-save" class="option-tree-ui-button button button-primary" href="#"><?php _e('Add to your font stack','trizzy'); ?></a>
    <div style="clear:both"></div>
    <h4><?php _e('Your fonts stack','trizzy'); ?></h4>
    <div id="ot-saved-fonts">
    <?php if(!empty($field_value)){
        foreach ($field_value as $key => $value) {?>
        <div class="option-tree-setting">
          <div class="open"><strong><?php echo $key; ?></strong> - <?php echo $value['variants']; ?> - <?php echo $value['subsets']; ?></div>
          <div class="button-section">
            <a href="javascript:void(0);" class="option-tree-font-remove option-tree-ui-button button button-secondary light right-item" title="Delete">
              <span class="icon ot-icon-trash"></span><?php _e('Delete','trizzy'); ?>
            </a>
          </div>
          <input type="hidden" name="option_tree[trizzy_font][<?php echo $key ?>][font-name]" value="<?php echo $key ?>">
          <input type="hidden" name="option_tree[trizzy_font][<?php echo $key ?>][variants]" value="<?php echo $value['variants'];  ?>">
          <input type="hidden" name="option_tree[trizzy_font][<?php echo $key ?>][subsets]" value="<?php echo $value['subsets']; ?>">
        </div>
          <?php
        }
    } ?>
    </div>
    <?php
  }
}

add_action( 'wp_ajax_ot_load_fonts',  'ot_load_fonts' );
function ot_load_fonts() {

    global $phantom_googlefonts;
    global $phantom_brickfonts;
    $id = isset( $_POST['id'] ) ? $_POST['id'] : '';
    $fontslibrary = isset( $_POST['family'] ) ? $_POST['family'] : 'gfonts';
    switch ($fontslibrary) {
        case 'gfonts':
            $fontsarray = unserialize($phantom_googlefonts);
            break;
        case 'brick':
            $fontsarray = $phantom_brickfonts;
            break;
        default:
            $fontsarray = unserialize($phantom_googlefonts);
            break;
    }

    if ( !empty( $_POST['name'] ) )  {
        $variants = $fontsarray[$_POST['name']]['variants'];
        if( isset($fontsarray[$_POST['name']]['subsets']) ) {
            $subsets = $fontsarray[$_POST['name']]['subsets'];
        } else {
            $subset = '';
    	}
    ?>
    <div class="format-setting-inner">
    <?php if(!empty($variants)) { ?>
        <h4 class="label"><?php _e('Font variants','trizzy'); ?></h4>
        <div id="variants">
        <?php $i = 0; foreach ($variants as $key => $value) { ?>
            <p>
            <input type="checkbox" id="pp-<?php echo $id; ?>-variants-<?php echo $i; ?>" <?php if($value == 'regular') { echo "checked='checked'"; } ?> value="<?php echo $value ?>" class="option-tree-ui-checkbox ">
            <label for="pp-<?php echo $id; ?>-variants-<?php echo $i; ?>"><?php echo $value ?></label>
        </p>
        <?php $i++; }
        echo '</div>';
    } ?>
    <?php if(!empty($subsets)) { ?>
        <h4 class="label"><?php _e('Font subsets','trizzy'); ?></h4>
        <div id="subsets">
        <?php $y = 0; foreach ($subsets as $key => $value) { ?>
            <p>
            <input type="checkbox" id="pp-<?php echo $id; ?>-subsets-<?php echo $y; ?>" <?php if($value == 'latin') { echo "checked='checked'"; } ?> value="<?php echo $value ?>" class="option-tree-ui-checkbox ">
            <label for="pp-<?php echo $id; ?>-subsets-<?php echo $y; ?>"><?php echo $value ?></label>
        </p>
        <?php $y++; }
        echo "</div>";
    } ?>
    </div>
    <?php
    }
    die();
}

add_action( 'wp_ajax_ot_save_fonts',  'ot_save_fonts' );
function ot_save_fonts() {

    $fontname = isset( $_POST['fontname'] ) ? $_POST['fontname'] : '';
    $variants = isset( $_POST['variants'] ) ? $_POST['variants'] : '';
    $subsets = isset( $_POST['subsets'] ) ? $_POST['subsets'] : '';


    if ( !empty( $_POST['fontname'] ) )  {
    ?>
    <div class="option-tree-setting">
      <div class="open"><strong><?php echo $fontname; ?></strong> - <?php echo implode($variants); ?> - <?php echo implode ($subsets); ?></div>
      <div class="button-section">
        <a href="javascript:void(0);" class="option-tree-font-remove  option-tree-ui-button button button-secondary light right-item" title="Delete">
          <span class="icon ot-icon-trash"></span><?php _e('Delete','trizzy'); ?>
        </a>
      </div>
      <input type="hidden" name="option_tree[trizzy_font][<?php echo $fontname ?>][font-name]" value="<?php echo $fontname ?>">
      <input type="hidden" name="option_tree[trizzy_font][<?php echo $fontname ?>][variants]" value="<?php echo implode(",",$variants); ?>">
      <input type="hidden" name="option_tree[trizzy_font][<?php echo $fontname ?>][subsets]" value="<?php echo implode(",",$subsets); ?>">
    </div>
    <?php
    }
    die();
}

function filter_ot_recognized_font_families( $array, $field_id ) {
    /* only run the filter when the field ID is my_google_fonts_headings */
    $fonts = ot_get_option('trizzy_font');
    foreach ($fonts as $key => $value) {
        $array[$key] = $key;
    }
    return $array;
}
add_filter( 'ot_recognized_font_families', 'filter_ot_recognized_font_families', 10, 2 );


function phantom_get_google_fonts_json(){
    $json_data = file_get_contents(TEMPLATEPATH.'/inc/fonts.json');
    $data = json_decode($json_data,true);
    $items = $data['items'];
    $i = 0;
    $googlefonts = array();
    foreach ($items as $item) {
        if(!empty($item['variants'])) { $variants = $item['variants']; } else { $variants = ''; }
        if(!empty($item['subsets'])) { $subsets = $item['subsets']; } else { $subsets = ''; }
        $googlefonts[$item['family']] = array(
            'variants'=> $variants,
            'subsets'=> $subsets,
            );
    }
    echo serialize($googlefonts);
}
// admin scripts

function add_video_wmode_transparent($html, $url, $attr) {
	if ( strpos( $html, "<embed src=" ) !== false )
		{ return str_replace('</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $html); }
	elseif ( strpos ( $html, 'feature=oembed' ) !== false )
		{ return str_replace( 'feature=oembed', 'feature=oembed&wmode=opaque', $html ); }
	else
		{ return $html; }
}
add_filter( 'embed_oembed_html', 'add_video_wmode_transparent', 10, 3);


add_filter( 'widget_tag_cloud_args', 'trizzy_widget_tag_cloud_args' );
function trizzy_widget_tag_cloud_args( $args ) {
	$args['number'] = 12;
	$args['largest'] = 12;
	$args['smallest'] = 12;
	$args['unit'] = 'px';
	return $args;
}



function trizzy_fallback_menu(){
    $args = array(
        'sort_column' => 'menu_order, post_title',
        'menu_class'  => '',
        'include'     => '',
        'exclude'     => '',
        'echo'        => true,
        'show_home'   => false,
        'link_before' => '',
        'link_after'  => '' );
    wp_page_menu($args);

}

function add_menuclass( $ulclass ) {
  return preg_replace( '/<ul>/', '<ul id="responsive" class="menu js-enabled arrows">', $ulclass, 1 );
}
add_filter( 'wp_page_menu', 'add_menuclass' );

add_filter('wp_nav_menu_items','add_search_box_to_menu', 10, 2);
function add_search_box_to_menu( $items, $args ) {
	if(is_page_template( 'template-homesimple.php')) {
		if( $args->theme_location == 'primary' ) {
		return $items.'<li id="search-in-menu">
					<form action="'.home_url().'" id="searchform" method="get">
						<i class="fa fa-search"></i><input type="text" class="search-text-box"   name="s">
					</form>
				</li>';
		}
	}
	return $items;
}
?>