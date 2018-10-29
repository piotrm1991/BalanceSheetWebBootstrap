<?php

class SingleEntry
{
    private $dbo = null;
    private $loggedId;

    public $id;
    public $user_id;
    public $amount;
    public $date;
    public $comment;

    function __construct($dbo, $loggedId, $id='', $user_id, $amount, $date, $comment)
    {
        $this -> dbo = $dbo;
        $this -> loggedId = $loggedId;

        $this -> id = $id;
        $this -> user_id = $user_id;
        $this -> amount = $amount;
        $this -> date = $date;
        $this -> comment = $comment;
    }
}
?>	

