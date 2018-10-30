<?php

class Settings
{
    private $userLoggedIn;
    private $dbo;

    private $categoriesIncomeNames;
    private $categoriesIncomeNamesTranslated;
    private $fieldsIncome = array();

    private $categoriesExpenseNames;
    private $categoriesExpenseNamesTranslated;
    private $fieldsExpense = array();

    private $paymentsNames;
    private $paymentsNamesTranslated;
    private $fieldsPayment = array();

    private $newCategoryName = array();
	private $newUsername;
	private $newPassword;

    function __construct($dbo, $userLoggedIn)
    {
        $this -> dbo = $dbo;
        $this -> userLoggedIn = $userLoggedIn;
        $this -> getCategoriesAndPayments();
        $this -> initFields();
    }
	
    function getCategoriesAndPayments()
    {
        $expenseCategoryName = new ExpenseCategoryNames($this -> dbo, $this -> userLoggedIn -> id);
        $this -> categoriesExpenseNames = $expenseCategoryName -> getNames();
        $this -> categoriesExpenseNamesTranslated = $expenseCategoryName -> getNamesTranslated();

        $paymentMethodName = new PaymentMethodsNames($this -> dbo, $this -> userLoggedIn -> id);
        $this -> paymentsNames = $paymentMethodName -> getNames();
        $this -> paymentsNamesTranslated = $paymentMethodName -> getNamesTranslated();

        $incomeCategoryName = new IncomeCategoryNames($this -> dbo, $this -> userLoggedIn -> id);
        $this -> categoriesIncomeNames = $incomeCategoryName -> getNames();
        $this -> categoriesIncomeNamesTranslated = $incomeCategoryName -> getNamesTranslated();
    }
	
    function initFields()
    {
        foreach ($this -> categoriesExpenseNames as $value) {
            foreach ($this -> categoriesExpenseNamesTranslated as $description) {
                if ($value['id'] == $description['id']) {
                    $this -> fieldsExpense[$value['id']] = new FormInputSelectionOption('category', $value['name'], $description['name']);
                }
            }
        }
		
        foreach ($this -> paymentsNames as $value) {
            foreach ($this -> paymentsNamesTranslated as $description) {
                if ($value['id'] == $description['id']) {
                    $this -> fieldsPayment[$value['id']] = new FormInputSelectionOption('payment', $value['name'], $description['name']);
                    break;
                }
            }
        }
        
        foreach ($this -> categoriesIncomeNames as $value) {
            foreach ($this -> categoriesIncomeNamesTranslated as $description) {
                if ($value['id'] == $description['id']) {
                    $this -> fieldsIncome[$value['id']] = new FormInputSelectionOption('category', $value['name'], $description['name']);
                    break;
                }
            }
        }
    }
	
    function showEditCategoryForms()
    {
        $inputExpenseFields = $this -> fieldsExpense;
        $inputIncomeFields = $this -> fieldsIncome;
        $inputPaymentFields = $this -> fieldsPayment;

        include 'templates/editCategoryForms.php';
    }
	
    function showDeleteCategoryForms()
    {
        $inputExpenseFields = $this -> fieldsExpense;
        $inputIncomeFields = $this -> fieldsIncome;
        $inputPaymentFields = $this -> fieldsPayment;

        include 'templates/deleteCategoriedForm.php';
    }
	
    function checkExpenseCategoryEditForm()
    {
        if ($_POST['newCategoryName'] == null) {
            return FORM_DATA_MISSING;
        }

        $newCategoryName = filter_input(INPUT_POST, 'newCategoryName', 
                           FILTER_SANITIZE_SPECIAL_CHARS);
        $newCategoryName = ltrim($newCategoryName);
		$newCategoryName = rtrim($newCategoryName);
        
        if ($newCategoryName == '') {
            return FORM_DATA_MISSING;
        }
        
        if (strlen($newCategoryName)<3 || strlen($newCategoryName)>20) {
            return WRONG_LENGTH;
        }
        
        if ($_POST['category'] == null) {
            return ACTION_FAILED;
        }
        
        foreach ($this -> categoriesExpenseNamesTranslated as $category) {
            if (strtolower($category['name']) == strtolower($newCategoryName)) {
                return ALREADY_EXISTS;
            }
        }
        
        $this -> newCategoryName['name'] = $newCategoryName;
        foreach ($this -> categoriesExpenseNames as $category) {
            if ($category['name'] == $_POST['category']) {
                $this -> newCategoryName['id'] = $category['id'];
            }
        }
        $_SESSION['newCategoryName'] = $this -> newCategoryName;
        return ACTION_OK;
    }
	
