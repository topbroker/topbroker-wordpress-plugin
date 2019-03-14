<?php
namespace TopBroker;

class TopBrokerEstates{

    /**
     * @var API
     */
    private $api;


    /**
    * @var endpoint
    */
    private $endpoint = 'estates';


    /**
     * @var estate_types Availble Estate types
     */
    private $estate_types = ['flat', 'commercial', 'house', 'site'];

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
     * Returns list of Estates.
     *
     * @param  array $params
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getList($params = [])
    {
        return $this->api->post($this->buildPath(), $params);
    }

    /**
     * Returns list of Estates.
     *
     * @param  array $params
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCount($params = [])
    {
        return $this->api->post($this->buildPath("count"), $params);
    }

    /**
     * Returns list of Estate Custom Fields.
     *
     * 
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCustomFields($options = [])
    {
        return $this->api->get($this->buildPath("custom_fields"), $options);
    }

    /**
     * Returns full information of Estate by ID.
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
     * Returns Estate Attributes By Estate Type
     *
     * @param  string $type
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAttributes($type, $options = [])
    {
        if(!in_array($type, $this->estate_types)){
            $type = $this->estate_types[0];
        }
        
        return $this->api->get("estate_attributes/".$type, $options);
    }

     /**
     * Assign Estate to Estate
     *
     * @param  integer $id
     * @options mixed $options
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function assignEstate($id, $options = [])
    {
        if(!(int)$options['estate_id']){
            throw new Exception("estate_id must be provided as ['estate_id' => 1234]");
        }
        return $this->api->put($this->buildPath($id . '/assign_estate/' . $options['estate_id'] ), []);
    }

    /**
     * Returns assigned Estate List to Contact
     *
     * @param  integer $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAssignedEstateList($id, $options = [])
    {
        return $this->api->get($this->buildPath($id. '/assigned_estates'), $options);
    }

     /**
     * Assign Contact to Estate
     *
     * @param  integer $id
     * @options mixed $options
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function assignContact($id, $options = [])
    {
        if(!(int)$options['contact_id']){
            throw new Exception("contact_id must be provided as ['contact_id' => 1234]");
        }
        return $this->api->put($this->buildPath($id . '/assign_contact/' . $options['contact_id'] ), []);
    }

    /**
     * Returns assigned Contact List to Contact
     *
     * @param  integer $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAssignedContactList($id, $options = [])
    {
        return $this->api->get($this->buildPath($id. '/assigned_contacts'), $options);
    }

    /**
     * Change Owner (User) of Estate
     *
     * @param  integer $id
     * @options mixed $options
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function changeOwner($id, $options = [])
    {
        if(!(int)$options['user_id']){
            throw new Exception("user_id must be provided as ['user_id' => 1234]");
        }
        return $this->api->put($this->buildPath($id . '/change_owner/' . $options['user_id'] ), []);
    }

    /**
     * Change Privacy of Estate
     *
     * @param  integer $id
     * @options mixed $options
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function changePrivacy($id, $options = [])
    {

        if(!in_array($options['privacy_level'], ['public', 'shared', 'private'])){
            throw new Exception("privacy_level must be one of: 'public', 'shared', 'private'");
        }
        return $this->api->put($this->buildPath($id . '/change_privacy'), $options);
    }


    /**
     * Returns full endpoint path
     *
     * @param  string $segment
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function buildPath($segment = null)
    {
        return is_null($segment) ? $this->endpoint : $this->endpoint."/".$segment;
    }





}


?>