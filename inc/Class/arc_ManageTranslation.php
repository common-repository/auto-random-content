<?php
/**
 * Created by PhpStorm.
 * User: marcobaroni
 * Date: 08/01/18
 * Time: 12.09
 */

class arc_ManageTranslation
{
    ############### ATTR ###################
    public function __construct()
    {
        add_action('plugins_loaded', [$this, 'load_translation']);
    }

    ############## METHODS #################
    public function load_translation()
    {
        load_plugin_textdomain(RANDOM_CONTENT_PLUGIN_DOMAIN_NAME, false, RANDOM_CONTENT_PLUGIN_DIR_RELATIVE . '/languages/');
    }

}