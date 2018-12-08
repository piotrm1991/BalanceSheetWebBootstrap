<?php

abstract class SingleEntry
{
    private $dbo = null;
    private $loggedId;

    public $id;
    public $user_id;
    public $amount;
    public $category;
    public $date;
    public $comment;

    abstract function assignCategory();   
    abstract function getStartHTML();  
    abstract function getBalanceHTML();
}
?>	

