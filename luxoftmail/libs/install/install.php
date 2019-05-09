<?php

/**
 * Description of install
 *
 * @author Artem Yuriev art3mk4@gmail.com May 9, 2019 11:38:11 AM
 */

/**
 * luxoftmail_install
 * 
 * @global type $wpdb
 */
function luxoftmail_install()
{
    global $wpdb;

    require_once(dirname(__FILE__) . '/sql.php');
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    foreach (luxoft_sql_list() as $key) {
        dbDelta($key);
    }
}

/**
 * luxoftmail_uninstall
 */
function luxoftmail_uninstall()
{
    
}

/**
 * luxoftmail_activate
 */
function luxoftmail_activate()
{
    luxoftmail_installed();
    do_action('luxoftmail_activate');
}

/**
 * luxoftmail_deactivate
 */
function luxoftmail_deactivate()
{
    luxoftmail_uninstall();
    do_action('luxoftmail_uninstall');
}

/**
 * luxoftmail_installed
 * 
 * @return type
 */
function luxoftmail_installed()
{
    if (!current_user_can('install_plugins')) {
        return;
    }

    if (get_option('luxoft-version') < LUXOFTMAIL_VERSION) {
        luxoftmail_install();
    }
}
add_action('admin_menu', 'luxoftmail_installed');

/**
 * luxoftmail_register_script
 */
function luxoftmail_register_script()
{
    $scripts = array(
        'front_luxoftmail_script' => array(
            'url'    => '/assets/js/luxoft.js',
            'parent' => array('jquery'),
            'ver'    => LUXOFTMAIL_VERSION
        )
    );

    foreach ($scripts as $key => $value) {
        wp_enqueue_script($key, LUXOFTMAIL_URL . $value['url'], $value['parent'], $value['ver']);
    }

    wp_localize_script(
        'front_luxoftmail_script',
        'ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php')
        )
    );
}
add_action('wp_enqueue_scripts', 'luxoftmail_register_script');