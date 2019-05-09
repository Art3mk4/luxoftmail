<?php
/**
 * Plugin Name: Luxoft Mail Plugin
 * Plugin URI: https://luxoft.com/
 * Description: WordPress plugin
 * Version: 0.0.1
 * Requires at least: WP 5.1.0
 * Author: Artem Yuriev art3mk4@gmail.com
 * Author URI: https://luxoft.com/
 * License: SHAREWARE
 */

if (!defined('LUXOFTMAIL_VERSION')) define('LUXOFTMAIL_VERSION', '0.0.1');
if (!defined('LUXOFTMAIL_PATH')) define('LUXOFTMAIL_PATH', plugin_dir_path(__FILE__));
if (!defined('LUXOFTMAIL_URL')) define('LUXOFTMAIL_URL', str_replace(array('https:', 'http:'), '', plugins_url('luxoftmail')));

$dirname = dirname(__FILE__);
$phpfiles = array(
    'autoload.php',
    'install.php',
    'menu.php',
    'actions.php',
    'handlers.php'
);

foreach ($phpfiles as $value) {
    require($dirname . '/libs/install/' . $value);
}

require_once($dirname . '/libs/TemplateLuxoftMail.php');
register_activation_hook(__FILE__, 'luxoftmail_install');
register_uninstall_hook(__FILE__, 'luxoftmail_uninstall');
register_activation_hook(__FILE__, 'luxoftmail_activate');
register_deactivation_hook(__FILE__, 'luxoftmail_deactivate');