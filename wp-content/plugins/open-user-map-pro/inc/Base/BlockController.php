<?php
/**
 * @package OpenUserMapPlugin
 */

namespace OpenUserMapPlugin\Base;

use OpenUserMapPlugin\Base\BaseController;

class BlockController extends BaseController
{
    public function register() {
        // Gutenberg Blocks
        add_action('init', array($this, 'set_gutenberg_blocks'));
    }

    /**
     * Setup Gutenberg Blocks
     */
    public function set_gutenberg_blocks()
    {   
        // register JS for Gutenberg Blocks
        $asset_file = include( $this->plugin_path . 'blocks/build/index.asset.php');
        wp_register_script(
            'oum_blocks_script', 
            $this->plugin_url . 'blocks/build/index.js', 
            $asset_file['dependencies'],
            $asset_file['version']
        );

        // Register Block: Open User Map
        register_block_type( 'open-user-map/map', array(
            'api_version' => 2,
            'editor_script' => 'oum_blocks_script',
            'render_callback' => is_admin() ? null : array($this, 'render_block_map')
        ) );

        // add JS translation for Gutenberg Blocks script
        /*
         Pay Attention: 
         - currently doesnt work with wordpress.org translation --> use local translation file 
         - Translation file needs to be called "open-user-map-de_DE-oum_blocks_script.json"
         - Howto: https://developer.wordpress.org/block-editor/how-to-guides/internationalization/
         */
        wp_set_script_translations( 
            'oum_blocks_script', 
            'open-user-map', 
            $this->plugin_path . 'languages' 
        );
    }
}