    function saveEditedExpenseCategory()
    {
        $this -> newCategoryName = $_SESSION['newCategoryName'];
        unset($_SESSION['newCategoryName']);

        $saveEditedCategoryQuery = $this -> dbo -> prepareSaveEditedExpenseCategory($this -> newCategoryName['id'], $this -> newCategoryName['name']);
        if ($saveEditedCategoryQuery -> execute()) {
            return ACTION_OK;
        } else {
            return ACTION_FAILED;
        }
    }
	
    function checkIncomeCategoryEditForm()
    {
        if ($_POST['newCategoryName'] == null) {
            return FORM_DATA_MISSING;
        }

        $newCategoryName = filter_input(INPUT_POST, 'newCategoryName', 
                           FILTER_SANITIZE_SPECIAL_CHARS);
        $newCategoryName = ltrim($newCategoryName);
		$newCategoryName = rtrim($newCategoryName);
        
        if ($newCategoryName == '') {
            return FORM_DATA_MISSING;
        }
        
        if (strlen($newCategoryName)<3 || strlen($newCategoryName)>20) {
            return WRONG_LENGTH;
        }
        
        if ($_POST['category'] == null) {
            return ACTION_FAILED;
        }
        
        foreach ($this -> categoriesIncomeNamesTranslated as $category) {
            if (strtolower($category['name']) == strtolower($newCategoryName)) {
                return ALREADY_EXISTS;
            }
        }
        
        $this -> newCategoryName['name'] = $newCategoryName;
        foreach ($this -> categoriesIncomeNames as $category) {
            if ($category['name'] == $_POST['category']) {
                $this -> newCategoryName['id'] = $category['id'];
            }
        }
        
        $_SESSION['newCategoryName'] = $this -> newCategoryName;
        return ACTION_OK;
    }
	
    function saveEditedIncomeCategory()
    {
        $this -> newCategoryName = $_SESSION['newCategoryName'];
        unset($_SESSION['newCategoryName']);

        $saveEditedCategoryQuery = $this -> dbo -> prepareSaveEditedIncomeCategory($this -> newCategoryName['id'], $this -> newCategoryName['name']);
        if ($saveEditedCategoryQuery -> execute()) {
            return ACTION_OK;
        } else {
            return ACTION_FAILED;
        }
    }

    function checkPaymentCategoryEditForm()
    {
        if ($_POST['newCategoryName'] == null) {
            return FORM_DATA_MISSING;
        }

        $newCategoryName = filter_input(INPUT_POST, 'newCategoryName', 
                           FILTER_SANITIZE_SPECIAL_CHARS);
        $newCategoryName = ltrim($newCategoryName);
		$newCategoryName = rtrim($newCategoryName);
        
        if ($newCategoryName == '') {
            return FORM_DATA_MISSING;
        }
        
        if (strlen($newCategoryName)<3 || strlen($newCategoryName)>20) {
            return WRONG_LENGTH;
        }
        
        if ($_POST['category'] == null) {
            return ACTION_FAILED;
        }
        
        foreach ($this -> paymentsNamesTranslated as $category) {
            if (strtolower($category['name']) == strtolower($newCategoryName)) {
                return ALREADY_EXISTS;
            }
        }
        
        $this -> newCategoryName['name'] = $newCategoryName;
        foreach ($this -> paymentsNames as $category) {
            if ($category['name'] == $_POST['category']) {
                $this -> newCategoryName['id'] = $category['id'];
            }
        }
        
        $_SESSION['newCategoryName'] = $this -> newCategoryName;
        return ACTION_OK;
    }

