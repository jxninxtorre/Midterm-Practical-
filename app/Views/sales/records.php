<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm border-0 rounded-4" style="max-width: 640px; margin: auto;">
    <div class="card-body p-4">
        <h3 class="mb-3 text-pink fw-bold"><i class="fas fa-cash-register"></i> Record Sale</h3>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger rounded-pill px-3 py-2">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success rounded-pill px-3 py-2">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('sales/store') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label fw-semibold">Select Product</label>
                <select name="product_id" class="form-control rounded-pill" required>
                    <option value="">-- Choose Product --</option>
                    <?php foreach ($products as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= esc($p['name']) ?> (Stock: <?= $p['stock_quantity'] ?> - ₱<?= number_format($p['price'], 2) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Select Customer <small class="text-muted">(Optional)</small></label>
                <select name="customer_id" class="form-control rounded-pill">
                    <option value="">-- Walk-in Customer --</option>
                    <?php foreach ($customers as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= esc($c['full_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Quantity</label>
                <input type="number" name="quantity" class="form-control rounded-pill" min="1" value="1" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= site_url('/') ?>" class="btn btn-secondary rounded-pill px-4">Cancel</a>
                <button type="submit" class="btn btn-kawaii px-4">Complete Sale</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>