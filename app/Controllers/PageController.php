<?php

namespace App\Controllers;

use PhpParser\Node\Scalar\String_;

class PageController extends BaseController {

    public function sideBar() {
      
         return view('layout/sidebar');
    }

    public function showDashboard(){
        // Create a shared instance of the m
        $userModel = model('UserModel');
        //  dump($userModel);
        $allUsers[] = $userModel->findAll();
        return view('screens/dashboard', $allUsers);
    }

    public function showSuccess() : String
    {
        return view('screens/success');
    }
    
    // Add methods for other pages (users, settings) similarly
}