<?php
if ( ! defined( 'ABSPATH' ) ) {
        die( __( "Can't load this file directly", 'woo-import-export' ) );
}

if ( file_exists( WPIE_CLASSES_DIR . '/class-wpie-extensions.php' ) ) {
        require_once(WPIE_CLASSES_DIR . '/class-wpie-extensions.php');

        $wpie_ext = new \wpie\addons\WPIE_Extension();

        $wpie_export_ext = $wpie_ext->wpie_get_export_extension();

        $wpie_import_ext = $wpie_ext->wpie_get_import_extension();

        $wpieExtData = $wpie_ext->wpie_get_activated_ext();
} else {
        $wpie_export_ext = array();

        $wpie_import_ext = array();

        $wpieExtData = array();
}

$page = isset( $_GET[ 'page' ] ) ? wpie_sanitize_field( $_GET[ 'page' ] ) : "";
?>
<div class="wpie_main_container">
        <div class="wpie_content_header">
                <div class="wpie_content_header_inner_wrapper">
                        <div class="wpie_content_header_title"><?php esc_html_e( 'Extensions', 'woo-import-export' ); ?></div>
                        <div class="wpie_fixed_header_button">
                                <div class="wpie_btn wpie_btn_primary wpie_ext_save">
                                        <i class="fas fa-check wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Save', 'woo-import-export' ); ?>
                                </div>
                        </div>
                </div>

        </div>
        <div class="wpie_content_wrapper">
                <form class="wpie_general_frm" method="post" action="#">
                        <div class="wpie_section_wrapper">
                                <div class="wpie_content_data_header wpie_section_wrapper_selected">
                                        <div class="wpie_content_title"><?php esc_html_e( 'Export Extensions', 'woo-import-export' ); ?></div>
                                        <div class="wpie_layout_header_icon_wrapper"><i class="fas fa-chevron-up wpie_layout_header_icon wpie_layout_header_icon_collapsed" aria-hidden="true"></i><i class="fas fa-chevron-down wpie_layout_header_icon wpie_layout_header_icon_expand" aria-hidden="true"></i></div>
                                </div>
                                <div class="wpie_section_content" style="display: block;">
                                        <table class="wpie_ext_list_table">
                                                <tr>
                                                    <?php
                                                    if ( ! empty( $wpie_export_ext ) ) {

                                                            $temp = 0;
                                                            foreach ( $wpie_export_ext as $key => $extData ) {

                                                                    if ( isset( $extData[ "is_default" ] ) && $extData[ "is_default" ] == true ) {
                                                                            continue;
                                                                    }
                                                                    if ( $temp % 3 == 0 ) {
                                                                            ?>
                                                                        </tr>
                                                                        <tr>
                                                                            <?php
                                                                    }
                                                                    ?>
                                                                        <td class="wpie_ext_container">
                                                                                <div class="wpie_ext_wrapper" >
                                                                                        <div class="wpie_ext_name_wrapper"><?php echo esc_html( isset( $extData[ "name" ] ) ? $extData[ "name" ] : ""  ); ?></div>
                                                                                        <div class="wpie_ext_desc_wrapper"><?php echo esc_html( isset( $extData[ "short_desc" ] ) ? $extData[ "short_desc" ] : ""  ); ?></div>
                                                                                        <div class="wpie_ext_btn_wrapper">
                                                                                                <div class="wpie_switch">
                                                                                                        <input type="checkbox" name="wpie_ext[]" class="wpie_switch_checkbox" value="<?php echo esc_attr( $key ); ?>" id="wpie_switch_<?php echo esc_attr( $temp ); ?>" <?php if ( is_array( $wpieExtData ) && in_array( $key, $wpieExtData ) ) { ?>checked="checked"<?php } ?>>
                                                                                                        <label class="wpie_switch_label" for="wpie_switch_<?php echo esc_attr( $temp ); ?>">
                                                                                                                <span class="wpie_switch_inner">
                                                                                                                        <span class="wpie_switch_active"><span class="wpie_switch_switch"><?php esc_html_e( "ON", 'woo-import-export' ) ?></span></span>
                                                                                                                        <span class="wpie_switch_inactive"><span class="wpie_switch_switch"><?php esc_html_e( "OFF", 'woo-import-export' ) ?></span></span>
                                                                                                                </span>
                                                                                                        </label>
                                                                                                </div>
                                                                                                <?php if ( isset( $extData[ "settings" ] ) ) { ?>
                                                                                                        <div class="wpie_ext_setting_btn">
                                                                                                                <a class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_export_save_field_btn" href="<?php echo esc_url( admin_url( "admin.php?page=" . $page . "&wpie_ext=" . $key ) ); ?>">
                                                                                                                        <i class="fas fa-cogs wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Settings', 'woo-import-export' ); ?>
                                                                                                                </a>
                                                                                                        </div>
                                                                                                <?php } ?>
                                                                                        </div>
                                                                                </div>
                                                                        </td>
                                                                        <?php $temp ++; ?>
                                                                <?php } ?>
                                                        <?php } else { ?>
                                                                <td class="wpie_ext_empty_msg"><?php esc_html_e( "No Extension installed. Please install extension for use all features.", 'woo-import-export' ) ?></td>
                                                        <?php } ?>
                                                </tr>
                                        </table>
                                </div>
                        </div>
                        <div class="wpie_section_wrapper">
                                <div class="wpie_content_data_header wpie_section_wrapper_selected">
                                        <div class="wpie_content_title"><?php esc_html_e( 'Import Extensions', 'woo-import-export' ); ?></div>
                                        <div class="wpie_layout_header_icon_wrapper"><i class="fas fa-chevron-up wpie_layout_header_icon wpie_layout_header_icon_collapsed" aria-hidden="true"></i><i class="fas fa-chevron-down wpie_layout_header_icon wpie_layout_header_icon_expand" aria-hidden="true"></i></div>
                                </div>
                                <div class="wpie_section_content" style="display: block;">
                                        <table class="wpie_ext_list_table">
                                                <tr>
                                                    <?php
                                                    if ( ! empty( $wpie_import_ext ) ) {

                                                            $temp = 0;
                                                            foreach ( $wpie_import_ext as $key => $extData ) {

                                                                    if ( isset( $extData[ "is_default" ] ) && $extData[ "is_default" ] == true ) {
                                                                            continue;
                                                                    }
                                                                    if ( $temp % 3 == 0 ) {
                                                                            ?>
                                                                        </tr>
                                                                        <tr>
                                                                            <?php
                                                                    }
                                                                    ?>
                                                                        <td class="wpie_ext_container">
                                                                                <div class="wpie_ext_wrapper" >
                                                                                        <div class="wpie_ext_name_wrapper"><?php echo esc_html( isset( $extData[ "name" ] ) ? $extData[ "name" ] : ""  ); ?></div>
                                                                                        <div class="wpie_ext_desc_wrapper"><?php echo esc_html( isset( $extData[ "short_desc" ] ) ? $extData[ "short_desc" ] : ""  ); ?></div>
                                                                                        <div class="wpie_ext_btn_wrapper">
                                                                                                <div class="wpie_switch">
                                                                                                        <input type="checkbox" name="wpie_ext[]" class="wpie_switch_checkbox" value="<?php echo esc_attr( $key ); ?>" id="wpie_switch_import_<?php echo esc_attr( $temp ); ?>" <?php if ( is_array( $wpieExtData ) && in_array( $key, $wpieExtData ) ) { ?>checked="checked"<?php } ?>>
                                                                                                        <label class="wpie_switch_label" for="wpie_switch_import_<?php echo esc_attr( $temp ); ?>">
                                                                                                                <span class="wpie_switch_inner">
                                                                                                                        <span class="wpie_switch_active"><span class="wpie_switch_switch"><?php esc_html_e( "ON", 'woo-import-export' ) ?></span></span>
                                                                                                                        <span class="wpie_switch_inactive"><span class="wpie_switch_switch"><?php esc_html_e( "OFF", 'woo-import-export' ) ?></span></span>
                                                                                                                </span>
                                                                                                        </label>
                                                                                                </div>
                                                                                                <?php if ( isset( $extData[ "settings" ] ) ) { ?>
                                                                                                        <div class="wpie_ext_setting_btn">
                                                                                                                <a class="wpie_btn wpie_btn_secondary wpie_btn_radius wpie_export_save_field_btn" href="<?php echo esc_url( admin_url( "admin.php?page=" . $page . "&wpie_ext=" . $key ) ); ?>">
                                                                                                                        <i class="fas fa-cogs wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Settings', 'woo-import-export' ); ?>
                                                                                                                </a>
                                                                                                        </div>
                                                                                                <?php } ?>
                                                                                        </div>
                                                                                </div>
                                                                        </td>
                                                                        <?php $temp ++; ?>
                                                                <?php } ?>
                                                        <?php } else { ?>
                                                                <td class="wpie_ext_empty_msg"><?php esc_html_e( "No Extension installed. Please install extension for use all features.", 'woo-import-export' ) ?></td>
                                                        <?php } ?>
                                                </tr>
                                        </table>
                                </div>
                        </div>
                </form>
        </div>
