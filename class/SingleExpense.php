<?php
class SingleExpense extends SingleEntry
{
    public $expense_category_assigned_to_user_id;
    public $payment_method_assigned_to_user_id;
    public $category;
    public $payment;
    public $categoryTranslated;
    public $paymentTranslated;

    function __construct($dbo, $loggedId, $id='', $user_id, $expense_category_assigned_to_user_id, $payment_method_assigned_to_user_id, $amount, $date, $comment)
    {
        $this -> dbo = $dbo;
        $this -> loggedId = $loggedId;

        $this -> id = $id;
        $this -> user_id = $user_id;
        $this -> expense_category_assigned_to_user_id = $expense_category_assigned_to_user_id;
        $this -> payment_method_assigned_to_user_id = $payment_method_assigned_to_user_id;
        $this -> amount = $amount;
        $this -> date = $date;
        $this -> comment = $comment;
        $this -> assignCategory();
        $this -> assignPaymentMethod();
        $this -> assignCategoryTranslated();
        $this -> assignPaymentMethodTranslated();
    }
    
    function assignCategory()
    {
        $expenseCategoryNames = new ExpenseCategoryNames($this -> dbo, $this -> loggedId);
        $categoryNames = $expenseCategoryNames -> getNames();
        foreach ($categoryNames as $id) {
            if ($this -> expense_category_assigned_to_user_id == $id['id']) {
                $this -> category = $id['name'];
                break;		
            }
        }
    }
    
    function assignPaymentMethod()
    {
        $paymentMethodsNames = new PaymentMethodsNames($this -> dbo, $this -> loggedId);
        $paymentNames = $paymentMethodsNames -> getNames();
        foreach ($paymentNames as $id) {
            if ($this -> payment_method_assigned_to_user_id == $id['id']) {
                $this -> payment = $id['name'];  
                break;
            }
        }
    }
    
    function assignCategoryTranslated()
    {
        $expenseCategoryNames = new ExpenseCategoryNames($this -> dbo, $this -> loggedId);
        $categoryNames = $expenseCategoryNames -> getNamesTranslated();
        foreach ($categoryNames as $id) {
            if ($this -> expense_category_assigned_to_user_id == $id['id']) {
                $this -> categoryTranslated = $id['name'];
                break;		
            }
        }
    }
    
    function assignPaymentMethodTranslated()
    {
        $paymentMethodsNames = new PaymentMethodsNames($this -> dbo, $this -> loggedId);
        $paymentNames = $paymentMethodsNames -> getNamesTranslated();
        foreach ($paymentNames as $id) {
            if ($this -> payment_method_assigned_to_user_id == $id['id']) {
                $this -> paymentTranslated = $id['name'];  
                break;
            }
        }
    }
    
    function deleteExpense()
    {
        $deleteExpenseQuery = $this -> dbo -> prepreExpenseIncomeQuery($this -> id);
        if ($deleteExpenseQuery -> execute()) {
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
            <i class='glyphicon glyphicon-arrow-right'></i>&nbsp;&nbsp;".$this->date."
            ".$this->amount."&nbsp;zł
            &nbsp;&nbsp;
            ".$this->categoryTranslated."
            &nbsp;&nbsp;
            ".$this->paymentTranslated."
            &nbsp;&nbsp;
            ".$this->comment."
            &nbsp;&nbsp;
            <a data-toggle='modal' data-target='#editExpense' style='cursor: pointer;' data-date='".$this->date."' data-amount='".$this->amount."' data-category='".$this->categoryTranslated."' data-payment='".$this->paymentTranslated."' data-comment='".$this->comment."' data-id='".$this->id."' data-category-id='".$this->expense_category_assigned_to_user_id."' data-payment-id='".$this->payment_method_assigned_to_user_id."'><i class='glyphicon glyphicon-pencil'></i></a>
            &nbsp;&nbsp;
            <a data-toggle='modal' data-target='#deleteExpense' style='cursor: pointer;' data-date='".$this->date."' data-amount='".$this->amount."' data-category='".$this->categoryTranslated."' data-payment='".$this->paymentTranslated."' data-comment='".$this->comment."' data-id='".$this->id."' data-category-id='".$this->expense_category_assigned_to_user_id."' data-payment-id='".$this->payment_method_assigned_to_user_id."'><i class='glyphicon glyphicon-trash'></i></a>
        </section>	
        ";
    }
  
    function getBalanceHTML()
    {
        return 
        "
        <section class='singleBalance' >
            <i class='glyphicon glyphicon-arrow-right'></i>&nbsp;&nbsp;".$this->date."
            ".$this->amount."&nbsp;zł
            &nbsp;&nbsp;
            ".$this->paymentTranslated."
            &nbsp;&nbsp;
            ".$this->comment."
            &nbsp;&nbsp;
            <a data-toggle='modal' data-target='#editExpense' style='cursor: pointer;' data-date='".$this->date."' data-amount='".$this->amount."' data-category='".$this->categoryTranslated."' data-payment='".$this->paymentTranslated."' data-comment='".$this->comment."' data-id='".$this->id."' data-category-id='".$this->expense_category_assigned_to_user_id."' data-payment-id='".$this->payment_method_assigned_to_user_id."'><i class='glyphicon glyphicon-pencil'></i></a>
            &nbsp;&nbsp;
            <a data-toggle='modal' data-target='#deleteExpense' style='cursor: pointer;' data-date='".$this->date."' data-amount='".$this->amount."' data-category='".$this->categoryTranslated."' data-payment='".$this->paymentTranslated."' data-comment='".$this->comment."' data-id='".$this->id."' data-category-id='".$this->expense_category_assigned_to_user_id."' data-payment-id='".$this->payment_method_assigned_to_user_id."'><i class='glyphicon glyphicon-trash'></i></a>
        </section>
        ";
    }
}
?>	

