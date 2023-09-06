<?php

namespace App\Controllers;

use PhpParser\Node\Scalar\String_;

class PageController extends BaseController {

    public function sideBar()  : String
    {
         return view('layout/sidebar');
    }

    public function showDashboard() : String
    {
        // Create a shared instance of the m
        $userModel = model('UserModel');
        $postModel = model('MyPost');
        $allUsers = $userModel->findAll();
        $allPosts = $postModel->findAll();
        $totalUsers = count($allUsers);
        $totalPosts = count($allPosts);
        return view('screens/dashboard', ["totalUsers" => $totalUsers, "totalPosts" => $totalPosts]);
    }

    public function showSuccess() : String
    {
        return view('screens/success');
    }

    // Add methods for other pages (users, settings) similarly
}