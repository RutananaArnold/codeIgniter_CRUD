
<?= $this->extend('layout/sidebar'); ?>

<?= $this->section('content'); ?>

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

<div class="d-flex justify-content-center align-items-center">
    <div class="col-md-4">
        <div class="border border-3 border-success"></div>
        <div class="card  bg-white shadow p-5">
            <div class="mb-4 text-center">
                <i style="color: green; font-size: 100px;" class="checkmark">✓</i>
            </div>
            <div class="text-center">
                <?php if (session()->has('success')) : ?>

                        <h1> <?= session('success') ?></h1>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
