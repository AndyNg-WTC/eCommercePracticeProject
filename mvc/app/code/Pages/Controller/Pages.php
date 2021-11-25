<?php

declare(strict_types=1);

namespace code\Pages\Controller;

use libraries\Controller;

class Pages extends Controller
{
    public function __construct()
    {
    }
    public function index(): void
    {
        $data = [
            'title' => 'MVC',
        ];


        $this->view($this->getModule(__FILE__), __FUNCTION__, $data);
    }
    public function about(): void
    {
        $data = [
            'title' => 'About Us'
        ];

        $this->view($this->getModule(__FILE__), __FUNCTION__, $data);
    }
    public function posts(): void
    {
        // setting postModel method
        $this->postModel = $this->model($this->getModule(__FILE__), $this->getModule(__FILE__));

        $posts = $this->postModel->getPosts();
        $data = [
            'title' => 'Posts from DB',
            'posts' => $posts
        ];


        $this->view($this->getModule(__FILE__), __FUNCTION__, $data);
    }
}
