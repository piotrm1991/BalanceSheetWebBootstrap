<?php

session_start();

unset($_SESSION['logged_id']);
unset($_SESSION['logged_login']);
header('Location: index.php');