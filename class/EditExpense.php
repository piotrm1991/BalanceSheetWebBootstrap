<?php

class EditExpense
{
    private $dbo = null;
    private $fields = array();
    private $fieldsSelection = array();
    private $loggedId;
    private $categories;
    private $categoriesTranslated;
    private $payments;
    private $paymentsTranslated;
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
        $this -> categoriesTranslated = $expenseCategoryName -> getNamesTranslated();

        $paymentMethodName = new PaymentMethodsNames($this -> dbo, $this -> loggedId);
        $this -> payments = $paymentMethodName -> getNames();
        $this -> paymentsTranslated = $paymentMethodName -> getNamesTranslated();
    }

    function initFields()
    {
        $this -> fields['amount'] = new FormInputNumber('amount', 'Kwota', 'Kwota'); 
        $this -> fields['date'] = new FormInputDate('date', 'Data', ''); 
        $this -> fields['comment'] = new FormTextareaInput('comment', 'Komentarz (opcjonalnie)', '1', 'Komentarz');

        foreach ($this -> categories as $value) {
            foreach ($this -> categoriesTranslated as $description) {
                if ($value['id'] == $description['id']) {
                    $this -> fieldsSelection[$value['id']] = new FormInputSelectionOption('category', $value['name'], $description['name']);
                    break;
                }
            }
        }

        foreach ($this -> payments as $value) {
            foreach ($this -> paymentsTranslated as $description) {
                if ($value['id'] == $description['id']) {
                    $this -> fieldsSelection[$value['id']] = new FormInputSelectionOption('payment', $value['name'], $description['name']);
                    break;
                }
            }
        }
    }

    function showExpenseEditForm()
    {
        $inputFields = $this -> fields;
        $inputFieldsSelection = $this -> fieldsSelection;

        include 'templates/expenseEditForm.php'; 
    }

    function checkExpenseEditForm()
    {
        $this -> newExpense = new SingleExpense ($this -> dbo, $this -> loggedId, $_POST['id'], $this -> loggedId, $_POST['expense_category_assigned_to_user_id_old'], $_POST['payment_method_assigned_to_user_id_old'], $_POST['amount_old'], $_POST['date_old'], $_POST['comment_old']);

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
        if ($_POST['comment'] != '') {
            $this -> newExpense -> comment = filter_input(INPUT_POST, 'comment', 
                                             FILTER_SANITIZE_SPECIAL_CHARS);
        }
        $_SESSION['editedExpense'] = new SingleExpense($this -> dbo, $this -> loggedId, $this -> newExpense -> id, $this -> loggedId, $this -> newExpense -> expense_category_assigned_to_user_id, $this -> newExpense -> payment_method_assigned_to_user_id, $this -> newExpense -> amount, $this -> newExpense -> date, $this -> newExpense -> comment);

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