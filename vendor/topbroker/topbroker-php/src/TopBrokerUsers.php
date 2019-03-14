<?php

namespace TopBroker;

class TopBrokerUsers{

    /**
     * @var API
     */
    private $api;


    /**
    * @var endpoint
    */
    private $endpoint = 'users';


    /**
     * TopBroker::API constructor.
     *
     * @param TopBroker::API $http
     */
    public function __construct($api)
    {
        $this->api = $api;
    }

    /**
     * Returns list of Users.
     *
     * @param  array $params
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getList($params = [])
    {
        return $this->api->get($this->buildPath(), $params);
    }

    /**
     * Count Users.
     *
     * @param  array $params
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCount($params = [])
    {
        return $this->api->get($this->buildPath('count'), $params);
    }

    /**
     * Returns list of User Custom Fields.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCustomFields($options = [])
    {
        return $this->api->get($this->buildPath("custom_fields"), $options);
    }


    /**
     * Returns full information of User by ID.
     *
     * @param  integer $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getItem($id, $options = [])
    {
        return $this->api->get($this->buildPath($id), $options);
    }

    /**
     * Returns full endpoint path
     *
     * @param string $segment
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function buildPath($segment = null)
    {
        return is_null($segment) ? $this->endpoint : $this->endpoint."/".$segment;
    }
}

