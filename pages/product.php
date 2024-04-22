<?php
require_once ("Models/Database.php");
require_once ("Pages/layout/Header.php");
require_once ("Pages/layout/Navbar.php");

$categoryId = $_GET['id'] ?? "";

$products = $dbContext->getSelectedProduct($categoryId);

?>
<?php
layout_header("Marcus");
?>
<?php
layout_Navbar($dbContext);
?>
<main>
    <section class="main">
        <div class="main-content">
            <h1>Innebandy Produkter</h1>
        </div>
    </section>
    <section>
        <div class='products-info'>
            <?php foreach ($products as $product): ?>
                <p>
                    <?php echo $product->brand; ?>
                    <br>
                    <?php echo $product->brandname; ?>
                    <br>
                    <?php echo $product->price; ?> kr
                </p>
            <?php endforeach; ?>
        </div>
    </section>
</main>