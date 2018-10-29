<?php

class LastEntries
{
    private $dbo = null;
    private $loggedId;
    private $threeLastExpenses = array();
    private $threeLastIncomes = array();

    function __construct($dbo, $loggedId)
    {
        $this->dbo = $dbo;
        $this->loggedId = $loggedId;
        $this->getThreeLastExpenses();
        $this->getThreeLastIncomes();
    }

    function getThreeLastExpenses()
    {
        $lastExpenses = $this->dbo->getThreeLastExpenses($this->loggedId);

        foreach ($lastExpenses as $lastExpense) {
            $this->threeLastExpenses[] = new SingleExpense($this->dbo, $this->loggedId, $lastExpense['id'], $lastExpense['user_id'], $lastExpense['expense_category_assigned_to_user_id'],     $lastExpense['payment_method_assigned_to_user_id'], $lastExpense['amount'], $lastExpense['date'], $lastExpense['comment']); 
        }
    }

    function getThreeLastIncomes()
    {
        $lastIncomes = $this->dbo->getThreeLastIncomes($this->loggedId);

        foreach ($lastIncomes as $lastIncome) {
            $this->threeLastIncomes[] = new SingleIncome($this->dbo, $this->loggedId, $lastIncome['id'], $lastIncome['user_id'], $lastIncome['income_category_assigned_to_user_id'], $lastIncome['amount'], $lastIncome['date'], $lastIncome['comment']); 
        }
    }

    function showStart()
    {
        $lastExpenses = $this->threeLastExpenses;
        $lastIncomes = $this->threeLastIncomes;
        include 'templates/start.php';
    }
}