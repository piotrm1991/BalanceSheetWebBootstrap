<?php
class AddExpense
{
    private $dbo = null;
    private $fields = array();
    private $fieldsSelectionCategories = array();
    private $fieldsSelectionPayment = array();
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
        $this -> fields['date'] = new FormInputDate('date', 'Data', 'datePickerExpense'); 
        $this -> fields['comment'] = new FormTextareaInput('comment', 'Komentarz (opcjonalnie)', '1', 'Komentarz');

        foreach ($this -> categories as $value) {
            foreach ($this -> categoriesTranslated as $description) {
                if ($value['id'] == $description['id']) {
                    $this -> fieldsSelectionCategories[$value['id']] = new FormInputSelectionOption('category', $value['name'], $description['name']);
                    break;
                }
            }
        }

        foreach ($this -> payments as $value) {
            foreach ($this -> paymentsTranslated as $description) {
                if ($value['id'] == $description['id']) {
                    $this -> fieldsSelectionPayment[$value['id']] = new FormInputSelectionOption('payment', $value['name'], $description['name']);
                    break;
                }
            }
        }
    }

    function showExpenseForm()
    {
        $inputFields = $this -> fields;
        $fieldsSelectionPayment = $this -> fieldsSelectionPayment;
        $fieldsSelectionCategories = $this -> fieldsSelectionCategories;

        include 'templates/expenseForm.php'; 
    }

    function checkExpenseForm()
    {
        foreach ($this -> fields as $name => $val) {
            if (!isset($_POST[$name])) {
                return FORM_DATA_MISSING;
            }
        }
        
        if ($_POST['amount'] <= 0) {
            return FORM_DATA_MISSING;
        }
        
        if (!isset($_POST['category'])) {
            return FORM_DATA_MISSING;
        }
        
        if ($_POST['category'] == '') {
            return FORM_DATA_MISSING;
        }
        
        if (!isset($_POST['payment'])) {
            return FORM_DATA_MISSING;
        }
        
        if ($_POST['category'] == '') {
            return FORM_DATA_MISSING;
        }
        
        $comment = '';
        
        if (isset($_POST['comment'])) {
            $comment = filter_input(INPUT_POST, 'comment', 
                       FILTER_SANITIZE_SPECIAL_CHARS);
        }
        $amount = $_POST['amount'];
        $date = $_POST['date'];
        $category = $_POST['category'];
        $payment = $_POST['payment'];
        $categoryId;
        
        foreach ($this -> categories as $name) {
            if ($category == $name['name']) {
                $categoryId = $name['id'];
            }
        }
        
        $paymentId;
        foreach ($this -> payments as $name) {
            if ($payment == $name['name']) {
                $paymentId = $name['id'];
            }
        }
        $_SESSION['newExpense'] = new SingleExpense($this -> dbo, $this -> loggedId, '', $this -> loggedId, $categoryId, $paymentId, $amount, $date, $comment);

        return ACTION_OK;
    }

    function saveExpense()
    {
        $this -> newExpense = $_SESSION['newExpense'];
        unset($_SESSION['newExpense']);

        $saveExpenseQuery = $this -> dbo -> prepareSaveExpenseQuery($this -> newExpense->loggedId, $this -> newExpense -> expense_category_assigned_to_user_id, $this -> newExpense -> payment_method_assigned_to_user_id, $this -> newExpense -> amount, $this -> newExpense -> date, $this -> newExpense -> comment);

        if ($this -> dbo -> executeSaveExpenseQuery($saveExpenseQuery)) {
            return ACTION_OK;
        } else {
            return ACTION_FAILED;
        }
    }
}