<?php
class EditIncome
{
    private $dbo = null;
    private $fields = array();
    private $fieldsSelection = array();
    private $loggedId;
    private $categories;
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
    }

    function initFields()
    {
        $this -> fields['amount'] = new FormInputNumber('amount', 'Kwota:', 'Kwota'); 
        $this -> fields['date'] = new FormInputDate('date', 'Data:', ''); 
        $this -> fields['comment'] = new FormTextareaInput('comment', 'Komentarz (opcjonalnie)', '1', 'Komentarz');

        foreach ($this -> categories as $value) {
            $this -> fieldsSelection[$value['id']] = new FormInputSelectionOption('category', $value['name'], $value['name']);
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
        $this -> newIncome = (new SingleIncomeBuilder($this -> dbo, $this -> loggedId))
                                            -> addId($_POST['id'])
                                            -> addUserId($this -> loggedId)
                                            -> addAmount($_POST['amount_old'])
                                            -> addDate($_POST['date_old'])
                                            -> addComment($_POST['comment_old'])
                                            -> addIncomeCategoryId($_POST['income_category_assigned_to_user_id_old'])
                                            -> build();

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
        
        $this -> newIncome -> comment = $comment;
        $_SESSION['editedIncome'] = (new SingleIncomeBuilder($this -> dbo, $this -> loggedId))
                                            -> addId($this -> newIncome -> id)
                                            -> addUserId($this -> loggedId)
                                            -> addAmount($this -> newIncome -> amount)
                                            -> addDate($this -> newIncome -> date)
                                            -> addComment($this -> newIncome -> comment)
                                            -> addIncomeCategoryId($this -> newIncome -> income_category_assigned_to_user_id)
                                            -> build();

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