
<?php 
    // require __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "functions.php";
    $formats = formats_all();
?>

<!-- NOTE: ENSURE FORM METHOD IS SET TO POST AND THAT ALL FIELDS HAVE NAMES -->

<form method="POST">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control" name="title" required>

    <label for="artist" class="form-label">Artist</label>
    <input type="text" class="form-control" name="artist" required>

    <label for="price" class="form-label">Price</label>
    <input name="price" type="number" step="0.01" class="form-control" id="price" required>

    <br>

    <select name="format_id" class="form-select" required>
        <option value="" default> Select a Format </option>
        <?php foreach ($formats as $f): ?>
            <option value="<?= (int)$f['id'] ?>"><?= htmlspecialchars($f['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <br>

    <input type="hidden" name="action" value="create">

    <button class="btn btn-primary">Submit</button>
</form>