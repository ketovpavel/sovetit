<?php
/**
 * Получаем ID страницы по его slug
 *
 * @see sovetit_on_page_id
 *
 * @param $post_name
 *
 * @return int
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 * Date: 16.05.2021
 */
function sovetit_on_page_id( $post_name ) {
	$page_id = absint( $post_name );
	if ( $page_id && $page_id == $post_name ) {
		$page_obj = get_post( $page_id );
	} else {
		$page_obj = get_page_by_path( $post_name );
	}
	$page_id = ( $page_obj ) ? $page_obj->ID : -1;
	return $page_id;
}

/**
 * Сокращаем функцию без ID
 *
 * @see sovetit_get_post_meta
 *
 * @param        $key
 * @param null   $post_id
 * @param string $single
 *
 * @return mixed
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 * Date: 16.05.2021
 */
function sovetit_get_post_meta( $key, $post_id = null, $single = '' ) {
	if ( empty ( $post_id ) ) {
		$result = carbon_get_post_meta( get_the_ID(), $key, $single );
	} else {
		$result = carbon_get_post_meta( $post_id, $key, $single );
	}
	return $result;
}

/**
 * Переписать мета, так же сокращ. без ID
 *
 * @see sovetit_set_post_meta
 *
 * @param        $key
 * @param        $value
 * @param null   $post_id
 * @param string $single
 *
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 * Date: 16.05.2021
 */
function sovetit_set_post_meta( $key, $value, $post_id = null, $single = '' ) {
	if ( empty ( $post_id ) ) {
		carbon_set_post_meta( get_the_ID(), $key, $value, $single );
	} else {
		carbon_set_post_meta( $post_id, $key, $value, $single );
	}
}

/**
 * @see sovetit_guten_styles
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2021, SoveTit RU
 * Date: 16.05.2021
 */
