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
            
            record_insert($title, $artist, $price, $format_id);
            $view = "created";
    }
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link href="starter_files/assets/styles.css" rel="stylesheet">
</head>

<body>

    <!-- include the navbar at the top of the page -->
    <?php include __DIR__ . "/starter_files/components/nav.php"?>

    <?php
        if ($view === 'list')        include __DIR__ . '/partials/record-list.php';
        elseif ($view === 'create')  include __DIR__ . '/partials/record-form.php';
        elseif ($view === 'created') include __DIR__ . '/partials/record-created.php';
    ?>
</body>
</html>