<?php
/**
 * @package OpenUserMapPlugin
 */

namespace OpenUserMapPlugin\Pages;

use \OpenUserMapPlugin\Base\BaseController;

class Frontend extends BaseController
{
    public function register()
    { 
      // Shortcodes
      add_action('init', array($this, 'set_shortcodes'));

      if ( oum_fs()->is__premium_only() ):
        if ( oum_fs()->can_use_premium_code() ):

          //PRO: Add user location within registration
          if(get_option('oum_enable_add_user_location')):
            add_action('register_form', array($this, 'render_block_add_user_location__premium_only'));
            add_action('user_register', array($this, 'add_user_location__premium_only'));
          endif;

        endif;
      endif;
    }

    /**
     * Setup Shortcode
     */
    public function set_shortcodes()
    {
      add_shortcode('open-user-map', array($this, 'render_block_map'));
    }
}
