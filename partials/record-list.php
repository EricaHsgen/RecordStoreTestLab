<?php
    // xss defense
    function esc_html(string $s): string {
        return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    }
?>

<!-- <h1>UNIT TEST 2 - RECORDS JOIN</h1> -->
<table>
    <thead>
        <th>ID</th>
        <th>Title</th>
        <th>Artist</th>
        <th>Price</th>
        <th>Format</th>
    </thead>
    <tbody>
        <?php foreach($join_row as $r): ?>
            <tr>
                <td><?= (int)$r['record_id'] ?></td>
                <td><?= esc_html($r['title']) ?></td>
                <td><?= esc_html($r['artist']) ?></td>
                <!-- Display price in a decimal format -->
                <td class ="text-end">$<?= number_format((float)esc_html($r['price']), 2) ?></td>
                <td><?= esc_html($r['name']) ?></td>
                <!-- create update and delete buttons per row -->
                 <td>
                    <form method="post" class="d-inline">
                        <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                        <input type="hidden" name="action" value="edit">
                        <button class="btn btn-sm btn-outline-primary">Edit</button>
                    </form>
                    <form method="post" class="d-inline" onsubmit="return confirm('Delete this book?');">
                        <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                        <input type="hidden" name="action" value="delete">
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                 </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>