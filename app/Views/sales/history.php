<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-pink fw-bold mb-0">
                <i class="fas fa-history"></i> Sales History
            </h3>

            <a href="<?= site_url('sales') ?>" class="btn btn-kawaii">
                <i class="fas fa-plus"></i> Record New Sale
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Staff Member</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Date &amp; Time</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($sales)): ?>
                        <?php foreach ($sales as $index => $s): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td class="fw-semibold">
                                    <?= esc($s['product_name'] ?? 'Unknown product') ?>
                                </td>
                                <td>
                                    <?= !empty($s['customer_name'])
                                        ? esc($s['customer_name'])
                                        : '<span class="text-muted fst-italic">Walk-in</span>' ?>
                                </td>
                                <td>
                                    <?= esc($s['staff_name'] ?? 'Unknown staff') ?>
                                </td>
                                <td><?= esc($s['quantity']) ?></td>
                                <td class="text-success fw-bold">
                                    ₱<?= number_format((float) $s['total_price'], 2) ?>
                                </td>
                                <td>
                                    <?php if (!empty($s['created_at'])): ?>
                                        <?= esc(date('M d, Y h:i A', strtotime($s['created_at']))) ?>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No sales recorded yet.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>