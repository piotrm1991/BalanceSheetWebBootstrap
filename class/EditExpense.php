<?php

class EditExpense
{
    private $dbo = null;
    private $fields = array();
    private $fieldsSelectionPayment = array();
    private $fieldsSelectionCategory = array();
    private $loggedId;
    private $categories;
    private $payments;
    private $newExpense;

    function __construct($dbo, $loggedId)
    {
        $this -> dbo = $dbo;
        $this -> loggedId = $loggedId;
        $this -> getCategoriesAndPayments();
        $this -> initFields();
    }

    function getCategoriesAndPayments()
    {
        $expenseCategoryName = new ExpenseCategoryNames($this -> dbo, $this -> loggedId);
        $this -> categories = $expenseCategoryName -> getNames();

        $paymentMethodName = new PaymentMethodsNames($this -> dbo, $this -> loggedId);
        $this -> payments = $paymentMethodName -> getNames();
    }

    function initFields()
    {
        $this -> fields['amount'] = new FormInputNumber('amount', 'Kwota', 'Kwota'); 
        $this -> fields['date'] = new FormInputDate('date', 'Data', ''); 
        $this -> fields['comment'] = new FormTextareaInput('comment', 'Komentarz (opcjonalnie)', '1', 'Komentarz');

        foreach ($this -> categories as $value) {
            $this -> fieldsSelectionCategory[$value['id']] = new FormInputSelectionOption('category', $value['name'], $value['name']);
        }

        foreach ($this -> payments as $value) {
            $this -> fieldsSelectionPayment[$value['id']] = new FormInputSelectionOption('payment', $value['name'], $value['name']);
        }
    }

    function showExpenseEditForm()
    {
        $inputFields = $this -> fields;
        $inputFieldsSelectionCategory = $this -> fieldsSelectionCategory;
        $inputFieldsSelectionPayment = $this -> fieldsSelectionPayment;

        include 'templates/expenseEditForm.php'; 
    }

    function checkExpenseEditForm()
    {
        $this -> newExpense = (new SingleExpenseBuilder($this -> dbo, $this -> loggedId))
                                -> addId($_POST['id'])
                                -> addUserId($this -> loggedId)
                                -> addAmount($_POST['amount_old'])
                                -> addDate($_POST['date_old'])
                                -> addComment($_POST['comment_old'])
                                -> addExpenseCategoryId($_POST['expense_category_assigned_to_user_id_old'])
                                -> addPaymentCategoryId($_POST['payment_method_assigned_to_user_id_old'])
                                -> build();

        if (!isset($_POST['category']) && $_POST['amount'] <= 0 && $_POST['date'] == null && $_POST['comment'] == '' && !isset($_POST['payment'])) {
            return FORM_DATA_MISSING;
        }
        if (isset($_POST['category'])) {
            foreach ($this -> categories as $name) {
                if ($_POST['category'] == $name['name']) {
                    $this -> newExpense -> expense_category_assigned_to_user_id = $name['id'];
                }
            }
        }
        
        if (isset($_POST['payment'])) {
            foreach ($this -> payments as $name) {
                if ($_POST['payment'] == $name['name']) {
                    $this -> newExpense -> payment_method_assigned_to_user_id = $name['id'];
                }
            }
        }
        
        if ($_POST['amount'] < 0) {
            return ACTION_FAILED;
        }
        if ($_POST['amount'] > 0) {
            $this -> newExpense -> amount = $_POST['amount'];
        }
        if ($_POST['date'] != null) {
            $this -> newExpense -> date = $_POST['date'];
        }
        $comment;
        if ($_POST['comment'] != '') {
            $comment = filter_input(INPUT_POST, 'comment', 
                       FILTER_SANITIZE_SPECIAL_CHARS);
        }
        $comment = ltrim($comment);
		$comment = rtrim($comment);
        
        if (strlen($comment) > 45) {
            return WRONG_LENGTH;
        }
        
        $this -> newExpense -> comment = $comment;
        $_SESSION['editedExpense'] = (new SingleExpenseBuilder($this -> dbo, $this -> loggedId))
                                        -> addId($this -> newExpense -> id)
                                        -> addUserId($this -> loggedId)
                                        -> addAmount($this -> newExpense -> amount)
                                        -> addDate($this -> newExpense -> date)
                                        -> addComment($this -> newExpense -> comment)
                                        -> addExpenseCategoryId($this -> newExpense -> expense_category_assigned_to_user_id)
                                        -> addPaymentCategoryId($this -> newExpense -> payment_method_assigned_to_user_id)
                                        -> build();

        return ACTION_OK;
    }

    function saveEditedExpense()
    {
        $this -> newExpense = $_SESSION['editedExpense'];
        unset($_SESSION['editedExpense']);

        $saveEditedQuery = $this -> dbo -> prepareSaveEditedExpense($this -> newExpense -> id, $this -> newExpense -> expense_category_assigned_to_user_id, $this -> newExpense -> payment_method_assigned_to_user_id, $this -> newExpense -> amount, $this -> newExpense -> date, $this -> newExpense -> comment);

        if ($saveEditedQuery -> execute()) {
            return ACTION_OK;
        } else {
            return ACTION_FAILED;
        }
    }
}
?>