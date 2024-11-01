<?php
/**
 *  Addon Order Report
 *
 *  @package WooCommerce\Admin
 */
defined( 'ABSPATH' ) || exit;

/**
 *  Addon Order Report Class
 */
class WCOAA_Report_Orders {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'woocommerce_rest_prepare_report_orders', array( $this, 'wcoaa_rest_prepare_report_orders' ), 10, 3 );
	}

	/**
	 * Filter a report.
	 *
	 * Modification of the report data.
	 *
	 * @param WP_REST_Response $response The response object.
	 * @param object           $report   The original report object.
	 * @param WP_REST_Request  $request  Request used to generate the response.
	 */
	function wcoaa_rest_prepare_report_orders( $response, $report, $request ) {

		$sku = array();
		$course_start_date = array();

		if ( isset( $response->data['extended_info'] ) && isset( $response->data['extended_info']['products'] ) ) {

			foreach ( $response->data['extended_info']['products'] as $product ) {

				$sku[] = get_post_meta( $product['id'], '_sku', true );

				$course_date         = get_post_meta( $product['id'], 'course_start_date', true );
				$course_date         = isset( $course_date ) ? date( 'Y-m-d', strtotime( $course_date ) ) : '';
				$course_start_date[] = $course_date;
			}
		}
		$response->data['sku']         = implode( ', ', $sku );
		$response->data['course_date'] = (string) implode( ', ', $course_start_date );

		$student_ref = '';
		if ( isset( $response->data['extended_info']['customer']['user_id'] ) ) {

			$user_id     = $response->data['extended_info']['customer']['user_id'];
			$student_ref = get_user_meta( $user_id, 'student_reference', true );
		}
		$response->data['student_reference'] = $student_ref;
		$get_columns                         = get_option( 'bfs_order_analytics' );
		$order_id                            = ( isset( $response->data['order_id'] ) && $response->data['order_id'] ) ? $response->data['order_id'] : '';
		$order                               = wc_get_order( $order_id );

		foreach ( $get_columns as $column ) {
			$key = ( isset( $column['key'] ) && $column['key'] ) ? $column['key'] : '';

			$response->data[ $key ] = $order->get_meta( $key );

		}
		$billing_address = $order->get_formatted_billing_address();
		$billing_address = str_replace( '<br/>', "\n", $billing_address );

		$shipping_address = $order->get_formatted_shipping_address();
		$shipping_address = str_replace( '<br/>', "\n", $shipping_address );

		$response->data['billing_address'] = $billing_address;
		$response->data['shipping_address'] = $shipping_address;
		$response->data['email_address'] = $order->get_billing_email();
		return $response;
	}

}
new WCOAA_Report_Orders();
