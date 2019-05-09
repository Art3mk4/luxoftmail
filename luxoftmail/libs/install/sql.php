<?php

/**
 * Description of sql
 *
 * @author Artem Yuriev art3mk4@gmail.com May 9, 2019 12:02:20 PM
 */

/**
 * luxoft_sql_list
 * 
 * @global type $wpdb
 * @return type
 */
function luxoft_sql_list()
{
    global $wpdb;

    $charset_collate = !empty($wpdb->charset) ? "DEFAULT CHARACTER SET $wpdb->charset" : "DEFAULT CHARACTER SET utf8mb4";

    return array(
        
    );
}