<?= $this->extend('layout/sidebar'); ?>

<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Edit User</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Edit User</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<div class="container card p-4">
    <div class="alert alert-warning p-3 mt-4">
        <h6>You can make changes to this user account.</h6>
    </div>

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

    <form action="/update-user" method="POST" class="form">
        <!-- Adding CSRF token field -->
        <?= csrf_field() ?>

        <input type="hidden" name="user_id" value="<?= esc($user['id']) ?>">
        <div class="form-group mb-2">
            <label for="">Full Name</label>
            <input class="form-control form-control-sm mt-1" name="name" value="<?= esc($user['name']) ?>" type="text" required style="height: 40px;" placeholder="Full Name">
        </div>
        <div class="form-group mb-2">
            <label for="">Age</label>
            <input class="form-control form-control-sm mt-1" name="age" value="<?= esc($user['age']) ?>" type="text" required style="height: 40px;" placeholder="Age e.g 24">
        </div>
        <div class="form-group mb-2">
            <label for="">Email</label>
            <input class="form-control form-control-sm mt-1" name="email" value="<?= esc($user['email']) ?>" type="text" required style="height: 40px;" placeholder="Email e.g example@gmail.com">
        </div>
        <div class="form-group mb-2">
            <label for="">New Password</label>
            <input class="form-control form-control-sm mt-1" name="password" type="text" style="height: 40px;" placeholder="Strong password">
        </div>
        <div class="form-group mb-2">
            <label for="">Repeat Password</label>
            <input class="form-control form-control-sm mt-1" name="password_confirmation" type="password" style="height: 40px;" placeholder="Repeat password">
        </div>
        <br> <br>
        <button class="btn btn-sm w-100 mb-4  block btn-success" style="height: 40px;">Save Changes</button>
    </form>

</div>

<?= $this->endSection(); ?>
