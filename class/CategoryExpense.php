<?php
class CategoryExpense extends Category
{
    function __construct($dbo, $loggedId, $id, $sum)
    {
        $this -> dbo = $dbo;
        $this -> loggedId = $loggedId;
        $this -> id = $id;
        $this -> sum = $sum;
        $this -> getName();
        $this -> getNameTranslated();
    }

    function getNameTranslated()
    {
        $expenseCategoryNames = new ExpenseCategoryNames($this -> dbo, $this -> loggedId);
        $categoryNames = $expenseCategoryNames -> getNamesTranslated();
        foreach ($categoryNames as $id) {
            if ($this -> id == $id['id']) {
                $this -> nameTranslated = $id['name'];
                break;		
            }
        }
    }

    function getName()
    {
        $expenseCategoryNames = new ExpenseCategoryNames($this -> dbo, $this -> loggedId);
        $categoryNames = $expenseCategoryNames -> getNames();
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
            <strong>$this->nameTranslated</strong>
            <div style='float: right;'>$this->sum&nbsp;zł</div>	
        </div>
        ";
    }
}
?>