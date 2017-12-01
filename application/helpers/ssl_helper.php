<?php
if (!function_exists('force_ssl'))
{
    function force_ssl()
    {
        $CI =& get_instance();
        $CI->config->config['site_url'] =
                 str_replace('http://', 'https://',
                 $CI->config->config['site_url'].'/');
        if ($_SERVER['SERVER_PORT'] != 443)
        {
            redirect(str_replace('//','/',$CI->uri->uri_string()));
        }
    }
}

	function remove_ssl()
	{
		$CI =& get_instance();
		$CI->config->config['site_url'] =
					  str_replace('https://', 'http://',
					  $CI->config->config['site_url'].'/');
		if ($_SERVER['SERVER_PORT'] != 80)
		{
		   redirect(str_replace('//','/',$CI->uri->uri_string()));
		}
	}
?>