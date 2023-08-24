<?php

require_once __DIR__ . '/../php/db.php';
session_start();

$errors = [];
$loggedUser = null;

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Validation
    if(empty($email) || empty($password)) {
        return $errors[] = 'Fill all fields';
    }

    //Check does user exists
    $sql = "SELECT email, password_hash FROM organizers WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        //Verify password
        if(password_verify($password, $user['password_hash'])) {
            //Login ok!
            
            $_SESSION['login'] = $user['email'];
            header('location: /events');
        } else {
            return $errors[] = 'Email or password not correct';
        }
    } else {
        return $errors[] = 'Invalid credentials';
    }
}

function check_login() {
    global $conn;

    if(isset($_SESSION['login'])) {
        $token = $_SESSION['login'];

        $sql = "SELECT name, email, slug, id FROM organizers WHERE email='$token'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            $loggedUser = mysqli_fetch_assoc($result);
            return $loggedUser;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

if(isset($_GET['logout'])) {
    $loggedUser = null;
    session_destroy();
}