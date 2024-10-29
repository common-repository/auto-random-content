<?php
/**
 * Plugin Name: Auto Random Content
 * Plugin URI: http://www.baronimarco.it/random-content
 * Version: 2.1.2
 * Description: This plugin created automatic post/page/media/terms with random content | It's Perfect for WP developer.
 * Author: Baroni Marco
 * Author URI: http://www.baronimarco.it
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: autorandomcontent
 * Domain Path: /languages
 * @author  Baroni Marco <baroni.marco.91@gmail.com>
 */
if (is_admin()) {

    /* LOAD COMPOSER LIBRARY */
    require_once("vendor/autoload.php");

    /* LOAD CONSTANT */
    DEFINE('RANDOM_CONTENT_PLUGIN_DIR', plugin_dir_path(__FILE__));
    DEFINE('RANDOM_CONTENT_PLUGIN_URL', plugin_dir_url(__FILE__));
    DEFINE('RANDOM_CONTENT_PLUGIN_DIR_RELATIVE', basename(dirname(__FILE__)));
    DEFINE('RANDOM_CONTENT_DIR_FOR_ACTIVATE_PLUGIN', __FILE__);
    DEFINE('RANDOM_CONTENT_PLUGIN_DOMAIN_NAME', 'autorandomcontent');

    /* SETUP THE NEW OPTION PAGE */
    $my_settings_page = new arc_RandomContentOptionPage();

    /* SETUP NEW BUTTON ON ADMIN BAR */
    $manage_admin_bar = new arc_ManageAdminBarButton();

    /* SETUP ASSETS OF PLUGIN & HTML ADDITIONAL */
    $manage_assets = new arc_ManageAssets();

    /* SETUP AJAX REQUEST THAT START RANDOM POST PROCEDURE & DELETE  */
    $auto_random_content = new arc_AutoRandomContent();

    /* SETUP OTHER AJAX REQUEST --> GENERALLY FROM OPTION PAGE  */
    $auto_random_content = new arc_ManageAjaxRequest();

    /* SETUP ON ACTIVATE PLUGIN THE NEW TABLE FOR LOG INFO */
    $activate_plugin = new arc_ManagePluginActivate();

    /* LOAD STRING TRANSLATION */
    $manage_translation = new arc_ManageTranslation();

    /* LOAD NEW WIDGET ON WP DASHBOARD */
    $widget_dashboard = new arc_DashBoardWidget();
}
