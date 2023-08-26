<?= $this->extend('layout/sidebar'); ?>

<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Add Post</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Add Post</li>
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


        <div class="container mt-1">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            Upload Post
                        </div>
                        <div class="card-body">
                            <form action="/upload-post" method="POST" enctype="multipart/form-data">
                                <!-- Adding CSRF token field -->
                                <?= csrf_field() ?>

                                <!-- Title Upload -->
                                <div class="mb-3">
                                    <label for="postTitle" class="form-label">Post Title</label>
                                    <input class="form-control" type="text" id="postTitle" name="postTitle">
                                </div>
                                <!-- Post Content -->
                                <div class="mb-3">
                                    <label for="postContent" class="form-label">Post Content</label>
                                    <textarea class="form-control" id="postContent" name="postContent" rows="4" required></textarea>
                                </div>
                                <!-- Image Upload -->
                                <div class="mb-3">
                                    <label for="postImage" class="form-label">Upload Image</label>
                                    <input class="form-control" type="file" id="postImage" name="postImage">
                                </div>
                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Upload Post</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?= $this->endSection(); ?>
