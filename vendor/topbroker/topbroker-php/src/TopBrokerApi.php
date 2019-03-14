<?php

namespace TopBroker;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;


class TopBrokerApi {

    /**
     * @var Client $http
     */
    private $http;

    /**
     * @var string API $api_url
     */
    private $api_url = 'https://api.topbroker.lt/api';

    /**
     * @var string API version
     */
    protected $api_version;

    /**
     * @var array API available versions
     */
    private $api_available_versions = ['v4'];

    /**
     * @var string API crediantials
     */
    protected $crediantials;
    /**
     * @var TopBrokerEstates $estates
     */
    public $estates;

    /**
     * @var TopBrokerContacts $contacts
     */
    public $contacts;

    /**
     * @var TopBrokerLocations $contacts
     */
    public $locations;

    /**
     * @var TopBrokerUsers $users
     */
    public $users;

    /**
     * @var TopBrokerDeals $deals
     */
    public $deals;

     /**
     * TopBroker API constructor.
     *
     * @param string $username App ID.
     * @param string|null $password Api Secrect Key.
     * @param string  $extraGuzzleRequestsOptions Extra Guzzle request options.
     */
    public function __construct($app_token_id, $app_secret_key)
    {
        
        $this->setDefaultClient();
        $this->setCredentials($app_token_id, $app_secret_key);
        $this->setApiVersion(null);
        
        $this->estates = new TopBrokerEstates($this);
        $this->locations = new TopBrokerLocations($this);
        $this->contacts = new TopBrokerContacts($this);
        $this->inquiries = new TopBrokerInquiries($this);
        $this->users = new TopBrokerUsers($this);
        $this->deals = new TopBrokerDeals($this);
    }

    /**
     * Sets HTTP client.
     *
     * @param Client $client
     */
    private function setClient($client)
    {
        $this->http = $client;
    }

    private function setDefaultClient()
    {        
        $this->http = new Client();
    }

    /**
     * Sets HTTP client.
     *
     * @param Client $client
     */
    public function setApiVersion($version)
    {
      if(in_array($version, $this->api_available_versions)){
        $this->api_version = $version;
      } else{
        $this->api_version = end($this->api_available_versions);
      }
      
    }


    /**
     * Sends POST request to Intercom API.
     *
     * @param  string $endpoint
     * @param  array $json
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($endpoint, $json)
    {
        $guzzleRequestOptions = $this->getGuzzleRequestOptions([
            'json' => $json,
            'auth' => $this->getAuth(),
            'headers' => [
                'Accept' => 'application/json'
            ],
        ]);
        $response = $this->http->request('POST', $this->getFullApiUrl($endpoint), $guzzleRequestOptions);
        return $this->handleResponse($response);
    }

    /**
     * Sends PUT request to Intercom API.
     *
     * @param  string $endpoint
     * @param  array $json
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put($endpoint, $json)
    {
        $guzzleRequestOptions = $this->getGuzzleRequestOptions([
            'json' => $json,
            'auth' => $this->getAuth(),
            'headers' => [
                'Accept' => 'application/json'
            ],
        ]);

        $response = $this->http->request('PUT', $this->getFullApiUrl($endpoint), $guzzleRequestOptions);
        return $this->handleResponse($response);
    }

    /**
     * Sends DELETE request to Intercom API.
     *
     * @param  string $endpoint
     * @param  array $json
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($endpoint, $json)
    {
        $guzzleRequestOptions = $this->getGuzzleRequestOptions(
            [
            'json' => $json,
            'auth' => $this->getAuth(),
            'headers' => [
                'Accept' => 'application/json'
            ],
            ]
        );

        $response = $this->http->request('DELETE', $this->getFullApiUrl($endpoint), $guzzleRequestOptions);
        return $this->handleResponse($response);
    }

    /**
     * @param string $endpoint
     * @param array  $query
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($endpoint, $query)
    {
        $guzzleRequestOptions = $this->getGuzzleRequestOptions(
            [
            'query' => $query,
            'auth' => $this->getAuth(),
            'headers' => [
                'Accept' => 'application/json'
            ],
            ]
        );

        $response = $this->http->request('GET', $this->getFullApiUrl($endpoint), $guzzleRequestOptions);
        return $this->handleResponse($response);
    }


    /**
     * Returns authentication parameters.
     *
     * @return array
     */
    protected function getFullApiUrl($endpoint)
    {
        return "$this->api_url/$this->api_version/$endpoint";
    }

    /**
     * Returns authentication parameters.
     *
     * @return array
     */
    public function setCredentials($username, $password)
    {
      $this->credentials = [$username, $password];
    }
    /**
     * Returns authentication parameters.
     *
     * @return array
     */
    public function getAuth()
    {
        return $this->credentials;
    }

    /**
     * @param Response $response
     * @return mixed
     */
    private function handleResponse(Response $response)
    {
        $stream = \GuzzleHttp\Psr7\stream_for($response->getBody());
        $data = json_decode($stream);
        return $data;
    }


    /**
     * Returns Guzzle Requests Options Array
     *
     * @param  array $defaultGuzzleRequestOptions
     * @return array
     */
    public function getGuzzleRequestOptions($defaultGuzzleRequestOptions = [])
    {
        return $defaultGuzzleRequestOptions;
    }





}

?>