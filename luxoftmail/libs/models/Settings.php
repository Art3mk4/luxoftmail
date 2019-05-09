<?php

namespace models;

/**
 * Description of Settings
 *
 * @author Artem Yuriev art3mk4@gmail.com May 9, 2019 4:31:03 PM
 */
class Settings
{

    /**
     * CONST
     */
    CONST NAME = 'luxoftsettings';

    /**
     *
     * @var type 
     */
    private $_key;

    /**
     *
     * @var type 
     */
    private $_token;

    /**
     *
     * @var type 
     */
    private $_params;

    /**
     * Settings constructor
     */
    public function __construct()
    {
        $options = get_option(self::NAME, array());
        if (empty($options)) {
            $default = $this->getDefault();
            add_option(self::NAME, maybe_serialize($default));
        }
    }

    /**
     * select
     */
    public function select()
    {
        $args = get_option(self::NAME, '');
        if (empty($args)) {
            $args = $this->getDefault();
        }

        $this->_params = maybe_unserialize($args);
        $this->setKey($this->_params['key']);
        $this->setToken($this->_params['token']);
    }

    /**
     * update
     */
    public function update()
    {
        update_option(self::NAME, maybe_serialize($this->_params));
    }

    /**
     * getKey
     * 
     * @return type
     */
    public function getKey()
    {
        return $this->_key;
    }

    /**
     * getToken
     * 
     * @return type
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * setKey
     * 
     * @param type $key
     */
    public function setKey($key)
    {
        $this->_key = $key;
    }

    /**
     * setToken
     * 
     * @param type $token
     */
    public function setToken($token)
    {
        $this->_token = $token;
    }

    /**
     * getParams
     * 
     * @return type
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * setParams
     * 
     * @param type $params
     */
    public function setParams($params)
    {
        $defaults = $this->getDefault();
        $this->_params = wp_parse_args($params, $defaults);
    }

    /**
     * getDefault
     * 
     * @return type
     */
    public function getDefault()
    {
        return array(
            'key'   => '',
            'token' => ''
        );
    }

    /**
     * validate
     * 
     * @param type $data
     */
    public function validate($data = array())
    {
        $errors = $this->getErrorMessages();
        foreach ($errors as $key => $value) {
            if (empty($data[$key])) {
                return $value;
            }
        }
    }

    /**
     * 
     */
    public function getErrorMessages()
    {
        return array(
            'key'   => __('Enter valid key'),
            'token' => __('Enter valid token')
        );
    }
}