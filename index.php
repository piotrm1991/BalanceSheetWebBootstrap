<?php
include 'constants.php';
$config = require_once 'connect.php';
spl_autoload_register('classLoader');
session_start();

try{
	$getDB = new GetDB();
	$dbo = $getDB->getPDO($config);
    $portal = new PortalFront($dbo);
	
    $action = 'showMain';
    if (isset($_GET['action'])) 
	{
        $action = $_GET['action'];
    }
  
    $message = $portal->getMessage();

    switch($action)
	{
        case 'login' : 
            switch($portal->login()){
			case ACTION_OK : 
				$portal->setMessage('Zalogowanie prawidłowe');
				header('Location:index.php?action=showStart');
				return;
			case NO_LOGIN_REQUIRED : 
				$portal->setMessage('Najpierw proszę się wylogować.');
				header('Location:index.php?action=showMain');
				return;
			case ACTION_FAILED :
			case FORM_DATA_MISSING :
				$portal->setMessage('Błędny login lub hasło użytkownika');
				break;
			default:
				$portal->setMessage('Błąd serwera. Zalogowanie nie jest obecnie możliwe.');
            }
            header('Location:index.php?action=showLoginForm');
            break;
        case 'logout': 
            $portal->logout();
			$portal->setMessage('Zostałeś wylogowany.');
			header('Location:index.php?action=showMain');
            break;
        case 'registerUser' :
			switch($portal->registerUser()):
				case ACTION_OK:
				    $portal->setMessage('Rejestracja prawidłowa. Możesz się teraz zalogować.');
				    header('Location:index.php?action=showLoginForm');
				    return;
				case FORM_DATA_MISSING:
				    $_SESSION['registration_error']='Proszę wypełnić wszystkie pola formularza!';
				    break;
				case WRONG_LENGTH:
				    $_SESSION['registration_error']='Login musi posiadać od 3 do 20 znaków!';
				    break;
				case WRONG_CHARACTERS:
				    $_SESSION['registration_error']='Login może się składać tylko z liter i cyfr (bez polskich znaków)!';
				    break;
				case WRONG_LENGTH:
				    $_SESSION['registration_error']='Hasło musi posiadać od 8 do 20 znaków!';
				    break;
				case BOT_ALERT:
				    $_SESSION['registration_error']='Potwierdź, że nie jesteś botem!';
				    break;
				case ALREADY_EXISTS:
				    $_SESSION['registration_error']='Istnieje już konto o takim loginie!';
				    break;
				case ACTION_FAILED:
				    $_SESSION['registration_error']='Obecnie rejestracja nie jest możliwa.';
				    break;
				case SERVER_ERROR:
				default:
				    $_SESSION['registration_error']='Błąd serwera!';
			endswitch;
			header('Location:index.php?action=showRegistrationForm');       
            break;
        case 'addIncome' :
			switch($portal->checkIncomeForm()):
				case FORM_DATA_MISSING:
				    $_SESSION['warning']='Proszę wypełnić wymagane pola formularza!';
				    break;
				case ACTION_OK:
					switch($portal->saveIncome()):
						case ACTION_OK:
							$_SESSION['success']='Nowy wpis został zapisany!';
							break;
						case ACTION_FAILED:
							$_SESSION['warning']='Nie udało się zapisać';
							break;
						default:
							$_SESSION['warning']='Błąd serwera!';
					endswitch;
					break;
				case SERVER_ERROR:
				default:
					$_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
        case 'addExpense' :
			switch($portal->checkExpenseForm()):
				case FORM_DATA_MISSING:
				    $_SESSION['warning']='Proszę wypełnić wymagane pola formularza!';
				    break;
				case ACTION_OK:
					switch($portal->saveExpense()):
						case ACTION_OK:
							$_SESSION['success']='Nowy wpis został zapisany!';
							break;
						case ACTION_FAILED:
							$_SESSION['warning']='Nie udało się zapisać';
							break;
						default:
							$_SESSION['warning']='Błąd serwera!';
					endswitch;
					break;
				case SERVER_ERROR:
				default:
					$_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'chooseDate' :
			switch($portal->checkBalanceDate()):
				case FORM_DATA_MISSING:
				    $_SESSION['warning']='Proszę podać daty!';
				    break;
				case WRONG_ORDER:
				    $_SESSION['warning']='Proszę podać daty w odpowiedniej kolejności!';
				    break;
				case SAME_DATE:
				    $_SESSION['warning']='Daty nie mogą być takie same';
				    break;
				case ACTION_OK:
					header ('Location: index.php?action=showBalanceChoosenDate');
					return;
				case SERVER_ERROR:
				default:
					$_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'deleteIncome' :
			switch($portal->deleteIncome()):
				case ACTION_OK:
					$_SESSION['success'] = 'Wpis został usunięty';
					break;
				case SERVER_ERROR:
				default:
					$_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'deleteExpense' :
			switch($portal->deleteExpense()):
				case ACTION_OK:
					$_SESSION['success'] = 'Wpis został usunięty';
					break;
				case SERVER_ERROR:
				default:
					$_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'editIncome' :
			switch($portal->checkIncomeEditForm()):
				case ACTION_OK:
					switch($portal->saveEditedIncome()):
						case ACTION_OK:
							$_SESSION['success']='Zmiany zostały zapisane!';
							break;
						case ACTION_FAILED:
							$_SESSION['warning']='Nie udało się zapisać';
							break;
						default:
							$_SESSION['warning']='Błąd serwera!';
					endswitch;
					break;
				case FORM_DATA_MISSING:
					$_SESSION['warning'] = 'Nie wprowadzono żadnych zmian w formularzu.';
					break;
				case ACTION_FAILED:
					$_SESSION['warning'] = 'Kwota nie może być ujemna!';
					break;
				case SERVER_ERROR:
				default:
					$_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'editExpense' :
			switch($portal->checkExpenseEditForm()):
				case ACTION_OK:
					switch($portal->saveEditedExpense()):
						case ACTION_OK:
							$_SESSION['success']='Zmiany zostały zapisane!';
							break;
						case ACTION_FAILED:
							$_SESSION['warning']='Nie udało się zapisać';
							break;
						default:
							$_SESSION['warning']='Błąd serwera!';
					endswitch;
					break;
				case FORM_DATA_MISSING:
					$_SESSION['warning'] = 'Nie wprowadzono żadnych zmian w formularzu.';
					break;
				case ACTION_FAILED:
					$_SESSION['warning'] = 'Kwota nie może być ujemna!';
					break;
				case SERVER_ERROR:
				default:
					$_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'editExpenseCategory' :
			switch($portal->checkExpenseCategoryEditForm()):
				case ACTION_OK:
					switch($portal->saveEditedExpenseCategory()):
						case ACTION_OK:
							$_SESSION['success']='Zmiany zostały zapisane!';
							break;
						case ACTION_FAILED:
							$_SESSION['warning']='Nie udało się zapisać';
							break;
						default:
							$_SESSION['warning']='Błąd serwera!';
					endswitch;
					break;
				case FORM_DATA_MISSING:
					$_SESSION['warning'] = 'Musisz podać nową nazwę kategori.';
					break;
				case ALREADY_EXISTS:
					$_SESSION['warning'] = 'Taka kategoria już istnieje!';
					break;
				case WRONG_LENGTH:
					$_SESSION['warning'] = 'Nazwa musi mieć od 3 do 20 znaków!';
					break;
				case ACTION_FAILED:
					$_SESSION['warning'] = 'Musisz wybrać kategorię!';
					break;
				case SERVER_ERROR:
				default:
					$_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'editIncomeCategory' :
			switch($portal->checkIncomeCategoryEditForm()):
				case ACTION_OK:
					switch($portal->saveEditedIncomeCategory()):
						case ACTION_OK:
							$_SESSION['success']='Zmiany zostały zapisane!';
							break;
						case ACTION_FAILED:
							$_SESSION['warning']='Nie udało się zapisać';
							break;
						default:
							$_SESSION['warning']='Błąd serwera!';
					endswitch;
					break;
				case FORM_DATA_MISSING:
					$_SESSION['warning'] = 'Musisz podać nową nazwę kategori.';
					break;
				case ALREADY_EXISTS:
					$_SESSION['warning'] = 'Taka kategoria już istnieje!';
					break;
				case WRONG_LENGTH:
					$_SESSION['warning'] = 'Nazwa musi mieć od 3 do 20 znaków!';
					break;
				case ACTION_FAILED:
					$_SESSION['warning'] = 'Musisz wybrać kategorię!';
					break;
				case SERVER_ERROR:
				default:
					$_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'editPaymentCategory' :
			switch($portal->checkPaymentCategoryEditForm()):
				case ACTION_OK:
					switch($portal->saveEditedPaymentCategory()):
						case ACTION_OK:
							$_SESSION['success']='Zmiany zostały zapisane!';
							break;
						case ACTION_FAILED:
							$_SESSION['warning']='Nie udało się zapisać';
							break;
						default:
							$_SESSION['warning']='Błąd serwera!';
					endswitch;
					break;
				case FORM_DATA_MISSING:
					$_SESSION['warning'] = 'Musisz podać nową nazwę kategori.';
					break;
				case ALREADY_EXISTS:
					$_SESSION['warning'] = 'Taka kategoria już istnieje!';
					break;
				case WRONG_LENGTH:
					$_SESSION['warning'] = 'Nazwa musi mieć od 3 do 20 znaków!';
					break;
				case ACTION_FAILED:
					$_SESSION['warning'] = 'Musisz wybrać kategorię!';
					break;
				case SERVER_ERROR:
				default:
					$_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'addExpenseCategory' :
			switch($portal->checkNewExpenseCategoryForm()):
				case ACTION_OK:
					switch($portal->saveNewExpenseCategory()):
						case ACTION_OK:
							$_SESSION['success']='Zmiany zostały zapisane!';
							break;
						case ACTION_FAILED:
							$_SESSION['warning']='Nie udało się zapisać';
							break;
						default:
							$_SESSION['warning']='Błąd serwera!';
					endswitch;
					break;
				case FORM_DATA_MISSING:
					$_SESSION['warning'] = 'Musisz podać nową nazwę kategori.';
					break;
				case ALREADY_EXISTS:
					$_SESSION['warning'] = 'Taka kategoria już istnieje!';
					break;
				case WRONG_LENGTH:
					$_SESSION['warning'] = 'Nazwa musi mieć od 3 do 20 znaków!';
					break;
				case SERVER_ERROR:
				default:
					$_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'addIncomeCategory' :
			switch($portal->checkNewIncomeCategoryForm()):
				case ACTION_OK:
					switch($portal->saveNewIncomeCategory()):
						case ACTION_OK:
							$_SESSION['success']='Zmiany zostały zapisane!';
							break;
						case ACTION_FAILED:
							$_SESSION['warning']='Nie udało się zapisać';
							break;
						default:
							$_SESSION['warning']='Błąd serwera!';
					endswitch;
					break;
				case FORM_DATA_MISSING:
					$_SESSION['warning'] = 'Musisz podać nową nazwę kategori.';
					break;
				case ALREADY_EXISTS:
					$_SESSION['warning'] = 'Taka kategoria już istnieje!';
					break;
				case WRONG_LENGTH:
					$_SESSION['warning'] = 'Nazwa musi mieć od 3 do 20 znaków!';
					break;
				case SERVER_ERROR:
				default:
					$_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'addPaymentCategory' :
			switch($portal->checkNewPaymentCategoryForm()):
				case ACTION_OK:
					switch($portal->saveNewPaymentCategory()):
						case ACTION_OK:
							$_SESSION['success']='Zmiany zostały zapisane!';
							break;
						case ACTION_FAILED:
							$_SESSION['warning']='Nie udało się zapisać';
							break;
						default:
							$_SESSION['warning']='Błąd serwera!';
					endswitch;
					break;
				case FORM_DATA_MISSING:
					$_SESSION['warning'] = 'Musisz podać nową nazwę kategori.';
					break;
				case ALREADY_EXISTS:
					$_SESSION['warning'] = 'Taka kategoria już istnieje!';
					break;
				case WRONG_LENGTH:
					$_SESSION['warning'] = 'Nazwa musi mieć od 3 do 20 znaków!';
					break;
				case SERVER_ERROR:
				default:
					$_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'deleteExpenseCategory' :
			switch($portal->checkDeleteExpenseCategoryForm()):
				case ACTION_OK:
					switch($portal->deleteExpenseCategory()):
						case ACTION_OK:
							$_SESSION['success']='Zmiany zostały zapisane!';
							break;
						case ACTION_FAILED:
							$_SESSION['warning']='Nie udało się zapisać';
							break;
						default:
							$_SESSION['warning']='Błąd serwera!';
					endswitch;
					break;
				case ACTION_FAILED:
					$_SESSION['warning'] = 'Musisz wybrać kategorię.';
					break;
				case SERVER_ERROR:
				default:
					$_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'deleteIncomeCategory' :
			switch($portal->checkDeleteIncomeCategoryForm()):
				case ACTION_OK:
					switch($portal->deleteIncomeCategory()):
						case ACTION_OK:
							$_SESSION['success']='Zmiany zostały zapisane!';
							break;
						case ACTION_FAILED:
							$_SESSION['warning']='Nie udało się zapisać';
							break;
						default:
							$_SESSION['warning']='Błąd serwera!';
					endswitch;
					break;
				case ACTION_FAILED:
					$_SESSION['warning'] = 'Musisz wybrać kategorię.';
					break;
				case SERVER_ERROR:
				default:
					$_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'deletePaymentCategory' :
			switch($portal->checkDeletePaymentCategoryForm()):
				case ACTION_OK:
					switch($portal->deletePaymentCategory()):
						case ACTION_OK:
							$_SESSION['success']='Zmiany zostały zapisane!';
							break;
						case ACTION_FAILED:
							$_SESSION['warning']='Nie udało się zapisać';
							break;
						default:
							$_SESSION['warning']='Błąd serwera!';
					endswitch;
					break;
				case ACTION_FAILED:
					$_SESSION['warning'] = 'Musisz wybrać kategorię.';
					break;
				case SERVER_ERROR:
				default:
					$_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'changeUsername' :
			switch($portal->checkEditUsernameForm()):
				case ACTION_OK:
					switch($portal->saveNewUsername()):
						case ACTION_OK:
							$_SESSION['success']='Zmiany zostały zapisane!';
							break;
						case ACTION_FAILED:
							$_SESSION['warning']='Nie udało się zapisać';
							break;
						default:
							$_SESSION['warning']='Błąd serwera!';
					endswitch;
					break;
				case FORM_DATA_MISSING:
				    $_SESSION['warning']='Należy wpisać nową nazwę użytkownika!';
				    break;
				case WRONG_LENGTH:
				    $_SESSION['warning']='Login musi posiadać od 3 do 20 znaków!';
				    break;
				case WRONG_CHARACTERS:
				    $_SESSION['warning']='Login może się składać tylko z liter i cyfr (bez polskich znaków)!';
				    break;
				case ALREADY_EXISTS:
				    $_SESSION['warning']='Istnieje już konto o takim loginie!';
				    break;
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'changePassword' :
			switch($portal->checkEditPasswordForm()):
				case ACTION_OK:
					switch($portal->saveNewPassword()):
						case ACTION_OK:
							$_SESSION['success']='Zmiany zostały zapisane!';
							break;
						case ACTION_FAILED:
							$_SESSION['warning']='Nie udało się zapisać';
							break;
						default:
							$_SESSION['warning']='Błąd serwera!';
					endswitch;
					break;
				case FORM_DATA_MISSING:
				    $_SESSION['warning']='Należy wpisać stare i nowe hasło!';
				    break;
				case WRONG_LENGTH:
				    $_SESSION['warning']='Nowe hasło musi składać się z od 5 do 20 znaków!';
				    break;
				case ACTION_FAILED:
				    $_SESSION['warning']='Nie udało się zmienić hasła!';
				    break;
				case SERVER_ERROR:
				default:
				    $_SESSION['warning']='Błąd serwera!';
			endswitch;
			header($_SESSION['actionReturn']);
            break;
		case 'deleteUser' :
			switch($portal->deleteUser()):
				case ACTION_OK:
			        $portal->setMessage('Konto zostało usunięte.');
					header('Location:index.php?action=showMain');
					break;
				case ACTION_FAILED:
				    $_SESSION['warning']='Nie udało się usunąć użytkownika!';
					header($_SESSION['actionReturn']);
				    break;
				case SERVER_ERROR:
				default:
				    $_SESSION['warning']='Błąd serwera!';
					header($_SESSION['actionReturn']);
			endswitch;
			break;
        default:
            include 'templates/mainTemplate.php';
    }
}
catch(Exception $e){
  echo 'Błąd: ' . $e->getMessage();
  exit('Portal chwilowo niedostępny');
}


function classLoader($name){
  if(file_exists("class/$name.php")){
    require_once("class/$name.php");
  } else {
    throw new Exception("Brak pliku z definicją klasy.");
  }
}
?>
