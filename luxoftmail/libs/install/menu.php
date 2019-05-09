<?php

/**
 * Description of menu
 *
 * @author Artem Yuriev art3mk4@gmail.com May 9, 2019 11:38:23 AM
 */

/**
 * luxoftmail_admin_menu
 */
function luxoftmail_admin_menu()
{
    if (function_exists('add_menu_page')) {
        add_menu_page(
            __('Luxoft Mail'),
            __('Luxoft Mail'),
            'activate_plugins',
            'luxoftmail',
            'luxoftmail_admin_action_main',
            'dashicons-email'
        );

        add_submenu_page('luxoftmail', __('Dashboard'), __('Dashboard'), 'activate_plugins', 'luxoftmail', 'luxoftmail_admin_action_main');
        add_submenu_page('luxoftmail', __('Settings'), __('Settings'), 'activate_plugins', 'luxoftmailsettings', 'luxoftmail_admin_action_settings');
    }
}

add_action('admin_menu', 'luxoftmail_admin_menu');

/**
 * luxoftmail_admin_action_main
 */
function luxoftmail_admin_action_main()
{
    luxoftmail_register_main_scripts();
    $template = new TemplateLuxoftMail();
    $tmpl = new models\vendor\adsTemplate();
    $template->setView(
        array(
            'title' => __('Dashboard')
        )
    );

    $template->setArgs(
        array(
            'tmpl' => $tmpl
        )
    );

    echo $template->render('main');
}

/**
 * luxoftmail_admin_action_settings
 */
function luxoftmail_admin_action_settings()
{
    luxoftmail_register_main_scripts();
    $template = new TemplateLuxoftMail();
    $tmpl = new models\vendor\adsTemplate();
    $template->setView(
        array(
            'title' => __('Settings')
        )
    );

    $template->setArgs(
        array(
            'tmpl' => $tmpl
        )
    );

    echo $template->render('settings');
}

/**
 * luxoftmail_plugin_load_admin
 */
function luxoftmail_register_main_scripts()
{
    wp_register_style('luxoft_bootstrap', plugins_url('/luxoftmail/assets/css/vendor/bootstrap/bootstrap.css'), '', LUXOFTMAIL_VERSION);
    wp_register_style('luxoft_main', plugins_url('/luxoftmail/assets/css/vendor/luxoft-main.css'), '', LUXOFTMAIL_VERSION);
    wp_register_style('luxoft_custom', plugins_url('/luxoftmail/assets/css/luxoft.css'), ['luxoft_main', 'luxoft_bootstrap'], LUXOFTMAIL_VERSION);
    wp_enqueue_style('luxoft_custom');

    wp_register_script('luxoft_handlebars', plugins_url('/luxoftmail/assets/js/vendor/handlebars.js'), '', LUXOFTMAIL_VERSION);
    wp_register_script('luxoft_main', plugins_url('/luxoftmail/assets/js/admin/main.js'), ['luxoft_handlebars'], LUXOFTMAIL_VERSION);
    wp_enqueue_script('luxoft_main');
}