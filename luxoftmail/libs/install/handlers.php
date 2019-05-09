<?php

/**
 * Description of handlers
 *
 * @author Artem Yuriev art3mk4@gmail.com May 9, 2019 11:38:42 AM
 */

/**
 * luxoftmail_ajax
 */
function luxoftmail_ajax()
{
    if (!empty($_POST)) {
        $response = models\ajax\AjaxRequest::getResponse($_POST);
        echo json_encode($response);
        die;
    }
}

add_action('wp_ajax_luxoftmail_ajax', 'luxoftmail_ajax');
add_action('wp_ajax_nopriv_luxoftmail_ajax', 'luxoftmail_ajax');