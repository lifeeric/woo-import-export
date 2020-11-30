<?php

namespace wpie\import\wc\order;

if ( ! defined( 'ABSPATH' ) ) {
        die( __( "Can't load this file directly", 'woo-import-export' ) );
}

if ( file_exists( WPIE_IMPORT_CLASSES_DIR . '/class-wpie-import-base.php' ) ) {

        require_once(WPIE_IMPORT_CLASSES_DIR . '/class-wpie-import-base.php');
}

class WPIE_Order_Import extends \wpie\import\base\WPIE_Import_Base {

        private $order;

        public function __construct( $wpie_import_option = array (), $import_type = "", &$addon_error = false, &$addon_log = array () ) {

                $this->wpie_import_option = $wpie_import_option;

                $this->import_type = $import_type;

                $this->addon_error = &$addon_error;

                $this->addon_log = &$addon_log;

                $required_files = array (
                        'class-wpie-order-address.php',
                        'class-wpie-order-details.php',
                        'class-wpie-order-notes.php',
                        'class-wpie-order-payment.php',
                        'class-wpie-order-refunds.php',
                        'class-wpie-order-total.php',
                        'items/class-wpie-order-coupon-item.php',
                        'items/class-wpie-order-fee-item.php',
                        'items/class-wpie-order-product-item.php',
                        'items/class-wpie-order-shipping-item.php',
                        'items/class-wpie-order-tax-item.php'
                );

                foreach ( $required_files as $file ) {

                        if ( file_exists( WPIE_IMPORT_CLASSES_DIR . "/extensions/wc/order/" . $file ) ) {

                                require_once(WPIE_IMPORT_CLASSES_DIR . "/extensions/wc/order/" . $file);
                        }
                }
                unset( $required_files );

                add_action( 'woocommerce_email', [ $this, 'unhook_those_pesky_emails' ] );
        }

        public function before_item_import( $wpie_import_record = array (), &$existing_item_id = 0, &$is_new_item = true, $is_search_duplicates ) {

                $this->wpie_import_record = $wpie_import_record;

                $this->existing_item_id = $existing_item_id;
        }

        public function get_item_title( &$title = "" ) {

                if ( empty( $this->existing_item_id ) || absint( $this->existing_item_id ) == 0 ) {
                        $title = 'Order &ndash; ' . date_i18n( 'F j, Y @ h:i A', strtotime( current_time( 'mysql' ) ) );
                }
        }

        public function after_item_import( $item_id = 0, $item = null, $is_new_item = false ) {

                $this->item_id = $item_id;

                $this->item = $item;

                $this->is_new_item = $is_new_item;

                $this->order = wc_get_order( $this->item_id );

                new \wpie\import\wc\order\details\WPIE_Order_Details( $this->item, $this->is_new_item );

                new \wpie\import\wc\order\address\WPIE_Order_Address( $this->wpie_import_option, $this->wpie_import_record, $this->item_id, $this->is_new_item, $this->order );

                new \wpie\import\wc\order\payment\WPIE_Order_Payment( $this->wpie_import_option, $this->wpie_import_record, $this->item_id, $this->is_new_item, $this->order );

                if ( ! $this->addon_error && $this->is_update_field( "order_number" ) ) {
                        $this->update_order_number();
                }

                if ( ! $this->addon_error && $this->is_update_field( "product" ) ) {
                        new \wpie\import\wc\order\item\WPIE_Order_Product_Item( $this->wpie_import_option, $this->wpie_import_record, $this->item_id, $this->is_new_item, $this->addon_error, $this->addon_log, $this->order );
                }

                if ( ! $this->addon_error && $this->is_update_field( "fee" ) ) {
                        new \wpie\import\wc\order\item\WPIE_Order_Fee_Item( $this->wpie_import_option, $this->wpie_import_record, $this->item_id, $this->is_new_item, $this->addon_error, $this->addon_log, $this->order );
                }

                if ( ! $this->addon_error && $this->is_update_field( "coupon" ) ) {
                        new \wpie\import\wc\order\item\WPIE_Order_Coupon_Item( $this->wpie_import_option, $this->wpie_import_record, $this->item_id, $this->is_new_item, $this->addon_error, $this->addon_log, $this->order );
                }

                if ( ! $this->addon_error && $this->is_update_field( "shipping" ) ) {

                        new \wpie\import\wc\order\item\WPIE_Order_Shipping_Item( $this->wpie_import_option, $this->wpie_import_record, $this->item_id, $this->is_new_item, $this->addon_error, $this->addon_log, $this->order );
                }

                if ( ! $this->addon_error && $this->is_update_field( "tax" ) ) {
                        new \wpie\import\wc\order\item\WPIE_Order_Tax_Item( $this->wpie_import_option, $this->wpie_import_record, $this->item_id, $this->is_new_item, $this->addon_error, $this->addon_log, $this->order );
                }

                if ( ! $this->addon_error && $this->is_update_field( "total" ) ) {
                        new \wpie\import\wc\order\total\WPIE_Order_Total( $this->wpie_import_option, $this->wpie_import_record, $this->item_id, $this->is_new_item, $this->addon_error, $this->addon_log, $this->order );
                }

                if ( ! $this->addon_error && $this->is_update_field( "notes" ) ) {
                        new \wpie\import\wc\order\notes\WPIE_Order_Notes( $this->wpie_import_option, $this->wpie_import_record, $this->item_id, $this->is_new_item, $this->addon_error, $this->addon_log );
                }

                $this->order->calculate_taxes();

                $this->order->save();

                if ( ! $this->addon_error && $this->is_update_field( "refunds" ) ) {
                        new \wpie\import\wc\order\refunds\WPIE_Order_Refunds( $this->wpie_import_option, $this->wpie_import_record, $this->item_id, $this->is_new_item, $this->addon_error, $this->addon_log );
                }
        }

