<?php

    require __DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "functions.php";

    // query that powers the table 
    $join_row = records_all();
    
    // get the value of view from GET request, if null then use show all values
    $view = filter_input(INPUT_GET, 'view') ?: 'list';
    // get the action to be executed from the POST request
    $action = filter_input(INPUT_POST, 'action');

    switch($action){
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
        if ($view === 'list')        include __DIR__ . '/partials/record-list.php';
        elseif ($view === 'create')  include __DIR__ . '/partials/record-form.php';
        elseif ($view === 'created') include __DIR__ . '/partials/record-created.php';
        elseif ($view === 'updated') include __DIR__ . '/partials/record-updated.php';
        elseif ($view === 'deleted') include __DIR__ . '/partials/record-deleted.php';
        else                         include __DIR__ . '/partials/record-list.php'; // default

    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>