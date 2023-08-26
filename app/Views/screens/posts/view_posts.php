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


    <div class="container mt-5">
        <div class="row">
            <!-- Loop through each post -->
            <?php foreach ($posts as $post): ?>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <img src="<?= esc($post['image_url']) ?>" class="card-img-top" alt="<?= esc($post['title']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($post['title']) ?></h5>
                            <p class="card-text"><?= esc($post['content']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?= $this->endSection(); ?>
