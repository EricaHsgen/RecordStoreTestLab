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

    function user_create(string $username, string $full_name, string $hash): void{
        $pdo = get_pdo();
        
        $stmt = $pdo -> prepare("
            INSERT INTO users (username, full_name, password_hash)
            VALUES (:u, :f, :p)
        ");
        $stmt -> execute([
            ':u' => $username,
            ':f' => $full_name,
            ':p' => $hash
        ]);
    }

    function user_find_by_username(string $username): ?array {
        $pdo = get_pdo();

        $stmt = $pdo -> prepare("
            SELECT * FROM users WHERE username = :u
        ");
        $stmt -> execute([':u' => $username]);

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    function records_by_ids(array $ids): array {
        if(empty($ids)) return [];

        $pdo = get_pdo();
        // creating a string from an array (implode()) using array_fill with a comma as the separator.
        // array_fill creates an array using a starting index of 0 with the length of the length of $ids
        $ph = implode(',', array_fill(0, count($ids), '?'));
        // what does ph stand for in this case?

        $stmt = $pdo -> prepare("
            SELECT r.id, r.title, r.artist, r.price, f.name
            FROM records r
            JOIN formats f ON r.format_id = f.id
            WHERE r.id IN ($ph) 
        "); 
        // ↑ is it okay to use variables directly in this case if it's not data being put in a database?
        // since $ph is just being used as criteria to search by?

        $stmt -> execute($ids);
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    function purchase_create(int $user_id, int $record_id){
        $pdo = get_pdo();

        $stmt = $pdo -> prepare("
            INSERT INTO purchases (user_id, record_id, purchase_date)
            VALUES(:u, :r, NOW())
        ");
        $stmt -> execute([
            ':u' => $user_id,
            ':r' => $record_id
        ]);
    }
?>