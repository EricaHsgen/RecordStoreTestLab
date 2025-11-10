
<?php 
    $is_edit = isset($record) && isset($record['record_id']);
    $action = $is_edit? 'update' : 'create';

    $title    = $is_edit ? htmlspecialchars($record['title'])  : '';
    $artist   = $is_edit ? htmlspecialchars($record['artist']) : '';
    $price    = $is_edit ? htmlspecialchars($record['price'])  : '';
    $format_id = $is_edit ? (int)$record['format_id']          : 0;

    $formats = formats_all();
?>

<h2> <?= $is_edit ? 'Edit Record' : 'Add Record' ?></h2>

<!-- NOTE: ENSURE FORM METHOD IS SET TO POST AND THAT ALL FIELDS HAVE NAMES -->

<form method="POST">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control" name="title" value="<?= $title ?>" required>

    <label for="artist" class="form-label">Artist</label>
    <input type="text" class="form-control" name="artist" value="<?= $artist ?>" required>

    <label for="price" class="form-label">Price</label>
    <input name="price" type="number" step="0.01" class="form-control" id="price" value="<?= $price ?>" required>

    <br>

    <select name="format_id" class="form-select" required>
        <option value="" default> Select a Format </option>
        <?php foreach ($formats as $f): ?>
            <option value="<?= (int)$f['id'] ?>" <?= $fid === $format_id ? 'selected' : '' ?> ><?= htmlspecialchars($f['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <br>

    <input type="hidden" name="action" value="<?= $action ?>">
    <?php if($is_edit): ?>
        <input type="hidden" name="id" value="<?= (int)$record['id'] ?>">
    <?php endif; ?>
    <button class="btn btn-primary"> <?= $is_edit ? 'Update' : 'Create' ?> </button>
</form>