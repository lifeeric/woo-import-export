<?php
if (!defined('ABSPATH')) {
        die(__("Can't load this file directly", 'woo-import-export'));
}
?>
<td>
    <div class="wpie_options_data wpie_order_item_row_option_wrapper">
        <div class="wpie_options_data_content">
            <input type="checkbox" class="wpie_checkbox wpie_order_item_sigle_row" id="wpie_order_item_sigle_row"  name="wpie_order_item_sigle_row" value="1"/>
            <label for="wpie_order_item_sigle_row" class="wpie_checkbox_label"><?php esc_html_e('Display each product in its own row', 'woo-import-export'); ?></label>
        </div>
        <div class="wpie_order_item_fill_empty_wrapper wpie_hide">
            <input type="checkbox" class="wpie_checkbox wpie_order_item_fill_empty" checked="checked" id="wpie_order_item_fill_empty" name="wpie_order_item_fill_empty" value="1"/>
            <label for="wpie_order_item_fill_empty" class="wpie_checkbox_label"><?php esc_html_e('Fill in empty columns', 'woo-import-export'); ?></label>
        </div>
    </div>
</td>