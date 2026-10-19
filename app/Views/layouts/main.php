<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'POS System') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?= $this->include('layouts/theme') ?>
</head>
<body>

<nav class="navbar navbar-expand-lg kawaii-nav">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('dashboard') ?>">Sweet POS</a>

        <div class="navbar-nav me-auto">
            <a class="nav-link" href="<?= site_url('products') ?>">Products</a>
            <a class="nav-link" href="<?= site_url('customers') ?>">Customers</a>
            <a class="nav-link" href="<?= site_url('users') ?>">Staff</a>
            <a class="nav-link" href="<?= site_url('sales/new') ?>">Record Sale</a>
            <a class="nav-link" href="<?= site_url('sales/history') ?>">Sales History</a>
        </div>

        <span class="navbar-text me-3"><?= esc(session()->get('full_name')) ?></span>
        <a class="btn btn-kawaii btn-sm" href="<?= site_url('logout') ?>">Logout</a>
    </div>
</nav>

<div class="container py-4">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

<div class="kawaii-footer">Sweet POS</div>

</body>
</html>