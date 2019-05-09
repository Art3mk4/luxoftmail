<?php

namespace models\ajax;
use models\Settings as Settings;
use models\Address as Address;
use models\Request as Request;

/**
 * Description of AjaxRequest
 *
 * @author Artem Yuriev art3mk4@gmail.com May 9, 2019 12:38:33 PM
 */
class AjaxRequest
{

    /**
     * getResponse
     * 
     * @param type $params
     * @return type
     */
    public static function getResponse($params)
    {
        if (isset($params['action'])) {
            $lux_action = 'action_' . $params['lux_action'];
            $args = $params['args'];
            $data = array();

            parse_str($args, $data);
            if (method_exists(get_called_class(), $lux_action)) {
                return call_user_func(array(__CLASS__, $lux_action), $data);
            }
        }

        return array(
            'error' => __('Undefined action')
        );
    }

    /**
     * action_main
     * 
     * @return type
     */
    public static function action_main()
    {
        $address = new Address();
        $address->select();
        $response = $address->getParams();
        $response['result'] = true;
        return $response;
    }

    /**
     * action_save_main
     * 
     * @return type
     */
    public static function action_save_main($params)
    {
        $address = new Address();
        $message = $address->validate($params);
        if (!empty($message)) {
            return array(
                'result'  => false,
                'message' => $message
            );
        }

        return self::saveParseAddress($params);
    }

    /**
     * action_front_address
     * 
     * @param type $params
     * @return type
     */
    public static function action_front_address($params)
    {
        if (!isset($params['address'])) {
            return array(
                'result' => false
            );
        }

        return self::saveParseAddress($params);
    }

    /**
     * action_settings
     * 
     * @return type
     */
    public static function action_settings()
    {
        $settings = new Settings();
        $settings->select();
        $response = $settings->getParams();
        $response['result'] = true;
        return $response;
    }

    /**
     * action_save_settings
     * 
     * @return type
     */
    public static function action_save_settings($params)
    {
        $settings = new Settings();
        $message = $settings->validate($params);
        if (!empty($message)) {
            return array(
                'result'  => false,
                'message' => $message
            );
        }

        $settings->setParams($params);
        $settings->update();

        return array(
            'result'  => true,
            'message' => __('Settings have been saved')
        );
    }

    /**
     * saveParseAddress
     * 
     * @param type $params
     * @return type
     */
    public static function saveParseAddress($params)
    {
        $request = new Request();
        $request->setAddress($params['address']);
        $response = $request->sendRequest();
        if (!$response) {
            return array(
                'result' => false
            );
        }

        $stringAddress = $request->parse();
        if (empty($stringAddress)) {
            return array(
                'result' => false
            );
        }

        $address = new Address();
        $address->setParams(
            array(
                'address' => $stringAddress
            )
        );
        $address->update();

        return array(
            'result' => true,
            'address' => $stringAddress,
            'message' => __('Address has been saved')
        );
    }
}