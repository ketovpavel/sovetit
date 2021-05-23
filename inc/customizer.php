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

		/* Settings Header */
		$wp_customize->add_section(
			'settings_header',
			array(
				'title' => __( 'Header', THEME_DOMAIN ),
				'priority' => 80,
			)
		);

		$wp_customize->add_setting('header_text_button',
			[ 'default' => sovetit_get_theme_text_default( 'header_text_button' ) ]
		)->transport = 'postMessage';
		$wp_customize->add_control(
			'header-text-button',
			array(
				'label' => __( 'Button text', THEME_DOMAIN ),
				'section' => 'settings_header',
				'type' => 'text',
			)
		);

		/* Settings Footer */
		$wp_customize->add_section(
			'settings_footer',
			array(
				'title' => __( 'Footer', THEME_DOMAIN ),
				'priority' => 80,
			)
		);

		$wp_customize->add_setting('footer_text_button',
			[ 'default' => sovetit_get_theme_text_default( 'footer_text_button' ) ]
		)->transport = 'postMessage';
		$wp_customize->add_control(
			'footer-text-button',
			array(
				'label' => __( 'Button text', THEME_DOMAIN ),
				'section' => 'settings_footer',
				'type' => 'text',
			)
		);

	}
}
add_action( 'customize_register', 'sovetit_customize_register' );

function sovetit_customize_header_text_button() {
	return get_theme_mod('header_text_button');
}
function sovetit_customize_footer_text_button() {
	return get_theme_mod('footer_text_button');
}