    function saveEditedPaymentCategory()
    {
        $this -> newCategoryName = $_SESSION['newCategoryName'];
        unset($_SESSION['newCategoryName']);

        $saveEditedCategoryQuery = $this -> dbo -> prepareSaveEditedPaymentCategory($this -> newCategoryName['id'], $this -> newCategoryName['name']);
        if($saveEditedCategoryQuery -> execute()){
            return ACTION_OK;
        } else {
            return ACTION_FAILED;
        }
    }
	
	function checkNewExpenseCategoryForm()
    {
        if ($_POST['newCategoryName'] == null) {
            return FORM_DATA_MISSING;
        }

        $newCategoryName = filter_input(INPUT_POST, 'newCategoryName', 
                           FILTER_SANITIZE_SPECIAL_CHARS);
        $newCategoryName = ltrim($newCategoryName);
		$newCategoryName = rtrim($newCategoryName);
        
        if ($newCategoryName == '') {
            return FORM_DATA_MISSING;
        }
        
        if (strlen($newCategoryName)<3 || strlen($newCategoryName)>20) {
            return WRONG_LENGTH;
        }
        
        foreach ($this -> categoriesExpenseNamesTranslated as $category) {
            if (strtolower($category['name']) == strtolower($newCategoryName)) {
                return ALREADY_EXISTS;
            }
        }
        $this -> newCategoryName['name'] = $newCategoryName;
		$this -> newCategoryName['user_id'] = $this -> userLoggedIn -> id;
        
        $_SESSION['newCategoryName'] = $this -> newCategoryName;
        return ACTION_OK;
    }

    function saveNewExpenseCategory()
    {
        $this -> newCategoryName = $_SESSION['newCategoryName'];
        unset($_SESSION['newCategoryName']);

        $saveNewCategoryQuery = $this -> dbo -> prepareSaveNewExpenseCategory($this -> newCategoryName['user_id'], $this -> newCategoryName['name']);
        if ($saveNewCategoryQuery -> execute()) {
            return ACTION_OK;
        } else {
            return ACTION_FAILED;
        }
    }
	
	function checkNewIncomeCategoryForm()
    {
        if ($_POST['newCategoryName'] == null) {
            return FORM_DATA_MISSING;
        }

        $newCategoryName = filter_input(INPUT_POST, 'newCategoryName', 
                           FILTER_SANITIZE_SPECIAL_CHARS);
        $newCategoryName = ltrim($newCategoryName);
		$newCategoryName = rtrim($newCategoryName);
        
        if ($newCategoryName == '') {
            return FORM_DATA_MISSING;
        }
        
        if (strlen($newCategoryName)<3 || strlen($newCategoryName)>20) {
            return WRONG_LENGTH;
        }
        
        foreach ($this -> categoriesIncomeNamesTranslated as $category) {
            if (strtolower($category['name']) == strtolower($newCategoryName)) {
                return ALREADY_EXISTS;
            }
        }
        $this -> newCategoryName['name'] = $newCategoryName;
		$this -> newCategoryName['user_id'] = $this -> userLoggedIn -> id;
        
        $_SESSION['newCategoryName'] = $this -> newCategoryName;
        return ACTION_OK;
    }

    function saveNewIncomeCategory()
    {
        $this -> newCategoryName = $_SESSION['newCategoryName'];
        unset($_SESSION['newCategoryName']);

        $saveNewCategoryQuery = $this -> dbo -> prepareSaveNewIncomeCategory($this -> newCategoryName['user_id'], $this -> newCategoryName['name']);
        if($saveNewCategoryQuery -> execute()){
            return ACTION_OK;
        } else {
            return ACTION_FAILED;
        }
    }
	
