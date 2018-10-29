<?php

class MyDBPDO extends PDO implements InputStream
{
    function prepareQueryIdPassword($username)
    {
        $userQuery = $this -> prepare('SELECT id, password FROM users WHERE username = :username');
        $userQuery -> bindValue(':username', $username, PDO::PARAM_STR);
        return $userQuery;
    }

    function executeQueryIdPassword($query)
    {
        $query -> execute();
        return $query;  
    }

    function prepareQueryUsers($username)
    {
        $numRows = $this -> prepare('SELECT COUNT(*) FROM users WHERE username = :username');
        $numRows -> bindValue(':username', $username, PDO::PARAM_STR);
        $numRows -> execute();
        return $numRows;
    }

    function getColumnsQueryUsers($query)
    {
        $number = $query -> fetchColumn();
        return $number;
    }

    function prepareSaveIncomeQuery($loggedId, $categoryId, $amount, $date, $comment)
    {
        $saveIncomeQuery = $this -> prepare('INSERT INTO incomes VALUES (NULL, :loggedId, :categoryId, :amount, :date, :comment)');
        $saveIncomeQuery -> bindValue(':loggedId', $loggedId, PDO::PARAM_INT);
        $saveIncomeQuery -> bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $saveIncomeQuery -> bindValue(':amount', $amount, PDO::PARAM_STR);
        $saveIncomeQuery -> bindValue(':date', $date, PDO::PARAM_STR);
        $saveIncomeQuery -> bindValue(':comment', $comment, PDO::PARAM_STR);
        return $saveIncomeQuery;
    }

    function executeSaveIncomeQuery($query)
    {
        $query -> execute();
        return $query;
    }

    function prepareSaveExpenseQuery($loggedId, $categoryId, $paymentId, $amount, $date, $comment)
    {
        $saveExpenseQuery = $this -> prepare('INSERT INTO expenses VALUES (NULL, :loggedId, :categoryId, :paymentId, :amount, :date, :comment)');
        $saveExpenseQuery -> bindValue(':loggedId', $loggedId, PDO::PARAM_INT);
        $saveExpenseQuery -> bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $saveExpenseQuery -> bindValue(':paymentId', $paymentId, PDO::PARAM_INT);
        $saveExpenseQuery -> bindValue(':amount', $amount, PDO::PARAM_STR);
        $saveExpenseQuery -> bindValue(':date', $date, PDO::PARAM_STR);
        $saveExpenseQuery -> bindValue(':comment', $comment, PDO::PARAM_STR);
        return $saveExpenseQuery;
    }

    function executeSaveExpenseQuery($query)
    {
        $query -> execute();
        return $query;
    }

    function checkIfUsernameExist($query)
    {
        $number = $query -> fetchColumn();
        return $number;
    }

    function prepareNewUserQueries($username, $password)
    {
        $queries = array();
        $newUserQuery = $this -> prepare('INSERT INTO users VALUES (NULL, :username, :password)');
        $newUserQuery -> bindValue(':username', $username, PDO::PARAM_STR); 
        $newUserQuery -> bindValue(':password', $password, PDO::PARAM_STR); 
        $queries['newUserQuery'] = $newUserQuery;

        $tableIncomesQuery = $this -> prepare('INSERT INTO incomes_category_assigned_to_users (user_id, name) SELECT (SELECT id FROM users ORDER BY id DESC LIMIT 1), name FROM incomes_category_default');
        $queries['tableIncomesQuery'] = $tableIncomesQuery;

        $tablePaymentQuery = $this -> prepare('INSERT INTO payment_methods_assigned_to_users (user_id, name) SELECT (SELECT id FROM users ORDER BY id DESC LIMIT 1), name FROM payment_methods_default');
        $queries['tablePaymentQuery'] = $tablePaymentQuery;

        $tableExpensesQuery = $this -> prepare('INSERT INTO expenses_category_assigned_to_users (user_id, name) SELECT (SELECT id FROM users ORDER BY id DESC LIMIT 1), name FROM expenses_category_default');
        $queries['tableExpensesQuery'] = $tableExpensesQuery;
        return $queries;
    }

    function executeNewUserQueries($queries)
    {
        $QUERIES_OK = true;
        foreach ($queries as $query) {
            if (!$query -> execute()) {
            $QUERIES_OK = false;
            }
        }
        return $QUERIES_OK;
    }

