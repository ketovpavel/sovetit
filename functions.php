<?php

if ( ! defined( 'THEME_DIR' ) ) {
	define( 'THEME_DIR',        dirname( __FILE__ ) );
	define( 'THEME_VERSION',    wp_get_theme()->get( 'Version' ) );
	define( 'THEME_DOMAIN',     wp_get_theme()->get( 'TextDomain' ) );
}

if ( ! function_exists( 'sovetit_setup' ) ) {
	/**
	 * @see sovetit_setup
	 * @author Pavel Ketov <pavel@sovetit.ru>
	 * @copyright Copyright (c) 2021, SoveTit RU
	 * Date: 16.05.2021
	 */
	function sovetit_setup() {

		load_theme_textdomain( THEME_DOMAIN, THEME_DIR . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support(
			'post-formats',
			array(
				'link',
				'aside',
				'gallery',
				'image',
				'quote',
				'status',
				'video',
				'audio',
				'chat',
			)
		);
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1568, 9999 );
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary menu', THEME_DOMAIN ),
				'footer'  => __( 'Secondary menu', THEME_DOMAIN ),
			)
		);
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

		$logo_width  = 300;
		$logo_height = 100;
		add_theme_support(
			'custom-logo',
			array(
				'height'               => $logo_height,
				'width'                => $logo_width,
				'flex-width'           => true,
				'flex-height'          => true,
				'unlink-homepage-logo' => true,
			)
		);
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Load Carbon Fields
		 */
		require THEME_DIR . '/inc/fields/vendor/autoload.php';
		Carbon_Fields\Carbon_Fields::boot();

		/**
		 * Register Carbon Fields compatibility file.
		 *
		 * @see sovetit_register_fields
		 * @author Pavel Ketov <pavel@sovetit.ru>
		 * @copyright Copyright (c) 2021, SoveTit RU
		 * Date: 16.05.2021
		 */
		function sovetit_register_fields() {
			if ( class_exists( 'Carbon_Fields\Carbon_Fields' ) ) {
				require_once THEME_DIR . '/inc/fields/vendor/functions-plugin.php';
				require_once THEME_DIR . '/inc/fields/post-meta.php';
			}
		}
		add_action( 'carbon_fields_register_fields', 'sovetit_register_fields', 1 );
	}
}
add_action( 'after_setup_theme', 'sovetit_setup' );

/**
 * Register widget area.
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @see sovetit_widgets_init
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 * Date: 16.05.2021
 */
function sovetit_widgets_init() {

	register_sidebar(
		[
			'name'          => esc_html__( 'Footer', THEME_DOMAIN ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your footer.', THEME_DOMAIN ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		]
	);
}
add_action( 'widgets_init', 'sovetit_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * This variable is intended to be overruled from themes.
 * @link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043
 *
 * @see sovetit_content_width
 * @global int $content_width Content width.
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 * Date: 16.05.2021
 */
function sovetit_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'sovetit_content_width', 750 );
}
add_action( 'after_setup_theme', 'sovetit_content_width', 0 );

/**
 * @see sovetit_enqueue_scripts
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 * Date: 16.05.2021
 */
function sovetit_enqueue_scripts() {

	wp_enqueue_style( THEME_DOMAIN . '-main', get_template_directory_uri() . '/assets/css/style.min.css', [], THEME_VERSION );
	wp_enqueue_style( THEME_DOMAIN . '-style', get_stylesheet_uri(), [], THEME_VERSION );

}
add_action( 'wp_enqueue_scripts', 'sovetit_enqueue_scripts' );

/**
 * Calculate classes for the main <html> element.
 *
 * @see sovetit_the_html_classes
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 * Date: 16.05.2021
 */
function sovetit_the_html_classes() {
	$classes = apply_filters( THEME_DOMAIN . '_html_classes', '' );
	if ( ! $classes ) {
		return;
	}
	echo 'class="' . esc_attr( $classes ) . '"';
}

/** Optimization BEGIN */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
add_action('wp_default_scripts', function ( $scripts ) {
	if ( ! empty( $scripts->registered['jquery'] ) ) {
		$scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, ['jquery-migrate'] );
	}
});
add_filter( 'emoji_svg_url', '__return_false' );
/** Optimization END */

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require THEME_DIR . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require THEME_DIR . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require THEME_DIR . '/inc/jetpack.php';
}

/**
 * @see sovetit_customize_preview_init
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 * Date: 23.05.2021
 */
function sovetit_customize_preview_init() {

	wp_enqueue_style(
		THEME_DOMAIN . '-customize',
		get_template_directory_uri() . '/inc/admin/css/customizer.css',
		[ 'customize-preview' ],
		THEME_VERSION
	);

	wp_enqueue_script(
		THEME_DOMAIN . '-customizer',
		get_template_directory_uri() . '/inc/admin/js/customize.js',
		[ 'customize-preview' ],
		THEME_VERSION
	);

}
add_action( 'customize_preview_init', 'sovetit_customize_preview_init' );

/**
 * @see sovetit_customize_admin_init
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 * Date: 24.05.2021
 */
function sovetit_customize_admin_init() {

	wp_enqueue_style(
		THEME_DOMAIN . '-admin',
		get_template_directory_uri() . '/inc/admin/css/style.css',
		[],
		THEME_VERSION
	);

	wp_enqueue_script(
		THEME_DOMAIN . '-admin',
		get_template_directory_uri() . '/inc/admin/js/script.js',
		[],
		THEME_VERSION
	);
}
add_action( 'admin_enqueue_scripts', 'sovetit_customize_admin_init' );

/**
 * Displaying an array in a readable form
 *
 * @see pre
 *
 * @param      $arr
 * @param null $var_dump
 *
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 * Date: 17.05.2021
 */
function pre( $arr, $var_dump = null ): void {
	if ( current_user_can( 'manage_options' ) ) {
		?>
		<pre> <?php
			if ( $var_dump === 1 ) {
				var_dump( $arr );
			} elseif ( $arr ) {
				print_r( $arr );
			} else {
				echo 'Empty :(';
			}
			?> </pre> <?php
	}
}