// Import SCSS entry file so that webpack picks up changes
//import './index.scss';

import {addFilter} from '@wordpress/hooks';
import {__} from '@wordpress/i18n';


function addAccessExpiresToDownloadsReport( reportTableData )
{
    const { endpoint, items } = reportTableData;    
    if ('orders' !== endpoint ) {
        return reportTableData;
    }

    var original_data = data.columns;
    reportTableData.headers = [
        ...reportTableData.headers,
    ];

    for(var i = 0; original_data.length > i; i++) {
        reportTableData.headers.push({'label': original_data[i].value, 'key': original_data[i].key});
    }
    
    reportTableData.rows = reportTableData.rows.map(
        ( row, index ) => {
            const item = items.data[ index ]; 
            const newRow = [
                ...row,
                ];
        for(var i = 0; original_data.length > i; i++) {
            var itemKey = original_data[i].key;
            newRow.push({'display': item[itemKey], 'value': item[itemKey]});
        }
        return newRow;
        } 
    );
    return reportTableData;
}
addFilter('woocommerce_admin_report_table', 'dev-blog-example', addAccessExpiresToDownloadsReport);

jQuery('.add-row').on(
    'click', function (e) {
        var meta_keys_count = data.meta_keys.length;
    
        var meta_keys = data.meta_keys;
        e.preventDefault();
        var repeaterRow = jQuery('.metadata-body');
        
        var options = '';
        for(var i = 0; i < meta_keys_count; i++) {
            options += '<option value="' +meta_keys[i]+ '">' + meta_keys[i] + '</option>';
        }
        var repeaterField = `
            <tr class="metadata-single">
                <td><input type="text" class="meta-value" name="meta[0][value]" value=""></td>
                <td>
                    <select class="meta-key" name="meta[0][key]">${options}</select>
                </td>
                <td><button class="remove-row"><i class="dashicons dashicons-trash"></i></button></td>
            </tr>
        `;
        repeaterRow.append(repeaterField);
        reArrangeNameAttribute();
    }
);

jQuery('body').on(
    'click', '.remove-row', function (e) {
        e.preventDefault();
        jQuery(this).closest('.metadata-single').remove();
        reArrangeNameAttribute();
    }
);

function reArrangeNameAttribute()
{
    jQuery(".metadata-single").each(
        function (index, element) {
            jQuery(this).find('.meta-value').attr('name', 'meta[' + index + '][value]');
            jQuery(this).find('.meta-key').attr('name', 'meta[' + index + '][key]');
        }
    )
}