<?php
/**
 *  Addon Admin
 *
 *  @package WooCommerce\Admin
 */
defined( 'ABSPATH' ) || exit;

/**
 *  Admin Main Class
 */
class WCOAA_Admin_Main {

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->includes();
		add_action( 'admin_enqueue_scripts', array( $this, 'wcoaa_register_script' ), 10 );
	}

	/**
	 * Instance function
	 */
	public function includes() {

		include_once WCOAA_ABSPATH . 'includes/admin/pages/settings-tab/class-oa-addon-settings-tab.php';
		include_once WCOAA_ABSPATH . 'includes/admin/pages/report-orders/class-oa-addon-report-orders.php';
	}

	/**
	 * Enqueue admin scripts and styles
	 */
	function wcoaa_register_script() {

		if ( ! class_exists( 'Automattic\WooCommerce\Admin\PageController' ) || ! \Automattic\WooCommerce\Admin\PageController::is_admin_or_embed_page() ) {
			return;
		}

		$script_path       = '/build/index.js';
		$script_asset_path = WCOAA_ABSPATH . '/build/index.asset.php';
		$script_asset      = file_exists( $script_asset_path )
			? include $script_asset_path
			: array(
				'dependencies' => array(),
				'version'      => filemtime( $script_path ),
			);
		$script_url        = WCOAA_PLUGIN_URL . $script_path;

		wp_register_script(
			'wc-order-analytics-add-on',
			$script_url,
			$script_asset['dependencies'],
			$script_asset['version'],
			true
		);

		wp_register_style(
			'wc-order-analytics-add-on',
			WCOAA_PLUGIN_URL . '/build/style.css',
			array(),
			filemtime( WCOAA_ABSPATH . '/build/style.css' )
		);

		$get_columns = get_option( 'bfs_order_analytics' );
		wp_localize_script(
			'wc-order-analytics-add-on',
			'data',
			array(
				'ajaxurl'   => admin_url( 'admin-ajax.php' ),
				'columns'   => $get_columns,
				'meta_keys' => $this->get_order_meta_keys(),

			)
		);

		wp_enqueue_script( 'wc-order-analytics-add-on' );
		wp_enqueue_style( 'wc-order-analytics-add-on' );
	}


	/**
	 * Get meta key of all orders
	 */
	public static function get_order_meta_keys() {
		global $wpdb;

		$meta_keys = array('billing_address', 'shipping_address', 'email_address');

		$db_meta_keys = $wpdb->get_col("SELECT DISTINCT(meta_key) FROM {$wpdb->prefix}wc_orders_meta WHERE order_id IN (SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'shop_order_placehold')");

		$meta_keys = array_merge($meta_keys, $db_meta_keys);
		
		return $meta_keys;
	}

}