function sovetit_guten_styles() {
	?>
	<style type="text/css">
		.block-editor-block-list__layout .wp-block {
			max-width: 100% !important;
		}
		.block-editor-block-list__layout .wp-block .cf-complex__groups {
			background-color: #fbfbfc;
		}
		.block-editor-block-list__layout .wp-block .cf-complex__group-body {
			border: 0 !important;
		}
		.block-editor-block-list__layout .block-editor .cf-complex .cf-field {
			padding-left: 15px;
			padding-bottom: 15px;
		}
		.block-editor-block-list__layout .wp-block .cf-complex--grid .cf-complex__group {
			margin-bottom: 0 !important;
			padding-bottom: 0 !important;
		}
		.block-editor-block-list__layout .wp-block .cf-complex--grid .cf-complex__group.cf-complex__group--collapsed{
			padding-bottom: 0;
		}
		.block-editor-block-list__layout .wp-block .cf-complex__group-head {
			border-top: 0 !important;
			border-right: 0 !important;
			border-bottom: 0 !important;
			border-left: 0 !important;
			flex-direction: column;
			align-items: center;
		}
		.block-editor-block-list__layout .wp-block .cf-complex__group-head {
			border-top: 0 !important;
		}
		.block-editor-block-list__layout .wp-block .cf-complex__group.cf-complex__group--grid {
			border: 1px solid #c5c5c5 !important;
		}
		.block-editor-block-list__layout .wp-block .cf-complex__group-head:hover {
			border-top: 0 !important;
		}
		.block-editor-block-list__layout .wp-block .cf-complex__group.cf-complex__group--grid:hover {
			border: 1px solid #cccccc !important;
		}
		.block-editor-block-list__layout .wp-block .cf-complex__group-index {
			color: #c5c5c5;
			font-weight: bold;
			font-size: 20px;
			line-height: 24px;
			border-right: 0 !important;
		}
		.block-editor-block-list__layout .wp-block .cf-field__head {
			color: #82878c;
			font-size: 14px;
			line-height: normal;
		}
		.block-editor-block-list__layout .wp-block .cf-field__asterisk {
			margin-left: 2px;
			font-size: 20px;
			vertical-align: sub;
		}
		.block-editor-block-list__layout .wp-block .cf-complex__groups {
			display: grid;
			flex: unset !important;
			gap: 1em;
		}

		.grid-template-columns-1 .cf-complex__groups {
			grid-template-columns: auto;
		}
		.grid-template-columns-2 .cf-complex__groups {
			grid-template-columns: repeat(2, auto);
		}
		.grid-template-columns-3 .cf-complex__groups {
			grid-template-columns: repeat(3, auto);
		}
		.grid-template-columns-4 .cf-complex__groups {
			grid-template-columns: repeat(4, auto);
		}

		.block-editor-block-list__layout .wp-block .cf-field .cf-textarea__input {
			height: 100px;
			min-height: 100px;
		}
		.block-editor-block-list__layout .wp-block .cf-field .cf-text__input {
			padding: 5px 15px;
			font-size: large;
			border-color: #e2e4e7;
			background-color: #e2e4e7;
		}
		.block-editor-block-list__layout .wp-block .cf-field .cf-textarea__input{
			padding: 15px;
			font-size: large;
			border-color: #e2e4e7;
			background-color: #e2e4e7;
		}
		.block-editor-block-list__layout .wp-block .cf-field .cf-text__input:hover,
		.block-editor-block-list__layout .wp-block .cf-field .cf-textarea__input:hover
		{
			background-color: #dde4ef;
		}
		.block-editor-block-list__layout .wp-block .cf-field .cf-text__input:focus,
		.block-editor-block-list__layout .wp-block .cf-field .cf-textarea__input:focus
		{
			background-color: #ffffff;
			border-color: #e2e4e7 !important;
		}
		.block-editor-block-list__layout .cf-field__label {
			margin-left: 5px;
			font-size: 18px;
			line-height: 20px;
			color: #ababab;
		}
		.block-editor-block-list__layout .cf-block__fields .cf-complex__group-action {
			color: #ffffff !important;
		}
		.block-editor-block-list__layout .cf-block__fields .cf-complex__group-action span:hover {
			color: #82878c !important;
		}
		.block-editor-block-list__layout .cf-block__fields .cf-complex__group-head {
			background-color: #23282e !important;
		}

		.cf-complex--grid .cf-complex__group.cf-complex__group--collapsed .cf-complex__group-action .dashicons-admin-page,
		.cf-complex--grid .cf-complex__group.cf-complex__group--collapsed .cf-complex__group-action .dashicons-trash
		{
			display: none;
		}

		.block-editor-block-list__layout .cf-complex__actions {
			margin: 15px 0 !important;
		}
		.block-editor-block-list__layout .cf-field.cf-complex.cf-complex--grid div.cf-field__body > div.cf-complex__actions > button,
		.block-editor-block-list__layout .cf-field.cf-complex.cf-complex--grid > div.cf-field__body > div.cf-complex__actions > div > button {
			font-size: 14px !important;
			padding: 3px 15px !important;
			color: #ffffff !important;
			border-color: #2271b1 !important;
			background: #2271b1 !important;
			border-width: 2px !important;
			border-radius: 0 !important;
		}
		.block-editor-block-list__layout .cf-field.cf-complex.cf-complex--grid div.cf-field__body > div.cf-complex__actions > button:hover,
		.block-editor-block-list__layout .cf-field.cf-complex.cf-complex--grid > div.cf-field__body > div.cf-complex__actions > div > button:hover {
			color: #2271b1 !important;
			background: #ffffff !important;
		}

		.block-editor-block-list__layout .wp-block .cf-block__fields {
			margin-bottom: 50px;
			padding: 20px 50px;
			background: #f3f3f3;
		}

	</style>
	<?php
}
add_action( 'admin_print_styles', 'sovetit_guten_styles' );