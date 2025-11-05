<?php
    // xss defense
    function esc_html(string $s): string {
        return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    }
?>

<!-- <h1> UNIT TEST 1 - FORMATS </h2>

<table>
    <thead>
        <th>ID</th>
        <th>Name</th>
    </thead>
    <tbody>
        <?php foreach($format_rows as $r): ?>
            <tr>
                <td><?= esc_html($r['id']) ?></td>
                <td><?= esc_html($r['name']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table> -->

<!-- <h1>UNIT TEST 2 - RECORDS JOIN</h1> -->
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
                <td><?= esc_html($r['title']) ?></td>
                <td><?= esc_html($r['artist']) ?></td>
                <td><?= esc_html($r['price']) ?></td>
                <td><?= esc_html($r['name']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- the insertion works you just have to refresh the page for it to update -->
<!-- <h1>UNIT TEST 3 - INSERT</h1> 
[record insert function here]
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
</table> -->
