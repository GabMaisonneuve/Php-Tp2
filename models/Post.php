<?php 
namespace App\Models;
use App\Models\CRUD;


class Post extends CRUD {
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $fillable = ['title', 'content', 'user_id', 'category_id'];



}
?>