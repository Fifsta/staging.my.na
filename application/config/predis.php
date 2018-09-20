<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Config for Rabbit MQ Library
 */


$host = getEnv('IA_REDIS_HOST');
if( $host ){

	$port = getEnv('IA_REDIS_PORT') ?: 6379;

	$config['redis'] = array(
	    'host' => $host,    // <- Your Host     (default: localhost)
	    'port' => $port,           // <- Your Port     (default: 6379)

	);
}else{
	$config['redis'] = array(
	    'host' => '127.0.0.1',    // <- Your Host     (default: 127.0.0.1)
	    'port' => 6379,           // <- Your Port     (default: 6379)
	    'scheme' => 'tcp'            // <- Your Vhost    (default: /)
	);
}