<?php

namespace models;

/**
 * Description of Settings
 *
 * @author Artem Yuriev art3mk4@gmail.com May 9, 2019 4:31:03 PM
 */
class Address
{

    /**
     * CONST
     */
    CONST NAME = 'luxoftaddress';

    /**
     *
     * @var type 
     */
    private $_address;

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
        $this->setAddress($this->_params['address']);
    }

    /**
     * update
     */
    public function update()
    {
        update_option(self::NAME, maybe_serialize($this->_params));
    }

    /**
     * getAddress
     * 
     * @return type
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * setAddress
     * 
     * @param type $address
     */
    public function setAddress($address)
    {
        $this->_address = $address;
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
            'address' => '',
        );
    }

    /**
     * validate
     * 
     * @param type $data
     * @return type
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
     * getErrorMessages
     * 
     * @return type
     */
    public function getErrorMessages()
    {
        return array(
            'address' => __('Enter valid address')
        );
    }
}