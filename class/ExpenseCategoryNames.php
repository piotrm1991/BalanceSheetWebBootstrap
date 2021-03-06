<?php
class ExpenseCategoryNames extends GetNames
{
    function __construct($dbo, $loggedId)
    {
        $this -> dbo = $dbo;
        $this -> loggedId = $loggedId;
        $this -> names = $this -> setNames();
    }

    function setNames()
    {
        $names = $this -> dbo -> getExpenseNames($this -> loggedId);
        return $names;
    }

    function getNames()
    {
        return $this -> names;
    }
}
?>