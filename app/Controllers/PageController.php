<?php

namespace App\Controllers;

class PageController extends BaseController {

    public function sideBar() {
      
         return view('screens/sidebar');
    }

    public function showDashboard(){
        return view('screens/dashboard');
    }
    
    
    // Add methods for other pages (users, settings) similarly
}