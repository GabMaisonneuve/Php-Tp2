<?php
namespace App\Models;

abstract class CRUD extends \PDO{

    final public function __construct(){
        parent::__construct('mysql:host=localhost;dbname=blog;port=3306;charset=utf8', 'root', 'admin');
    }

    final public function select($field = null, $order='asc'){
        if($field == null){
            $field = $this->primaryKey;
        }
        $sql = "SELECT * FROM $this->table ORDER BY $field $order";
        if($stmt = $this->query($sql)){
            return $stmt->fetchAll();
        }else{
            return false;
        }
        
    }

      final  public function readAll() {
        $sql = "SELECT posts.*, users.username AS author, categories.name AS category
                FROM posts
                JOIN users ON posts.user_id = users.id
                LEFT JOIN categories ON posts.category_id = categories.id
                ORDER BY id DESC";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    public function getAllCategories() {
    $sql = "SELECT * FROM categories ORDER BY name ASC";
    $stmt = $this->query($sql);
    return $stmt->fetchAll();
}

    final public function selectId($value){
        $sql = "SELECT * FROM  $this->table WHERE $this->primaryKey = :$this->primaryKey";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$this->primaryKey", $value);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count == 1){
            return $stmt->fetch();
        }else{
            return false;
        } 
    }

       final public function create($title, $content, $user_id, $category_id = null, $image = null) {
        $sql = "INSERT INTO posts (title, content, user_id, category_id, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->prepare($sql);
        return $stmt->execute([$title, $content, $user_id, $category_id, $image]);
    }


       final public function insert($data){

        $data_keys = array_fill_keys($this->fillable, '');
        $data = array_intersect_key($data, $data_keys);
 
        $fieldName = implode(', ', array_keys($data));
        $fieldValue = ":".implode(', :', array_keys($data));
        $sql = "INSERT INTO $this->table ($fieldName) VALUES ($fieldValue);";

        $stmt = $this->prepare($sql);
        foreach($data as $key=>$value){
            $stmt->bindValue(":$key", $value);
        }
        if($stmt->execute()){
            return $this->lastInsertId();
        }else{
            return false;
        } 
    }

  final public function update($data, $id){
    $data_keys = array_fill_keys($this->fillable, '');
    $data = array_intersect_key($data, $data_keys);

    if (empty($data)) {
        throw new Exception("No valid data provided for update.");
    }

    $fieldName = '';
    foreach($data as $key => $value){
        $fieldName .= "$key = :$key, ";
    }

    $fieldName = rtrim($fieldName, ', ');
    $sql = "UPDATE {$this->table} SET $fieldName WHERE {$this->primaryKey} = :{$this->primaryKey}";
    
    $stmt = $this->prepare($sql);
    $data[$this->primaryKey] = $id;

    return $stmt->execute($data);
}
    final public function delete($value){

        $sql = "DELETE FROM $this->table WHERE $this->primaryKey = :$this->primaryKey";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$this->primaryKey", $value);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }
}

?>