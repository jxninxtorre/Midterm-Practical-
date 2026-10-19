<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card" style="max-width:640px;">
    <div class="card-body p-4">
        <h3 class="mb-3">Add Staff</h3>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $e): ?>
                        <li><?= esc($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('users/create') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" maxlength="100" required
                       value="<?= esc(old('full_name', '', false)) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" maxlength="50" required
                       value="<?= esc(old('username', '', false)) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Avatar Image (JPG or PNG, max 2MB)</label>
                <input type="file" name="avatar" class="form-control" accept=".jpg,.jpeg,.png" required>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-kawaii">Save Staff</button>
                <a href="<?= site_url('users') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>