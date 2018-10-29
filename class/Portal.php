<?php

class Portal
{
    private $dbo = null;

    function __construct(InputStream $dbo)
    {
        $this->dbo = $this->initPDOMysql($dbo);
    }

    function initPDOMysql(InputStream $dbo)
    {	
        return $dbo;
    }
}