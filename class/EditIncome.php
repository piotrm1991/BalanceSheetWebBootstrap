<?php
class EditIncome
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
        $this -> fields['date'] = new FormInputDate('date', 'Data:', ''); 
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

    function showIncomeEditForm()
    {
        $inputFields = $this -> fields;
        $inputFieldsSelection = $this -> fieldsSelection;

        include 'templates/incomeEditForm.php'; 
    }

    function checkIncomeEditForm()
    {
        $this -> newIncome = new SingleIncome ($this -> dbo, $this -> loggedId, $_POST['id'], $this -> loggedId, $_POST['income_category_assigned_to_user_id_old'], $_POST['amount_old'], $_POST['date_old'], $_POST['comment_old']);

        if (!isset($_POST['category']) && $_POST['amount'] <= 0 && $_POST['date'] == null && $_POST['comment'] == '') {
            return FORM_DATA_MISSING;
        }
        if (isset($_POST['category'])) {
            foreach ($this -> categories as $name) {
                if ($_POST['category'] == $name['name']) {
                    $this -> newIncome -> income_category_assigned_to_user_id = $name['id'];
                }
            }
        }
        if ($_POST['amount'] < 0) {
            return ACTION_FAILED;
        }
        if ($_POST['amount'] > 0) {
            $this -> newIncome -> amount = $_POST['amount'];
        }
        if ($_POST['date'] != null) {
            $this -> newIncome -> date = $_POST['date'];
        }
        if ($_POST['comment'] != '') {
            $this -> newIncome -> comment = filter_input(INPUT_POST, 'comment', 
                                            FILTER_SANITIZE_SPECIAL_CHARS);
        }
        $_SESSION['editedIncome'] = new SingleIncome($this -> dbo, $this -> loggedId, $this -> newIncome -> id, $this -> loggedId, $this -> newIncome -> income_category_assigned_to_user_id, $this -> newIncome -> amount, $this -> newIncome -> date, $this -> newIncome -> comment);

        return ACTION_OK;
    }

    function saveEditedIncome()
    {
        $this -> newIncome = $_SESSION['editedIncome'];
        unset($_SESSION['editedIncome']);

        $saveEditedQuery = $this -> dbo -> prepareSaveEditedIncome($this -> newIncome -> id, $this -> newIncome -> income_category_assigned_to_user_id, $this -> newIncome -> amount, $this -> newIncome -> date, $this -> newIncome -> comment);

        if ($saveEditedQuery -> execute()) {
            return ACTION_OK;
        } else {
            return ACTION_FAILED;
        }
    }
}
?>