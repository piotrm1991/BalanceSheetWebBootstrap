<?php
class PortalFront extends Portal
{
    public $loggedIN = null;

    function __construct(InputStream $dbo)
    {
        $this -> dbo = $this -> initPDOMysql($dbo);
        $this -> loggedIN = $this -> getActualUser();
    }

    function getActualUser()
    {
        if (isset($_SESSION['loggedIN'])) {
            return $_SESSION['loggedIN'];
        } else {
            return null;
        }
    }

    function setMessage($message)
    {
        $_SESSION['message'] = $message;
    }

    function getMessage()
    {
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
            return $message;
        } else {
            return null;
        }
    }

    function login()
    {
        if (!$this -> dbo) return SERVER_ERROR;

        if ($this -> loggedIN) {
            return NO_LOGIN_REQUIRED;
        }

        if (!isset($_POST["username"]) || !isset($_POST["password"])) {
            return FORM_DATA_MISSING;
        }

        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        $userQuery = $this -> dbo -> prepareQueryIdPassword($username);

        if(!$this -> dbo -> executeQueryIdPassword($userQuery)) {
        return SERVER_ERROR;
        }

        $numRows = $this -> dbo -> prepareQueryUsers($username);

        if ($this -> dbo -> getColumnsQueryUsers($numRows) <> 1) {
            return ACTION_FAILED;
        } else {
            $user = $userQuery->fetch();
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['loggedIN'] = new User($user['id'], $username);
                return ACTION_OK;
            } else {
                return ACTION_FAILED;
            }
        }
    }

    function logout()
    {
        $this -> loggedIN = null;
        if (isset($_SESSION['loggedIN'])) {
            unset($_SESSION['loggedIN']);
        }
    }

    function showRegistrationForm()
    {
        $reg = new Registration($this -> dbo);
        return $reg -> showRegistrationForm();
    }

    function registerUser()
    {
        $reg = new Registration($this -> dbo);
        return $reg -> registerUser();
    } 
    
    function showIncomeForm()
    {
        $income = new AddIncome($this -> dbo, $this -> loggedIN -> id);
        return $income -> showIncomeForm();
    }
    
    function checkIncomeForm()
    {
        $income = new AddIncome($this -> dbo, $this -> loggedIN -> id);
        return $income -> checkIncomeForm();
    }
    
    function saveIncome()
    {
        $income = new AddIncome($this -> dbo, $this -> loggedIN -> id);
        return $income -> saveIncome();
    }
    
    function showExpenseForm()
    {
        $expense = new AddExpense($this -> dbo, $this -> loggedIN -> id);
        return $expense -> showExpenseForm();
    }
    
    function checkExpenseForm()
    {
        $expense = new AddExpense($this -> dbo, $this -> loggedIN -> id);
        return $expense -> checkExpenseForm();
    }
    
    function saveExpense()
    {
        $expense = new AddExpense($this -> dbo, $this -> loggedIN -> id);
        return $expense -> saveExpense();
    }
    
    function showStart()
    {
        $start = new LastEntries($this -> dbo, $this -> loggedIN -> id);
        return $start -> showStart();
    }
    
    function showBalanceThisMonth()
    {
        $balance = new Balance($this -> dbo, $this -> loggedIN -> id);
        $balance -> getBalaceThisMonth();
        return $balance -> showBalance();
    }
    
    function showBalanceLastMonth()
    {
        $balance = new Balance($this -> dbo, $this -> loggedIN -> id);
        $balance -> getBalaceLastMonth();
        return $balance -> showBalance();
    }
    
    function showBalanceThisYear()
    {
        $balance = new Balance($this -> dbo, $this -> loggedIN -> id);
        $balance -> getBalaceThisYear();
        return $balance -> showBalance();
    }
    
    function checkBalanceDate()
    {
        $balance = new Balance($this -> dbo, $this -> loggedIN -> id);;
        return $balance -> checkBalanceDate();
    }
    
    function showBalanceChoosenDate()
    {
        $balance = new Balance($this -> dbo, $this -> loggedIN -> id);
        $balance -> getBalaceChoosenDate();
        return $balance -> showBalance();
    }
    
    function deleteIncome()
    {
        $singleEntry = (new SingleIncomeBuilder($this -> dbo, $this -> loggedIN -> id))
                        -> addId($_POST['id'])
                        -> addUserId($this -> loggedIN -> id)
                        -> addAmount($_POST['amount'])
                        -> addDate($_POST['date'])
                        -> addComment($_POST['comment'])
                        -> addIncomeCategoryId($_POST['income_category_assigned_to_user_id'])
                        -> build();
        return  $singleEntry -> deleteIncome();; 
    }
        
    function deleteExpense()
    {
        $singleEntry = (new SingleExpenseBuilder($this -> dbo, $this -> loggedIN -> id))
                        -> addId($_POST['id'])
                        -> addUserId($this -> loggedIN -> id)
                        -> addAmount($_POST['amount'])
                        -> addDate($_POST['date'])
                        -> addComment($_POST['comment'])
                        -> addExpenseCategoryId($_POST['expense_category_assigned_to_user_id'])
                        -> addPaymentCategoryId($_POST['payment_method_assigned_to_user_id'])
                        -> build();
        return  $singleEntry -> deleteExpense();; 
    }
    
    function showIncomeEditForm()
    {
        $income = new EditIncome($this -> dbo, $this -> loggedIN -> id);
        return $income -> showIncomeEditForm();
    }
    
    function checkIncomeEditForm()
    {
        $income = new EditIncome($this -> dbo, $this -> loggedIN -> id);
        return $income -> checkIncomeEditForm();
    }
    
    function saveEditedIncome()
    {
        $income = new EditIncome($this -> dbo, $this -> loggedIN -> id);
        return $income -> saveEditedIncome();
    }
    
    function showExpenseEditForm()
    {
        $expense = new EditExpense($this -> dbo, $this -> loggedIN -> id);
        return $expense -> showExpenseEditForm();
    }
    
    function checkExpenseEditForm()
    {
        $expense = new EditExpense($this -> dbo, $this -> loggedIN -> id);
        return $expense -> checkExpenseEditForm();
    }
    function saveEditedExpense()
    {
        $expense = new EditExpense($this -> dbo, $this -> loggedIN -> id);
        return $expense -> saveEditedExpense();
    }
    
    function showSettings()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> showSettings();
    }
    
    function checkExpenseCategoryEditForm()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> checkExpenseCategoryEditForm();
    }
    
    function saveEditedExpenseCategory()
    {
    $settings = new Settings($this -> dbo, $this -> loggedIN);
    return $settings -> saveEditedExpenseCategory();
    }
    
    function checkIncomeCategoryEditForm()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> checkIncomeCategoryEditForm();
    }
    
    function saveEditedIncomeCategory()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> saveEditedIncomeCategory();
    }
    
    function checkPaymentCategoryEditForm()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> checkPaymentCategoryEditForm();
    }
    
    function saveEditedPaymentCategory()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> saveEditedPaymentCategory();
    }
    
    function checkNewExpenseCategoryForm()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> checkNewExpenseCategoryForm();
    }
    
    function saveNewExpenseCategory()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> saveNewExpenseCategory();
    }
    
    function checkNewIncomeCategoryForm()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> checkNewIncomeCategoryForm();
    }
    
    function saveNewIncomeCategory()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> saveNewIncomeCategory();
    }
    
    function checkNewPaymentCategoryForm()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> checkNewPaymentCategoryForm();
    }
    
    function saveNewPaymentCategory()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> saveNewPaymentCategory();
    }
    
    function checkDeleteExpenseCategoryForm()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> checkDeleteExpenseCategoryForm();
    }
    
    function deleteExpenseCategory()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> deleteExpenseCategory();
    }
    
    function checkDeleteIncomeCategoryForm()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> checkDeleteIncomeCategoryForm();
    }
    
    function deleteIncomeCategory()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> deleteIncomeCategory();
    }
    
    function checkDeletePaymentCategoryForm()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> checkDeletePaymentCategoryForm();
    }
    
    function deletePaymentCategory()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> deletePaymentCategory();
    }
    
    function checkEditUsernameForm()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> checkEditUsernameForm();
    }
    
    function saveNewUsername()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> saveNewUsername();
    }
    
    function checkEditPasswordForm()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> checkEditPasswordForm();
    }
    
    function saveNewPassword()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> saveNewPassword();
    }
    
    function deleteUser()
    {
        $settings = new Settings($this -> dbo, $this -> loggedIN);
        return $settings -> deleteUser();
    }
}
?>