<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between mb-3">
    <h2>Users</h2>
    <a href="<?= base_url('/users/create') ?>" class="btn btn-primary">Add User</a>
</div>

<table class="table table-bordered datatable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= esc($user['username']) ?></td>
            <td><?= esc($user['full_name']) ?></td>
            <td><?= esc($user['email']) ?></td>
            <td><?= ucfirst($user['role']) ?></td>
            <td><?= $user['is_active'] ? 'Active' : 'Inactive' ?></td>
            <td>
                <a href="<?= base_url('/users/edit/'.$user['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                <?php if($user['id'] != session()->get('user_id')): ?>
                <a href="<?= base_url('/users/delete/'.$user['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</a>
                <?php endif; ?>
             </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>