<?php

    require __DIR__ . DIRECTORY_SEPARATOR . "db.php";

    function formats_all(){
        // Return an array id and name from formats, ordered by name
        $pdo = get_pdo();

        $stmt = $pdo -> prepare("
            SELECT * FROM formats ORDER BY name; 
        ");
        $stmt -> execute();
        return $stmt -> fetchAll();
    }

    function records_all(){
        $pdo = get_pdo();

        $stmt = $pdo -> prepare("
            SELECT title, artist, price, name FROM records JOIN formats ON formats.id = records.format_id; 
        ");
        $stmt -> execute();
        return $stmt -> fetchAll();
    }

    function record_insert(){
        // TEMPORARY VALUES
        $title = "To Kill a Living Book";
        $artist = "Mili";
        $price = 15.00;
        $format_id = 1; 

        $pdo = get_pdo();

        $stmt = $pdo -> prepare("
            INSERT INTO records (title, artist, price, format_id)
            VALUES (:title, :artist, :price, :format_id)
        ");
        $stmt -> execute([
        ':title'    => $title,
        ':artist'   => $artist,
        ':price'    => $price,
        ':format_id' => $format_id
        ]);
        echo("Insert success: true, rows: 1");
    }
?>