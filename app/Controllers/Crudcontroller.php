<?php

namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;


class Crudcontroller extends BaseController
{

    public function index(): string
    {
        return view('screens/register');
    }


    public function save() : string {
        // Create a shared instance of the model.
        $userModel = model('UserModel');
        $request = \Config\Services::request();
        
        $data = [
            'name' => $request->getPost('username'),
            'email'  => $request->getPost('email'),
            'gender' => $request->getPost('gender'),
            'age' => $request->getPost('age'),
            'password' => password_hash($request->getPost('password'), PASSWORD_ARGON2I)
        ];


       $response = $userModel->insert($data, false);

        if($response){
         return view('screens/login');
        } else{
            echo "Failed to register user.";
           print($response);
           return view('screens/register');
        }
    }

    public function showLogin(): String{
        return view('screens/login');
    }

    public function login(){

        if ($this->request->is('post')) {
             // Create a shared instance of the model.
            $userModel = model('UserModel');
            $request = \Config\Services::request();
            $session = \Config\Services::session();

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $user = $userModel->where('email', $email)->first();

//            print_r(password_verify($password, $user['password']));
            if ($user) {
                // Set user session
                $session->set('user', $user['id']);
                return view('layout/sidebar');
            } else {
                echo('wrong credentials');
                return view('screens/login');
            }
//            return view('layout/sidebar').view('screens/dashboard');
        }
    }

    public function logout()
    {
        $session = \Config\Services::session();
        $session->remove('user');
        return view('screens/login');
    }


    public function fetchUsers() : String
    {
         // Create a shared instance of the model.
         $userModel = model('UserModel');
        //  dump($userModel);
         $allUsers = $userModel->findAll();
         return view('screens/users_screen', $allUsers);
    }


    //     $db = db_connect();
    //    $pQuery = $db->prepare(static function ($db) {
    //     return $db->table('users')->insert([
    //         'name' => $this->input->post('username'),
    //         'email'  => $this->input->post('email'),
    //         'gender' => $ths->input->post('gender'),
    //         'age' => $this->input->post('age'),
    //         'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
    //     ]);
    // });

}