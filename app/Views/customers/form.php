<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $isEdit = ! empty($customer); ?>

<div class="card" style="max-width:640px;">
    <div class="card-body p-4">
        <h3 class="mb-3"><?= $isEdit ? 'Edit Customer' : 'Add Customer' ?></h3>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $e): ?>
                        <li><?= esc($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= $isEdit ? site_url('customers/' . $customer['id'] . '/update') : site_url('customers') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" maxlength="100" required
                       value="<?= esc(old('full_name', $customer['full_name'] ?? '', false)) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" maxlength="100" required
                       value="<?= esc(old('email', $customer['email'] ?? '', false)) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Phone (optional)</label>
                <input type="text" name="phone" class="form-control" maxlength="20"
                       value="<?= esc(old('phone', $customer['phone'] ?? '', false)) ?>">
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-kawaii"><?= $isEdit ? 'Save Changes' : 'Add Customer' ?></button>
                <a href="<?= site_url('customers') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>