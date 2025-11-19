<h2>Your Cart</h2>


<!-- records in cart comes from index on line 169 -->
<!-- we need these because it is what will populate the view of our cart -->
<?php $records = $records_in_cart ?? []; ?>

<?php if (empty($records)): ?>
  <p>Your cart is empty.</p>
<?php else: ?>

  <table class="table">
    <thead>
      <tr>
        <th>Title</th>
        <th>Artist</th>
        <th>Format</th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($records as $row): ?>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <form method="post">
    <input type="hidden" name="action" value="checkout">
    <button class="btn btn-success">Complete Purchase</button>
  </form>

<?php endif; ?>