        /**
         * Unhook and remove WooCommerce default emails.
         */
        public function unhook_those_pesky_emails( $email_class ) {

                /**
                 * Hooks for sending emails during store events
                 * */
                remove_action( 'woocommerce_low_stock_notification', array ( $email_class, 'low_stock' ) );
                remove_action( 'woocommerce_no_stock_notification', array ( $email_class, 'no_stock' ) );
                remove_action( 'woocommerce_product_on_backorder_notification', array ( $email_class, 'backorder' ) );

                // New order emails
                remove_action( 'woocommerce_order_status_pending_to_processing_notification', array ( $email_class->emails[ 'WC_Email_New_Order' ], 'trigger' ) );
                remove_action( 'woocommerce_order_status_pending_to_completed_notification', array ( $email_class->emails[ 'WC_Email_New_Order' ], 'trigger' ) );
                remove_action( 'woocommerce_order_status_pending_to_on-hold_notification', array ( $email_class->emails[ 'WC_Email_New_Order' ], 'trigger' ) );
                remove_action( 'woocommerce_order_status_failed_to_processing_notification', array ( $email_class->emails[ 'WC_Email_New_Order' ], 'trigger' ) );
                remove_action( 'woocommerce_order_status_failed_to_completed_notification', array ( $email_class->emails[ 'WC_Email_New_Order' ], 'trigger' ) );
                remove_action( 'woocommerce_order_status_failed_to_on-hold_notification', array ( $email_class->emails[ 'WC_Email_New_Order' ], 'trigger' ) );

                // Processing order emails
                remove_action( 'woocommerce_order_status_pending_to_processing_notification', array ( $email_class->emails[ 'WC_Email_Customer_Processing_Order' ], 'trigger' ) );
                remove_action( 'woocommerce_order_status_pending_to_on-hold_notification', array ( $email_class->emails[ 'WC_Email_Customer_Processing_Order' ], 'trigger' ) );

                // Completed order emails
                remove_action( 'woocommerce_order_status_completed_notification', array ( $email_class->emails[ 'WC_Email_Customer_Completed_Order' ], 'trigger' ) );

                // Note emails
                remove_action( 'woocommerce_new_customer_note_notification', array ( $email_class->emails[ 'WC_Email_Customer_Note' ], 'trigger' ) );
        }

        private function update_order_number() {

                $order_number = wpie_sanitize_field( $this->get_field_value( 'wpie_item_order_number' ) );

                if ( ! empty( $order_number ) ) {
                        update_post_meta( $this->item_id, '_wpie_order_number', $order_number );
                }
                unset( $order_number );
        }

        public function __destruct() {

                parent::__destruct();

                foreach ( $this as $key => $value ) {
                        unset( $this->$key );
                }
        }

}
