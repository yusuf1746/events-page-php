<?php declare(strict_types=1);

namespace App\Controller;

session_start();

unset($_SESSION['userName']);
$_SESSION['loggedIn'] = false;
session_regenerate_id();

header('Location: index.php');
exit;