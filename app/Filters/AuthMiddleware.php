<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthMiddleware implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Your authentication logic goes here
        // For example, check if the user is logged in
        if (! $this->isLoggedIn()) {
            return redirect()->to('/login'); // Redirect to the login page if not logged in
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Your code after the request goes here
    }

    public function isLoggedIn(){
        // Check if a user is logged in based on your authentication method
        // For example, if you're using CodeIgniter 4's built-in Authentication library
        return session()->has('userId'); // Assuming 'logged_in' is a session variable set upon successful login
    }
}

