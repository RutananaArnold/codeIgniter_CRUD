<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;

class PostsController extends BaseController
{


    public function addPost()
    {
        return view('screens/posts/add_post');
    }

    public function uploadPost()
    {
        // Create a shared instance of the model.
        $myPost = model('MyPost');

        // Retrieve form data
        $title = $this->request->getPost('postTitle');
        $content = $this->request->getPost('postContent');
        $image = $this->request->getFile('postImage');

        // Validate and process the uploaded image
        if ($image->isValid() && $image->getSize() < 2097152) { // Max size: 2MB
            // Generate a unique filename for the image (e.g., using time)
            $newName = $image->getRandomName();

            // Move the uploaded file to the desired directory (e.g., 'writable/uploads')
            $image->move(ROOTPATH . '/public/uploads', $newName);
            $session = \Config\Services::session();

            // Save the post data (title, content, and image filename) to a database
            $data = [
                'title' => $title,
                'body' => $content,
                'ownerId' => $session->get('userId'),
                'file'=> $newName
            ];
            try {
                $myPost->insert($data, true);
            } catch (\ReflectionException $e) {
            }

            // Redirect to a success page or a different page
            return redirect()->to('/success')->with('success', 'Post uploaded successfully');
        } else {
            // Handle validation errors or invalid image
            return redirect()->back()->withInput()->with('error', 'Invalid image or image size exceeds 2MB');
        }
    }

    public function fetchPosts()
    {
        // Create a shared instance of the model.
        $postModel = model('MyPost');

        $posts = $postModel->select('posts.*, users.name AS ownerName')->join('users','users.id = posts.ownerId');
        $allPosts = [
            'posts' => $posts->paginate(10),
            'pager' => $postModel->pager,
        ];

        return view('screens/posts/view_posts', $allPosts);
    }
}
