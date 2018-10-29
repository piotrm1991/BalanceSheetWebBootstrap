<?php

class GetNames
{
    private $dbo = null;
    private $loggedId;
    private $names;

    function __construct($dbo, $loggedId, $names)
    {
        $this->dbo = $dbo;
        $this->loggedId = $loggedId;
        $this->names = $names;
    }

    function getNames()
    {
        return $this->names;
    }
}