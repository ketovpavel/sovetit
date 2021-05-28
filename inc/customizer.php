<?php
/**
 * Theme Options – The Customize API
 * @link https://developer.wordpress.org/themes/customize-api/
 *
 * @see sovetit_customize_register
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 *
 * @copyright Copyright (c) 2021, SoveTit RU
 * Date: 16.05.2021
 * @author Pavel Ketov <pavel@sovetit.ru>
 */
function sovetit_customize_register( $wp_customize ) {

	if ( isset( $wp_customize->selective_refresh ) ) {

		$wp_customize->selective_refresh->add_partial( 'header_text_button', array(
			'selector'        => '.get-header a',
			'render_callback' => 'sovetit_customize_header_text_button',
		) );

		$wp_customize->selective_refresh->add_partial( 'footer_text_button', array(
			'selector'        => '.get-footer a',
			'render_callback' => 'sovetit_customize_footer_text_button',
		) );

		/** Example function sovetit_choices_post_type */
		$choices_post_type = sovetit_choices_post_type( 'post' ); // Записи или для CF7 'wpcf7_contact_form'
		if ( $choices_post_type ) {
			$wp_customize->selective_refresh->add_partial( 'footer_example_post', array(
				'selector'        => '#footer_example_post',
				'render_callback' => 'sovetit_customize_footer_example_post',
			) );
		}

		/* Settings Header */
		$wp_customize->add_section(
			'settings_header',
			array(
				'title' => esc_html__( 'Header', THEME_DOMAIN ),
				'priority' => 80,
			)
		);

		$wp_customize->add_setting('header_text_button',
			[ 'default' => sovetit_get_theme_text_default( 'header_text_button' ) ]
		)->transport = 'postMessage';
		$wp_customize->add_control(
			'header-text-button',
			array(
				'label' => esc_html__( 'Button text', THEME_DOMAIN ),
				'section' => 'settings_header',
				'type' => 'text',
			)
		);

		/* Settings Footer */
		$wp_customize->add_section(
			'settings_footer',
			array(
				'title' => esc_html__( 'Footer', THEME_DOMAIN ),
				'priority' => 80,
			)
		);

		$wp_customize->add_setting('footer_text_button',
			[ 'default' => sovetit_get_theme_text_default( 'footer_text_button' ) ]
		)->transport = 'postMessage';
		$wp_customize->add_control(
			'footer-text-button',
			array(
				'label' => esc_html__( 'Button text', THEME_DOMAIN ),
				'section' => 'settings_footer',
				'type' => 'text',
			)
		);

		/** Example function sovetit_choices_post_type */
		if ( $choices_post_type ) {
			$wp_customize->add_setting('footer_example_post', [ 'default' => 0 ] );
			$wp_customize->add_control(
				'footer_example_post', [
					'label' => esc_html__( 'Example post', THEME_DOMAIN ),
					'section' => 'settings_footer',
					'type'    => 'select',
					'choices' => $choices_post_type,
				]
			);
		}

	}
}
add_action( 'customize_register', 'sovetit_customize_register' );

function sovetit_customize_header_text_button() {
	return get_theme_mod('header_text_button');
}
function sovetit_customize_footer_text_button() {
	return get_theme_mod('footer_text_button');
}

/** Example function sovetit_choices_post_type */
function sovetit_customize_footer_example_post() {
	return get_theme_mod('footer_example_post');
}