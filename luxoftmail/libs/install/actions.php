<?php

/**
 * Description of actions
 *
 * @author Artem Yuriev art3mk4@gmail.com May 9, 2019 11:38:30 AM
 */

/**
 * luxoftmail_init_db
 * 
 * @global type $wpdb
 */
function luxoftmail_init_db()
{
    global $wpdb;
}
add_action('init', 'luxoftmail_init_db');

/**
 * luxoft_home_page
 */
function luxoft_home_page()
{
    if (is_page('home')) {
        load_template(LUXOFTMAIL_PATH . 'libs/templates/_home.php', true);
        die();
    }
}
add_action('template_redirect', 'luxoft_home_page');