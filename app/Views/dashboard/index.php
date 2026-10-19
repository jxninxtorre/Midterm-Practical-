<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body p-4 text-center">
        <h2>Welcome, <?= esc(session()->get('full_name')) ?>!</h2>
        <p class="mb-0">Ready to sell some cute things today? Use the menu above to get started.</p>
    </div>
</div>
<?= $this->endSection() ?>