    function getThreeLastExpenses($userId)
    {
        $lastExpensesQuery = $this -> prepare('SELECT * FROM expenses WHERE user_id=:logged_id ORDER BY id DESC LIMIT 3');
        $lastExpensesQuery -> bindValue(':logged_id', $userId, PDO::PARAM_STR);
        $lastExpensesQuery -> execute();
        $lastExpenses = $lastExpensesQuery -> fetchAll();
        return $lastExpenses;
    }

    function getThreeLastIncomes($userId)
    {
        $lastIncomesQuery = $this -> prepare('SELECT * FROM incomes WHERE user_id=:logged_id ORDER BY id DESC LIMIT 3');
        $lastIncomesQuery -> bindValue(':logged_id', $userId, PDO::PARAM_STR);
        $lastIncomesQuery -> execute();
        $lastIncomes = $lastIncomesQuery -> fetchAll();
        return $lastIncomes;
    }

    function getPaymentNames($userId)
    {
        $idPaymentQuery = $this -> prepare('SELECT id, name FROM payment_methods_assigned_to_users WHERE user_id=:logged_id');
        $idPaymentQuery -> bindValue(':logged_id', $userId, PDO::PARAM_STR);
        $idPaymentQuery -> execute();
        $names = $idPaymentQuery -> fetchAll();
        return $names;
    }
    
    function getExpenseNames($userId)
    {
        $idExpenseQuery = $this -> prepare('SELECT id, name FROM expenses_category_assigned_to_users WHERE user_id=:loggedId');
        $idExpenseQuery -> bindValue(':loggedId', $userId, PDO::PARAM_STR);
        $idExpenseQuery -> execute();
        $names = $idExpenseQuery -> fetchAll();
        return $names;
    }
    
    function getIncomeNames($userId){
        $idPaymentQuery = $this -> prepare('SELECT id, name FROM incomes_category_assigned_to_users WHERE user_id=:logged_id');
        $idPaymentQuery -> bindValue(':logged_id', $userId, PDO::PARAM_STR);
        $idPaymentQuery -> execute();
        $names = $idPaymentQuery -> fetchAll();
        return $names;
    }
    
    function getIncomeCategoriesThisMonth($loggedId)
    {
        $date = new DateTime();
        $dateThisMonth = $date -> format('Y-m-00');

        $incomeThisMonthQuery = $this -> prepare('SELECT income_category_assigned_to_user_id, SUM(amount) AS amount FROM incomes WHERE user_id=:logged_id AND date>:date GROUP BY income_category_assigned_to_user_id ORDER BY amount DESC');
        $incomeThisMonthQuery -> bindValue(':logged_id', $loggedId, PDO::PARAM_INT);
        $incomeThisMonthQuery -> bindValue(':date', $dateThisMonth, PDO::PARAM_STR);
        $incomeThisMonthQuery -> execute();
        $incomeThisMonth = $incomeThisMonthQuery -> fetchAll();
        return $incomeThisMonth;
    }
    
    function getExpenseCategoriesThisMonth($loggedId)
    {
        $date = new DateTime();
        $dateThisMonth = $date -> format('Y-m-00');

        $expenseThisMonthQuery = $this -> prepare('SELECT expense_category_assigned_to_user_id, SUM(amount) AS amount FROM expenses WHERE user_id=:logged_id AND date>:date GROUP BY expense_category_assigned_to_user_id ORDER BY amount DESC');
        $expenseThisMonthQuery -> bindValue(':logged_id', $loggedId, PDO::PARAM_INT);
        $expenseThisMonthQuery -> bindValue(':date', $dateThisMonth, PDO::PARAM_STR);
        $expenseThisMonthQuery -> execute();
        $expenseThisMonth = $expenseThisMonthQuery -> fetchAll();
        return $expenseThisMonth;
    }
    
    function getExpenseThisMonth($loggedId)
    {
        $date = new DateTime();
        $dateThisMonth = $date -> format('Y-m-00'); 

        $expenseThisMonthQuery = $this -> prepare('SELECT * FROM expenses WHERE user_id=:logged_id AND date>:date');
        $expenseThisMonthQuery -> bindValue(':logged_id', $loggedId, PDO::PARAM_INT);
        $expenseThisMonthQuery -> bindValue(':date', $dateThisMonth, PDO::PARAM_STR);
        $expenseThisMonthQuery -> execute();
        $expenseThisMonth = $expenseThisMonthQuery -> fetchAll();
        return $expenseThisMonth;
    }
    
