<?php
class Balance
{
    private $dbo = null;
    private $loggedId;

    private $categoriesExpenseNames;

    private $categoriesIncomeNames;

    private $categoriesExpense = array();
    private $categoriesIncome = array();

    private $incomes = array();
    private $expenses = array();

    private $expenseSum;
    private $incomeSum;

    private $expenseCategoriesQuery;
    private $incomeCategoriesQuery;

    private $incomeQuery;
    private $expenseQuery;

    private $pieData = array
    (
        array ('Category', 'Amount')
    );

    function __construct($dbo, $loggedId)
    {
        $this -> dbo = $dbo;
        $this -> loggedId = $loggedId;
        $this -> getCategories();
    }

    function getCategories()
    {
        $expenseCategoryName = new ExpenseCategoryNames($this -> dbo, $this -> loggedId);
        $this -> categoriesExpenseNames = $expenseCategoryName -> getNames();

        $incomeCategoryName = new IncomeCategoryNames($this -> dbo, $this -> loggedId);
        $this -> categoriesIncomeNames = $incomeCategoryName -> getNames();
    }

    function getBalaceThisMonth()
    {
        $this -> incomeCategoriesQuery = $this -> dbo -> getIncomeCategoriesThisMonth($this -> loggedId);
        $this -> expenseCategoriesQuery = $this -> dbo -> getExpenseCategoriesThisMonth($this -> loggedId);
        $this -> incomeQuery = $this -> dbo -> getIncomeThisMonth($this -> loggedId);
        $this -> expenseQuery = $this -> dbo -> getExpenseThisMonth($this -> loggedId);
        $this -> prepareData();
    }

    function getBalaceLastMonth()
    {
        $this -> incomeCategoriesQuery = $this -> dbo -> getIncomeCategoriesLastMonth($this -> loggedId);
        $this -> expenseCategoriesQuery = $this -> dbo -> getExpenseCategoriesLastMonth($this -> loggedId);
        $this -> incomeQuery = $this -> dbo -> getIncomeLastMonth($this -> loggedId);
        $this -> expenseQuery = $this -> dbo -> getExpenseLastMonth($this -> loggedId);
        $this -> prepareData();
    }

    function getBalaceThisYear()
    {
        $this -> incomeCategoriesQuery = $this -> dbo -> getIncomeCategoriesThisYear($this -> loggedId);
        $this -> expenseCategoriesQuery = $this -> dbo -> getExpenseCategoriesThisYear($this -> loggedId);
        $this -> incomeQuery = $this -> dbo -> getIncomeThisYear($this -> loggedId);
        $this -> expenseQuery = $this -> dbo -> getExpenseThisYear($this -> loggedId);
        $this -> prepareData();
    }

    function getBalaceChoosenDate()
    {
        if (isset($_SESSION['dateA']) && isset($_SESSION['dateB'])) {
            $dateA = $_SESSION['dateA'];
            unset($_SESSION['dateA']);
            $dateB = $_SESSION['dateB'];
            unset($_SESSION['dateB']);

            $this -> incomeCategoriesQuery = $this -> dbo -> getIncomeCategoriesChoosenDate($this -> loggedId, $dateA, $dateB);
            $this -> expenseCategoriesQuery = $this -> dbo -> getExpenseCategoriesChoosenDate($this -> loggedId, $dateA, $dateB);
            $this -> incomeQuery = $this -> dbo -> getIncomeChoosenDate($this -> loggedId, $dateA, $dateB);
            $this -> expenseQuery = $this -> dbo -> getExpenseChoosenDate($this -> loggedId, $dateA, $dateB);
            $this -> prepareData();
        }
    }

    function checkBalanceDate()
    {
        if (!isset($_POST['dateA']) || !isset($_POST['dateB'])) {
            return FORM_DATA_MISSING;
        }
        if (($_POST['dateA'] == NULL) || ($_POST['dateB'] == NULL)) {
            return FORM_DATA_MISSING;
        }
        if ($_POST['dateA'] > $_POST['dateB']) {
            return WRONG_ORDER;
        }
        if ($_POST['dateA'] == $_POST['dateB'] && $_POST['dateA'] != NULL) {
            return SAME_DATE;
        }
        $_SESSION['dateA'] = $_POST['dateA'];
        $_SESSION['dateB'] = $_POST['dateB'];
        return ACTION_OK;
    }

    function getBalaceDate()
    {
        $this -> incomeCategoriesQuery = $this -> dbo -> getIncomeCategoriesThisYear($this -> loggedId);
        $this -> expenseCategoriesQuery = $this -> dbo -> getExpenseCategoriesThisYear($this -> loggedId);
        $this -> incomeQuery = $this -> dbo -> getIncomeThisYear($this -> loggedId);
        $this -> expenseQuery = $this -> dbo -> getExpenseThisYear($this -> loggedId);
        $this -> prepareData();
    }

    function prepareData()
    {
        foreach ($this -> incomeCategoriesQuery as $income) {
            $this -> categoriesIncome[] = new CategoryIncome($this -> dbo, $this -> loggedId, $income['income_category_assigned_to_user_id'], $income['amount']);
            $this -> incomeSum += $income['amount'];
        }
        foreach ($this -> expenseCategoriesQuery as $expense) {
            $this -> categoriesExpense[] = new CategoryExpense($this -> dbo, $this -> loggedId, $expense['expense_category_assigned_to_user_id'], $expense['amount']); 
            $this -> expenseSum += $expense['amount'];
        }
        foreach ($this -> categoriesExpense as $category) {
            $newPieData = array(array($category -> name, floatval($category -> sum)),);
            $this -> pieData = array_merge($this -> pieData, $newPieData);
        }

        foreach ($this -> expenseQuery as $expense) {
            $this -> expenses[] = new SingleExpense($this -> dbo, $this -> loggedId, $expense['id'], $expense['user_id'], $expense['expense_category_assigned_to_user_id'], $expense['payment_method_assigned_to_user_id'], $expense['amount'], $expense['date'], $expense['comment']); 
        }
        foreach ($this -> incomeQuery as $income) {
            $this -> incomes[] = new SingleIncome($this -> dbo, $this -> loggedId, $income['id'], $income['user_id'], $income['income_category_assigned_to_user_id'], $income['amount'], $income['date'], $income['comment']); 
        }
    }

    function showBalance()
    {
        $categoriesIncome = $this -> categoriesIncome;
        $categoriesExpense = $this -> categoriesExpense;
        $incomeSum = $this -> incomeSum;
        $expenseSum = $this -> expenseSum;
        $incomes = $this -> incomes;
        $expenses = $this -> expenses;
        $pieData = $this -> pieData;

        include 'templates/showBalance.php'; 
    }
}
?>