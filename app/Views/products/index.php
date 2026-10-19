<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .product-thumb { width: 64px; height: 64px; object-fit: cover; border-radius: 16px; border: 3px solid #fff; box-shadow: 0 2px 8px rgba(255,143,194,.35); }
    .product-thumb-empty { display: flex; align-items: center; justify-content: center; background: var(--lav); color: var(--ink-soft); font-size: .7rem; text-align: center; }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Products</h2>
    <a href="<?= site_url('products/new') ?>" class="btn btn-kawaii">Add Product</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width:90px;">Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Added</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($products)): ?>
                <tr><td colspan="6" class="text-center py-4">No products yet. Click "Add Product" to create one.</td></tr>
            <?php endif; ?>

            <?php foreach ($products as $p): ?>
                <tr>
                    <td>
                        <?php if (! empty($p['image'])): ?>
                            <img src="<?= site_url('products/image/' . $p['image']) ?>" alt="<?= esc($p['name']) ?>" class="product-thumb">
                        <?php else: ?>
                            <div class="product-thumb product-thumb-empty">No image</div>
                        <?php endif; ?>
                    </td>
                    <td><?= esc($p['name']) ?></td>
                    <td>&#8369;<?= number_format($p['price'], 2) ?></td>
                    <td><?= (int) $p['stock_quantity'] ?></td>
                    <td><?= date('M d, Y', strtotime($p['created_at'])) ?></td>
                    <td class="text-end">
                        <a href="<?= site_url('products/' . $p['id'] . '/edit') ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form action="<?= site_url('products/' . $p['id'] . '/delete') ?>" method="post" class="d-inline"
                              onsubmit="return confirm('Delete this product?');">
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