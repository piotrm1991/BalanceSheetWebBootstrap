<?php

class CategoryIncome extends Category
{
    function __construct($dbo, $loggedId, $id, $sum)
    {
        $this -> dbo = $dbo;
        $this -> loggedId = $loggedId;
        $this -> id = $id;
        $this -> sum = $sum;
        $this -> getName();
    }

    function getName()
    {
        $incomeCategoryNames = new IncomeCategoryNames($this -> dbo, $this -> loggedId);
        $categoryNames = $incomeCategoryNames->getNames();
        foreach ($categoryNames as $id) {
            if ($this -> id == $id['id']) {
                $this -> name = $id['name'];
                break;		
            }
        }
    }

    function getBalanceHTML()
    {
        echo 
        "
        <div class='singleCategory' >
            <strong>$this->name</strong>
            <div style='float: right;'>$this->sum&nbsp;zł</div>
        </div>
        ";
    }
}
?>