<?php
 /**
 * Plugin Name: WC Order Analytics Add-on
 * Plugin URI: 
 * Description: Include a personalized column within the WC Analytics report.
 * Version: 1.0.2
 * Requires at least: 6.3
 * Tested up to: 6.6.2
 * Requires PHP: 7.4
 * Author: BrainFleck Solution
 * Author URI: https://brainfleck.com/
 * Network: true
 * @package WooCommerce\Admin
 * Text Domain: wc-order-analytics-add-on
 * License: GPLv2 or later
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */



defined( 'ABSPATH' ) || exit;

define( 'WCOAA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WCOAA_VERSION', '1.0.2' );
define( 'WCOAA_TEMPLATE_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/' );
define( 'WCOAA_PLUGIN_PATH', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
define( 'WCOAA_MAIN_FILE', __FILE__ );
define( 'WCOAA_ABSPATH', dirname( __FILE__ ) . '/' );
define( 'WCOAA_TEXT', 'wc-order-analytics-add-on' );
define( 'WCOAA_MAIN_FILE_NAME', basename( __FILE__ ) );
define( 'WCOAA_MAIN_DIR_NAME', basename( dirname( __FILE__ ) ) );
define( 'WCOAA_UPLOAD_DIR', wp_upload_dir()['basedir'] );

/**
 * Check upon activation of the WooCommerce plugin.
*/

if (! function_exists('is_plugin_active')) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if (! is_plugin_active('woocommerce/woocommerce.php')) {
    add_action('admin_notices', 'wcoaa_not_active_notice');
} else {
    
    if (! class_exists('WCOAA_Report_Main', false)) {
        include_once WCOAA_ABSPATH . '/includes/class-oa-addon-report-main.php';

        /**
         * Main instance function.
         */
        function wcoaa()
        {
            return WCOAA_Report_Main::instance();
        }
        wcoaa();
    }
}

/**
 * Display a notice in the WordPress admin if WooCommerce is not activated.
 */
function wcoaa_not_active_notice()
{
?>
    <div class="notice notice-error is-dismissible">
        <p>
            <?php
            /* translators: %s: plugin name */
            printf(
                esc_html__('The %s plugin requires WooCommerce to be activated. Please activate WooCommerce first.', 'wc-order-analytics-add-on'),
                '<strong>WC Order Analytics Add-on</strong>'
            );
            ?>
        </p>
    </div>
<?php
}