    function getIncomeThisMonth($loggedId)
    {
        $date = new DateTime();
        $dateThisMonth = $date -> format('Y-m-00');

        $incomeThisMonthQuery = $this -> prepare('SELECT * FROM incomes WHERE user_id=:logged_id AND date>:date');
        $incomeThisMonthQuery -> bindValue(':logged_id', $loggedId, PDO::PARAM_INT);
        $incomeThisMonthQuery -> bindValue(':date', $dateThisMonth, PDO::PARAM_STR);
        $incomeThisMonthQuery -> execute();
        $incomeThisMonth = $incomeThisMonthQuery -> fetchAll();
        return $incomeThisMonth;
    }
    
    function getIncomeCategoriesLastMonth($loggedId)
    {
        $date = new DateTime();
        $dateLastMonthB = $date -> format('Y-m-00');
        $date -> modify('-1 month');
        $dateLastMonthA = $date -> format('Y-m-00');

        $incomeLastMonthQuery = $this -> prepare('SELECT income_category_assigned_to_user_id, SUM(amount) AS amount FROM incomes WHERE user_id=:logged_id AND date BETWEEN :dateA AND :dateB GROUP BY income_category_assigned_to_user_id ORDER BY amount DESC');
        $incomeLastMonthQuery -> bindValue(':logged_id', $loggedId, PDO::PARAM_INT);
        $incomeLastMonthQuery -> bindValue(':dateA', $dateLastMonthA, PDO::PARAM_STR);
        $incomeLastMonthQuery -> bindValue(':dateB', $dateLastMonthB, PDO::PARAM_STR);
        $incomeLastMonthQuery -> execute();
        $incomeLastMonth = $incomeLastMonthQuery -> fetchAll();
        return $incomeLastMonth;
    }
    
    function getExpenseCategoriesLastMonth($loggedId)
    {
        $date = new DateTime();
        $dateLastMonthB = $date -> format('Y-m-00');
        $date -> modify('-1 month');
        $dateLastMonthA = $date -> format('Y-m-00');

        $expenseLastMonthQuery = $this -> prepare('SELECT expense_category_assigned_to_user_id, SUM(amount) AS amount FROM expenses WHERE user_id=:logged_id AND date BETWEEN :dateA AND :dateB GROUP BY expense_category_assigned_to_user_id ORDER BY amount DESC');
        $expenseLastMonthQuery -> bindValue(':logged_id', $loggedId, PDO::PARAM_INT);
        $expenseLastMonthQuery -> bindValue(':dateA', $dateLastMonthA, PDO::PARAM_STR);
        $expenseLastMonthQuery -> bindValue(':dateB', $dateLastMonthB, PDO::PARAM_STR);
        $expenseLastMonthQuery -> execute();
        $expenseLastMonth = $expenseLastMonthQuery -> fetchAll();
        return $expenseLastMonth;
    }
    
    function getExpenseLastMonth($loggedId)
    {
        $date = new DateTime();
        $dateLastMonthB = $date -> format('Y-m-00');
        $date -> modify('-1 month');
        $dateLastMonthA = $date -> format('Y-m-00'); 

        $expenseLastMonthQuery = $this -> prepare('SELECT * FROM expenses WHERE user_id=:logged_id AND date BETWEEN :dateA AND :dateB');
        $expenseLastMonthQuery -> bindValue(':logged_id', $loggedId, PDO::PARAM_INT);
        $expenseLastMonthQuery -> bindValue(':dateA', $dateLastMonthA, PDO::PARAM_STR);
        $expenseLastMonthQuery -> bindValue(':dateB', $dateLastMonthB, PDO::PARAM_STR);
        $expenseLastMonthQuery -> execute();
        $expenseLastMonth = $expenseLastMonthQuery -> fetchAll();
        return $expenseLastMonth;
    }
    