    function checkNewPaymentCategoryForm()
    {
        if ($_POST['newCategoryName'] == null) {
            return FORM_DATA_MISSING;
        }

        $newCategoryName = filter_input(INPUT_POST, 'newCategoryName', 
                           FILTER_SANITIZE_SPECIAL_CHARS);
        $newCategoryName = ltrim($newCategoryName);
        $newCategoryName = rtrim($newCategoryName);
        
        if ($newCategoryName == '') {
            return FORM_DATA_MISSING;
        }
        
        if (strlen($newCategoryName)<3 || strlen($newCategoryName)>20) {
            return WRONG_LENGTH;
        }
        
        foreach ($this -> paymentsNamesTranslated as $category) {
            if (strtolower($category['name']) == strtolower($newCategoryName)) {
                return ALREADY_EXISTS;
            }
        }
        $this -> newCategoryName['name'] = $newCategoryName;
		$this -> newCategoryName['user_id'] = $this -> userLoggedIn->id;
        
        $_SESSION['newCategoryName'] = $this -> newCategoryName;
        return ACTION_OK;
    }

    function saveNewPaymentCategory()
    {
        $this -> newCategoryName = $_SESSION['newCategoryName'];
        unset($_SESSION['newCategoryName']);

        $saveNewCategoryQuery = $this -> dbo -> prepareSaveNewPaymentCategory($this -> newCategoryName['user_id'], $this->newCategoryName['name']);
        if ($saveNewCategoryQuery -> execute()) {
            return ACTION_OK;
        } else {
            return ACTION_FAILED;
        }
    }
	
	function checkDeleteExpenseCategoryForm()
    {
        if ($_POST['category'] == null) {
            return ACTION_FAILED;
        }
        $categoryName = $_POST['category'];
        foreach ($this -> categoriesExpenseNames as $category) {
            if ($category['name'] == $categoryName) {
                $this -> newCategoryName['id'] = $category['id'];
            }
        }
        $_SESSION['newCategoryName'] = $this -> newCategoryName;
        return ACTION_OK;
    }

    function deleteExpenseCategory()
    {
        $this -> newCategoryName = $_SESSION['newCategoryName'];
        unset($_SESSION['newCategoryName']);
		
        $deleteCategoryQueries = $this -> dbo -> prepareDeleteExpenseCategory($this -> newCategoryName['id']);
		$QUERIES_OK = $this -> dbo -> executeDeleteCategoryQueries($deleteCategoryQueries);
        if ($QUERIES_OK) {
            return ACTION_OK;
        } else {
            return ACTION_FAILED;
        }
    }

    function checkDeleteIncomeCategoryForm()
    {
        if ($_POST['category']==null) {
            return ACTION_FAILED;
        }
        $categoryName = $_POST['category'];
        foreach ($this -> categoriesIncomeNames as $category) {
            if ($category['name'] == $categoryName) {
                $this -> newCategoryName['id'] = $category['id'];
            }
        }
        $_SESSION['newCategoryName'] = $this -> newCategoryName;
        return ACTION_OK;
    }

    function deleteIncomeCategory()
    {
        $this -> newCategoryName = $_SESSION['newCategoryName'];
        unset($_SESSION['newCategoryName']);
		
        $deleteCategoryQueries = $this -> dbo -> prepareDeleteIncomeCategory($this -> newCategoryName['id']);
		$QUERIES_OK = $this -> dbo -> executeDeleteCategoryQueries($deleteCategoryQueries);
        if ($QUERIES_OK) {
            return ACTION_OK;
        } else {
            return ACTION_FAILED;
        }
    }
	
	function checkDeletePaymentCategoryForm()
    {
        if ($_POST['category'] == null) {
            return ACTION_FAILED;
        }
        $categoryName = $_POST['category'];
        foreach ($this -> paymentsNames as $category) {
            if ($category['name'] == $categoryName) {
                $this -> newCategoryName['id'] = $category['id'];
            }
        }
        $_SESSION['newCategoryName'] = $this -> newCategoryName;
        return ACTION_OK;
    }

    function deletePaymentCategory()
    {
        $this -> newCategoryName = $_SESSION['newCategoryName'];
        unset($_SESSION['newCategoryName']);
		
        $deleteCategoryQueries = $this -> dbo -> prepareDeletePaymentCategory($this -> newCategoryName['id']);
		$QUERIES_OK = $this -> dbo -> executeDeleteCategoryQueries($deleteCategoryQueries);
        if ($QUERIES_OK) {
            return ACTION_OK;
        } else {
            return ACTION_FAILED;
        }
    }
	
