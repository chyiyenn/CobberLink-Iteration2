<?php
/**
 * @package OpenUserMapPlugin
 */

namespace OpenUserMapPlugin\Pages;

use \OpenUserMapPlugin\Base\BaseController;

class Settings extends BaseController
{
    public function register()
    {
        add_action('admin_menu', array($this, 'add_admin_pages'));
        add_action('admin_init', array($this, 'add_plugin_settings'));
        add_action('admin_notices', array($this, 'show_getting_started_notice'));
        add_action('wp_ajax_oum_dismiss_getting_started_notice', array($this, 'getting_started_dismiss_notice'));
    }

    public function add_admin_pages()
    {
        add_options_page('Open User Map', 'Open User Map', 'manage_options', 'open_user_map', array($this, 'admin_index'));
    }

    public function add_plugin_settings()
    {
        register_setting('open-user-map-settings-group', 'oum_getting_started_notice_dismissed');
        register_setting('open-user-map-settings-group', 'oum_map_style');
        register_setting('open-user-map-settings-group', 'oum_marker_icon');
        register_setting('open-user-map-settings-group', 'oum_marker_user_icon');
        register_setting('open-user-map-settings-group', 'oum_map_size');
        register_setting('open-user-map-settings-group', 'oum_map_height');
        register_setting('open-user-map-settings-group', 'oum_map_size_mobile');
        register_setting('open-user-map-settings-group', 'oum_map_height_mobile');
        register_setting('open-user-map-settings-group', 'oum_start_lat', array('sanitize_callback' => array($this, 'validate_geocoordinate')));
        register_setting('open-user-map-settings-group', 'oum_start_lng', array('sanitize_callback' => array($this, 'validate_geocoordinate')));
        register_setting('open-user-map-settings-group', 'oum_start_zoom', array('sanitize_callback' => 'intval'));
        register_setting('open-user-map-settings-group', 'oum_disable_title');
        register_setting('open-user-map-settings-group', 'oum_title_required');
        register_setting('open-user-map-settings-group', 'oum_title_maxlength');
        register_setting('open-user-map-settings-group', 'oum_title_label');
        register_setting('open-user-map-settings-group', 'oum_map_label');
        register_setting('open-user-map-settings-group', 'oum_searchaddress_label');
        register_setting('open-user-map-settings-group', 'oum_hide_address');
        register_setting('open-user-map-settings-group', 'oum_disable_gmaps_link');
        register_setting('open-user-map-settings-group', 'oum_disable_address');
        register_setting('open-user-map-settings-group', 'oum_address_label');
        register_setting('open-user-map-settings-group', 'oum_disable_description');
        register_setting('open-user-map-settings-group', 'oum_description_required');
        register_setting('open-user-map-settings-group', 'oum_description_label');
        register_setting('open-user-map-settings-group', 'oum_disable_image');
        register_setting('open-user-map-settings-group', 'oum_image_required');
        register_setting('open-user-map-settings-group', 'oum_disable_audio');
        register_setting('open-user-map-settings-group', 'oum_audio_required');
        register_setting('open-user-map-settings-group', 'oum_custom_fields');
        register_setting('open-user-map-settings-group', 'oum_disable_cluster');
        register_setting('open-user-map-settings-group', 'oum_disable_fullscreen');
        register_setting('open-user-map-settings-group', 'oum_enable_currentlocation');
        register_setting('open-user-map-settings-group', 'oum_max_image_filesize');
        register_setting('open-user-map-settings-group', 'oum_max_audio_filesize');
        register_setting('open-user-map-settings-group', 'oum_action_after_submit');
        register_setting('open-user-map-settings-group', 'oum_thankyou_redirect');
        register_setting('open-user-map-settings-group', 'oum_thankyou_headline');
        register_setting('open-user-map-settings-group', 'oum_thankyou_text');
        register_setting('open-user-map-settings-group', 'oum_addanother_label');
        register_setting('open-user-map-settings-group', 'oum_plus_button_label');
        register_setting('open-user-map-settings-group', 'oum_submit_button_label');
        register_setting('open-user-map-settings-group', 'oum_form_headline');
        register_setting('open-user-map-settings-group', 'oum_enable_user_notification');
        register_setting('open-user-map-settings-group', 'oum_user_notification_subject');
        register_setting('open-user-map-settings-group', 'oum_user_notification_message');
        register_setting('open-user-map-settings-group', 'oum_enable_admin_notification');
        register_setting('open-user-map-settings-group', 'oum_admin_notification_email');
        register_setting('open-user-map-settings-group', 'oum_admin_notification_subject');
        register_setting('open-user-map-settings-group', 'oum_admin_notification_message');
        register_setting('open-user-map-settings-group', 'oum_enable_user_restriction');
        register_setting('open-user-map-settings-group', 'oum_enable_redirect_to_registration');
        register_setting('open-user-map-settings-group', 'oum_enable_auto_publish');
        register_setting('open-user-map-settings-group', 'oum_enable_auto_publish_for_everyone');
        register_setting('open-user-map-settings-group', 'oum_enable_add_user_location');
        register_setting('open-user-map-settings-group', 'oum_enable_marker_types');
        register_setting('open-user-map-settings-group', 'oum_marker_types_label');
        register_setting('open-user-map-settings-group', 'oum_ui_color');
        register_setting('open-user-map-settings-group', 'oum_disable_add_location');
        register_setting('open-user-map-settings-group', 'oum_enable_single_page');
    }

    public function admin_index()
    {
        require_once $this->plugin_path . 'templates/page-backend-settings.php';
    }

    public static function validate_geocoordinate($input) 
    {
        // Validation
        $geocoordinate_validated = floatval(str_replace(',', '.', sanitize_text_field($input)));
        if(!$geocoordinate_validated) {
            $geocoordinate_validated = '';
        }

        return $geocoordinate_validated;
    }

    public static function show_getting_started_notice() 
    {
        // return if already dismissed
        if( get_option( 'oum_getting_started_notice_dismissed' ) ) {
            return;
        }

        $screen = get_current_screen();
        
        // Only render this notice in the plugin settings page.
        if ( ! $screen || 'settings_page_open_user_map' !== $screen->base ) {
            return;
        }

        // Render the notice's HTML.
        echo '<div class="notice oum-getting-started-notice notice-success is-dismissible">';
        echo sprintf( __( '<h3>Getting started</h3><ol><li>Create your first <a href="%s">location</a></li><li>Use the Gutenberg Block "Open User Map" or the shortcode <code>[open-user-map]</code> to place the map within your content</li></ol>', 'open-user-map' ), '/wp-admin/post-new.php?post_type=oum-location' );
        echo '</div>';
    }

    public static function getting_started_dismiss_notice() 
    {
        update_option( 'oum_getting_started_notice_dismissed', 1 );
    }
}
