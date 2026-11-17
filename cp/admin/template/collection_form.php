<?php
if (!function_exists('e')) { http_response_code(404); exit; } // only usable when included by a page
/*
 * Shared collection form for collections.php (add) and editCollection.php (edit).
 * Expects $collection (array, empty when adding).
 */
$isEdit = !empty($collection['collectionID']);
?>
<form class="form-sample" action="adminCode.php" method="POST" enctype="multipart/form-data">
  <?php if ($isEdit): ?>
    <input type="hidden" name="colID" value="<?= (int) $collection['collectionID'] ?>">
  <?php endif; ?>
  <div class="row">
    <div class="col-md-6 form-group">
      <label for="colName">Name</label>
      <input type="text" id="colName" name="colName" value="<?= e($collection['colName'] ?? '') ?>" class="form-control" placeholder="e.g. Men" required>
    </div>
    <div class="col-md-6 form-group d-flex align-items-end">
      <div class="form-check">
        <label class="form-check-label">
          <input type="checkbox" class="form-check-input" name="Lte" value="1" <?= !empty($collection['limitedEdition']) ? 'checked' : '' ?>>
          Limited Edition <i class="input-helper"></i>
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label for="colDescription">Description</label>
    <textarea id="colDescription" class="form-control" name="colDescription" rows="4"><?= e($collection['colDescription'] ?? '') ?></textarea>
  </div>
  <div class="form-group">
    <label for="file-upload">Image (JPG, PNG, GIF or WEBP)</label>
    <input id="file-upload" class="form-control" type="file" name="image" accept="image/*" <?= $isEdit ? '' : 'required' ?>>
    <?php if ($isEdit && $collection['colImage']): ?>
      <p class="mt-2 mb-0">Current image:</p>
      <img src="../upload/<?= e($collection['colImage']) ?>" height="60" width="60" alt="<?= e($collection['colName']) ?>">
    <?php endif; ?>
  </div>
  <button type="submit" name="<?= $isEdit ? 'editCollection' : 'addCollection' ?>" class="btn btn-primary mr-2"><?= $isEdit ? 'Update' : 'Add' ?></button>
  <?php if ($isEdit): ?>
    <a href="collections.php" class="btn btn-secondary">Back to collections</a>
  <?php endif; ?>
</form>
