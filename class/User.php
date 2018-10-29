<?php
class User
{
    public $id;
    public $username;
    public $privilege;
    
    function __construct($id, $username)
    {
        $this -> id = $id;
        $this -> username = $username;
        $this -> privilege = array();
    }
}
?>