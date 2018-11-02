<?php

class Category
{
    public $dbo;
    public $loggedId;
    public $id;
    public $name;
    public $sum;

    function __construct($dbo, $loggedId, $id, $sum)
    {
        $this -> dbo = $dbo;
        $this -> loggedId = $loggedId;
        $this -> id = $id;
        $this -> sum = $sum;
    }
}
?>