<?php


/* Define ABSPATH as this file's directory */
defined('ABSPATH')
	or define('ABSPATH', dirname($_SERVER["SCRIPT_FILENAME"]) . '/');


/**/
defined('APPPATH') 
	or define('APPPATH', ABSPATH . 'app');


/* Define ASSETS as the assets file directory */
defined('ASSETSPATH') 
	or define('ASSETSPATH', ABSPATH . 'assets');


/**/
defined('VIEWSPATH') 
	or define('VIEWSPATH', APPPATH . '/views');

require_once ABSPATH . '/config.php';

echo "<pre>";
//print_r($config);
echo "</pre>";

function getCurrentURL()
{
    $currentURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $currentURL .= $_SERVER["SERVER_NAME"];

    if($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443")
    {
        $currentURL .= ":".$_SERVER["SERVER_PORT"];
    } 

        $currentURL .= $_SERVER["REQUEST_URI"];
    return $currentURL;
}