    function getIncomeLastMonth($loggedId)
    {
        $date = new DateTime();
        $dateLastMonthB = $date -> format('Y-m-00');
        $date -> modify('-1 month');
        $dateLastMonthA = $date -> format('Y-m-00');

        $incomeLastMonthQuery = $this -> prepare('SELECT * FROM incomes WHERE user_id=:logged_id AND date BETWEEN :dateA AND :dateB');
        $incomeLastMonthQuery -> bindValue(':logged_id', $loggedId, PDO::PARAM_INT);
        $incomeLastMonthQuery -> bindValue(':dateA', $dateLastMonthA, PDO::PARAM_STR);
        $incomeLastMonthQuery -> bindValue(':dateB', $dateLastMonthB, PDO::PARAM_STR);
        $incomeLastMonthQuery -> execute();
        $incomeLastMonth = $incomeLastMonthQuery -> fetchAll();
        return $incomeLastMonth;
    }
    
    function getIncomeCategoriesThisYear($loggedId)
    {
        $date = new DateTime();
        $dateThisYear = $date -> format('Y-00-00');

        $incomeThisYearQuery = $this -> prepare('SELECT income_category_assigned_to_user_id, SUM(amount) AS amount FROM incomes WHERE user_id=:logged_id AND date>:date GROUP BY income_category_assigned_to_user_id ORDER BY amount DESC');
        $incomeThisYearQuery -> bindValue(':logged_id', $loggedId, PDO::PARAM_INT);
        $incomeThisYearQuery -> bindValue(':date', $dateThisYear, PDO::PARAM_STR);
        $incomeThisYearQuery -> execute();
        $incomeThisYear = $incomeThisYearQuery -> fetchAll();
        return $incomeThisYear;
    }
    
    function getExpenseCategoriesThisYear($loggedId)
    {
        $date = new DateTime();
        $dateThisYear = $date -> format('Y-00-00');

        $expenseThisYearQuery = $this -> prepare('SELECT expense_category_assigned_to_user_id, SUM(amount) AS amount FROM expenses WHERE user_id=:logged_id AND date>:date GROUP BY expense_category_assigned_to_user_id ORDER BY amount DESC');
        $expenseThisYearQuery -> bindValue(':logged_id', $loggedId, PDO::PARAM_INT);
        $expenseThisYearQuery -> bindValue(':date', $dateThisYear, PDO::PARAM_STR);
        $expenseThisYearQuery -> execute();
        $expenseThisYear = $expenseThisYearQuery -> fetchAll();
        return $expenseThisYear;
    }
    
    function getExpenseThisYear($loggedId)
    {
        $date = new DateTime();
        $dateThisYear = $date -> format('Y-00-00');

        $expenseThisYearQuery = $this -> prepare('SELECT * FROM expenses WHERE user_id=:logged_id AND date>:date');
        $expenseThisYearQuery -> bindValue(':logged_id', $loggedId, PDO::PARAM_INT);
        $expenseThisYearQuery -> bindValue(':date', $dateThisYear, PDO::PARAM_STR);
        $expenseThisYearQuery -> execute();
        $expenseThisYear = $expenseThisYearQuery -> fetchAll();
        return $expenseThisYear;
    }
    
    function getIncomeThisYear($loggedId)
    {
        $date = new DateTime();
        $dateThisYear = $date -> format('Y-00-00');

        $incomeThisYearQuery = $this -> prepare('SELECT * FROM incomes WHERE user_id=:logged_id AND date>:date');
        $incomeThisYearQuery -> bindValue(':logged_id', $loggedId, PDO::PARAM_INT);
        $incomeThisYearQuery -> bindValue(':date', $dateThisYear, PDO::PARAM_STR);
        $incomeThisYearQuery -> execute();
        $incomeThisYear = $incomeThisYearQuery -> fetchAll();
        return $incomeThisYear;
    }
    
    function getIncomeCategoriesChoosenDate($loggedId, $dateA, $dateB)
    {
        $incomeChoosenDateQuery = $this -> prepare('SELECT income_category_assigned_to_user_id, SUM(amount) AS amount FROM incomes WHERE user_id=:logged_id AND date BETWEEN :dateA AND :dateB GROUP BY income_category_assigned_to_user_id ORDER BY amount DESC');
        $incomeChoosenDateQuery -> bindValue(':logged_id', $loggedId, PDO::PARAM_INT);
        $incomeChoosenDateQuery -> bindValue(':dateA', $dateA, PDO::PARAM_STR);
        $incomeChoosenDateQuery -> bindValue(':dateB', $dateB, PDO::PARAM_STR);
        $incomeChoosenDateQuery -> execute();
        $incomeChoosenDate = $incomeChoosenDateQuery -> fetchAll();
        return $incomeChoosenDate;
    }
    
