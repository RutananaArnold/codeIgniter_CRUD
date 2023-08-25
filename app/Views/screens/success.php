
<?= $this->extend('layout/sidebar'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-center align-items-center">
    <div class="col-md-4">
        <div class="border border-3 border-success"></div>
        <div class="card  bg-white shadow p-5">
            <div class="mb-4 text-center">
                <i style="color: green; font-size: 100px;" class="checkmark">✓</i>
            </div>
            <div class="text-center">
                <h1>User Deleted successfully</h1>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
