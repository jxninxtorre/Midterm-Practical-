<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Customers</h2>
    <a href="<?= site_url('customers/new') ?>" class="btn btn-kawaii">Add Customer</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Added</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($customers)): ?>
                <tr><td colspan="6" class="text-center py-4">No customers yet. Click "Add Customer" to create one.</td></tr>
            <?php endif; ?>

            <?php foreach ($customers as $c): ?>
                <tr>
                    <td><?= (int) $c['id'] ?></td>
                    <td><?= esc($c['full_name']) ?></td>
                    <td><?= esc($c['email']) ?></td>
                    <td><?= esc($c['phone'] ?? '-') ?></td>
                    <td><?= date('M d, Y', strtotime($c['created_at'])) ?></td>
                    <td class="text-end">
                        <a href="<?= site_url('customers/' . $c['id'] . '/edit') ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form action="<?= site_url('customers/' . $c['id'] . '/delete') ?>" method="post" class="d-inline"
                              onsubmit="return confirm('Delete this customer?');">
                            <?= csrf_field() ?>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>