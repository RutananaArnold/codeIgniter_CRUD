<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \Firebase\JWT\JWT;
use CodeIgniter\API\ResponseTrait;

class CrudAPI extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $userModel = model('UserModel');
        $pager = \Config\Services::pager();
        $perPage = 10;
        $currentPage = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        // Fetch data with pagination
        $users = $userModel->paginate($perPage,'API_pagination', $currentPage);

        if(is_null($users)){
            return $this->respond([],200, "No users found");
        }

        return $this->respond(['users' => $users], 200, 'Success');
    }

    public function show($userId = null)
    {
        $userModel = model('UserModel');
        $user = $userModel->find('userId');

        if(is_null($user)){
            return $this->fail(['error' => 'User does not exist'], 404);
        }
        return $this->respond($user,200,"Success");
    }


    public function register()
    {
        $rules = [
            'name' => ['rules' => 'required'],
            'gender' => ['rules' => 'required'],
            'age' => ['rules' => 'required'],
            'email' => ['rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[users.email]'],
            'password' => ['rules' => 'required|min_length[6]|max_length[255]'],
            'confirm_password'  => [ 'label' => 'confirm password', 'rules' => 'matches[password]']
        ];


        if($this->validate($rules)){
            $model = model('UserModel');
            $data = [
                'name' => $this->request->getVar('name'),
                'email'    => $this->request->getVar('email'),
                'gender' => $this->request->getVar('gender'),
                'age' => $this->request->getVar('age'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
            ];
            try {
                $model->insert($data);
            } catch (\ReflectionException $e) {
            }

            return $this->respond(['message' => 'Registered Successfully'], 200);
        }else{
            $response = [
                'errors' => $this->validator->getErrors(),
                'message' => 'Invalid Inputs'
            ];
            return $this->fail($response , 409);

        }

    }

    public function login()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $userModel = model('UserModel');
        $user = $userModel->where('email', $email)->first();

        if(is_null($user)) {
            return $this->respond(['error' => 'Invalid username or password.'], 401);
        }

        $key = getenv('JWT_SECRET');
        $iat = time(); // current timestamp value
        $exp = $iat + 3600;

        $payload = array(
            "iss" => "Arnold",
            "aud" => "Mobile",
            "sub" => "Bearer token",
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "email" => $user['email'],
        );

        $token = JWT::encode($payload, $key, 'HS256');

        $response = [
            'message' => 'Login Successful',
            'token' => $token
        ];

        return $this->respond($response, 200);
    }


}
