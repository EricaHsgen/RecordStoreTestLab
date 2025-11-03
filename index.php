<?php
    require __DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "functions.php";


    $format_rows = formats_all();
    $join_row = records_all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Store</title>

    <style>
        th{
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1> UNIT TEST 1 - FORMATS </h2>

    <table>
        <thead>
            <th>ID</th>
            <th>Name</th>
        </thead>
        <tbody>
            <?php foreach($format_rows as $r): ?>
                <tr>
                    <td><?= $r['id'] ?></td>
                    <td><?= $r['name'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h1>UNIT TEST 2 - RECORDS JOIN</h1>
    <table>
        <thead>
            <th>Title</th>
            <th>Artist</th>
            <th>Price</th>
            <th>Format</th>
        </thead>
        <tbody>
            <?php foreach($join_row as $r): ?>
                <tr>
                    <td><?= $r['title'] ?></td>
                    <td><?= $r['artist'] ?></td>
                    <td><?= $r['price'] ?></td>
                    <td><?= $r['name'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- the insertion works you just have to refresh the page for it to update -->
    <h1>UNIT TEST 3 - INSERT</h1>
    <?php record_insert() ?>
    <table>
        <thead>
            <th>Title</th>
            <th>Artist</th>
            <th>Price</th>
            <th>Format</th>
        </thead>
        <tbody>
            <?php foreach($join_row as $r): ?>
                <tr>
                    <td><?= $r['title'] ?></td>
                    <td><?= $r['artist'] ?></td>
                    <td><?= $r['price'] ?></td>
                    <td><?= $r['name'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>