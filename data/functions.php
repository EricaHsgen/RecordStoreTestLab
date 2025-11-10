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
            SELECT records.id as record_id, title, artist, price, name FROM records JOIN formats ON formats.id = records.format_id; 
        ");
        $stmt -> execute();
        return $stmt -> fetchAll();
    }

    function record_insert($title, $artist, $price, $format_id){
        // TEMPORARY VALUES
        // $title = "To Kill a Living Book";
        // $artist = "Mili";
        // $price = 15.00;
        // $format_id = 1; 

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
        // echo("Insert success: true, rows: 1");
    }

    function record_get(int $id): ?array{
        $pdo = get_pdo();
        $stmt = $pdo -> prepare("
            SELECT records.id, title, artist, price, name, formats.id FROM records 
            JOIN formats ON formats.id = records.format_id
            WHERE records.id = :id
            LIMIT 1 
        ");
        $stmt -> execute([':id' => $id]);
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    function record_update(int $id, string $title, string $artist, float $price, int $format_id): int{
        $pdo = get_pdo();
        $stmt = $pdo -> prepare("
            UPDATE records
                SET title = :title,
                    artist = :artist,
                    price = :price,
                    format_id = :format_id
                WHERE id = :id
        ");
        $stmt -> execute([
            ':title' => $title,
            ':artist' => $artist,
            ':price' => $price,
            ':format_id' => $format_id,
            ':id' => $id
        ]);
        return $stmt -> rowCount();
    }

    function record_delete(int $id): int{
        $pdo = get_pdo();

        $stmt = $pdo -> prepare("
            DELETE FROM records WHERE id = :id
        ");
        $stmt -> execute([":id" => $id]);
        return $stmt -> rowCount();
    }
?>