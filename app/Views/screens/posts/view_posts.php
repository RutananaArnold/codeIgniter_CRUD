<?= $this->extend('layout/sidebar'); ?>

<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>View Posts</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">View Posts</li>
        </ol>
    </nav>
</div><!-- End Page Title -->


<br>
<?php if (session()->has('success')) : ?>
    <div class="alert alert-success">
        <?= session('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->has('error')) : ?>
    <div class="alert alert-danger">
        <?= session('error') ?>
    </div>
<?php endif; ?>

<?php $pager = \Config\Services::pager(); ?>

<div class="container mt-5">
    <div class="row">
        <!-- Loop through each post -->
        <?php foreach ($posts as $post): ?>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <img height="20px" src="<?= base_url('person.png') ?>" class="user-avatar" alt="<?= esc($post['ownerName']) ?>">
                        <span class="user-name"><?= esc($post['ownerName']) ?></span>
                    </div>
                    <img src="<?= base_url('uploads/' . esc($post['file'])) ?>" class="card-img-top" alt="<?= esc($post['title']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($post['title']) ?></h5>
                        <p class="card-text"><?= esc($post['body']) ?></p>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-4">
                                <a href="#" class="btn btn-sm btn-primary">Like</a>
                            </div>
                            <div class="col-4">
                                <a href="#" class="btn btn-sm btn-info">Comment</a>
                            </div>
                            <div class="col-4">
                                <a href="#" class="btn btn-sm btn-secondary">Share</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?= $pager->links() ?>

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
    }

    .card {
        border: 1px solid #ccc;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-img-top {
        max-height: 300px;
        object-fit: cover;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .card-text {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .owner-text {
        font-size: 14px;
        color: #888;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .page-item {
        margin: 0 5px;
    }
</style>

<?= $this->endSection(); ?>
