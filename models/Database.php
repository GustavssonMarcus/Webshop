<?php
require_once ("models/Category.php");
require_once ("models/Product.php");
class DBContext
{
    private $host = 'localhost';
    private $db = 'webshop';
    private $user = 'root';
    private $pass = 'root';
    private $charset = 'utf8mb4';

    private $pdo;

    function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db";
        $this->pdo = new PDO($dsn, $this->user, $this->pass);
    }
    function getAllCategories()
    {
        return $this->pdo->query('SELECT * FROM category')->fetchAll(PDO::FETCH_CLASS, 'Category');

    }
    function getSelectedProduct($id)
    {
        $prep = $this->pdo->prepare('SELECT * FROM products where categoryId=:id');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['id' => $id]);
        return $prep->fetch();
    }
    function getProductsByCategoryId($categoryId)
    {
        $prep = $this->pdo->prepare('SELECT * FROM products WHERE categoryId = :categoryId');
        $prep->execute(['categoryId' => $categoryId]);
        return $prep->fetchAll(PDO::FETCH_ASSOC);
    }

    function getCategoryById($id)
    {
        $prep = $this->pdo->prepare('SELECT * FROM category WHERE id = :id');
        $prep->execute(['id' => $id]);
        return $prep->fetch(PDO::FETCH_ASSOC);
    }
    function getPopularProducts()
    {
        return $this->pdo->query('select * from products order by popularity desc limit 0,10')->fetchAll(PDO::FETCH_CLASS, 'Product');

    }


    function getAllProducts()
    {
        return $this->pdo->query('SELECT * FROM products')->fetchAll(PDO::FETCH_CLASS, 'Product');
    }
}


?>