    function getExpenseCategoriesChoosenDate($loggedId, $dateA, $dateB)
    {
        $expenseChoosenDateQuery = $this -> prepare('SELECT expense_category_assigned_to_user_id, SUM(amount) AS amount FROM expenses WHERE user_id=:logged_id AND date BETWEEN :dateA AND :dateB GROUP BY expense_category_assigned_to_user_id ORDER BY amount DESC');
        $expenseChoosenDateQuery -> bindValue(':logged_id', $loggedId, PDO::PARAM_INT);
        $expenseChoosenDateQuery -> bindValue(':dateA', $dateA, PDO::PARAM_STR);
        $expenseChoosenDateQuery -> bindValue(':dateB', $dateB, PDO::PARAM_STR);
        $expenseChoosenDateQuery -> execute();
        $expenseChoosenDate = $expenseChoosenDateQuery -> fetchAll();
        return $expenseChoosenDate;
    }
    
    function getExpenseChoosenDate($loggedId, $dateA, $dateB)
    {
        $expenseChoosenDateQuery = $this -> prepare('SELECT * FROM expenses WHERE user_id=:logged_id AND date BETWEEN :dateA AND :dateB');
        $expenseChoosenDateQuery -> bindValue(':logged_id', $loggedId, PDO::PARAM_INT);
        $expenseChoosenDateQuery -> bindValue(':dateA', $dateA, PDO::PARAM_STR);
        $expenseChoosenDateQuery -> bindValue(':dateB', $dateB, PDO::PARAM_STR);
        $expenseChoosenDateQuery -> execute();
        $expenseChoosenDate = $expenseChoosenDateQuery -> fetchAll();
        return $expenseChoosenDate;
    }
    
    function getIncomeChoosenDate($loggedId, $dateA, $dateB)
    {
        $incomeChoosenDateQuery = $this -> prepare('SELECT * FROM incomes WHERE user_id=:logged_id AND date BETWEEN :dateA AND :dateB');
        $incomeChoosenDateQuery -> bindValue(':logged_id', $loggedId, PDO::PARAM_INT);
        $incomeChoosenDateQuery -> bindValue(':dateA', $dateA, PDO::PARAM_STR);
        $incomeChoosenDateQuery -> bindValue(':dateB', $dateB, PDO::PARAM_STR);
        $incomeChoosenDateQuery -> execute();
        $incomeChoosenDate = $incomeChoosenDateQuery -> fetchAll();
        return $incomeChoosenDate;
    }
    
    function prepreDeleteIncomeQuery($id)
    {
        $deleteIncomeQuery = $this -> prepare('DELETE FROM incomes WHERE id=:id');
        $deleteIncomeQuery -> bindValue(':id', $id, PDO::PARAM_INT);
        return $deleteIncomeQuery;
    }
    
    function prepreExpenseIncomeQuery($id)
    {
        $deleteExpenseQuery = $this -> prepare('DELETE FROM expenses WHERE id=:id');
        $deleteExpenseQuery -> bindValue(':id', $id, PDO::PARAM_INT);
        return $deleteExpenseQuery;
    }
    
    function prepareSaveEditedIncome($id, $categoryId, $amount, $date, $comment)
    {
        $saveEditedQuery = $this -> prepare('UPDATE incomes SET income_category_assigned_to_user_id=:categoryId, amount=:amount, date=:date, comment=:comment WHERE id=:id');
        $saveEditedQuery -> bindValue(':id', $id, PDO::PARAM_INT);
        $saveEditedQuery -> bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $saveEditedQuery -> bindValue(':amount', $amount, PDO::PARAM_STR);
        $saveEditedQuery -> bindValue(':date', $date, PDO::PARAM_STR);
        $saveEditedQuery -> bindValue(':comment', $comment, PDO::PARAM_STR);
        return $saveEditedQuery;
    }
    
