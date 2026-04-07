<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<h2><?= isset($category) ? 'Edit' : 'Add' ?> Category</h2>

<form action="<?= isset($category) ? base_url('/categories/update/'.$category['id']) : base_url('/categories/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $category['name'] ?? '' ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"><?= $category['description'] ?? '' ?></textarea>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-control" id="status" name="status">
            <option value="1" <?= (isset($category) && $category['status'] == 1) ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= (isset($category) && $category['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="<?= base_url('/categories') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>