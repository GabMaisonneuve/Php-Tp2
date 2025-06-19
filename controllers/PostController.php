<?php 
namespace App\Controllers;
use App\Models\Post;
use App\Providers\View;
use App\Providers\Validator;

class PostController {

  public function edit ($id){
  if (is_array($id)) {
        $id = $id['id'] ?? null;
    }

    $postModel = new Post();
    $existingPost = $postModel->selectId($id);
    $categories = $postModel->getAllCategories();
    return View::render('edit_post', [
      'existingPost' => $existingPost,
      'categories' => $categories,
    ]);
    
  }

  public function update($data) {
  $id = $data['id'] ?? null;
    $title = $data['title'] ?? '';
    $content = $data['content'] ?? '';
    $category_id = !empty($data['category_id']) ? (int)$data['category_id'] : null;
    $image = $data['image'] ?? null;

    $validator = new Validator();
    $validator
        ->field('title', $title)
        ->required()
        ->min(3)
        ->max(100);

    $validator
        ->field('content', $content)
        ->required()
        ->min(10);

    $validator
        ->field('category_id', $category_id, 'Category')
        ->required();

    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        $existingPost = (new Post())->selectId($id);
        $categories = (new Post())->getAllCategories();

        return View::render('edit_post', [
            'errors' => $errors,
            'existingPost' => $existingPost,
            'categories' => $categories
        ]);
    }

    $postModel = new Post();
    $postModel->update($data, $id);

    View::redirect("list_posts");
    exit;
  }


  public function delete($params) {
    $id = $params['id'] ?? null;

    if (!$id) {
        die("Missing post ID.");
    }

    $postModel = new Post();
    $postModel->delete($id);

    View::redirect("list_posts");
    exit;
}
    public function index () {
        $postModel = new Post();
        $posts = $postModel->readAll();
        return View::render('list_posts', ['posts' => $posts]);
    }

    public function store(){
       $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $category_id = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $image = $_POST['image'] ?? null;
    $user_id = 1;

    $validator = new Validator();
    $validator
        ->field('title', $title)
        ->required()
        ->min(3)
        ->max(100);

    $validator
        ->field('content', $content)
        ->required()
        ->min(10);

    $validator
        ->field('category_id', $category_id, 'Category')
        ->required();

    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        $categories = (new Post())->getAllCategories();

        return View::render('home', [
            'errors' => $errors,
            'old' => $_POST,
            'categories' => $categories
        ]);
    }

    $postModel = new Post();
    $postModel->create($title, $content, $user_id, $category_id, $image);

    View::redirect("list_posts");
    exit;
    }
}
?>