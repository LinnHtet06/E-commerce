<?php
$pageTitle = 'Products | DIOR Admin';
include __DIR__ . '/template/header.php';
$collections = getAllCollections();
$products = getAllProducts();
$product = [];
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Add a product</h4>
        <?php if (!$collections): ?>
          <p>Create a <a href="collections.php">collection</a> first, then add products to it.</p>
        <?php else: ?>
          <?php include __DIR__ . '/template/product_form.php'; ?>
        <?php endif; ?>
      </div>
    </div>

    <div class="card mt-4">
      <div class="card-body">
        <h4 class="card-title">Products</h4>
        <div class="table-responsive">
          <table id="tableID" class="uk-table uk-table-hover uk-table-striped" style="width:100%">
            <thead>
              <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Collection</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Size</th>
                <th>Note</th>
                <th>Production</th>
                <th>Expiry</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $item): ?>
                <tr>
                  <td><?= (int) $item['p_id'] ?></td>
                  <td><img src="../upload/<?= e($item['p_image']) ?>" alt="<?= e($item['p_name']) ?>" width="60" height="60"></td>
                  <td><?= e($item['p_name']) ?></td>
                  <td><?= e($item['colName']) ?></td>
                  <td>$<?= money($item['p_price']) ?></td>
                  <td class="<?= $item['p_stock'] <= 0 ? 'text-danger' : '' ?>"><?= $item['p_stock'] <= 0 ? 'Out of stock' : (int) $item['p_stock'] ?></td>
                  <td><?= e($item['p_size']) ?></td>
                  <td><?= e($item['p_note']) ?></td>
                  <td><?= e($item['p_productionDate']) ?></td>
                  <td><?= e($item['p_expirationDate']) ?></td>
                  <td><a class="btn btn-primary" href="editProduct.php?id=<?= (int) $item['p_id'] ?>">Edit</a></td>
                  <td>
                    <form action="adminCode.php" method="POST" data-confirm="Delete this product?">
                      <input type="hidden" name="productID" value="<?= (int) $item['p_id'] ?>">
                      <button type="submit" name="deleteProduct" class="btn btn-danger">Delete</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/template/footer.php'; ?>
