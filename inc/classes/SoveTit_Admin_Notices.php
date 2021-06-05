<?php
/**
 * Дополнительная проверка полей в админке
 *
 * Class SoveTit_Admin_Notices
 *
 * @link https://wp-kama.ru/hook/admin_notices
 *
 */
class SoveTit_Admin_Notices {

	/**
	 * SoveTit_Admin_Notices constructor.
	 */
	public function __construct() {
		add_action( 'save_post', [ $this, 'save_post' ] );
		add_action( 'admin_notices', [ $this, 'admin_notices' ] );
	}

	/**
	 * @see save_post
	 *
	 * @param $post_id
	 *
	 * @copyright Copyright (c) 2021, SoveTit RU
	 * @author Pavel Ketov <pavel@sovetit.ru>
	 */
	public function save_post( $post_id ) {

		$post = get_post($post_id );

		if( $post->post_status == 'publish' && ! has_post_thumbnail($post_id ) && get_post_type() == 'post' ) {

			wp_update_post( [ 'ID' => $post_id, 'post_status' => 'draft' ] );
			add_filter( 'redirect_post_location', [ $this, 'notice_thumbnail' ], 99 );

		}
	}

	/**
	 * @see notice_thumbnail
	 *
	 * @param $location
	 *
	 * @return string
	 * @author Pavel Ketov <pavel@sovetit.ru>
	 * @copyright Copyright (c) 2021, SoveTit RU
	 */
	public function notice_thumbnail( $location ) {
		remove_filter( 'redirect_post_location', [ $this, 'notice_thumbnail' ], 99 );
		return add_query_arg( [ 'sv-field' => 'thumbnail' ], $location );
	}

	/**
	 * @see admin_notices
	 *
	 * @author Pavel Ketov <pavel@sovetit.ru>
	 * @copyright Copyright (c) 2021, SoveTit RU
	 */
	public function admin_notices() {

		if ( ! isset( $_GET['sv-field'] ) ) {
			return;
		} else {
			/**
			 * Очищаем строку
			 * @var $field
			 */
			$field = sanitize_text_field( $_GET['sv-field'] );
		}

		switch ( $field ) {
			case 'thumbnail' :
				?>
				<div class="notice notice-error is-dismissible">
					<p><?php esc_html_e( 'The post has not been published because the post image has not been set!', THEME_DOMAIN ) ?></p>
				</div>
				<?php
				break;
		}

	}
}