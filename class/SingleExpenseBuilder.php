<?php

class SingleExpenseBuilder
{
    public $dbo = null;
    public $loggedId;

    public $id;
    public $user_id;
    public $amount;
    public $date;
    public $comment;
    public $expense_category_assigned_to_user_id;
    public $payment_method_assigned_to_user_id;

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
    
    public function addExpenseCategoryId($expense_category_assigned_to_user_id)
    {
        $this -> expense_category_assigned_to_user_id = $expense_category_assigned_to_user_id;
        return $this;
    }
    
    public function addPaymentCategoryId($payment_method_assigned_to_user_id)
    {
        $this -> payment_method_assigned_to_user_id = $payment_method_assigned_to_user_id;
        return $this;
    }
    
    public function build()
    {
        return new SingleExpense($this);
    }
}
?>