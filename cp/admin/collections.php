<?php
$pageTitle = 'Collections | DIOR Admin';
include __DIR__ . '/template/header.php';
$collections = getAllCollections();
$collection = [];
?>
<div class="main-panel">
  <div class="content-wrapper">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Add a collection</h4>
        <?php include __DIR__ . '/template/collection_form.php'; ?>
      </div>
    </div>

    <div class="card mt-4">
      <div class="card-body">
        <h4 class="card-title">Collections</h4>
        <div class="table-responsive">
          <table id="tableID" class="uk-table uk-table-hover uk-table-striped" style="width:100%">
            <thead>
              <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Limited Edition</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($collections as $item): ?>
                <tr>
                  <td><?= (int) $item['collectionID'] ?></td>
                  <td><img src="../upload/<?= e($item['colImage']) ?>" alt="<?= e($item['colName']) ?>" width="60" height="60"></td>
                  <td><?= e($item['colName']) ?></td>
                  <td><?= e($item['colDescription']) ?></td>
                  <td><?= $item['limitedEdition'] ? 'Yes' : 'No' ?></td>
                  <td><a class="btn btn-primary" href="editCollection.php?id=<?= (int) $item['collectionID'] ?>">Edit</a></td>
                  <td>
                    <form action="adminCode.php" method="POST" data-confirm="Delete this collection AND all of its products?">
                      <input type="hidden" name="collectionID" value="<?= (int) $item['collectionID'] ?>">
                      <button type="submit" name="deleteColBtn" class="btn btn-danger">Delete</button>
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
