<?php

$memcached_enabled = $this->cache->memcached->is_supported();
if(!$memcached_enabled) 
{ 
 echo "Memcached is not installed"; 
 die; 
}

?>	