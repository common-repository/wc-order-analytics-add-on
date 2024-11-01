<?php
/**
 *  Addon Main Class
 *
 *  @package WooCommerce\Admin
 */
defined( 'ABSPATH' ) || exit;

/**
 * Main Class
 */
class WCOAA_Report_Main {

	/**
	 * Created Instance for main class
	 *
	 * @var Object
	 */
	protected static $_instance = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->includes();
	}

	/**
	 * Instance function
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Includes other class files
	 */
	public function includes() {
		if ( ! class_exists( 'WCOAA_Admin_Main', false ) ) {
			include_once WCOAA_ABSPATH . 'includes/admin/class-oa-addon-admin-main.php';
			new WCOAA_Admin_Main();
		}
	}
}
