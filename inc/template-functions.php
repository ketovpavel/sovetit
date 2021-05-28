<?php
/**
 * Настройки темы по умолчанию
 *
 * @see sovetit_get_theme_text_default
 *
 * @param $name
 *
 * @return string|null
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 * Date: 16.05.2021
 */
function sovetit_get_theme_text_default( $name ) {
	switch ( $name ) {
		case 'home_text_button' :
			$default = esc_html__('Designed to be timeless', THEME_DOMAIN );
			break;
		default : $default = null;
	}
	return $default;
}

/**
 * @see sovetit_get_home_screen_settings
 *
 * @param $name
 *
 * @copyright Copyright (c) 2021, SoveTit RU
 * Date: 16.05.2021
 * @author Pavel Ketov <pavel@sovetit.ru>
 */
function sovetit_get_home_screen_settings( $name ) {
	echo empty( get_theme_mod( $name ) ) ? sovetit_get_theme_text_default( $name ) : get_theme_mod( $name );
}

if ( ! function_exists( 'sovetit_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function sovetit_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
		/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', THEME_DOMAIN ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
}

if ( ! function_exists( 'sovetit_posted_by' ) ) {
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function sovetit_posted_by() {
		$byline = sprintf(
		/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', THEME_DOMAIN ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
}

if ( ! function_exists( 'sovetit_entry_footer' ) ) {
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function sovetit_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', THEME_DOMAIN ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', THEME_DOMAIN ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', THEME_DOMAIN ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', THEME_DOMAIN ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
					/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', THEME_DOMAIN ),
						[
							'span' => [
								'class' => [],
							],
						]
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', THEME_DOMAIN ),
					[
						'span' => [
							'class' => [],
						],
					]
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
}

if ( ! function_exists( 'sovetit_post_thumbnail' ) ) {
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function sovetit_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail(
					'post-thumbnail',
					[
						'alt' => the_title_attribute(
							[
								'echo' => false,
							]
						),
					]
				);
				?>
			</a>

		<?php
		endif; // End is_singular().
	}
}

if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

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
 * Преобразовываем время в нормальный вид
 *
 * @see sovetit_get_post_time
 *
 * @param $get_post_time
 *
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 *
 * @example sovetit_get_post_time( get_post_time() );
 */
function sovetit_get_post_time( $get_post_time ) {
	date_default_timezone_set( 'Europe/Moscow' );
	$ndate 			= date('d.m.Y', $get_post_time );
	$ndate_time 	= date('H:i', $get_post_time );
	$ndate_exp 		= explode('.', $ndate);
	$nmonth = [
		1 => 	esc_html__( 'jan', THEME_DOMAIN ),	// янв
		2 => 	esc_html__( 'feb', THEME_DOMAIN ),	// фев
		3 => 	esc_html__( 'mar', THEME_DOMAIN ),	// мар
		4 => 	esc_html__( 'apr', THEME_DOMAIN ),	// апр
		5 => 	esc_html__( 'may', THEME_DOMAIN ),	// мая
		6 => 	esc_html__( 'jun', THEME_DOMAIN ),	// июн
		7 => 	esc_html__( 'jul', THEME_DOMAIN ),	// июл
		8 => 	esc_html__( 'aug', THEME_DOMAIN ),	// авг
		9 => 	esc_html__( 'sep', THEME_DOMAIN ),	// сен
		10 => 	esc_html__( 'oct', THEME_DOMAIN ),	// окт
		11 => 	esc_html__( 'nov', THEME_DOMAIN ),	// ноя
		12 => 	esc_html__( 'dec', THEME_DOMAIN )	// дек
	];
	$nmonth_name = '';
	foreach ( $nmonth as $key => $value ) {
		if( $key == intval( $ndate_exp[1] ) ) $nmonth_name = $value;
	}
	if( $ndate == date( 'd.m.Y' ) )
		echo esc_html__( 'Today', THEME_DOMAIN ) . ', '.$ndate_time;
	elseif( $ndate == date( 'd.m.Y', strtotime( '-1 day' ) ) )
		echo esc_html__( 'Yesterday', THEME_DOMAIN ) . ', '.$ndate_time;
	else echo $ndate_exp[0].' '.$nmonth_name.', '.$ndate_time;
}