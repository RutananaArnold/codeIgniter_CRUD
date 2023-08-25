<?= $this->extend('layout/sidebar'); ?>

<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Delete User</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Delete User</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<div class="container card p-4">
    <div class="alert alert-warning p-3 mt-4">
        <h6>You can delete this user account.</h6>
    </div>

    <br>
        <section class="section about-section gray-bg" id="about">
        <form action="/delete-user" method="post">
                <!-- Adding CSRF token field -->
          <?= csrf_field() ?>
            <div class="container">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-lg-6">
                        <div class="about-text go-to">
                           <div class="row about-list">
                               <input type="hidden" name="user_id" value="<?= esc($user['id']) ?>">
                                <div class="col-md-6">
                                    <div class="media">
                                        <label>Name</label>
                                        <p><?= esc($user['name']) ?></p>
                                    </div>
                                    <div class="media">
                                        <label>Age</label>
                                        <p><?= esc($user['age']) ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="media">
                                        <label>E-mail</label>
                                        <p><?= esc($user['email']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-avatar">
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" title="" alt="">
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 20px">
                    <div class="col">
                        <a href="#" class="btn btn-outline-warning btn-sm">Cancel</a>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                    </div>
                </div>
            </div>
    </form>
        </section>

</div>

<?= $this->endSection(); ?>
