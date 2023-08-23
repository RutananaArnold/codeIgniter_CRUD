<?php

namespace App\Controllers;
use Config\Services;

class Crudcontroller extends BaseController
{

    public function index(): string
    {
        return view('screens/register');
    }


    public function save() : string {
        // Create a shared instance of the model.
        $userModel = model('UserModel');

        $data = [
            'name' => $this->request->getPost('username'),
            'email'  => $this->request->getPost('email'),
            'gender' => $this->request->getPost('gender'),
            'age' => $this->request->getPost('age'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_ARGON2I)
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
            $session = \Config\Services::session();

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $user = $userModel->where('email', $email)->first();

            if ($user) {
                // Set user session
                $session->set('user', $user['id']);
                return redirect()->to('/dashboard-view', null, 'refresh');
            } else {
                echo('wrong credentials');
                return view('screens/login');
            }
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
         $allUsers = [
            'users' => $userModel->paginate(10),
             'pager' => $userModel->pager,
         ];
         return view('screens/users_screen', $allUsers);
    }

    public function showEditUser($userId)
    {
        // Create a shared instance of the model.
        $userModel = model('UserModel');
        $user = $userModel->find($userId);
        if(is_null($user)){
            return redirect()->back();
        }

        return view('screens/edit_user', ['user' => $user]);
    }

    public function updateUser(){
        if (! $this->request->is('post')) {
            return redirect()->back();
        }

        $rules =[
            'user_id' => 'required',
            'name' => 'required',
            'age' => 'required',
            'email' => 'required|valid_email',
            'password' => 'min_length[6]',
            'password_confirmation' => 'matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back();   //redirect with error message
        }

        // Create a shared instance of the model.
        $userModel = model('UserModel');
        $id = $this->request->getPost('user_id');
        $name = $this->request->getPost('name');
        $age = $this->request->getPost('age');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = [
            'name' =>  $name,
            'email'  => $email,
            'age' => $age,
            'password' => $password
        ];

        try {
            $response = $userModel->update($id, $user);
        } catch (\ReflectionException $e) {
            return redirect()->back()->with('foo', 'message');
        }
        return redirect()->back()->with('success', 'User detail updated successfully');   //success with a success message
    }


}