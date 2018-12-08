<?php
interface InputStream
{
    function prepareQueryIdPassword($username);

    function executeQueryIdPassword($query);

    function prepareQueryUsers($username);

    function getColumnsQueryUsers($query);

    function prepareSaveIncomeQuery($loggedId, $categoryId, $amount, $date, $comment);

    function executeSaveIncomeQuery($query);

    function prepareSaveExpenseQuery($loggedId, $categoryId, $paymentId, $amount, $date, $comment);

    function executeSaveExpenseQuery($query);

    function checkIfUsernameExist($query);

    function prepareNewUserQueries($username, $password);

    function executeNewUserQueries($queries);

    function getThreeLastExpenses($userId);

    function getThreeLastIncomes($userId);

    function getPaymentNames($userId);
    
    function getExpenseNames($userId);
    
    function getIncomeNames($userId);
    
    function getIncomeCategoriesThisMonth($loggedId);
    
    function getExpenseCategoriesThisMonth($loggedId);
    
    function getExpenseThisMonth($loggedId);
    
    function getIncomeThisMonth($loggedId);
    
    function getIncomeCategoriesLastMonth($loggedId);
    
    function getExpenseCategoriesLastMonth($loggedId);
    
    function getExpenseLastMonth($loggedId);
    
    function getIncomeLastMonth($loggedId);
    
    function getIncomeCategoriesThisYear($loggedId);
    
    function getExpenseCategoriesThisYear($loggedId);
    
    function getExpenseThisYear($loggedId);
    
    function getIncomeThisYear($loggedId);
    
    function getIncomeCategoriesChoosenDate($loggedId, $dateA, $dateB);
    
    function getExpenseCategoriesChoosenDate($loggedId, $dateA, $dateB);
    
    function getExpenseChoosenDate($loggedId, $dateA, $dateB);
    
    function getIncomeChoosenDate($loggedId, $dateA, $dateB);
    
    function prepreDeleteIncomeQuery($id);
    
    function prepreExpenseIncomeQuery($id);
    
    function prepareSaveEditedIncome($id, $categoryId, $amount, $date, $comment);
    
    function prepareSaveEditedExpense($id, $categoryId, $paymentId, $amount, $date, $comment);
    
    function prepareSaveEditedExpenseCategory($id, $name);
    
    function prepareSaveEditedIncomeCategory($id, $name);
    
    function prepareSaveEditedPaymentCategory($id, $name);
    
    function prepareSaveNewExpenseCategory($userId, $name);
    
    function prepareSaveNewIncomeCategory($userId, $name);
    
    function prepareSaveNewPaymentCategory($userId, $name);
    
    function prepareDeleteExpenseCategory($id);
    
    function executeDeleteCategoryQueries($queries);
    
    function prepareDeleteIncomeCategory($id);
    
    function prepareDeletePaymentCategory($id);
    
    function prepareSaveNewUsername($username, $userId);
    
    function prepareSaveNewPassword($password, $userId);
    
    function prepareDeleteUser($userId);
    
    function executeDeleteUser($queries);
}
?>