    function prepareSaveEditedExpense($id, $categoryId, $paymentId, $amount, $date, $comment)
    {
        $saveEditedQuery = $this -> prepare('UPDATE expenses SET expense_category_assigned_to_user_id=:categoryId, payment_method_assigned_to_user_id=:paymentId, amount=:amount, date=:date, comment=:comment WHERE id=:id');
        $saveEditedQuery -> bindValue(':id', $id, PDO::PARAM_INT);
        $saveEditedQuery -> bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $saveEditedQuery -> bindValue(':paymentId', $paymentId, PDO::PARAM_INT);
        $saveEditedQuery -> bindValue(':amount', $amount, PDO::PARAM_STR);
        $saveEditedQuery -> bindValue(':date', $date, PDO::PARAM_STR);
        $saveEditedQuery -> bindValue(':comment', $comment, PDO::PARAM_STR);
        return $saveEditedQuery;
    }
    
    function prepareSaveEditedExpenseCategory($id, $name)
    {
        $saveEditedQuery = $this -> prepare('UPDATE expenses_category_assigned_to_users SET name=:name WHERE id=:id');
        $saveEditedQuery -> bindValue(':id', $id, PDO::PARAM_INT);
        $saveEditedQuery -> bindValue(':name', $name, PDO::PARAM_STR);
        return $saveEditedQuery;
    }
    
    function prepareSaveEditedIncomeCategory($id, $name)
    {
        $saveEditedQuery = $this -> prepare('UPDATE incomes_category_assigned_to_users SET name=:name WHERE id=:id');
        $saveEditedQuery -> bindValue(':id', $id, PDO::PARAM_INT);
        $saveEditedQuery -> bindValue(':name', $name, PDO::PARAM_STR);
        return $saveEditedQuery;
    }
    
    function prepareSaveEditedPaymentCategory($id, $name)
    {
        $saveEditedQuery = $this -> prepare('UPDATE payment_methods_assigned_to_users SET name=:name WHERE id=:id');
        $saveEditedQuery -> bindValue(':id', $id, PDO::PARAM_INT);
        $saveEditedQuery -> bindValue(':name', $name, PDO::PARAM_STR);
        return $saveEditedQuery;
    }
    
    function prepareSaveNewExpenseCategory($userId, $name)
    {
        $saveNewCategoryQuery = $this -> prepare('INSERT INTO expenses_category_assigned_to_users VALUES (NULL, :userId, :name)');
        $saveNewCategoryQuery -> bindValue(':userId', $userId, PDO::PARAM_INT);
        $saveNewCategoryQuery -> bindValue(':name', $name, PDO::PARAM_STR);
        return $saveNewCategoryQuery;
    }
    
    function prepareSaveNewIncomeCategory($userId, $name)
    {
        $saveNewCategoryQuery = $this -> prepare('INSERT INTO incomes_category_assigned_to_users VALUES (NULL, :userId, :name)');
        $saveNewCategoryQuery -> bindValue(':userId', $userId, PDO::PARAM_INT);
        $saveNewCategoryQuery -> bindValue(':name', $name, PDO::PARAM_STR);
        return $saveNewCategoryQuery;
    }
    
    function prepareSaveNewPaymentCategory($userId, $name)
    {
        $saveNewCategoryQuery = $this -> prepare('INSERT INTO payment_methods_assigned_to_users VALUES (NULL, :userId, :name)');
        $saveNewCategoryQuery -> bindValue(':userId', $userId, PDO::PARAM_INT);
        $saveNewCategoryQuery -> bindValue(':name', $name, PDO::PARAM_STR);
        return $saveNewCategoryQuery;
    }
    
    function prepareDeleteExpenseCategory($id)
    {
        $queries = array();

        $deleteExpenseCategoryQuery = $this -> prepare('DELETE FROM expenses_category_assigned_to_users WHERE id=:id');
        $deleteExpenseCategoryQuery -> bindValue(':id', $id, PDO::PARAM_INT);
        $queries['deleteExpenseCategoryQuery'] = $deleteExpenseCategoryQuery;

        $deleteExpensesQuery = $this -> prepare('DELETE FROM expenses WHERE expense_category_assigned_to_user_id=:id');
        $deleteExpensesQuery -> bindValue(':id', $id, PDO::PARAM_INT);
        $queries['deleteExpensesQuery'] = $deleteExpensesQuery;

        return $queries;
    }
    
    function executeDeleteCategoryQueries($queries)
    {
        $QUERIES_OK = true;
        foreach ($queries as $query) {
            if (!$query -> execute()) {
            $QUERIES_OK = false;
            }
        }
        return $QUERIES_OK;
    }
    
