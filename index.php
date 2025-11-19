<?php

    require __DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "functions.php";

    session_start();

    // query that powers the table 
    $join_row = records_all();
    
    // get the value of view from GET request, if null then use show all values
    $view = filter_input(INPUT_GET, 'view') ?: 'list';
    // get the action to be executed from the POST request
    $action = filter_input(INPUT_POST, 'action');

    // this runs if you are not logged and trying to access a page other than login or register
    // or trying to do an action other than login or register while not being logged in
    function require_login(): void{
        if(empty($_SESSION['user_id'])){
            header('Location: ?view=login');
            exit;
        }
    }

    $public_views = ['login', 'register'];
    $public_actions = ['login', 'register'];

    if($action && !in_array($action, $public_actions, true)){
        require_login();
    }

    if(!$action && !in_array($view, $public_views, true)){
        require_login();
    }

    switch($action){
        // the login block is checking input against data already in the database so that it can give you access to other pages
        // the register block is creating new information in the database after validation
        case 'login':
            $username = trim((string)($_POST['username'] ?? ''));
            $password = trim((string)($_POST['password'] ?? ''));

            //verify login information
            if($username && $password){
                $user = user_find_by_username($username);
                if($user && password_verify($password, $user['password_hash'])){
                    $_SESSION['user_id'] = (int)$user['id'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $view = 'list';
                } else {
                    $login_error = "Invalid username or password";
                    $view = 'login';
                }
            }
            break;
        
        case 'logout':
            //destroy the session and then restart it
            $_SESSION = [];
            session_destroy();
            session_start();
            $view = 'login';
            break;

        case 'register':
            // secure strings
            $username = trim((string)($_POST['username'] ?? ''));
            $full_name = trim((string)($_POST['full_name'] ?? ''));
            $password = trim((string)($_POST['password'] ?? ''));
            $confirm = trim((string)($_POST['confirm_password'] ?? ''));

            // validation
            if($username && $full_name && $password && $password === $confirm){
                $existing = user_find_by_username($username);
                //check to see if the username already exists
                if($existing){
                    $register_error = "That username already exists.";
                    $view = 'register';
                } else {
                    // create hashed password and add to user database
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    user_create($username, $fullname, $hash);

                    $user = user_find_by_username($username);
                    $_SESSION['user_id'] = (int) $user['id'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $view = 'list';
                }
            } else {
                $register_error = "Complete all fields and match passwords.";
                $view = 'register';
            }
            break;

        // the data stored in the cart is a collection of integers relating to keys in the records table
        case 'add_to_cart':
            require_login();
            $record_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            if($record_id){
                if(!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                $_SESSION['cart'][] = $record_id;
            }
            $view = 'list';
            break;

        // upon checkout, new purchases for each item in the cart are created and stored in the purchases table
        // then the cart is cleared
        case 'checkout':
            require_login();
            $cart_ids = $_SESSION['cart'] ?? [];

            if($cart_ids){
                foreach($cart_ids as $rid){
                    purchase_create((int)$_SESSION['user_id'], (int)$rid);
                }
                $_SESSION['cart'] = [];
            }
            $view = 'checkout_success';
            break;

        case "create":
            $title    = trim((string)(filter_input(INPUT_POST, 'title') ?? ''));
            $artist   = trim((string)(filter_input(INPUT_POST, 'artist') ?? ''));
            $price    = (float)(filter_input(INPUT_POST, 'price') ?? 0);
            $format_id = (int)(filter_input(INPUT_POST, 'format_id') ?? 0);

            if($title && $artist && $$format_id){
                record_insert($title, $artist, $price, $format_id);
                $view = "created";
            } else {
                $view = "create";
            }
            break;

        case "delete":
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            if($id){
                $deleted = record_delete($id);
            }
            $view = 'deleted';
            break;

        case "edit":
            $id = filter_input(INPUT_POST, 'record_id', FILTER_VALIDATE_INT);
            if($id){
                $record = record_get($id);
            }
            $view = "create";
            break;

        case "update":
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $title = (string) filter_input(INPUT_POST, 'title', FILTER_UNSAFE_RAW);
            $artist = (string) filter_input(INPUT_POST, 'artist', FILTER_UNSAFE_RAW);
            $price_in = filter_input(INPUT_POST, 'price', FILTER_UNSAFE_RAW);
            $format_id = filter_input(INPUT_POST, 'format_id', FILTER_UNSAFE_RAW);

            $price = is_numeric($price_in) ? (float)$price_in : null;

            if($id && $title != '' && $author !== '' && $price !== null && $format_id){
                record_update($id, $title, $author, $price, (int)$format_id);
            }
            $view = 'updated';
            break;
        // end switch
        if($view === 'cart'){
            $cart_ids = $_SESSION['cart'] ?? [];
            $records_in_cart = records_by_ids($cart_ids);
        }
    }
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <link href="starter_files/assets/styles.css" rel="stylesheet">
</head>

<body>

    <!-- include the navbar at the top of the page -->
    <?php include __DIR__ . "/starter_files/components/nav.php"?>

    <?php
        if($view === 'login')                    include __DIR__ . 'partials/login_form.php';
        elseif ($view === 'register')            include __DIR__ . '/partials/register_form.php';
        elseif ($view === 'cart')                include __DIR__ . '/partials/cart.php';
        elseif ($view === 'checkout_success')    include __DIR__ . '/partials/checkout_success.php';
        elseif ($view === 'list')                include __DIR__ . '/partials/record-list.php';
        elseif ($view === 'create')              include __DIR__ . '/partials/record-form.php';
        elseif ($view === 'created')             include __DIR__ . '/partials/record-created.php';
        elseif ($view === 'updated')             include __DIR__ . '/partials/record-updated.php';
        elseif ($view === 'deleted')             include __DIR__ . '/partials/record-deleted.php';
        else                                     include __DIR__ . '/partials/record-list.php'; // default

    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>