<?= $this->extend('layout/sidebar'); ?>

<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Users</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<?php $pager = \Config\Services::pager(); ?>

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

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <th>No</th>
                <th>Full Name</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Email</th>
                <th>Action</th>
            </thead>
            <tbody>
            <?php

            // Calculate the starting item number for the current page
            $startingNumber = ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1;
            foreach ($users as $user):
                ?>
                <tr>
                    <td><?= $startingNumber++ ?></td>
                    <td><?= esc($user['name']) ?></td>
                    <td><?= esc($user['gender']) ?> </td>
                    <td><?= esc($user['age']) ?> </td>
                    <td><?= esc($user['email']) ?> </td>
                    <td>
                        <a href="/edit-user/<?= esc($user['id']) ?>" class="btn btn-outline-warning btn-sm" style="width: 6em;"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                        <a href="/delete-screen/<?= esc($user['id']) ?>" class="btn btn btn-outline-danger btn-outline btn-sm" style="width: 6em;"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>

<?= $pager->links() ?>

<?= $this->endSection(); ?>


