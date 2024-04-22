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
        $this->seedfNotSeeded();
        $this->initIfNotInitialized();
    }

    function seedfNotSeeded()
    {
        static $seeded = false;
        if ($seeded)
            return;
        $categories = $this->getAllCategories();

        $this->createIfNotExisting('Salming', 'White', '1199', 'Stick', 'Q Series Aero', '1', $categories[array_rand($categories)]->id);
        $this->createIfNotExisting('Unihoc', 'Blue', '799', 'Stick', 'Unilite Superskin', '2', $categories[array_rand($categories)]->id);
        $this->createIfNotExisting('Fatpipe', 'Red', '1399', 'Stick', 'G 27', '3', $categories[array_rand($categories)]->id);
        $this->createIfNotExisting('Oxdog', 'Brown', '1300', 'Stick', 'Sense Hes', '4', $categories[array_rand($categories)]->id);
        $this->createIfNotExisting('Jolly', 'Black', '1299', 'Stick', 'Black HII', '5', $categories[array_rand($categories)]->id);
        $this->createIfNotExisting('Exel', 'Pink', '1245', 'Stick', 'E-lite', '6', $categories[array_rand($categories)]->id);
        $this->createIfNotExisting('Zone', 'Orange', '999', 'Stick', 'Hyperlite Airlight', '7', $categories[array_rand($categories)]->id);
        $this->createIfNotExisting('Fatpipe', 'Purple', '300', 'Blade', 'CTRL PPB', '3', $categories[array_rand($categories)]->id);
        $this->createIfNotExisting('Jolly', 'Red', '249', 'Blade', 'Galaxy', '5', $categories[array_rand($categories)]->id);
        $this->createIfNotExisting('Oxdog', 'Green', '350', 'Blade', 'Avox', '4', $categories[array_rand($categories)]->id);
        $this->createIfNotExisting('Salming', 'Pink', '299', 'Blade', 'Q1', '1', $categories[array_rand($categories)]->id);
        $this->createIfNotExisting('Unihoc', 'Blue', '350', 'Blade', 'EVO3 Hook', '2', $categories[array_rand($categories)]->id);
        $this->createIfNotExisting('Zone', 'Black', '300', 'Blade', 'Supreme air', '7', $categories[array_rand($categories)]->id);
        $this->createIfNotExisting('Exel', 'Lime green', '299', 'Blade', 'Megalomaniac', '6', $categories[array_rand($categories)]->id);

        $seeded = true;

    }

    function createIfNotExisting($brand, $color, $price, $brandtype, $brandname, $categoryId, $id)
    {
        $existing = $this->getProductByBrand($brand);
        if ($existing) {
            return;
        }
        ;
        return $this->addProduct($brand, $color, $price, $brandtype, $brandname, $categoryId, $id);
    }
    function getProductByBrand($brand)
    {
        $prep = $this->pdo->prepare('SELECT * FROM Products WHERE Brand = :brand');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['brand' => $brand]);
        return $prep->fetch();
    }


    function addProduct($brand, $color, $price, $brandtype, $brandname, $categoryId, $id)
    {
        $prep = $this->pdo->prepare('INSERT INTO Products
        (Brand, Color, Price, BrandType, BrandName, CategoryId) 
        VALUE(:Brand, :Color, :Price, :BrandType, :BrandName, :CategoryId);
        ');
        $prep->execute(["Brand" => $brand, "Color" => $color, "Price" => $price, "BrandType" => $brandtype, "BrandName" => $brandname, "CategoryId" => $categoryId]);
        return $this->pdo->lastInsertId();
    }



    function getAllCategories()
    {
        return $this->pdo->query('SELECT * FROM category')->fetchAll(PDO::FETCH_CLASS, 'Category');

    }
    function getSelectedProduct($categoryId)
    {
        $prep = $this->pdo->prepare('SELECT * FROM Products WHERE ID = :categoryId');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['categoryId' => $categoryId]);
        return $prep->fetchAll(); // Assuming there could be multiple products with the same category
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

    function searchProducts($search_term, $sort_col, $sort_order)
    {
        $valid_sort_columns = ['product_id', 'brand', 'brandname', 'color', 'price'];
        if (!in_array($sort_col, $valid_sort_columns)) {
            $sort_col = 'product_id';
        }

        $valid_sort_orders = ['ASC', 'DESC'];
        if (!in_array($sort_order, $valid_sort_orders)) {
            $sort_order = 'ASC';
        }

        $sql = 'SELECT * FROM products WHERE brand LIKE :search_term OR brandname LIKE :search_term OR color LIKE :search_term';

        $sql .= ' ORDER BY ' . $sort_col . ' ' . $sort_order;

        $prep = $this->pdo->prepare($sql);
        $search_term = "%$search_term%";
        $prep->execute(['search_term' => $search_term]);

        return $prep->fetchAll(PDO::FETCH_CLASS, 'Product');
    }



    function getAllProductsSorted($sortCol, $sortOrder)
    {
        $searched = isset($_GET['search']) ? $_GET['search'] : '';

        if ($searched) {
            return $this->searchProducts($searched, $sortCol, $sortOrder);
        } else {

            $sql = "SELECT * FROM products ORDER BY $sortCol $sortOrder";
            return $this->pdo->query($sql)->fetchAll(PDO::FETCH_CLASS, 'Product');
        }
    }

    function initIfNotInitialized()
    {

        static $initialized = false;
        if ($initialized)
            return;
        $sql = "CREATE TABLE IF NOT EXISTS `Products` (
                `Id` INT NOT NULL AUTO_INCREMENT,
                `Brand` varchar(50) NOT NULL,
                `Color` varchar(50) NOT NULL,
                `Price` INT(11) NOT NULL,
                `BrandType` varchar(50) NOT NULL,
                `BrandName` varchar(10) NOT NULL,
                `CategoryId` INT NOT NULL,
                `Popularity` INT(11) NOT NULL,
                PRIMARY KEY (`Id`),
                FOREIGN KEY (`CategoryId`)
                REFERENCES Category(id)
            )";
        $this->pdo->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `Category` (
                    `Id` int NOT NULL AUTO_INCREMENT,
                    `Category` varchar(50) NOT NULL,
                    PRIMARY KEY (`Id`)
                )";
        $this->pdo->exec($sql);
    }

}
?>