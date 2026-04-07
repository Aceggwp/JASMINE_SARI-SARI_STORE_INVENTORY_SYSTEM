<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between mb-3">
    <h2>Categories</h2>
    <a href="<?= base_url('/categories/create') ?>" class="btn btn-primary">Add Category</a>
</div>

<table class="table table-bordered datatable">
    <thead>
        <tr><th>ID</th><th>Name</th><th>Description</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
        <?php foreach($categories as $category): ?>
        <tr>
            <td><?= $category['id'] ?></td>
            <td><?= $category['name'] ?></td>
            <td><?= $category['description'] ?></td>
            <td><?= $category['status'] ? 'Active' : 'Inactive' ?></td>
            <td>
                <a href="<?= base_url('/categories/edit/'.$category['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?= base_url('/categories/delete/'.$category['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>