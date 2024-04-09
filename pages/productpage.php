<?php
require_once ("Pages/layout/Navbar.php");
require_once ("Pages/layout/Header.php");
require_once ("Models/Database.php");

$id = $_GET['id'] ?? "";
$dbContext = new DBContext();

$category = $dbContext->getCategoryById($id);
$products = $dbContext->getProductsByCategoryId($id);

layout_header("Marcus Shop");
?>
<!------------------sidenav-------------->
<?php
layout_Navbar($dbContext);
?>
<Main>
    <Section class="main">
        <div class="main-content">
            <h1>Innebandy Produkter</h1>
            <h2>
                <?php echo $category['category']; ?>
            </h2>
            <ul>
                <?php foreach ($products as $product): ?>
                    <li class='products-info'>
                        <?php echo $product['brandname']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </Section>
</Main>