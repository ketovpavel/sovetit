<?php

if ( ! defined( 'THEME_DIR' ) ) {
	define( 'THEME_DIR',        dirname( __FILE__ ) );
	define( 'THEME_VERSION',    wp_get_theme()->get( 'Version' ) );
	define( 'THEME_DOMAIN',     wp_get_theme()->get( 'TextDomain' ) );
	define( 'THEME_URI',    	get_template_directory_uri() );
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
				'footer'  => esc_html__( 'Secondary menu', THEME_DOMAIN ),
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

		/**
		 * Load theme classes
		 */
		sovetit_load_classes([
			/**
			 * Is class SoveTit_Admin_Notices compatibility file
			 * Раскомментировать, если нужна дополнительная проверка полей в админке
			 * Uncomment if you need additional check of fields in the admin panel
			 */
			//'SoveTit_Admin_Notices',
		]);
	}
}
add_action( 'after_setup_theme', 'sovetit_setup' );


/**
 * Load theme classes
 *
 * @see sovetit_load_classes
 *
 * @param array $class_name
 * @param bool  $widget
 *
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 */
function sovetit_load_classes( $class_name = [], $widget = false ) {

	if ( ! is_array( $class_name ) ) {

		$title_arr 	= '<h1>' . esc_html__( "Function error: ", THEME_DOMAIN ) . '<small>' . __FUNCTION__ . '()</small></h1>';
		$mess_arr = $title_arr . '<br>' . sprintf(
				__( '<h3>A correct example of passing parameters to a function:</h3><code>%s</code><p>It turns out that you need to pass it as an array <b>;)</b></p>', THEME_DOMAIN ),
				__FUNCTION__ . "( array( '" . $class_name . "', 'SoveTit_Admin_Notices', 'My_Class' ) )",
			);

		wp_die( $mess_arr, $title_arr );
	}

	$title 	= esc_html__( "No class: ", THEME_DOMAIN );
	$mess 	= esc_html__( "Failed to load class: ", THEME_DOMAIN );

	if ( $widget ) {
		foreach ( $class_name as $class ) {
			include THEME_DIR . "/inc/classes/widgets/{$class}.php";
			if ( class_exists( $class ) ) {
				register_widget( $class );
			} else {
				wp_die( $mess . $class, $title . $class );
			}
		}
	} else {
		foreach ( $class_name as $class ) {
			include THEME_DIR . "/inc/classes/{$class}.php";
			if ( class_exists( $class ) ) {
				new $class;
			} else {
				wp_die( $mess . $class, $title . $class );
			}
		}
	}
}

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

	wp_enqueue_style( THEME_DOMAIN . '-main', THEME_URI . '/assets/css/style.min.css', [], THEME_VERSION );
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
		THEME_URI. '/inc/admin/css/customizer.css',
		[ 'customize-preview' ],
		THEME_VERSION
	);

	wp_enqueue_script(
		THEME_DOMAIN . '-customizer',
		THEME_URI . '/inc/admin/js/customize.js',
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
		THEME_URI . '/inc/admin/css/style.css',
		[],
		THEME_VERSION
	);

	wp_enqueue_script(
		THEME_DOMAIN . '-admin',
		THEME_URI . '/inc/admin/js/script.js',
		[],
		THEME_VERSION
	);
}
add_action( 'admin_enqueue_scripts', 'sovetit_customize_admin_init' );

/**
 * Получаем массив типа записи для использования в Customize
 *
 * @see sovetit_choices_post_type
 *
 * @param $post_type
 *
 * @return array|bool
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 *
 * @example Пример массив созданных форм Contact Form 7
```
print_r( sovetit_choices_post_type( 'wpcf7_contact_form' ) );
Array (
[0] 	=> — Выбрать —
[206] 	=> Первая
[207] 	=> Вторая
)

```
 */
function sovetit_choices_post_type( $post_type ) {

	$posts = get_posts([
		'post_type'         => $post_type,
		'posts_per_page'	=> -1,
		'orderby'           => 'ID',
		'order'             => 'ASC',
	]);

	if ( empty( $posts ) ) return false;

	$title = [ 0 => __( '&mdash; Select &mdash;' ) ];

	foreach ( $posts as $field ) {
		sovetit_remove_requests_field( $field );
		$title[$field->ID] .= $field->post_title;
	}

	return $title;
}

/**
 * @see sovetit_remove_requests_field
 *
 * @param $field
 *
 * @return mixed
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 */
function sovetit_remove_requests_field( $field ) {
	unset(
		$field->post_author,
		$field->post_date,
		$field->post_date_gmt,
		$field->post_content,
		$field->post_excerpt,
		$field->post_status,
		$field->comment_status,
		$field->ping_status,
		$field->post_password,
		$field->post_name,
		$field->to_ping,
		$field->pinged,
		$field->post_modified,
		$field->post_modified_gmt,
		$field->post_content_filtered,
		$field->guid,
		$field->menu_order,
		$field->post_type,
		$field->post_mime_type,
		$field->comment_count,
		$field->filter
	);
	return $field;
}

/**
 * Количество записей
 *
 * @see sovetit_posts_count
 *
 * @param array $args
 *
 * @return int
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 */
function sovetit_posts_count( $args = [] ) {

	$posts = get_posts( array_merge(
		$args,
		[ 'posts_per_page'  => -1 ]
	));

	foreach ( $posts as $filed ) {
		sovetit_remove_requests_field( $filed );
		unset( $filed->post_title, $filed->post_parent );
	}

	$count = count( $posts );

	if ( $count < 1 ) return 0;

	return $count;

}

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