<?php
class SingleIncome extends SingleEntry
{
    public $income_category_assigned_to_user_id;

    function __construct($singleIncomeBuilder)
    {
        $this -> dbo = $singleIncomeBuilder -> dbo;
        $this -> loggedId = $singleIncomeBuilder -> loggedId;

        $this -> id = $singleIncomeBuilder -> id;
        $this -> user_id = $singleIncomeBuilder -> user_id;
        $this -> income_category_assigned_to_user_id = $singleIncomeBuilder -> income_category_assigned_to_user_id;
        $this -> amount = $singleIncomeBuilder -> amount;
        $this -> date = $singleIncomeBuilder -> date;
        $this -> comment = $singleIncomeBuilder -> comment;
        $this -> assignCategory();
    }

    function assignCategory()
    {
        $incomeCategoryNames = new IncomeCategoryNames($this -> dbo, $this -> loggedId);
        $categoryNames = $incomeCategoryNames -> getNames();
        foreach ($categoryNames as $id) {
            if ($this -> income_category_assigned_to_user_id == $id['id']) {
                $this -> category = $id['name'];
                break;		
            }
        }
    }

    function deleteIncome()
    {
        $deleteIncomeQuery = $this -> dbo -> prepreDeleteIncomeQuery($this -> id);
        if ($deleteIncomeQuery -> execute()) {
            return ACTION_OK;
        } else {
            return SERVER_ERROR;
        }
    }

    function getStartHTML()
    {
        echo 
        "
        <section class='singleEntry'>
            <i class='glyphicon glyphicon-arrow-right'></i>
            &nbsp;&nbsp;
            " . $this -> date . "
            &nbsp;&nbsp;
            " . $this -> amount . "&nbsp;zł
            &nbsp;&nbsp;
            " . $this -> category . "
            <div style='float: right;'>
                <a data-toggle='modal' data-target='#editIncome' style='cursor: pointer;' data-date='" . $this -> date . "' data-amount='" . $this -> amount . "' data-category='".$this -> category . "' data-comment='" . $this -> comment . "' data-id='" . $this -> id . "' data-category-id='" . $this -> income_category_assigned_to_user_id . "'><i class='glyphicon glyphicon-pencil'></i></a>
                &nbsp;&nbsp;
                <a data-toggle='modal' data-target='#deleteIncome' style='cursor: pointer;' data-date='" . $this -> date . "' data-amount='".$this -> amount."' data-category='".$this -> category . "' data-comment='" . $this -> comment . "' data-id='".$this -> id . "' data-category-id='" . $this -> income_category_assigned_to_user_id . "'><i class='glyphicon glyphicon-trash'></i></a>
            </div>
            <br>
            <div style='padding-left: 24px;'>" . $this->comment . "</div>
        </section>	
        ";
    }

    function getBalanceHTML()
    {
        return "
        <section class='singleBalance'>
            <i class='glyphicon glyphicon-arrow-right'></i>
            &nbsp;&nbsp;
            " . $this -> date . "
            &nbsp;&nbsp;
            " . $this -> amount . "&nbsp;zł
            &nbsp;&nbsp;
            <div style='float: right;'>
                <a data-toggle='modal' data-target='#editIncome' style='cursor: pointer;' data-date='" . $this -> date . "' data-amount='" . $this -> amount . "' data-category='" . $this -> category . "' data-comment='" . $this -> comment . "' data-id='" . $this -> id . "' data-category-id='" . $this -> income_category_assigned_to_user_id . "'><i class='glyphicon glyphicon-pencil'></i></a>
                &nbsp;&nbsp;
                <a data-toggle='modal' data-target='#deleteIncome' style='cursor: pointer;' data-date='" . $this -> date . "' data-amount='" . $this -> amount . "' data-category='".$this -> category . "' data-comment='" . $this -> comment . "' data-id='" . $this -> id . "' data-category-id='" . $this -> income_category_assigned_to_user_id . "'><i class='glyphicon glyphicon-trash'></i></a>
            </div>
            <br>
            <div style='padding-left: 24px;'>" . $this -> comment . "</div>
        </section>
        ";
    }
}
?>