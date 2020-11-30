<?php

/**
 * The Updates routine for version 3.0.0
 *
 * @since      3.0.0
 * @package    wpie
 * @subpackage wpie\Core
 * @author     VJinfotech <support@vjinfotech.com>
 */

/**
 * Delete previous notices.
 */
function wpie_3_0_0_update() {

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        global $wpdb;

        if ( $wpdb->has_cap( 'collation' ) ) {

                if ( ! empty( $wpdb->charset ) )
                        $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";

                if ( ! empty( $wpdb->collate ) )
                        $charset_collate .= " COLLATE $wpdb->collate";
        }

        $wpie_template = $wpdb->prefix . 'wpie_template';

        $wpie_template_table = "CREATE TABLE IF NOT EXISTS {$wpie_template}(
							
                            id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                            status VARCHAR(25),
                            opration VARCHAR(100) NOT NULL, 
                            username VARCHAR(60) NOT NULL, 
                            unique_id VARCHAR(100) NOT NULL, 
                            opration_type VARCHAR(100) NOT NULL,
                            options LONGTEXT,
                            process_log VARCHAR(255),
                            process_lock INT(3),
                            create_date DATETIME NOT NULL,
                            last_update_date DATETIME NOT NULL 

                            ){$charset_collate}";

        dbDelta( $wpie_template_table );

        unset( $charset_collate, $wpie_template, $wpie_template_table );

        wpie_clear_old_data_3_0_0();
}

function wpie_clear_old_data_3_0_0() {
        //remove schedule export
        wp_clear_scheduled_hook( "wpie_cron_scheduled_order_export" );
        wp_clear_scheduled_hook( "wpie_cron_scheduled_product_export" );
        wp_clear_scheduled_hook( "wpie_cron_scheduled_user_export" );
        wp_clear_scheduled_hook( "wpie_cron_scheduled_product_cat_export" );
        wp_clear_scheduled_hook( "wpie_cron_scheduled_coupon_export" );

        //remove schedule Import
        wp_clear_scheduled_hook( "wpie_cron_scheduled_coupon_import" );
        wp_clear_scheduled_hook( "wpie_cron_scheduled_product_import" );
        wp_clear_scheduled_hook( "wpie_cron_scheduled_product_cat_import" );
        wp_clear_scheduled_hook( "wpie_cron_scheduled_order_import" );
        wp_clear_scheduled_hook( "wpie_cron_scheduled_user_import" );
}

wpie_3_0_0_update();
