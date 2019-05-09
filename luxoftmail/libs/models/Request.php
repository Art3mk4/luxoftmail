<?php

namespace models;

/**
 * Description of Request
 *
 * @author Artem Yuriev art3mk4@gmail.com May 9, 2019 5:12:54 PM
 */
class Request
{

    /**
     *
     * @var type 
     */
    private $_url;

    /**
     *
     * @var type 
     */
    private $_address;

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
    private $_request;

    /**
     * Request constructor
     */
    public function __construct()
    {
        $settings = new Settings();
        $settings->select();
        $this->_key = $settings->getKey();
        $this->_token = $settings->getToken();
        $this->_url = 'https://otpravka-api.pochta.ru/1.0/clean/address';
    }

    /**
     * sendRequest
     */
    public function sendRequest()
    {
        $this->_request = wp_remote_post(
            $this->getUrl(),
            array(
                'method' => 'POST',
                'timeout' => 45,
                'sslverify' => false,
                'headers' => array(
                    'Content-Type'         => 'application/json;charset=UTF-8',
                    'Authorization'        => 'AccessToken ' . $this->_token,
                    'X-User-Authorization' => 'Basic ' . $this->_key
                ),
                'body' => json_encode(
                    array(
                        array(
                            'id'               => 'adr 1',
                            'original-address' => $this->getAddress()
                        )
                    )
                )
            )
        );

        if ($this->_request['response']['code'] != 200) {
            return false;
        }

        if ($this->_request['response']['message'] != 'OK') {
            return false;
        }
        
        return true;
    }

    /**
     * parse
     * 
     * @return type
     */
    public function parse()
    {
        $bodyParams = (array)current(json_decode($this->_request['body']));
        if (in_array($bodyParams['quality-code'], array('GOOD', 'POSTAL_BOX', 'ON_DEMAND', 'UNDEF_05'))
            && in_array($bodyParams['validation-code'], array('VALIDATED', 'OVERRIDDEN', 'CONFIRMED_MANUALLY'))
        ) {
            $params = array();
            foreach ($this->getFields() as $item) {
                if (!empty($bodyParams[$item])) {
                    if ($item == 'house') {
                        $params[] = 'д ' . $bodyParams[$item];
                    } else {
                        $params[] = $bodyParams[$item];
                    }
                }
            }

            return implode(', ', $params);
        }

        return '';
    }

    /**
     * getFields
     * 
     * @return type
     */
    public function getFields()
    {
        return array('index', 'region', 'place', 'street', 'house');
    }

    /**
     * getUrl
     * 
     * @return type
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * setUrl
     * 
     * @param type $url
     */
    public function setUrl($url)
    {
        $this->_url = $url;
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
     * getRequest
     * 
     * @return type
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * setRequest
     * 
     * @param type $request
     */
    public function setRequest($request)
    {
        $this->_request = $request;
    }
}