    function checkEditUsernameForm()
    {
	    if (!isset($_POST['newUsername'])) {
		    return FORM_DATA_MISSING;
		}
		$newUsername = filter_input(INPUT_POST, 'newUsername', 
					   FILTER_SANITIZE_SPECIAL_CHARS);
		$newUsername = ltrim($newUsername);
		$newUsername = rtrim($newUsername);
		if ($newUsername == '') {
		    return FORM_DATA_MISSING;
		}
        $usernameQueryCount = $this -> dbo -> prepareQueryUsers($newUsername);
        if ($this -> dbo -> checkIfUsernameExist($usernameQueryCount) > 0) {
		    return ALREADY_EXISTS;
        }

        if (strlen($newUsername)<3 || strlen($newUsername)>20) {
            return WRONG_LENGTH;
        }
		
        if (ctype_alnum($newUsername) == false) {
            return WRONG_CHARACTERS;
        }
		$this -> newUsername = $newUsername;
		$_SESSION['newUsername'] = $this -> newUsername;
		
	    return ACTION_OK;
    }
	
    function saveNewUsername()
    {
	    $this -> newUsername = $_SESSION['newUsername'];
	    unset($_SESSION['newUsername']);
		
		$saveNewUsernameQuery = $this -> dbo -> prepareSaveNewUsername($this -> newUsername, $this -> userLoggedIn -> id);

        if ($saveNewUsernameQuery -> execute()) {
		    $_SESSION['loggedIN'] -> username = $this -> newUsername;
            return ACTION_OK;
        } else {
            return ACTION_FAILED;
        }
    }
	
    function checkEditPasswordForm()
    {
        $oldPassword = filter_input(INPUT_POST, 'oldPassword');
        $newPassword = filter_input(INPUT_POST, 'newPassword');
		
		$newPassword = ltrim($newPassword);
        $newPassword = rtrim($newPassword);
		
	    if ($oldPassword == '' || $newPassword == '') {
	        return FORM_DATA_MISSING;
		}
		
	    if (strlen($newPassword)<5 || strlen($newPassword)>20) {
		    return WRONG_LENGTH;
		}
        $userQuery = $this -> dbo -> prepareQueryIdPassword($this -> userLoggedIn -> username);

        if (!$this -> dbo -> executeQueryIdPassword($userQuery)) {
            return SERVER_ERROR;
        }
		$numRows = $this -> dbo -> prepareQueryUsers($this -> userLoggedIn -> username);
		if ($this -> dbo -> getColumnsQueryUsers($numRows) <> 1)	{
            return ACTION_FAILED;
        } else {
		    $user = $userQuery -> fetch();
		    if ($user && password_verify($oldPassword, $user['password'])) {
                $this -> newPassword = $newPassword;
				$_SESSION['newPassword'] = $this -> newPassword;
                return ACTION_OK;
		    } else {
			    return ACTION_FAILED;
		    }
        }
    }
	
    function saveNewPassword()
    {
        $this -> newPassword = $_SESSION['newPassword'];
	    unset($_SESSION['newPassword']);
		$newPassword = password_hash($this -> newPassword, PASSWORD_DEFAULT);
		$saveNewPasswordQuery = $this -> dbo -> prepareSaveNewPassword($newPassword, $this -> userLoggedIn -> id);

        if ($saveNewPasswordQuery -> execute()) {
            return ACTION_OK;
        } else {
            return ACTION_FAILED;
        }
    }
	
    function deleteUser()
    {
        $deleteUserQueries = $this -> dbo -> prepareDeleteUser($this -> userLoggedIn -> id);
        $QUERIES_OK = $this -> dbo -> executeDeleteUser($deleteUserQueries);
        if ($QUERIES_OK) {
			unset($_SESSION['loggedIN']);
            return ACTION_OK;
        } else {
            return ACTION_FAILED;
        }
    }
	
    function showSettings()
    {
        include 'templates/settingsForm.php';
        $this -> showEditCategoryForms();
        include 'templates/addCategoriesForm.php';
        $this -> showDeleteCategoryForms();
        include 'templates/editUserForm.php';
        include 'templates/deleteUserForm.php';
    }
}
?>