<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .user-avatar { width: 64px; height: 64px; object-fit: cover; border-radius: 16px; border: 3px solid #fff; box-shadow: 0 2px 8px rgba(255,143,194,.35); }
    .user-avatar-empty { display: flex; align-items: center; justify-content: center; background: var(--lav); color: var(--ink-soft); font-size: .7rem; text-align: center; }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Staff Management</h2>
    <a href="<?= site_url('users/new') ?>" class="btn btn-kawaii">Add Staff</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width:90px;">Avatar</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Added</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr><td colspan="5" class="text-center py-4">No staff members found. Click "Add Staff" to create one.</td></tr>
                <?php endif; ?>

                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <?php if (!empty($user['avatar']) && file_exists(FCPATH . 'uploads/' . $user['avatar'])): ?>
                                <img src="<?= base_url('uploads/' . $user['avatar']) ?>" alt="<?= esc($user['full_name']) ?>" class="user-avatar">
                            <?php else: ?>
                                <div class="user-avatar user-avatar-empty">No image</div>
                            <?php endif; ?>
                        </td>
                        <td class="fw-semibold"><?= esc($user['full_name']) ?></td>
                        <td><?= esc($user['username']) ?></td>
                        <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                        <td class="text-end">
                            <a href="<?= site_url('users/edit/' . $user['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form action="<?= site_url('users/delete/' . $user['id']) ?>" method="post" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this staff?');">
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