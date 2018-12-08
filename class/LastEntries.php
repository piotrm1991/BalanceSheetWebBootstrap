<?php

class LastEntries
{
    private $dbo = null;
    private $loggedId;
    private $threeLastExpenses = array();
    private $threeLastIncomes = array();

    function __construct($dbo, $loggedId)
    {
        $this -> dbo = $dbo;
        $this -> loggedId = $loggedId;
        $this -> getThreeLastExpenses();
        $this -> getThreeLastIncomes();
    }

    function getThreeLastExpenses()
    {
        $lastExpenses = $this -> dbo -> getThreeLastExpenses($this -> loggedId);

        foreach ($lastExpenses as $lastExpense) {
            $this -> threeLastExpenses[] = (new SingleExpenseBuilder($this -> dbo, $this -> loggedId))
                                            -> addId($lastExpense['id'])
                                            -> addUserId($lastExpense['user_id'])
                                            -> addAmount($lastExpense['amount'])
                                            -> addDate($lastExpense['date'])
                                            -> addComment($lastExpense['comment'])
                                            -> addExpenseCategoryId($lastExpense['expense_category_assigned_to_user_id'])
                                            -> addPaymentCategoryId($lastExpense['payment_method_assigned_to_user_id'])
                                            -> build();
        }
    }

    function getThreeLastIncomes()
    {
        $lastIncomes = $this -> dbo -> getThreeLastIncomes($this -> loggedId);

        foreach ($lastIncomes as $lastIncome) {
            $this -> threeLastIncomes[] = (new SingleIncomeBuilder($this -> dbo, $this -> loggedId))
                                            -> addId($lastIncome['id'])
                                            -> addUserId($lastIncome['user_id'])
                                            -> addAmount($lastIncome['amount'])
                                            -> addDate($lastIncome['date'])
                                            -> addComment($lastIncome['comment'])
                                            -> addIncomeCategoryId($lastIncome['income_category_assigned_to_user_id'])
                                            -> build();
        }
    }

    function showStart()
    {
        $lastExpenses = $this -> threeLastExpenses;
        $lastIncomes = $this -> threeLastIncomes;
        include 'templates/start.php';
    }
}