<?php
if (!function_exists('e')) { http_response_code(404); exit; } // only usable when included by a page
/*
 * Shared product form for products.php (add) and editProduct.php (edit).
 * Expects $product (array, empty when adding) and $collections.
 */
$isEdit = !empty($product['p_id']);
$value = fn ($key) => e($product[$key] ?? '');
?>
<form class="form-sample" action="adminCode.php" method="POST" enctype="multipart/form-data">
  <?php if ($isEdit): ?>
    <input type="hidden" name="productID" value="<?= (int) $product['p_id'] ?>">
  <?php endif; ?>
  <div class="row">
    <div class="col-md-6 form-group">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" value="<?= $value('p_name') ?>" maxlength="100" class="form-control" required>
    </div>
    <div class="col-md-6 form-group">
      <label for="price">Price ($)</label>
      <input type="number" id="price" name="price" value="<?= $value('p_price') ?>" min="0" step="0.01" class="form-control" required>
    </div>
    <div class="col-md-6 form-group">
      <label for="collectionID">Collection</label>
      <select id="collectionID" name="collectionID" class="form-control" required>
        <option value="">Select a collection</option>
        <?php foreach ($collections as $col): ?>
          <option value="<?= (int) $col['collectionID'] ?>" <?= (int) ($product['collectionID'] ?? 0) === (int) $col['collectionID'] ? 'selected' : '' ?>>
            <?= e($col['colName']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-6 form-group">
      <label for="size">Size</label>
      <input type="text" id="size" name="size" value="<?= $value('p_size') ?>" placeholder="e.g. 100ml" class="form-control" required>
    </div>
    <div class="col-md-6 form-group">
      <label for="stockqty">Stock quantity</label>
      <input type="number" id="stockqty" name="stockqty" value="<?= $value('p_stock') ?>" min="0" step="1" class="form-control" required>
    </div>
    <div class="col-md-6 form-group">
      <label for="note">Fragrance note</label>
      <input type="text" id="note" name="note" value="<?= $value('p_note') ?>" class="form-control" required>
    </div>
    <div class="col-md-6 form-group">
      <label for="productionDate">Production date</label>
      <input type="date" id="productionDate" name="productionDate" value="<?= $value('p_productionDate') ?>" class="form-control">
    </div>
    <div class="col-md-6 form-group">
      <label for="expirationDate">Expiry date</label>
      <input type="date" id="expirationDate" name="expirationDate" value="<?= $value('p_expirationDate') ?>" class="form-control">
    </div>
  </div>
  <div class="form-group">
    <label for="ingredients">Ingredients</label>
    <input type="text" id="ingredients" name="ingredients" value="<?= $value('p_ingredients') ?>" class="form-control" required>
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <textarea id="description" class="form-control" name="description" rows="4"><?= $value('p_description') ?></textarea>
  </div>
  <div class="form-group">
    <label for="file-upload">Image (JPG, PNG, GIF or WEBP)</label>
    <input id="file-upload" class="form-control" type="file" name="image" accept="image/*" <?= $isEdit ? '' : 'required' ?>>
    <?php if ($isEdit && $product['p_image']): ?>
      <p class="mt-2 mb-0">Current image:</p>
      <img src="../upload/<?= $value('p_image') ?>" height="60" width="60" alt="<?= $value('p_name') ?>">
    <?php endif; ?>
  </div>
  <button type="submit" name="<?= $isEdit ? 'updateProduct' : 'addProduct' ?>" class="btn btn-primary mr-2"><?= $isEdit ? 'Update' : 'Add' ?></button>
  <?php if ($isEdit): ?>
    <a href="products.php" class="btn btn-secondary">Back to products</a>
  <?php endif; ?>
</form>
