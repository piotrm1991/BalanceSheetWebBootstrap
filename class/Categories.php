<?php
class Categories
{
    private $paymentMethods;
    private $expenseCategory;
    private $incomeCategory;

    function __construct()
    {
        $this -> paymentMethods = array
        (
        "Cash" => "Gotówka",
        "Debit Card" => "Karta debetowa",
        "Credit Card" => "Karta kredytowa"
        );
        
        $this -> expenseCategory = array
        (
            "Transport" => "Transport",
            "Books" => "Książki",
            "Food" => "Jedzenie",
            "Apartments" => "Mieszkanie",
            "Training" => "Szkolenie",
            "Health" => "Opieka zdrowotna",
            "Clothes" => "Ubrania",
            "Hygiene" => "Higiena",
            "Kids"=> "Dzieci",
            "Recreation" => "Rozrywka",
            "Trip" => "Wycieczka",
            "Savings" => "Oszczędności",
            "For Retirement" => "Emerytura",
            "Debt Repayment" => "Długi",
            "Gift" => "Prezent",
            "Another" => "Inne wydatki"
        );
        $this -> incomeCategory = array
        (
            "Salary" => "Wynagrodzenie",
            "Interest" => "Odsetki",
            "Allegro" => "Sprzedaż na allegro",
            "Another" => "Inne",
        );
    }

    function getExpenseCategories()
    {
        return $this -> expenseCategory;
    }

    function getIncomeCategories()
    {
        return $this -> incomeCategory;
    }

    function getPaymentMethods()
    {
        return $this -> paymentMethods;
    }
}
?>



