<?php

class AddIncome
{
    private $dbo = null;
    private $fields = array();
    private $fieldsSelection = array();
    private $loggedId;
    private $categories;
    private $categoriesTranslated;
    private $newIncome;
    
    function __construct($dbo, $loggedId)
    {
        $this -> dbo = $dbo;
        $this -> loggedId = $loggedId;
        $this -> getCategories();
        $this -> initFields();
    }
    
    function getCategories()
    {
        $incomeCategoryName = new IncomeCategoryNames($this -> dbo, $this -> loggedId);
        $this -> categories = $incomeCategoryName -> getNames();
        $this -> categoriesTranslated = $incomeCategoryName -> getNamesTranslated();
    }
    
    function initFields()
    {
        $this -> fields['amount'] = new FormInputNumber('amount', 'Kwota:', 'Kwota'); 
        $this -> fields['date'] = new FormInputDate('date', 'Data:', 'datePickerIncome'); 
        $this -> fields['comment'] = new FormTextareaInput('comment', 'Komentarz (opcjonalnie)', '1', 'Komentarz');

        foreach ($this -> categories as $value) {
            foreach ($this -> categoriesTranslated as $description) {
                if ($value['id'] == $description['id']) {
                    $this -> fieldsSelection[$value['id']] = new FormInputSelectionOption('category', $value['name'], $description['name']);
                    break;
                }
            }
        }
    }
    
    function showIncomeForm()
    {
        $inputFields = $this -> fields;
        $inputFieldsSelection = $this -> fieldsSelection;

        include 'templates/incomeForm.php'; 
    }
    
    function checkIncomeForm()
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
        $comment = '';
        if (isset($_POST['comment'])) {
            $comment = filter_input(INPUT_POST, 'comment', 
                       FILTER_SANITIZE_SPECIAL_CHARS);
        }
        $comment = ltrim($comment);
		$comment = rtrim($comment);
        
        if (strlen($comment) > 45) {
            return WRONG_LENGTH;
        }
        
        $amount = $_POST['amount'];
        $date = $_POST['date'];
        $category = $_POST['category'];
        $categoryId;
        foreach ($this -> categories as $name) {
            if ($category == $name['name']) {
                $categoryId = $name['id'];
            }
        }
        $_SESSION['newIncome'] = new SingleIncome($this -> dbo, $this -> loggedId, '', $this -> loggedId, $categoryId, $amount, $date, $comment);

        return ACTION_OK;
    }
    
    function saveIncome()
    {
        $this -> newIncome = $_SESSION['newIncome'];
        unset($_SESSION['newIncome']);

        $saveIncomeQuery = $this -> dbo -> prepareSaveIncomeQuery($this -> newIncome -> loggedId, $this -> newIncome -> income_category_assigned_to_user_id, $this -> newIncome -> amount, $this -> newIncome -> date, $this -> newIncome -> comment);

        if ($this -> dbo -> executeSaveIncomeQuery($saveIncomeQuery)) {
            return ACTION_OK;
        } else {
            return ACTION_FAILED;
        }
    }
}
?>