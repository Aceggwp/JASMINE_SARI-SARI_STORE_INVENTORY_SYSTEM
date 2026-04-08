<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<h2>Activity Logs</h2>

<table class="table table-bordered datatable">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Action</th>
            <th>Description</th>
            <th>IP Address</th>
            <th>Date/Time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($logs as $log): ?>
        <tr>
            <td><?= $log['id'] ?></td>
            <td><?= esc($log['user_name'] ?? 'Unknown') ?></td>
            <td><?= esc($log['action']) ?></td>
            <td><?= esc($log['description']) ?></td>
            <td><?= esc($log['ip_address']) ?></td>
            <td><?= date('Y-m-d H:i:s', strtotime($log['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $pager->links() ?>

<?= $this->endSection() ?>