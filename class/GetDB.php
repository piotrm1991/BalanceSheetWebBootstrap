<?php

class GetDB
{
    function getPDO($config)
    {
	    $dbo = new MyDBPDO("mysql:host={$config['host']}; dbname={$config['database']}; charset=utf8", $config['user'], $config['password'], [
		       PDO::ATTR_EMULATE_PREPARES => false, 
		       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
	    return $dbo;
    }
}
?>