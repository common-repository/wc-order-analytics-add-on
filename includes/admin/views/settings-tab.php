<?php
/**
 * Create view for setting tab
 *
 * @package WooCommerce\Admin
 */
defined( 'ABSPATH' ) || exit;

	$meta_keys = WCOAA_Admin_Main::get_order_meta_keys();
	$meta_data = get_option( 'bfs_order_analytics' );
?>
	<div class="order-analytics-setting">
		<div class="meta-header">
			<h1><?php esc_html_e( 'Order Analytics report custom column', 'wc-order-analytics-add-on' ); ?></h1> <button class="add-row" type="button"><span class="add-icon">+</span> Add Row</button>
		</div>
		<input type="hidden" name="action" value="repeater_form_data_save">
		<table>
			<thead class="table-header">
				<tr>
					<th width="45%"><?php esc_html_e( 'Column Label', 'wc-order-analytics-add-on' ); ?></th>
					<th width="45%"><?php esc_html_e( 'Order Meta Key', 'wc-order-analytics-add-on' ); ?></th>
					<th width="10%" colspan="2"><?php esc_html_e( 'Action', 'wc-order-analytics-add-on' ); ?></th>
				</tr>
			</thead>
			<tbody class="metadata-body">
				<?php
				if ( ! empty( $meta_data ) ) {
					foreach ( $meta_data as $key => $meta_item ) { ?>
					<tr class="metadata-single">
						<td><input type="text" class="meta-value" name="meta[<?php echo esc_attr($key); ?>][value]" value="<?php echo esc_attr($meta_item['value']); ?>"></td>
							<td>
								<select class="meta-key" name="meta[<?php echo esc_attr($key); ?>][key]">
									<?php
										foreach ($meta_keys as $meta_key) {
											echo '<option value="' . esc_attr($meta_key) . '"';
											if ($meta_key === $meta_item['key']) {
												echo ' selected="selected"';
											}
											echo '>' . esc_html($meta_key) . '</option>';
										}
										?>
								</select>
							</td>
						<td><button class="remove-row"><i class="dashicons dashicons-trash"></i></button></td>
					</tr>
					<?php }
				} ?>
			</tbody>
		</table>
	</div>
	  
