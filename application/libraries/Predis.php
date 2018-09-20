<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*

Redis Implementation Library for fast cache based memory writes helping MySQL

https://github.com/nrk/predis


*/


class Predis {

    // Default private vars
    private $CI;

    // Default protected vars
    protected $config;

    /**
     * __construct : Constructor
     * @method __construct
     */
    public function __construct(array $config = array())
    {
        // Load the CI instance
        $this->CI = & get_instance();

        // Define the config global
        $this->config = (!empty($config)) ? $config : array();

        //Hold client
        $this->client = null;

        // Initialize the connection
        $this->initialize($this->config);
    }

    /**
     * initialize : Initialize the configuration of the Library
     * @method initialize
     */
    public function initialize(array $config = array())
    {

        var_dump($config);
        // We check if we have a config given then we initialize the connection
        if(!empty($config)) {

            $this->client = new Predis\Client([
                'scheme' => 'tcp',
                'host'   => '10.0.0.1',
                'port'   => 6379,
            ]);

        } else {
            show_error('Invalid Redis configuration file', 'error', 'x');
        }
    }

    /**
     * Test method
     * @method test
     */
    public function test()
    {

        echo 'Test';
        var_dump($this->client);
    }

}    
/* End of file Predis.php */
/* Location: ./application/librairies/Predis.php */