</div>
<div class="wpie_doc_wrapper">
        <div class="wpie_doc_container">
                <a class="wpie_doc_url" href="<?php echo esc_url( WPIE_SUPPORT_URL ); ?>" target="_blank"><?php esc_html_e( 'Support', 'woo-import-export' ); ?></a>
                <div class="wpie_doc_url_delim">|</div>
                <a class="wpie_doc_url" href="<?php echo esc_url( WPIE_DOC_URL ); ?>" target="_blank"><?php esc_html_e( 'Documentation', 'woo-import-export' ); ?></a>
        </div>
</div>
<div class="wpie_loader wpie_hidden">
        <div></div>
        <div></div>
</div>
<div class="modal fade wpie_error_model" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content wpie_error">
                        <div class="modal-header">
                                <h5 class="modal-title"><?php esc_html_e( 'ERROR', 'woo-import-export' ); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times wpie_general_btn_icon " aria-hidden="true"></i>
                                </button>
                        </div>
                        <div class="modal-body">
                                <div class="wpie_error_content"></div>
                        </div>
                        <div class="modal-footer">
                                <div class="wpie_btn wpie_btn_red wpie_btn_radius " data-dismiss="modal">
                                        <i class="fas fa-check wpie_general_btn_icon " aria-hidden="true"></i><?php esc_html_e( 'Ok', 'woo-import-export' ); ?>
                                </div>
                        </div>
                </div>
        </div>
</div>