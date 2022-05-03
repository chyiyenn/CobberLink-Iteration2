<?php
/**
 * @package OpenUserMapPlugin
 */

namespace OpenUserMapPlugin\Base;

use \OpenUserMapPlugin\Base\BaseController;

class SettingsLinks extends BaseController
{

    public function register()
    {
        add_filter('plugin_action_links_' . $this->plugin, array($this, 'settings_link'));
    }

    public function settings_link($links)
    {
        $settings_link = '<a href="options-general.php?page=open_user_map">Settings</a>';
        array_push($links, $settings_link);

        return $links;
    }
}
