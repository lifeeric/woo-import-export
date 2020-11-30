<?php
if ( ! defined( 'ABSPATH' ) ) {
        die( __( "Can't load this file directly", 'woo-import-export' ) );
}

if ( ! function_exists( "wpie_import_order_update_fields" ) ) {

        function wpie_import_order_update_fields() {

                ob_start();
                ?>
                <div class="wpie_field_mapping_container_element">
                        <div class="wpie_field_mapping_inner_title"><?php esc_html_e( 'Update Existing items data', 'woo-import-export' ); ?></div>
                        <div class="wpie_field_mapping_other_option_wrapper">
                                <input type="radio" class="wpie_radio wpie_item_update wpie_item_update_all" checked="checked" name="wpie_item_update" id="wpie_item_update_all" value="all"/>
                                <label for="wpie_item_update_all" class="wpie_radio_label"><?php esc_html_e( 'Update all data', 'woo-import-export' ); ?></label>
                        </div>
                        <div class="wpie_field_mapping_other_option_wrapper">
                                <input type="radio" class="wpie_radio wpie_item_update wpie_item_update_specific" name="wpie_item_update" id="wpie_item_update_specific" value="specific"/>
                                <label for="wpie_item_update_specific" class="wpie_radio_label"><?php esc_html_e( 'Choose which data to update', 'woo-import-export' ); ?></label>
                                <div class="wpie_radio_container">
                                        <div class="wpie_update_item_all_action"><?php esc_html_e( 'Check/Uncheck All', 'woo-import-export' ); ?></div>
                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                <input type="checkbox" class="wpie_checkbox wpie_item_update_field is_update_item_post_status" checked="checked" name="is_update_item_post_status" id="is_update_item_post_status" value="1"/>
                                                <label for="is_update_item_post_status" class="wpie_checkbox_label"><?php esc_html_e( 'Order status', 'woo-import-export' ); ?></label>
                                        </div>
                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                <input type="checkbox" class="wpie_checkbox wpie_item_update_field is_update_item_order_number" checked="checked" name="is_update_item_order_number" id="is_update_item_order_number" value="1"/>
                                                <label for="is_update_item_order_number" class="wpie_checkbox_label"><?php esc_html_e( 'Order Number', 'woo-import-export' ); ?></label>
                                        </div>
                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                <input type="checkbox" class="wpie_checkbox wpie_item_update_field is_update_item_excerpt" checked="checked" name="is_update_item_excerpt" id="is_update_item_excerpt" value="1"/>
                                                <label for="is_update_item_excerpt" class="wpie_checkbox_label"><?php esc_html_e( 'Customer Note', 'woo-import-export' ); ?></label>
                                        </div>
                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                <input type="checkbox" class="wpie_checkbox wpie_item_update_field is_update_item_dates" checked="checked" name="is_update_item_dates" id="is_update_item_dates" value="1"/>
                                                <label for="is_update_item_dates" class="wpie_checkbox_label"><?php esc_html_e( 'Dates', 'woo-import-export' ); ?></label>
                                        </div>
                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                <input type="checkbox" class="wpie_checkbox wpie_item_update_field is_update_item_billing_details" checked="checked" name="is_update_item_billing_details" id="is_update_item_billing_details" value="1"/>
                                                <label for="is_update_item_billing_details" class="wpie_checkbox_label"><?php esc_html_e( 'Billing Details', 'woo-import-export' ); ?></label>
                                        </div>
                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                <input type="checkbox" class="wpie_checkbox wpie_item_update_field is_update_item_shipping_details" checked="checked" name="is_update_item_shipping_details" id="is_update_item_shipping_details" value="1"/>
                                                <label for="is_update_item_shipping_details" class="wpie_checkbox_label"><?php esc_html_e( 'Shipping Details', 'woo-import-export' ); ?></label>
                                        </div>
                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                <input type="checkbox" class="wpie_checkbox wpie_item_update_field is_update_item_payment" checked="checked" name="is_update_item_payment" id="is_update_item_payment" value="1"/>
                                                <label for="is_update_item_payment" class="wpie_checkbox_label"><?php esc_html_e( 'Payment Details', 'woo-import-export' ); ?></label>
                                        </div>
                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                <input type="checkbox" class="wpie_checkbox wpie_item_update_field is_update_item_notes" checked="checked" name="is_update_item_notes" id="is_update_item_notes" value="1"/>
                                                <label for="is_update_item_notes" class="wpie_checkbox_label"><?php esc_html_e( 'Order Notes', 'woo-import-export' ); ?></label>
                                        </div>
                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                <input type="checkbox" class="wpie_checkbox wpie_item_update_field is_update_item_product" checked="checked" name="is_update_item_product" id="is_update_item_product" value="1"/>
                                                <label for="is_update_item_product" class="wpie_checkbox_label"><?php esc_html_e( 'Product Items', 'woo-import-export' ); ?></label>
                                                <div class="wpie_checkbox_container">
                                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                                <input type="radio" class="wpie_radio wpie_item_update_cf wpie_item_update_product_all" checked="checked" name="wpie_item_update_product" id="wpie_item_update_product_all" value="all"/>
                                                                <label for="wpie_item_update_product_all" class="wpie_radio_label"><?php esc_html_e( 'Update all products', 'woo-import-export' ); ?></label>
                                                        </div>
                                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                                <input type="radio" class="wpie_radio wpie_item_update_cf wpie_item_update_product_append" name="wpie_item_update_product" id="wpie_item_update_product_append" value="append"/>
                                                                <label for="wpie_item_update_product_append" class="wpie_radio_label"><?php esc_html_e( "Don't touch existing products, append new products", 'woo-import-export' ); ?></label>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                <input type="checkbox" class="wpie_checkbox wpie_item_update_field is_update_item_fee" checked="checked" name="is_update_item_fee" id="is_update_item_fee" value="1"/>
                                                <label for="is_update_item_fee" class="wpie_checkbox_label"><?php esc_html_e( 'Fees Items', 'woo-import-export' ); ?></label>
                                        </div>
                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                <input type="checkbox" class="wpie_checkbox wpie_item_update_field is_update_item_coupon" checked="checked" name="is_update_item_coupon" id="is_update_item_coupon" value="1"/>
                                                <label for="is_update_item_coupon" class="wpie_checkbox_label"><?php esc_html_e( 'Coupon Items', 'woo-import-export' ); ?></label>
                                        </div>
                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                <input type="checkbox" class="wpie_checkbox wpie_item_update_field is_update_item_shipping" checked="checked" name="is_update_item_shipping" id="is_update_item_shipping" value="1"/>
                                                <label for="is_update_item_shipping" class="wpie_checkbox_label"><?php esc_html_e( 'Shipping Items', 'woo-import-export' ); ?></label>
                                        </div>
                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                <input type="checkbox" class="wpie_checkbox wpie_item_update_field is_update_item_tax" checked="checked" name="is_update_item_tax" id="is_update_item_tax" value="1"/>
                                                <label for="is_update_item_tax" class="wpie_checkbox_label"><?php esc_html_e( 'Tax Items', 'woo-import-export' ); ?></label>
                                        </div>
                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                <input type="checkbox" class="wpie_checkbox wpie_item_update_field is_update_item_refunds" checked="checked" name="is_update_item_refunds" id="is_update_item_refunds" value="1"/>
                                                <label for="is_update_item_refunds" class="wpie_checkbox_label"><?php esc_html_e( 'Refunds', 'woo-import-export' ); ?></label>
                                        </div>
                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                <input type="checkbox" class="wpie_checkbox wpie_item_update_field is_update_item_total" checked="checked" name="is_update_item_total" id="is_update_item_total" value="1"/>
                                                <label for="is_update_item_total" class="wpie_checkbox_label"><?php esc_html_e( 'Order Total', 'woo-import-export' ); ?></label>
                                        </div>
                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                <input type="checkbox" class="wpie_checkbox wpie_item_update_field is_update_item_cf" checked="checked" name="is_update_item_cf" id="is_update_item_cf" value="1"/>
                                                <label for="is_update_item_cf" class="wpie_checkbox_label"><?php esc_html_e( 'Custom Fields', 'woo-import-export' ); ?></label>
                                                <div class="wpie_checkbox_container">
                                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                                <input type="radio" class="wpie_radio wpie_item_update_cf wpie_item_update_cf_append" checked="checked" name="wpie_item_update_cf" id="wpie_item_update_cf_append" value="append"/>
                                                                <label for="wpie_item_update_cf_append" class="wpie_radio_label"><?php esc_html_e( 'Update all Custom Fields and keep fields if not found in file', 'woo-import-export' ); ?></label>
                                                        </div>
                                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                                <input type="radio" class="wpie_radio wpie_item_update_cf wpie_item_update_cf_all" name="wpie_item_update_cf" id="wpie_item_update_cf_all" value="all"/>
                                                                <label for="wpie_item_update_cf_all" class="wpie_radio_label"><?php esc_html_e( 'Update all Custom Fields and Remove fields if not found in file', 'woo-import-export' ); ?></label>
                                                        </div>
                                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                                <input type="radio" class="wpie_radio wpie_item_update_cf wpie_item_update_cf_includes" name="wpie_item_update_cf" id="wpie_item_update_cf_includes" value="includes"/>
                                                                <label for="wpie_item_update_cf_includes" class="wpie_radio_label"><?php esc_html_e( "Update only these Custom Fields, leave the rest alone", 'woo-import-export' ); ?></label>
                                                                <div class="wpie_radio_container">
                                                                        <input type="text" class="wpie_content_data_input wpie_item_update_cf_includes_data" name="wpie_item_update_cf_includes_data" value=""/>
                                                                </div>
                                                        </div>
                                                        <div class="wpie_field_mapping_other_option_wrapper">
                                                                <input type="radio" class="wpie_radio wpie_item_update_cf wpie_item_update_cf_excludes" name="wpie_item_update_cf" id="wpie_item_update_cf_excludes" value="excludes"/>
                                                                <label for="wpie_item_update_cf_excludes" class="wpie_radio_label"><?php esc_html_e( "Leave these fields alone, update all other Custom Fields", 'woo-import-export' ); ?></label>
                                                                <div class="wpie_radio_container">
                                                                        <input type="text" class="wpie_content_data_input wpie_item_update_cf_excludes_data" name="wpie_item_update_cf_excludes_data" value=""/>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>

                <?php
                $sections = ob_get_clean();

                return $sections;
        }

}