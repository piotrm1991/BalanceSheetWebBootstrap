<?php
class Registration
{
    private $dbo = null;
    private $fields = array();
  
    function __construct($dbo)
    {
        $this -> dbo = $dbo;
        $this -> initFields();
    }
  
    function initFields()
    {
        $this -> fields['username'] = new FormInput('username', 'Login', 'Nazwa użytkownika', 'glyphicon glyphicon-user');
        $this -> fields['password'] = new FormInput('password', 'Hasło', 'Hasło', 'glyphicon glyphicon-lock', '', 'password');
        $this -> fields['password2'] = new FormInput('password2', 'Powtórz hasło', 'Powtórz hasło', 'glyphicon glyphicon-lock', '', 'password');
    }
  
    function showRegistrationForm()
    {
        foreach ($this->fields as $name => $field) {
            $field -> value = isset($_SESSION['formData'][$name]) ? $_SESSION['formData'][$name] : '';
        }
        $formData = $this -> fields;
        if (isset($_SESSION['formData'])) {
            unset($_SESSION['formData']);
        }
        include 'templates/registrationForm.php'; 
    }
  
    function registerUser()
    {
        foreach ($this->fields as $name => $val) {
            if (!isset($_POST[$name])) {
                return FORM_DATA_MISSING;
            }
        }
    
        $fieldsFromForm = array();
        $emptyFieldDetected = false;
        foreach ($this->fields as $name => $val) {
            if ($val->type != 'password') {
                $fieldsFromForm[$name] = filter_input(INPUT_POST, $name, 
                FILTER_SANITIZE_SPECIAL_CHARS);
                $fieldsFromForm[$name] = ltrim($fieldsFromForm[$name]);
                $fieldsFromForm[$name] = rtrim($fieldsFromForm[$name]);
            } else {
                $fieldsFromForm[$name] = $_POST[$name];
            }
            if ($fieldsFromForm[$name] == '' && $val->required) {
                $emptyFieldDetected = true;
            }
        }

        if ($emptyFieldDetected) {
            unset($fieldsFromForm['password']);
            unset($fieldsFromForm['password2']);
            $_SESSION['formData'] = $fieldsFromForm;
            return FORM_DATA_MISSING;
        }

        $usernameQueryCount = $this->dbo->prepareQueryUsers($fieldsFromForm['username']);
        if ($this->dbo->checkIfUsernameExist($usernameQueryCount) > 0) {
            unset($fieldsFromForm['password']);
            unset($fieldsFromForm['password2']);
            $_SESSION['formData'] = $fieldsFromForm;
            return ALREADY_EXISTS;
        }

        if (strlen($fieldsFromForm['username'])<3 || strlen($fieldsFromForm['username'])>20) {
            unset($fieldsFromForm['password']);
            unset($fieldsFromForm['password2']);
            $_SESSION['formData'] = $fieldsFromForm;
            return WRONG_LENGTH;
        }

        if (ctype_alnum($fieldsFromForm['username']) == false) {
            unset($fieldsFromForm['password']);
            unset($fieldsFromForm['password2']);
            $_SESSION['formData'] = $fieldsFromForm;
            return WRONG_CHARACTERS;
        }
		
        if (strlen($fieldsFromForm['password'])<5 || strlen($fieldsFromForm['password'])>20) {
            unset($fieldsFromForm['password']);
            unset($fieldsFromForm['password2']);
            $_SESSION['formData'] = $fieldsFromForm;
            return WRONG_LENGTH;
        }

        if ($fieldsFromForm['password'] != $fieldsFromForm['password2']) {
            unset($fieldsFromForm['password']);
            unset($fieldsFromForm['password2']);
            $_SESSION['formData'] = $fieldsFromForm;
            return PASSWORDS_DO_NOT_MATCH;
        }

        $secretKey = "6LeaGXYUAAAAAGiLBmz1I6IgXg3o-OeWbPU-TpkB";
        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']);	
        $answer = json_decode($check);
        if ($answer->success==false) {
            unset($fieldsFromForm['password']);
            unset($fieldsFromForm['password2']);
            $_SESSION['formData'] = $fieldsFromForm;
            return BOT_ALERT;
        }

        unset($fieldsFromForm['password2']);
        unset($this -> fields['password2']);



        $fieldsFromForm['password'] = password_hash($fieldsFromForm['password'], PASSWORD_DEFAULT);

        $queriesNewUser = $this -> dbo -> prepareNewUserQueries($fieldsFromForm['username'], $fieldsFromForm['password']);
        $QUERIES_OK = $this -> dbo -> executeNewUserQueries($queriesNewUser);

        if ($QUERIES_OK) {
            return ACTION_OK;
        } else {
            unset($fieldsFromForm['password']);
            $_SESSION['formData'] = $fieldsFromForm;
            return ACTION_FAILED;
        }
    }
}