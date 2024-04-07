<?php

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


    function getAllProducts()
    {
        return $this->pdo->query('SELECT * FROM products')->fetchAll(PDO::FETCH_CLASS, 'Product');
    }
}
// function getProduct($id)
// {
//     $prep = $this->pdo->prepare('SELECT * FROM products where id=:id');
//     $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
//     $prep->execute(['id' => $id]);
//     return $prep->fetch();
// }

?>