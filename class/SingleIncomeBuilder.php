<?php

class SingleIncomeBuilder
{
    public $dbo = null;
    public $loggedId;

    public $id;
    public $user_id;
    public $amount;
    public $date;
    public $comment;
    public $income_category_assigned_to_user_id;

    public function __construct($dbo, $loggedId)
    {
        $this -> dbo = $dbo;
        $this -> loggedId = $loggedId;
    }

    public function addId($id)
    {
        $this -> id = $id;
        return $this;
    }
    
    public function addUserId($user_id)
    {
        $this -> user_id = $user_id;
        return $this;
    }
    
    public function addAmount($amount)
    {
        $this -> amount = $amount;
        return $this;
    }
    
    public function addDate($date)
    {
        $this -> date = $date;
        return $this;
    }
    
    public function addComment($comment)
    {
        $this -> comment = $comment;
        return $this;
    }
    
    public function addIncomeCategoryId($income_category_assigned_to_user_id)
    {
        $this -> income_category_assigned_to_user_id = $income_category_assigned_to_user_id;
        return $this;
    }
    
    public function build()
    {
        return new SingleIncome($this);
    }
}
?>