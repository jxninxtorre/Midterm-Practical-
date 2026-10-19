<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $isEdit = ! empty($product); ?>

<div class="card" style="max-width:640px;">
    <div class="card-body p-4">
        <h3 class="mb-3"><?= $isEdit ? 'Edit Product' : 'Add Product' ?></h3>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $e): ?>
                        <li><?= esc($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= $isEdit ? site_url('products/' . $product['id'] . '/update') : site_url('products') ?>"
              method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" maxlength="100" required
                       value="<?= esc(old('name', $product['name'] ?? '', false)) ?>">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" name="price" class="form-control" step="0.01" min="0" required
                           value="<?= esc(old('price', $product['price'] ?? '', false)) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Stock Quantity</label>
                    <input type="number" name="stock_quantity" class="form-control" min="0" step="1" required
                           value="<?= esc(old('stock_quantity', $product['stock_quantity'] ?? '0', false)) ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Product Image (JPG or PNG, max 2MB)</label>
                <?php if ($isEdit && ! empty($product['image'])): ?>
                    <div class="mb-2">
                        <img src="<?= site_url('products/image/' . $product['image']) ?>" alt="current image"
                             style="width:120px;height:120px;object-fit:cover;border-radius:20px;border:3px solid #fff;box-shadow:0 2px 8px rgba(255,143,194,.35);">
                        <div><small style="color:var(--ink-soft);">Upload a new file to replace this image.</small></div>
                    </div>
                <?php endif; ?>
                <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png">
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-kawaii"><?= $isEdit ? 'Save Changes' : 'Add Product' ?></button>
                <a href="<?= site_url('products') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>