    function prepareDeleteIncomeCategory($id)
    {
        $queries = array();

        $deleteIncomesCategoryQuery = $this -> prepare('DELETE FROM incomes_category_assigned_to_users WHERE id=:id');
        $deleteIncomesCategoryQuery -> bindValue(':id', $id, PDO::PARAM_INT);
        $queries['deleteIncomesCategoryQuery'] = $deleteIncomesCategoryQuery;

        $deleteIncomesQuery = $this -> prepare('DELETE FROM incomes WHERE income_category_assigned_to_user_id=:id');
        $deleteIncomesQuery -> bindValue(':id', $id, PDO::PARAM_INT);
        $queries['deleteIncomesQuery'] = $deleteIncomesQuery;

        return $queries;
    }
    
    function prepareDeletePaymentCategory($id)
    {
        $queries = array();

        $deletePaymentsCategoryQuery = $this -> prepare('DELETE FROM payment_methods_assigned_to_users WHERE id=:id');
        $deletePaymentsCategoryQuery -> bindValue(':id', $id, PDO::PARAM_INT);
        $queries['deletePaymentsCategoryQuery'] = $deletePaymentsCategoryQuery;

        $deletePaymentQuery = $this -> prepare('DELETE FROM expenses WHERE payment_method_assigned_to_user_id=:id');
        $deletePaymentQuery -> bindValue(':id', $id, PDO::PARAM_INT);
        $queries['deletePaymentQuery'] = $deletePaymentQuery;

        return $queries;
    }
    
    function prepareSaveNewUsername($username, $userId)
    {
        $saveNewUsernameQuery = $this -> prepare('UPDATE users SET username=:username WHERE id=:userId');
        $saveNewUsernameQuery -> bindValue(':userId', $userId, PDO::PARAM_INT);
        $saveNewUsernameQuery -> bindValue(':username', $username, PDO::PARAM_STR);

        return $saveNewUsernameQuery;
    }
    
    function prepareSaveNewPassword($password, $userId)
    {
        $saveNewPasswordQuery = $this -> prepare('UPDATE users SET password=:password WHERE id=:userId');
        $saveNewPasswordQuery -> bindValue(':userId', $userId, PDO::PARAM_INT);
        $saveNewPasswordQuery -> bindValue(':password', $password, PDO::PARAM_STR);

        return $saveNewPasswordQuery;
    }
    
    function prepareDeleteUser($userId)
    {
        $queries = array();

        $deleteUser = $this -> prepare('DELETE FROM users WHERE id=:userId');
        $deleteUser -> bindValue(':userId', $userId, PDO::PARAM_INT);
        $queries['deleteUser'] = $deleteUser;

        $deleteIncomeCategories = $this -> prepare('DELETE FROM incomes_category_assigned_to_users WHERE user_id=:userId');
        $deleteIncomeCategories -> bindValue(':userId', $userId, PDO::PARAM_INT);
        $queries['deleteIncomeCategories'] = $deleteIncomeCategories;

        $deleteExpenseCategories = $this -> prepare('DELETE FROM expenses_category_assigned_to_users WHERE user_id=:userId');
        $deleteExpenseCategories -> bindValue(':userId', $userId, PDO::PARAM_INT);
        $queries['deleteExpenseCategories'] = $deleteExpenseCategories;

        $deletePaymentMethods = $this -> prepare('DELETE FROM payment_methods_assigned_to_users WHERE user_id=:userId');
        $deletePaymentMethods -> bindValue(':userId', $userId, PDO::PARAM_INT);
        $queries['deletePaymentMethods'] = $deletePaymentMethods;

        $deleteIncomes = $this -> prepare('DELETE FROM incomes WHERE user_id=:userId');
        $deleteIncomes -> bindValue(':userId', $userId, PDO::PARAM_INT);
        $queries['deleteIncomes'] = $deleteIncomes;

        $deleteExpenses = $this -> prepare('DELETE FROM expenses WHERE user_id=:userId');
        $deleteExpenses -> bindValue(':userId', $userId, PDO::PARAM_INT);
        $queries['deleteExpenses'] = $deleteExpenses;

        return $queries;
    }
    
    function executeDeleteUser($queries)
    {
        $QUERIES_OK = true;
        foreach ($queries as $query) {
            if (!$query->execute()) {
                $QUERIES_OK = false;
            }
        }
        return $QUERIES_OK;
    }
}
?>