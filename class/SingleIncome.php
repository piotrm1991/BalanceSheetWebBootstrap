<?php
class SingleIncome extends SingleEntry
{
    public $income_category_assigned_to_user_id;
    public $category;
    public $categoryTranslated;

    function __construct($dbo, $loggedId, $id='', $user_id, $income_category_assigned_to_user_id, $amount, $date, $comment)
    {
        $this -> dbo = $dbo;
        $this -> loggedId = $loggedId;

        $this -> id = $id;
        $this -> user_id = $user_id;
        $this -> income_category_assigned_to_user_id = $income_category_assigned_to_user_id;
        $this -> amount = $amount;
        $this -> date = $date;
        $this -> comment = $comment;
        $this -> assignCategory();
        $this -> assignCategoryTranslated();
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

    function assignCategoryTranslated()
    {
        $incomeCategoryNames = new IncomeCategoryNames($this -> dbo, $this -> loggedId);
        $categoryNames = $incomeCategoryNames -> getNamesTranslated();
        foreach ($categoryNames as $id) {
            if ($this -> income_category_assigned_to_user_id == $id['id']) {
                $this -> categoryTranslated = $id['name'];
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
            ".$this -> date."
            &nbsp;&nbsp;
            ".$this -> amount."&nbsp;zł
            &nbsp;&nbsp;
            ".$this -> categoryTranslated."
            <div style='float: right;'>
                <a data-toggle='modal' data-target='#editIncome' style='cursor: pointer;' data-date='".$this -> date."' data-amount='".$this -> amount."' data-category='".$this->categoryTranslated."' data-comment='".$this -> comment."' data-id='".$this -> id."' data-category-id='".$this->income_category_assigned_to_user_id."'><i class='glyphicon glyphicon-pencil'></i></a>
                &nbsp;&nbsp;
                <a data-toggle='modal' data-target='#deleteIncome' style='cursor: pointer;' data-date='".$this -> date."' data-amount='".$this->amount."' data-category='".$this -> categoryTranslated."' data-comment='".$this -> comment."' data-id='".$this -> id."' data-category-id='".$this -> income_category_assigned_to_user_id."'><i class='glyphicon glyphicon-trash'></i></a>
            </div>
            <br>
            <div style='padding-left: 20px;'>".$this->comment."</div>
        </section>	
        ";
    }

    function getBalanceHTML()
    {
        return "
        <section class='singleBalance'>
            <i class='glyphicon glyphicon-arrow-right'></i>
            &nbsp;&nbsp;
            ".$this -> date."
            &nbsp;&nbsp;
            ".$this -> amount."&nbsp;zł
            &nbsp;&nbsp;
            <div style='float: right;'>
                <a data-toggle='modal' data-target='#editIncome' style='cursor: pointer;' data-date='".$this -> date."' data-amount='".$this -> amount."' data-category='".$this -> categoryTranslated."' data-comment='".$this -> comment."' data-id='".$this -> id."' data-category-id='".$this -> income_category_assigned_to_user_id."'><i class='glyphicon glyphicon-pencil'></i></a>
                &nbsp;&nbsp;
                <a data-toggle='modal' data-target='#deleteIncome' style='cursor: pointer;' data-date='".$this -> date."' data-amount='".$this -> amount."' data-category='".$this -> categoryTranslated."' data-comment='".$this -> comment."' data-id='".$this -> id."' data-category-id='".$this -> income_category_assigned_to_user_id."'><i class='glyphicon glyphicon-trash'></i></a>
            </div>
            <br>
            <div style='padding-left: 23px;'>".$this->comment."</div>
        </section>
        ";
    }
}
?>