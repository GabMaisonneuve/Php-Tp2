<?php 
namespace App\Controllers;
use App\Models\Post;
use App\Providers\View;

class HomeController {
    public function index(){
        $postModel = new Post();
        $posts = $postModel->select();
        $categories = $postModel->getAllCategories();
        return View::render('home', [
            'posts' => $posts,
            'categories' => $categories
        // include 'views/home.php';
        ]);
}
}
?>