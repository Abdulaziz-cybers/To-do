<?php
var_dump($_POST);
if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])){
    var_dump(1);
    if($_POST['password'] !== $_POST['confirm_password']){
        $_SESSION['error'] = 'Passwords do not match';
        header('Location: /register');
        exit();
    }
    $lastUserId = (new App\Users())->register($_POST['name'],$_POST['email'],$_POST['password']);
    if($lastUserId){
        unset($_SESSION['error']);
        header('Location: /todos');
        exit();
    }
    $_SESSION['error'] = 'Email already exists';
    header('Location: /register');
}