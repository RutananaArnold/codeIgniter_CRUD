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
            return $this->fail($response , 400);

        }

    }

    public function login()
    {
        $rules = [
            'email' => ['rules' => 'required'],
            'password' => ['rules' => 'required'],
        ];

        if($this->validate($rules)){

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
                'token' => $token,
                'user' => $user,
            ];

            return $this->respond($response, 200);
        } else {
            $response = [
                'errors' => $this->validator->getErrors(),
                'message' => 'Invalid Inputs'
            ];
            return $this->fail($response , 400);
        }
    }

    public function showUserDetail()
    {
        $rules =[
            'userId' => ['rules' => 'required'],
        ];

        if($this->validate($rules)){
            $userId = $this->request->getVar('userId');
            $userModel = model('UserModel');
            $user = $userModel->find($userId);

            if(is_null($user)){
                return $this->fail(['error' => 'User does not exist'], 404);
            }
            return $this->respond($user,200,"Success");
        } else{
            $response = [
                'errors' => $this->validator->getErrors(),
                'message' => 'Invalid Inputs'
            ];
            return $this->fail($response , 400);
        }
    }

    public function updateUserDetail(){
        $rules = [
            'userId' => ['rules'=>'required'],
            'name' => ['rules' => 'required'],
            'age'=> ['rules' => 'required']
        ];

        if ($this->validate($rules)){
            $userModel = model('UserModel');
            $data = [
                'name' => $this->request->getVar('name'),
                'age' => $this->request->getVar('age')
            ];

            $userId = $this->request->getVar('userId');

            try {
                $userModel->update($userId,$data);
            } catch(\ReflectionException $e){
                return $this->fail(['exception' => $e], '400');
            }

            return $this->respond(['message' => 'User detail updated Successfully'], 200);
        } else {
            $response = [
                'errors' => $this->validator->getErrors(),
                'message' => 'Invalid Inputs'
            ];
            return $this->fail($response , 400);
        }
    }

    public function addNewPost(){
        $rules = [
            'title' => ['rules'=>'required'],
            'body'=> ['rules'=>'required'],
            'userId'=> ['rules'=>'required'],
            'file' => 'uploaded[file]' // Add allowed MIME types here
        ];

        $response = []; // Initialize the response array

        if (!$this->validate($rules)) {
            $response['message'] = 'failed';
            $response['errors'] = $this->validator->getErrors();
            // You can customize the error response here
        } else {
            $myPost = model('MyPost');
            // Validation passed, proceed with saving the post
            // You can access the uploaded file using $this->request->getFile('file')
            $title = $this->request->getVar('title');
            $body = $this->request->getVar('body');
            $userId = $this->request->getVar('userId');
            $file = $this->request->getFile('file');

            // Generate a unique filename for the image (e.g., using time)
            $newFileName = $file->getRandomName();

            // Move the uploaded file to the desired directory (e.g., 'writable/uploads')
            $file->move(ROOTPATH . '/public/uploads', $newFileName);

            $data = [
                'title' => $title,
                'body' => $body,
                'ownerId' => $userId,
                'file'=> $newFileName
            ];

            // Save the file and the post data to your database or storage system
            try {
                $myPost->insert($data);
            } catch (\ReflectionException $e) {

            }

            $response['message'] = 'Successful';
            $response['message'] = 'Post added successfully';
            // You can include additional data in the success response if needed
        }

        return $this->respond($response, '200');// Return JSON response
    }

    public function displayPosts(){

    }
}
