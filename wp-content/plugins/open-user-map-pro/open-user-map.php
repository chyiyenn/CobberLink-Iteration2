<?php

/**
 * @package OpenUserMapPlugin
 */
/*
Plugin Name: Open User Map | Everybody can add locations Pro
Plugin URI: https://wordpress.org/plugins/open-user-map/
Description: Let your visitors add locations directly from within the map. They drop a marker on the map and provide some location details. After submit the location proposal will be "pending" and wait for your review approval to get published.
Author: 100plugins
Version: 1.2.14
Author URI: https://www.open-user-map.com/
License: GPLv3 or later
Text Domain: open-user-map
*/
/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.

Copyright 2022 100plugins
*/
defined( 'ABSPATH' ) or die( 'Direct access is not allowed.' );

if ( function_exists( 'oum_fs' ) ) {
    oum_fs()->set_basename( true, __FILE__ );
} else {
    // FREEMIUS INTEGRATION CODE
    
    if ( !function_exists( 'oum_fs' ) ) {
        // Create a helper function for easy SDK access.
        function oum_fs()
        {
            global  $oum_fs ;
            
            if ( !isset( $oum_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $oum_fs = fs_dynamic_init( array(
                    'id'             => '9083',
                    'slug'           => 'open-user-map',
                    'premium_slug'   => 'open-user-map-pro',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_e4bbeb52c0d44fa562ba49d2c632d',
                    'is_premium'     => true,
                    'premium_suffix' => 'Pro',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'trial'          => array(
                    'days'               => 7,
                    'is_require_payment' => false,
                ),
                    'menu'           => array(
                    'slug'       => 'open_user_map',
                    'first-path' => 'options-general.php?page=open_user_map',
                    'contact'    => false,
                    'support'    => false,
                    'parent'     => array(
                    'slug' => 'options-general.php',
                ),
                ),
                    'is_live'        => true,
                ) );
            }
            
            return $oum_fs;
        }
        
        // Init Freemius.
        oum_fs();
        // Signal that SDK was initiated.
        do_action( 'oum_fs_loaded' );
    }
    
    // Special uninstall routine with Freemius
    function oum_fs_uninstall_cleanup()
    {
        global  $wpdb ;
        //delete posts
        $wpdb->query( "DELETE FROM " . $wpdb->prefix . "posts WHERE post_type='oum-location'" );
        //delete postmeta
        $wpdb->query( "DELETE FROM " . $wpdb->prefix . "postmeta WHERE meta_key LIKE '%oum_%'" );
        //delete options
        $wpdb->query( "DELETE FROM " . $wpdb->prefix . "options WHERE option_name LIKE 'oum_%'" );
    }
    
    oum_fs()->add_action( 'after_uninstall', 'oum_fs_uninstall_cleanup' );
    // Better Opt-In Screen
    add_action( 'admin_body_class', function ( $class ) {
        if ( oum_fs()->is_activation_mode() ) {
            $class .= ' oum-fs-optin-dashboard';
        }
        return $class;
    } );
    oum_fs()->add_action( 'connect/before', function () {
        echo  '<div class="oum-optin-wrapper"><div class="oum-optin-hero"><div class="oum-optin-image"></div></div>' ;
    } );
    oum_fs()->add_action( 'connect/after', function () {
        echo  '</div>' ;
    } );
    oum_fs()->add_filter( 'connect_message', function ( $text ) {
        $current_user = wp_get_current_user();
        $text = '<span>Hey ' . $current_user->user_login . ',</span>Never miss an important update - opt in to our security &amp; feature updates notifications, and non-sensitive diagnostic tracking with <a href="https://freemius.com/wordpress/usage-tracking/9083/open-user-map/" target="_blank" rel="noopener" tabindex="1">freemius.com</a>. For developing the <strong>Open User Map plugin</strong> in the way you want it this helps us a lot. Thank you!';
        return $text;
    } );
    // ... Your plugin's main file logic ...
    // Require once the composer autoload
    if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
        require_once dirname( __FILE__ ) . '/vendor/autoload.php';
    }
    /**
     * The code that runs during plugin activation
     */
    function oum_activate_plugin()
    {
        OpenUserMapPlugin\Base\Activate::activate();
    }
    
    register_activation_hook( __FILE__, 'oum_activate_plugin' );
    /**
     * The code that runs during plugin deactivation
     */
    function oum_deactivate_plugin()
    {
        OpenUserMapPlugin\Base\Deactivate::deactivate();
    }
    
    register_deactivation_hook( __FILE__, 'oum_deactivate_plugin' );
    /**
     * Initialize all the core classes of the plugin
     */
    if ( class_exists( 'OpenUserMapPlugin\\Init' ) ) {
        OpenUserMapPlugin\Init::register_services();
    }
}
