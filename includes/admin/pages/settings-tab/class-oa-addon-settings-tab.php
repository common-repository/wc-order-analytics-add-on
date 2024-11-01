<?php
/**
 * Addon Settings Tab
 *
 * @package WooCommerce\Admin
 */
defined( 'ABSPATH' ) || exit;

/**
 * Addon Settings Tab Class
 */
class WCOAA_Settings_Tab {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'oa_wc_order_analytics_tab' ), 50 );
		add_action( 'woocommerce_settings_tabs_wc_order_analytics', array( $this, 'oa_wc_order_analytics_settings_tab' ), 10 );
		add_action( 'woocommerce_settings_save_wc_order_analytics', array( $this, 'oa_wc_order_analytics_settings_tab_save' ), 10 );
	}

	/**
	 * Create order analytics tab
	 *
	 * @var $settings_tabs: string
	 */
	function oa_wc_order_analytics_tab( $settings_tabs ) {
		$settings_tabs['wc_order_analytics'] = __( 'Order analytics', 'wc-order-analytics-add-on' );
		return $settings_tabs;
	}

	/**
	 * Call order analytics tab view
	 */
	function oa_wc_order_analytics_settings_tab() {
		include_once WCOAA_ABSPATH . 'includes/admin/views/settings-tab.php';
	}

	/**
	 * Save order analytics data
	 */
	function oa_wc_order_analytics_settings_tab_save() {
		// $order_analytics = ! empty( $_REQUEST['meta'] ) ? $_REQUEST['meta'] : '';
		// update_option( 'bfs_order_analytics', $order_analytics );

		if (isset($_REQUEST['meta']) && is_array($_REQUEST['meta'])) {
            $sanitized_meta = array();
        
            foreach ($_REQUEST['meta'] as $key => $value_array) {
                $sanitized_value_array = array();
        
                foreach ($value_array as $subkey => $subvalue) {
                    $sanitized_value_array[$subkey] = sanitize_text_field($subvalue);
                }
        
                $sanitized_meta[$key] = $sanitized_value_array;
            }
            update_option('bfs_order_analytics', $sanitized_meta);
        }
	}
}
new WCOAA_Settings_Tab();
